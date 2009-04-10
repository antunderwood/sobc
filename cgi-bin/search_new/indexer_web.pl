# Perlfect Search - allow indexing files via http
#$rcs = ' $Id: indexer_web.pl,v 1.25 2003/02/24 22:45:42 daniel Exp $ ' ;

# Copyright (C) 2000-2003 Daniel Naber <daniel.naber@t-online.de>
# 
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or (at
# your option) any later version.
#
# This program is distributed in the hope that it will be useful, but
# WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
# General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307
# USA

use LWP::UserAgent;
use URI;

my $md5;
BEGIN {
	eval {
		require Digest::MD5;
		import Digest::MD5;
		$md5 = new Digest::MD5;
	};
	if ($@) { # oops, no Digest::MD5
		require MD5;
		import MD5;
		$md5 = new MD5;
	}
}

my $http_user_agent = LWP::UserAgent->new;
my $host = "";
my $base = "";
my %list;	# list of visited pages ($list{$digest} = $url)
my $cloned_documents;
my $ignored_documents;

## Get the host and base part of $BASE_URL
sub init_http {
	my $uri = new URI($BASE_URL);
	$host = $uri->host;
	$base = $uri->scheme.":".$uri->opaque;
	$cloned_documents = 0;
	$ignored_documents = 0;
	print "Note: I will not visit more than \$HTTP_MAX_PAGES=$HTTP_MAX_PAGES pages.\n";
	return $uri->scheme."://".$uri->host;
}

## Fetch $url and all URLs that this document links to. Remember
## visited documents and their checksums in %list
sub crawl_http {
	my $url = shift;
	my $date = "";
	my $filesize = 0;

	# fetch URL via http, if not yet visited:
	foreach my $visited_url (values %list) {
		if( $url eq $visited_url ) {
			debug("Ignoring '$url': already visited\n");
			return;
		}
	}
	if( ! check_accept_url($url) ) {
		$list{'ign_'.$ignored_documents} = $url;
		$ignored_documents++;
		return;
	}
	my $content;
	($url, $date, $filesize, $content) = get_url($http_user_agent, $url);
	return if( ! $url );

	my $ext = get_suffix($url);
	if( $ext && $EXT_FILTER{$ext} ) {
		my $tmpfile = "${TMP_DIR}tempfile";
		open(TMPFILE, ">$tmpfile") or (warn "Cannot write '$tmpfile': $!" and return);
		binmode(TMPFILE);
		print TMPFILE $content;
		close(TMPFILE);
		$content = filterFile($tmpfile, $ext);
		unlink $tmpfile or warn "Cannot remove '$tmpfile: $!'"
	}

	# Calculate checksum of content:
	$md5->reset();
	$md5->add($content);
	my $digest = $md5->hexdigest();
	# URL with the same content already visited?:
	if( $list{$digest} ) {
		debug("Ignoring '$url': content identical to '$list{$digest}'\n");
		$list{'clone_'.$cloned_documents} = $url;
		$cloned_documents++;
		return;
	}
	# return if content could not be fetched, but before remember digest and URL:
	$list{$digest} = $url;
	return if( ! $url );
	# Check for meta tags against robots
	my $meta_tags = robot_meta_tag(\$content);
	if( $meta_tags eq "none" ) {	# indexing and following are forbidden by meta tags
		debug("Ignoring '$url': META tags forbid indexing and following\n");
		return;
	} 
	my $content_tmp = $content; 	# content might be modified below
	if( $meta_tags eq "noindex" ) {	# indexing this file is forbidden by meta tags
		debug("'$url': META tags forbid indexing\n");
	} else {
		# call the Perlfect Search index functions:
		my $doc_id = record_file($url);
		index_file($url, $doc_id, $filesize, $date, \$content);
	}
	if( $meta_tags eq "nofollow" ) {	# following is forbidden by meta tags
		debug("'$url': META tags forbid following\n");
		return;
	} 
	if( !$HTTP_FOLLOW_COMMENT_LINKS ) {
		# remove all HTML comments
		$content_tmp =~ s#<!--.*?-->##igs;
	}
	# 'parse' HTML for new URLs (Meta-Redirects and Anchors):
	while( $content_tmp =~ m/
			content\s*=\s*["'][0-9]+;\s*URL\s*=\s*(.*?)['"]
			|
			href\s*=\s*["'](.*?)['"]
			|
			frame[^>]+src\s*=\s*["'](.*?)['"]
			/gisx ) {
		my $new_url = $+;
		# &amp; in a link to distinguish arguments is actually correct, but we have to
		# convert it to fetch the file:
		$new_url =~ s/&amp;/&/g;
		my $next_url = next_url($url, $new_url);
		if ( $next_url ) {
			crawl_http($next_url);
		}
	}

}

## Return an absolute version of the $new_url, which is relative
## to $url.
sub next_url {
	my $base_url = shift;
	my $new_url = shift;
	# a hack by Daniel Quappe to work around some strange bug in the URI module:
	$new_url =~ s/^javascript:/mailto:/igs;
	my $new_uri = URI->new_abs($new_url, $base_url);
	# get rid of "#fragment":
	$new_uri = URI->new($new_uri->scheme.":".$new_uri->opaque);
	# get the right URL even if the link has too many "../":
	my $path = $new_uri->path;
	$path =~ s/\.\.\///g;
	$new_uri->path($path);
	$new_url = $new_uri->as_string;
	return $new_url;
}

## Check if URL is accepted, return 1 if yes, 0 otherwise
sub check_accept_url {
	my $url = shift;
	my $reject;
	# ignore "empty" links (shouldn't happen):
	if( ! $url || $url eq '' ) {
		$reject = "empty/undefined URL";
	}
	# ignore foreign servers/URLs and non-http protocols:
	my $server_okay = 0;
	foreach my $allowed_url (@HTTP_LIMIT_URLS) {
		if( $url =~ m/:\/\// && $url =~ m/^$allowed_url/i ) {
			$server_okay = 1;
			last;
		}
	}
	if( !$server_okay ) {
		$reject = "not below \$HTTP_LIMIT_URL or non-http protocol";
	}
	# ignore file links:
	if( $url =~ m/^file:/i ) {
		$reject = "file URL";
	}
	# ignore javascript: and mailto: links:
	if( $url =~ m/^mailto:/i ) {        # javascript: was replaced by mailto: already
		$reject = "mailto or javascript link";
	}
	# ignore document internal links:
	if( $url =~ m/^#/i ) {
		$reject = "local link";
	}
	if( !$reject ) {
		my $ignore_reason = to_be_ignored($url);
		if( $ignore_reason ) {
			$reject = $ignore_reason;
		}
	}
	if( $reject ) {
		debug("Ignoring '$url': $reject\n");
		return 0;
	}
	return 1;
}

# Shut up misguided -w warnings about "used only once". Has no functional meaning.
sub CGI_pl_sillyness {
  my $zz;
  $zz = $HTTP_LIMIT_URL;
  $zz = $HTTP_CONTENT_TYPES;
}

1;

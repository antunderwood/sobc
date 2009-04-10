# Perlfect Search - tools.pl
# Mapping of Numbers to HTML entities and other useful functions
# Hash taken from htdig's SGMLEntities.cc (shortened)
#$rcs = ' $Id: tools.pl,v 1.14 2003/03/12 18:50:52 daniel Exp $ ' ;

# Copyright (C) 1999-2002 Giorgos Zervas <giorgos@perlfect.com> and 
#  Daniel Naber <daniel.naber@t-online.de>
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

my $http_max_pages_counter = 0;

# Remove some HTML special characters from a string. This is necessary
# to avoid cross site scripting attacks. 
# See http://www.cert.org/advisories/CA-2000-02.html
sub cleanup {
  my $str = $_[0];
  if( ! defined($str) ) {
    return "";
  }
  $str =~ s/[<>"'&]/ /igs;
  return $str;
}

# Escape some HTML special characters in a string. This is necessary
# to avoid cross site scripting attacks. 
# See http://www.cert.org/advisories/CA-2000-02.html
sub html_escape {
  my $str = $_[0];
  if( ! defined($str) ) {
    return "";
  }
  $str =~ s/&/&amp;/igs;
  $str =~ s/</&lt;/igs;
  $str =~ s/>/&gt;/igs;
  $str =~ s/"/&quot;/igs;
  $str =~ s/'/&apos;/igs;
  return $str;
}

sub init_config {
	if( $DOCUMENT_ROOT !~ m#/$# ) {
		# add ending slash if necessary
		$DOCUMENT_ROOT = $DOCUMENT_ROOT."/";
	}
	$BASE_URL =~ s/\/$//;		# remove trailing slash
}

sub init_robot_check {
	my $base = shift;
	if( $ROBOT_AGENT && $HTTP_START_URL ) {
		eval "use WWW::RobotRules";
		if( $@ ) {
			die("Cannot use robots.txt, maybe WWW::RobotRules is not installed? $!");
		}
		$main::robot = WWW::RobotRules->new($ROBOT_AGENT);
		my $url = "$base/robots.txt";
		print "Loading $url...\n";
		my $http_user_agent = LWP::UserAgent->new;
		my $robots_txt;
		(undef, undef, undef, $robots_txt) = get_url($http_user_agent, $url);
		if( $robots_txt ) {
			$main::robot->parse($url, $robots_txt);
		} else {
			warn("Not using any robots.txt.\n");
		}
	}
}

sub isHTML {
  my $filename = shift;
  my $ext = get_suffix($filename);
  if( $ext ) {
    return grep(/^$ext$/i, @HIGHLIGHT_EXT);
  } else {
    return 0;
  }
}

sub get_suffix {
  my $filename = shift;
  ($suffix) = ($filename =~ m/\.([^.]*)$/);
  return $suffix;
}

sub filterFile {
  my $filename = shift;
  my $ext = shift;
  my $buffer;
  my @args = split(/\s+/, $EXT_FILTER{$ext});
  # don't allow any filename for security reasons:
  if( $filename !~ m/^[\/a-zA-Z0-9_.: +-]*$/ || $filename =~ m/\.\./ ) {
    print STDERR "Ignoring '$filename': illegal characters in filename\n";
    return "";
  }
  foreach (@args) {
    if( $_ eq 'FILENAME' ) {
      $_ =~ s/FILENAME/"$filename"/g;
    }
  }
  my $command = join(' ', @args);
  open(CMD, "$command|") || warn("Cannot execute '$command': $!") && return "";
  while( <CMD> ) {
    $buffer .= $_;
  }
  close(CMD);
  return $buffer;
}

sub debug {
	my $str = shift;
	if( $HTTP_DEBUG && $ENV{'REQUEST_METHOD'} ) {
		print $str;
	} elsif( $HTTP_DEBUG && ! $ENV{'REQUEST_METHOD'} ) {
		print STDERR $str;
	}
}

sub error {
	my $str = shift;
	if( $ENV{'REQUEST_METHOD'} ) {
		print $str;
	} else {
		print STDERR $str;
	}
}

# Fetch URL via http, return real URL (differs only in case of redirect) and
# document's contents. Return nothing in case of error or unwanted Content-Type
sub get_url {
  my $http_user_agent = shift;
  my $url = shift;
  my $search_mode = shift;		# $search_mode = don't show debugging

  # Avoid endless loops:
  if( $http_max_pages_counter >= $HTTP_MAX_PAGES ) {
    error("Error: Ignoring '$url': \$HTTP_MAX_PAGES=$HTTP_MAX_PAGES limit reached.\n");
    return;
  }
  $http_max_pages_counter++;

  my $request = HTTP::Request->new(GET => $url);
  my $response = $http_user_agent->request($request);
  if( $response->is_error ) {
    error("Error: Couldn't get '$url': response code " .$response->code. "\n");
    return;
  }

  if( $response->headers_as_string =~ m/^Content-Type:\s*(.+)$/im ) {
    my $content_type = $1;
    $content_type =~ s/^(.*?);.*$/$1/;		# ignore possible charset value
    if( ! grep(/^$content_type$/i, @HTTP_CONTENT_TYPES) ) {
      debug("Ignoring '$url': content-type '$content_type'\n");
      return;
    }
  }

  my $buffer = $response->content;
  my $size = length($buffer);
  debug("Fetched  '$url', $size bytes\n") if( ! $search_mode );
  # Maybe we are we redirected, so use the new URL.
  # Note: this also uses <base href="...">, so href="..." has to point
  # to the page itself, not to the directory (even though the latter 
  # will work okay in browsers):
  $url = $response->base;
  return ($url, $response->last_modified, $size, $buffer);
}

## Are there meta tags that forbid visiting this page /
## following its URLs? Returns "", "none", "noindex" or "nofollow"
sub robot_meta_tag {
  my $content = shift;
  my $meta_tags = "";
  while( ${$content} =~ m/<meta(.*?)>/igs ) {
    my $tag = $1;
    if( $tag =~ m/name\s*=\s*"robots"/is ) {
      my ($value) = ($tag =~ m/content\s*=\s*"(.*?)"/igs);
      if( $value =~ m/none/is ) {
        $meta_tags = "none";
      } elsif( $value =~ m/noindex/is && $value =~ m/nofollow/is ) {
        $meta_tags = "none";
      } elsif( $value =~ m/noindex/is ) {
        $meta_tags = "noindex";
      } elsif( $value =~ m/nofollow/is ) {
        $meta_tags = "nofollow";
      }
    }
  }
  return $meta_tags;
}

# Load the user's list of (common) words that should not be indexed.
# Use a hash so lookup is faster. Well-chosen stopwords can make 
# indexing faster.
sub load_stopwords {
  my %stopwords;
  open(FILE, $STOPWORDS_FILE) or (warn "Cannot open '$STOPWORDS_FILE': $!" and return);
  while (<FILE>) {
    chomp;
    $_ =~ s/\r//g; # get rid of carriage returns
    $stopwords{$_} = 1;
  }
  close(FILE);
  return %stopwords;
}

my $special_chars;	# special characters we have to replace
# Build list of special characters that will be replaced in normalize(),
# put this list in global variable $special_chars.
sub build_char_string {
  foreach my $number (keys %entities) {
    $special_chars .= chr($number);
  }
}

# Represent all special characters as the character they are based on.
sub remove_accents {
  my $buffer = $_[0];
  # Special cases:
  $buffer =~ s/&thorn;/th/igs;
  $buffer =~ s/&eth;/d/igs;
  $buffer =~ s/&szlig;/ss/igs;
  # Now represent special characters as the characters they are based on:
  $buffer =~ s/&(..?)(grave|acute|circ|tilde|uml|ring|cedil|slash|lig);/$1/igs;
  return $buffer;
}

# Represent all special characters as HTML entities like &<entitiy>;
sub normalize_special_chars {
  my $buffer = $_[0];
  # There may be special characters that are not encoded, so encode them:
  $buffer =~ s/([$special_chars])/"&#".ord($1).";"/gse;
  # Special characters can be encoded using hex values:
  $buffer =~ s/&#x([\dA-F]{2});/"&#".hex("0x".$1).";"/igse;
  # Special characters may be encoded with numbers, undo that (use the if() to avoid warnings):
  $buffer =~ s/&#(\d\d\d);/if( $1 >= 192 && $1 <= 255 ) { "&$entities{$1};"; }/gse;
  return $buffer;
}

%entities = (
	192 => 'Agrave',	#  capital A, grave accent 
	193 => 'Aacute',	#  capital A, acute accent 
	194 => 'Acirc',		#  capital A, circumflex accent 
	195 => 'Atilde',	#  capital A, tilde 
	196 => 'Auml',		#  capital A, dieresis or umlaut mark 
	197 => 'Aring',		#  capital A, ring 
	198 => 'AElig',		#  capital AE diphthong (ligature) 
	199 => 'Ccedil',	#  capital C, cedilla 
	200 => 'Egrave',	#  capital E, grave accent 
	201 => 'Eacute',	#  capital E, acute accent 
	202 => 'Ecirc',		#  capital E, circumflex accent 
	203 => 'Euml',		#  capital E, dieresis or umlaut mark 
	205 => 'Igrave',	#  capital I, grave accent 
	204 => 'Iacute',	#  capital I, acute accent 
	206 => 'Icirc',		#  capital I, circumflex accent 
	207 => 'Iuml',		#  capital I, dieresis or umlaut mark 
	208 => 'ETH',		#  capital Eth, Icelandic (Dstrok) 
	209 => 'Ntilde',	#  capital N, tilde 
	210 => 'Ograve',	#  capital O, grave accent 
	211 => 'Oacute',	#  capital O, acute accent 
	212 => 'Ocirc',		#  capital O, circumflex accent 
	213 => 'Otilde',	#  capital O, tilde 
	214 => 'Ouml',		#  capital O, dieresis or umlaut mark 
	216 => 'Oslash',	#  capital O, slash 
	217 => 'Ugrave',	#  capital U, grave accent 
	218 => 'Uacute',	#  capital U, acute accent 
	219 => 'Ucirc',		#  capital U, circumflex accent 
	220 => 'Uuml',		#  capital U, dieresis or umlaut mark 
	221 => 'Yacute',	#  capital Y, acute accent 
	222 => 'THORN',		#  capital THORN, Icelandic 
	223 => 'szlig',		#  small sharp s, German (sz ligature) 
	224 => 'agrave',	#  small a, grave accent 
	225 => 'aacute',	#  small a, acute accent 
	226 => 'acirc',		#  small a, circumflex accent 
	227 => 'atilde',	#  small a, tilde
	228 => 'auml',		#  small a, dieresis or umlaut mark 
	229 => 'aring',		#  small a, ring
	230 => 'aelig',		#  small ae diphthong (ligature) 
	231 => 'ccedil',	#  small c, cedilla 
	232 => 'egrave',	#  small e, grave accent 
	233 => 'eacute',	#  small e, acute accent 
	234 => 'ecirc',		#  small e, circumflex accent 
	235 => 'euml',		#  small e, dieresis or umlaut mark 
	236 => 'igrave',	#  small i, grave accent 
	237 => 'iacute',	#  small i, acute accent 
	238 => 'icirc',		#  small i, circumflex accent 
	239 => 'iuml',		#  small i, dieresis or umlaut mark 
	240 => 'eth',		#  small eth, Icelandic 
	241 => 'ntilde',	#  small n, tilde 
	242 => 'ograve',	#  small o, grave accent 
	243 => 'oacute',	#  small o, acute accent 
	244 => 'ocirc',		#  small o, circumflex accent 
	245 => 'otilde',	#  small o, tilde 
	246 => 'ouml',		#  small o, dieresis or umlaut mark 
	248 => 'oslash',	#  small o, slash 
	249 => 'ugrave',	#  small u, grave accent 
	250 => 'uacute',	#  small u, acute accent 
	251 => 'ucirc',		#  small u, circumflex accent 
	252 => 'uuml',		#  small u, dieresis or umlaut mark 
	253 => 'yacute',	#  small y, acute accent 
	254 => 'thorn',		#  small thorn, Icelandic 
	255 => 'yuml',		#  small y, dieresis or umlaut mark
);

1;

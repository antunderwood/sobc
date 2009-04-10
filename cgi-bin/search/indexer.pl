#!/usr/bin/perl -w
#$rcs = ' $Id: indexer.pl,v 1.78 2003/02/24 22:45:42 daniel Exp $ ' ;

# Perlfect Search
#
# Copyright (C) 1999-2003 Giorgos Zervas <giorgos@perlfect.com> and 
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

use Fcntl;

# If indexer.pl uses too much CPU, comment in the next two lines. "nice" takes
# a value between 0 (normal) and 19 (lowest priority). Tested on Linux only.
#use POSIX qw(nice);
#nice 19;
  
# added program path to @INC because it fails to find ./conf.pl if
# started from other directory
{ 
  # block is for $1 not mantaining its value
  $0 =~ /(.*)(\\|\/)/;
  push @INC, $1 if $1;
}

my $db_package = "";
package AnyDBM_File;
@ISA = qw(DB_File);
# You may try to comment in the next line if you don't have DB_File. Still
# this is not recommended.
#@ISA = qw(DB_File GDBM_File SDBM_File ODBM_File NDBM_File);
foreach my $isa (@ISA) {
  if( eval("require $isa") ) {
    $db_package = $isa;
    last;
  }
}
if( $db_package  ne 'DB_File' ) {
  die "*** The DB_File module was not found on your system.";
}

package main;
require 'conf.pl';
require 'indexer_filesystem.pl';
require 'tools.pl';
init_config();
if( $HTTP_START_URL ) {
  require 'indexer_web.pl';
}

$|=1;    # autoflush

# no formatting in the shell:
$br = "\n";
$em = "";
$em_end = "";

# Calling via CGI is allowed with password:
if( $INDEXER_CGI_PASSWORD && $ENV{'REQUEST_METHOD'} ) {
  print "Content-Type: text/html\n\n";
  my $title = "Perlfect Search $VERSION indexer.pl";
  print "<html><head><title>$title</title></head><body>";
  print "<h2>$title</h2>\n\n";
  print "<pre>";
  if( $ENV{'QUERY_STRING'} ) {    # call via method=GET
    print "*** Warning: You are calling this program in an insecure way!\n";
    print "*** Use method=\"POST\" to make the call more secure.\n\n";
  }
  use CGI;
  #use CGI::Carp qw(fatalsToBrowser);
  my $query = new CGI;
  if( $query->param('password') ne $INDEXER_CGI_PASSWORD ) {
    print "Error: Access denied, invalid password\n";
    print "(set \$INDEXER_CGI_PASSWORD in conf.pl).\n";
    exit;
  }
  # some nice formatting in the browser:
  $br = "<br>";
  $em = "<b>";
  $em_end = "</b>";
  print "Note: Do not call this script again while this instance is not finished.\n\n";
}

# Calling via CGI is NOT allowed, but someone tries to:
if( ! $INDEXER_CGI_PASSWORD && $ENV{'REQUEST_METHOD'} ) {
  print "Content-Type: text/html\n\n";
  print "Error: Access denied. indexer.pl cannot be called via CGI\n";
  print "because \$INDEXER_CGI_PASSWORD is not set in conf.pl.\n";
  exit;
}

print "Using $db_package...\n";

my $DN  = 0;  #documents number
my $TN  = 0;  #terms number (unique terms)
my $TN_non_unique = 0;  #terms number

my $no_index_count = 0;
my $no_index_count_robot = 0;

print "Checking for old temp files...\n";
delete_temp_files();

# The data structures that Perlfect Search uses to save information:
my %inv_index_db;   # term id -> list of pairs: (document id, relevancy)
my %docs_db;        # document id -> filename
my %urls_db;        # filename -> 1 (for looking up if a filename/url was indexed)
my %sizes_db;       # document id -> size in bytes
my %desc_db;        # document id -> description (from meta tag or start of body)
my %titles_db;      # document id -> document title
my %dates_db;       # document id -> date of last modification
my %content_db;     # document id -> start of the document's content (to show context of matches)
my %terms_db;       # term -> term id
# The following two hashes are temporary and will not be saved to disk:
my %df_db;          # term id -> number of occurences of this term in all documents
my %tf_db;          # term id -> list of pairs: (document id, number of occurences in this document)

if( $LOW_MEMORY_INDEX ) {
  tie %inv_index_db, $db_package, $INV_INDEX_TMP_DB_FILE, O_CREAT|O_RDWR, 0755 or die "Cannot open $INV_INDEX_TMP_DB_FILE: $!";
  tie %docs_db,      $db_package, $DOCS_TMP_DB_FILE, O_CREAT|O_RDWR, 0755      or die "Cannot open $DOCS_TMP_DB_FILE: $!";
  tie %urls_db,      $db_package, $URLS_TMP_DB_FILE, O_CREAT|O_RDWR, 0755      or die "Cannot open $URLS_TMP_DB_FILE: $!";
  tie %sizes_db,     $db_package, $SIZES_TMP_DB_FILE, O_CREAT|O_RDWR, 0755     or die "Cannot open $SIZES_TMP_DB_FILE: $!";
  tie %desc_db,      $db_package, $DESC_TMP_DB_FILE, O_CREAT|O_RDWR, 0755      or die "Cannot open $DESC_TMP_DB_FILE: $!"; 
  tie %titles_db,    $db_package, $TITLES_TMP_DB_FILE, O_CREAT|O_RDWR, 0755    or die "Cannot open $TITLES_TMP_DB_FILE: $!";
  tie %dates_db,     $db_package, $DATES_TMP_DB_FILE, O_CREAT|O_RDWR, 0755     or die "Cannot open $DATES_TMP_DB_FILE: $!";
  tie %terms_db,     $db_package, $TERMS_TMP_DB_FILE, O_CREAT|O_RDWR, 0755     or die "Cannot open $TERMS_TMP_DB_FILE: $!"; 
  tie %df_db,        $db_package, $DF_DB_FILE, O_CREAT|O_RDWR, 0755            or die "Cannot open $DF_DB_FILE: $!";
  tie %tf_db,        $db_package, $TF_DB_FILE, O_CREAT|O_RDWR, 0755            or die "Cannot open $TF_DB_FILE: $!";
}
tie %content_db,   $db_package, $CONTENT_TMP_DB_FILE, O_CREAT|O_RDWR, 0755   or die "Cannot open $CONTENT_TMP_DB_FILE: $!";

print "Building string of special characters...\n";
build_char_string();

print "Loading \'no index\' regular expressions:\n";
load_excludes();
print "Loading stopwords...";
my %stopwords = load_stopwords();
print scalar(keys(%stopwords))." stopwords loaded.\n";

print "Starting crawler...\n";
if( $HTTP_START_URL ) {
  $base_url = init_http();
  init_robot_check($base_url);
  crawl_http($HTTP_START_URL);
} else {
  print "Local indexing, robots.txt will not be used.\n";
  init_filesystem();
  crawl_filesystem($DOCUMENT_ROOT);
}
print "\nCrawler finished: indexed $DN files, ".($TN_non_unique+$TN)." terms ($TN different terms).\n";
print "Ignored $no_index_count files because of conf/no_index.txt\n";
if( $HTTP_START_URL ) {
  print "Ignored $no_index_count_robot files because of robots.txt\n\n";
}

print "Calculating weight vectors: \n";
weights();

untie %content_db;
if( $LOW_MEMORY_INDEX ) {
  # Removing the files is a problem on Windows NT if they are still tie'd:
  untie %inv_index_db;
  untie %docs_db;
  untie %urls_db;
  untie %sizes_db;
  untie %desc_db;
  untie %titles_db;
  untie %dates_db;
  untie %terms_db;
  untie %df_db;
  untie %tf_db;
  print "Removing unused db files:\n";
  print "    $TF_DB_FILE...";
  if (unlink $TF_DB_FILE) {
    print "ok\n";
  } else {
    warn "Cannot unlink $TF_DB_FILE: $!";
  }
  print "    $DF_DB_FILE...";
  if (unlink $DF_DB_FILE) {
    print "ok\n";
  } else {
    warn "Cannot unlink $DF_DB_FILE: $!";
  }
} else {
  print "Copying hash values to database files...\n";
  save_db($INV_INDEX_TMP_DB_FILE, %inv_index_db);
  save_db($DOCS_TMP_DB_FILE, %docs_db);
  save_db($URLS_TMP_DB_FILE, %urls_db);
  save_db($SIZES_TMP_DB_FILE, %sizes_db);
  save_db($DESC_TMP_DB_FILE, %desc_db);
  save_db($TITLES_TMP_DB_FILE, %titles_db);
  save_db($DATES_TMP_DB_FILE, %dates_db);
  save_db($TERMS_TMP_DB_FILE, %terms_db);
}

print "Renaming newly created db files...\n";
rename_db();

print "Indexer finished.\n";
if( -e $UPDATE_FILE ) {
  my $now = time();
  utime($now, $now, $UPDATE_FILE);
} else {
  open(FILE, ">$UPDATE_FILE");
  print FILE "\n";
  close(FILE);
}
if( $ENV{'REQUEST_METHOD'} ) {
  print "</pre></body></html>\n";
}
exit;

# Copy the keys and values of a hash to a persistent file on disk.
sub save_db {
  my $name = shift;
  print "    $name\n";
  my %hash = @_;
  my %db_tmp;
  tie %db_tmp, "DB_File", $name, O_CREAT|O_RDWR, 0755 or die "Cannot open '$name': $!"; 
  %db_tmp = %hash;
  untie %db_tmp;
}

# Sometimes people stop indexer.pl with Ctrl-C and temp files are left over.
# We better delete them so they don't confuse us.
sub delete_temp_files {
  my @tmp_files = ($INV_INDEX_TMP_DB_FILE,$DOCS_TMP_DB_FILE,$URLS_TMP_DB_FILE,$SIZES_TMP_DB_FILE,
    $TERMS_TMP_DB_FILE,$DESC_TMP_DB_FILE,$TITLES_TMP_DB_FILE,$CONTENT_TMP_DB_FILE);
  if( $LOW_MEMORY_INDEX ) {
    push(@tmp_files, $DF_DB_FILE,$TF_DB_FILE);
  }
  foreach my $oldfile (@tmp_files) {
    next unless (-e $oldfile);
    if (unlink $oldfile) {
      print "    Removing old temp file '$oldfile'\n";
    } else {
      warn "Cannot unlink $oldfile: $!";
    }
  }
}

# Save important parts of a file to the database.
sub index_file {
  my ($url, $doc_id, $filesize, $date, $buffer) = @_;
  my ($term, $term_id);
  my %tf;

  my $kb = sprintf("%.2f", $filesize / 1024);
  my $tempurl = $url;
  if( $ENV{'REQUEST_METHOD'} ) {
    $tempurl = html_escape($url);
  }
  print "    $doc_id: $tempurl ($kb KB)\n";
  $sizes_db{$doc_id} = $filesize;    # remember original document's size
  $date = -1 if( !$date );
  $dates_db{$doc_id} = $date;    # remember last modified date

  # Many auto-generated HTML files contain (correct) syntax that makes our
  # regexp very slow. So better clean up now:
  ${$buffer} =~ s/\s+>/>/gs;
  ${$buffer} =~ s/<\s+/</gs;

  record_desc($doc_id, $buffer, $url);
  if ($INDEX_URLS) {
    # to search for parts of URLs, e.g. filenames:
    # (cutting out $DOCUMENT_ROOT for security reasons!)
    ${$buffer} = cut_document_root($url)." ".${$buffer};
  }
  # to rank words in the title tag and in headlines differently:
  get_tag_contents("title", $buffer, $TITLE_WEIGHT);
  get_headline_contents($buffer);
  # to search for text in the follwing meta tags:
  ${$buffer} .= " ".get_meta_content("description", $buffer, $META_WEIGHT);
  ${$buffer} .= " ".get_meta_content("keywords", $buffer, $META_WEIGHT);
  ${$buffer} .= " ".get_meta_content("author", $buffer, $META_WEIGHT);
  # to search for images' alt texts:
  get_alt_texts($buffer);
  normalize($buffer);
  
  foreach (split " ", ${$buffer}) {
    next if( $stopwords{$_} );    # ignore stopwords
    $_ = substr $_, 0, $STEMCHARS if $STEMCHARS;
    if (length $_ >= $MINLENGTH) {
      $term_id = record_term($_);
      ++$tf{$term_id};
    }
  }
  
  foreach (keys %tf) {
    $df_db{$_}++;
    $tf_db{$_} = '' unless defined $tf_db{$_};
    $tf_db{$_} .= pack("ww", $doc_id, $tf{$_}); 
  }
}

# Calculate the weight (score) for each term in each file and 
# save it to the database.
sub weights {
  my ($weight, $term_id, $doc_id);
  my $count = 0;
  my $prev_indicator = 0;

  print "0%  10%  20%  30%  40%  50%  60%  70%  80%  90%  100%\n";
  print "|----|----|----|----|----|----|----|----|----|----|\n";
  print ">";

  foreach $term_id (keys %tf_db) {
    my $weights = $inv_index_db{$term_id} || '';
    my $df = $df_db{$term_id};
    my %tdf = unpack("w*",$tf_db{$term_id}); 
    $count++;
    $indicator = sprintf("%.0f", ($count/$TN * 50));
    $indicator = int($indicator);
    if( $indicator > $prev_indicator ) {
      $prev_indicator = $indicator;
      my $back = "\b ";
      if( $ENV{'REQUEST_METHOD'} ) {
        $back = "";
      }
      print "$back>";
    }
    foreach $doc_id (keys %tdf) {
      #print "weight = $tdf{$doc_id} * log ($DN / $df)\n";
      $weight = $tdf{$doc_id} * log ($DN / $df);
      $weight = int($weight*100);
      $weight = 65535 if ( $weight > 65535 );    # we're limited to 16 bit
      $weights .= pack("SS", $doc_id, $weight);
    }
    undef %tdf;
    $inv_index_db{$term_id} = $weights;
  }
  print "\n";
}

# Replace umlauts etc by ASCII characters, remove HTML, 
# remove remaining special charcaters. In the end, we only have [a-zA-Z0-9_].
# Then it is converted to lowercase and returned.
sub normalize {
  my $buffer = $_[0];

  if( $IGNORE_TEXT_START && $IGNORE_TEXT_END ) {  # strip user defined parts
    ${$buffer} =~ s/$IGNORE_TEXT_START.*?$IGNORE_TEXT_END//gis;
  }
  ${$buffer} =~ s/<!--.*?-->//gis;  # strip html comments
  ${$buffer} =~ s/-(\s*\n\s*)?//g;  # join parts of hyphenated words

  if( $SPECIAL_CHARACTERS ) {
    ${$buffer} = normalize_special_chars(${$buffer});
    ${$buffer} = remove_accents(${$buffer});
  }

  # Replace HTML tags (and maybe numbers) by spaces:
  if ($INDEX_NUMBERS) {
    ${$buffer} =~ s/(<[^>]*>)/ /gs;
  } else {
    ${$buffer} =~ s/(\b\d+\b)|(<[^>]*>)/ /gs;
  }

  ${$buffer} =~ tr/a-zA-Z0-9_/ /cs;
  ${$buffer} = lc ${$buffer};
}

# Return the body without HTML and unnecessary whitespace.
sub get_cleaned_body {
  my $buffer = $_[0];
  my $filename = $_[1];
  my $cleaned = "";
  if( isHTML($filename) ) {
    ($cleaned) = (${$buffer} =~ m/<BODY.*?>(.*)<\/BODY>/is);
    $cleaned = ${$buffer} if( ! $cleaned );    # broken HTML files maybe don't have a <body>
  } else {
    # non HTML files don't have a "body" (e.g. PDF)
    $cleaned = ${$buffer};
  }
  $cleaned =~ s/$IGNORE_TEXT_START.*?$IGNORE_TEXT_END//gis;  # strip user defined parts
  $cleaned =~ s/<!--.*?-->//gis;        # strip html comments
  $cleaned =~ s/<.+?>/ /gis;            # strip html
  $cleaned =~ s/\s+/ /gis;              # strip too much whitespace
  $cleaned =~ tr/\n\r/ /s;
  # comment out the following line if you want to index Arabic (and other non-Latin1 charstets?):
  $cleaned = normalize_special_chars($cleaned);
  return $cleaned;
}

# Save the (document ID, filename) relation to the database.
sub record_file {
  my $file = $_[0];
  $file = cut_document_root($file);
  ++$DN;
  # for development only:
  #if( $DN % 100 == 0 ) {
  #  memory_usage();
  #}
  if( $DN >= 65535 ) {
    die "Error: Indexing more than 65534 documents is not supported";
  }
  $docs_db{$DN} = $file;
  $urls_db{$file} = 1;
  return $DN;
}

# Save a short description for every document to the database. If no 
# meta description tag is available, take the first words from the body.
# Also save the <title> to the database.
sub record_desc {
  my ($doc_id, $buffer, $file) = @_;
  my ($desc, $title, $cleanbody);
  my @desc_ary;

  # Save Description or beginning of body:
  $desc = get_meta_content("description", $buffer, 1);
  if( ! $desc || $CONTEXT_SIZE ) {
    $cleanbody = get_cleaned_body($buffer, $file);
  }
  unless ($desc) {
    @desc_ary = split " ", $cleanbody;
    my $to = $DESC_WORDS;
    $to = scalar(@desc_ary)-1 if( $DESC_WORDS >= scalar(@desc_ary) );
    $desc = join " ", @desc_ary[0..$to];
    $desc .= "..." if( $desc !~ m/\.\s*$/ );
  }
  $desc_db{$doc_id} = removeHTML($desc);

  # Save title:
  ($title) = (${$buffer} =~ m/<TITLE>(.*?)<\/TITLE>/is);
  if( (! $title) || $title =~ m/^\s+$/ ) {
    $file =~ s/.*\///;    # remove the path
    $title = $file;
  }
  if( length($title) > $MAX_TITLE_LENGTH ) {
    $title = substr($title, 0, $MAX_TITLE_LENGTH) . "...";
  }
  $titles_db{$doc_id} = removeHTML($title);

  # Optionally save the document (to show results with context):
  if( $CONTEXT_SIZE ) {
    my $cont = $cleanbody;
    $cont = substr($cont, 0, $CONTEXT_SIZE) if( $CONTEXT_SIZE != -1 );
    $content_db{$doc_id} = removeHTML($cont);
  }
}

# Get the content part for a certain meta tag. Weight with
# a certain factor by just repeating the result that often.
sub get_meta_content {
  my $name = $_[0];
  my $buffer = $_[1];
  my $weight = $_[2];
  my ($content) = (${$buffer} =~ m/<META\s+name\s*=\s*[\"\']?$name[\"\']?\s+content=[\"\'](.*?)[\"\'][\/\s]*>/is);
  return "" if( ! $content || $content =~ m/^\s+$/ );
  $content = (($content." ") x $weight);
  return $content;  
}

# Add all values for alt="...", joined with spaces to $buffer.
sub get_alt_texts {
  my $buffer = $_[0];
  my $alt_texts = "";
  while( ${$buffer} =~ m/alt\s*=\s*[\"\'](.*?)[\"\']/gis ) {
    $alt_texts .= " ".$1;
  }
  ${$buffer} .= $alt_texts;
}

# Add the contents of a certain tag, weighted by just repeating these contents
# to $buffer.
sub get_tag_contents {
  my $tag = $_[0];
  my $buffer = $_[1];
  my $weight = $_[2];
  my $tag_content = "";
  while( ${$buffer} =~ m/<$tag.*?>(.*?)<\/$tag>/igs ) {
    $tag_content .= (" ".$1) x $weight;
  }
  ${$buffer} .= $tag_content;
}

# Add the contents of all headline levels, weighted by just repeating these contents
# to $buffer.
sub get_headline_contents {
  my $buffer = $_[0];
  my $level;
  my $headlines = "";
  for( $level = 1; $level <= 6; $level++ ) {
    while( ${$buffer} =~ m/<h$level.*?>(.*?)<\/h$level>/igs ) {
      $headlines .= (" ".$1) x $H_WEIGHT{$level};
    }
  }
  ${$buffer} .= $headlines;
}

# Save a term's ID to the database, if it does not yet exist. Return the ID.
sub record_term {
  my $term = $_[0];
  print STDERR "Warning: record_term($term): No term was supplied\n" unless $term;
  my $lookup = $terms_db{$term};
  if ($lookup) {
    $TN_non_unique++;
    return $lookup;
  } else {
    $TN++;
    $terms_db{$term} = $TN;
    return $TN;
  }
}

# Is the file listed in @no_index?
# Supported ways to list a file in conf/no_index:
# /home/www/test/index.html (absolute path)
# /test/index.html (path relative to webroot, but with slash)
# test/index.html (path relative to webroot, no slash)
# http://localhost/test/index.html (absolute URL)
sub to_be_ignored {
  my $file = shift;
  # Check @no_index:
  my $file_relative;
  $file_relative = cut_document_root($file);
  foreach my $regexp (@no_index) {
    if( $file_relative =~ m/^\/?$regexp$/ || $file =~ m/^$regexp$/ ) {
      $no_index_count++;
      return "listed in no_index.txt";
    }
  }
  if( $ROBOT_AGENT && $HTTP_START_URL ) {
    if( ! $main::robot->allowed($file) ) {
      $no_index_count_robot++;
      return "disallowed by robots.txt";
    }
  }
  return undef;
}

# Remove $DOCUMENT_ROOT from an absolute filename and return the 
# relative filename, but starting with a slash. Don't change URLs.
sub cut_document_root {
  my $file = shift;
  my $root = "";
  my $tmp_file = "";
  if( $file !~ m/^http:/i ) {
    $DOCUMENT_ROOT =~ s/\\/\//g;
    # On Windows, both / and \ are valid to seperate paths. We still have to 
    # filter out $DOCUMENT_ROOT, so make \ to /:
    $file =~ s/\\/\//g;
    $tmp_file = $file;
    $root = $DOCUMENT_ROOT;
    ($file) = ($file =~ m/^$root(.*)$/);
    if( !$file && $tmp_file ne $root ) {
      # This should never happen!
      print STDERR "Warning: cannot remove '$root' from '$tmp_file'\n";
    }
    unless ($file =~ /^\//) {
      $file = "/".$file;
    }
  }
  return $file;
}

# Load the user's list of files that should not be indexed.
sub load_excludes {
  if (-e $NO_INDEX_FILE) {
    open (FILE, $NO_INDEX_FILE) or (warn "Cannot open $NO_INDEX_FILE: $!" and next);
    while (<FILE>) {
      chomp;
      $_ =~ s/\r//g;        # get rid of carriage returns      
      $_ =~ s/(\#.*)//g;    # ingore comments
      $_ =~ s/[\/\s]*$//;   # remove any trailing spaces and slashes
      next if( ! $_ );
      print "    - $_\n";
      
      $_ = quotemeta;       # escape all non-alphanumeric characters
      $_ =~ s/\\\*/\.\*/g;  # except for the * which is replaced by .*
      push @no_index, $_;
    }
    close (FILE);
  } else {
    print STDERR "Warning: $NO_INDEX_FILE missing.";
  }
}

# Move the temporary files to their non-temporary places. This is
# called when the new index is complete. This way the old index 
# files can still be used while the new ones are being created.
sub rename_db {
  my @files = (
    [$TERMS_TMP_DB_FILE, $TERMS_DB_FILE],
    [$DOCS_TMP_DB_FILE, $DOCS_DB_FILE],
    [$URLS_TMP_DB_FILE, $URLS_DB_FILE],
    [$SIZES_TMP_DB_FILE, $SIZES_DB_FILE],
    [$TITLES_TMP_DB_FILE, $TITLES_DB_FILE],
    [$DATES_TMP_DB_FILE, $DATES_DB_FILE],
    [$CONTENT_TMP_DB_FILE, $CONTENT_DB_FILE],
    [$DESC_TMP_DB_FILE, $DESC_DB_FILE],
    [$INV_INDEX_TMP_DB_FILE, $INV_INDEX_DB_FILE],
  );

  foreach (@files) {
    print "    ", $_->[0], " to ", $_->[1], "\n";
    rename $_->[0], $_->[1] or (warn "Cannot rename $_->[0]: $!" and next);
  }
}

# Remove HTML from a string.
sub removeHTML {
  my $str = $_[0];
  $str =~ s/<!--.*?-->//igs;
  $str =~ s/<.*?>//igs;
  $str =~ s/[<>]//igs;    # these may be left
  return $str;
}

# For development only: check memory usage during indexing.
sub memory_usage {
  my $pid = $$;
  my $str = `top -b -n 0 -p $pid`;
  my ($line) = ($str =~ m/^(.*?indexer\.pl.*?)$/igm);
  $line =~ s/^\s+//;
  my @line = split(/\s+/, $line);
  print "mem: $line[4]\n";
}

# Shut up misguided -w warnings about "used only once". Has no functional meaning.
sub warnings_sillyness {
  my $zz;
  $zz = $SIZES_DB_FILE;
  $zz = $TITLE_WEIGHT;
  $zz = $SPECIAL_CHARACTERS;
  $zz = $H_WEIGHT;
  $zz = $INDEX_URLS;
  $zz = $DESC_WORDS;
  $zz = $INV_INDEX_DB_FILE;
  $zz = $MINLENGTH;
  $zz = $DESC_DB_FILE;
  $zz = $TITLES_DB_FILE;
  $zz = $DATES_DB_FILE;
  $zz = $TERMS_DB_FILE;
  $zz = $DOCS_DB_FILE;
  $zz = $URLS_DB_FILE;
  $zz = $CONTENT_DB_FILE;
  $zz = $INDEX_NUMBERS;
  $zz = $VERSION;
  $zz = $ROBOT_AGENT;
  $zz = $main::robot;
}

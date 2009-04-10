#!/usr/bin/perl -w
#$rcs = ' $Id: search.pl,v 1.95 2003/02/24 22:45:42 daniel Exp $ ' ;

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

# Comment in the next two lines to log and show how long searches take:
#use Time::HiRes qw ();
#my $start_time = [Time::HiRes::gettimeofday];

use CGI;
# only comment this in for development:
#use CGI::Carp qw(fatalsToBrowser);
use Fcntl;
use POSIX qw(strftime);

# added program path to @INC because it fails to find ./conf.pl if started from
# other directory
{ 
  # block is for $1 not mantaining its value
  $0 =~ /(.*)(\\|\/)/;
  push @INC, $1 if $1;
}
require Perlfect::Template;

my $db_package = "";
# To use tainting, comment in the next 2 lines and comment out the next 8 lines.
# Note that you also have to add "./" to the filenames in the require commands.
#use DB_File;
#$db_package = 'DB_File';
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

package main;
require 'conf.pl';
require 'tools.pl';
init_config();

# See indexer.pl for a description of the data structures:
my %inv_index_db;
my %docs_db;
my %urls_db;
my %sizes_db;
my %desc_db;
my %content_db;
my %titles_db;
my %dates_db;
my %terms_db;

tie %inv_index_db, $db_package, $INV_INDEX_DB_FILE, O_RDONLY, 0755 or die "Cannot open $INV_INDEX_DB_FILE: $!";   
tie %docs_db,      $db_package, $DOCS_DB_FILE, O_RDONLY, 0755 or die "Cannot open $DOCS_DB_FILE: $!";   
tie %urls_db,      $db_package, $URLS_DB_FILE, O_RDONLY, 0755 or die "Cannot open $URLS_DB_FILE: $!";   
tie %sizes_db,     $db_package, $SIZES_DB_FILE, O_RDONLY, 0755 or die "Cannot open $SIZES_DB_FILE: $!";   
tie %desc_db,      $db_package, $DESC_DB_FILE, O_RDONLY, 0755 or die "Cannot open $DESC_DB_FILE: $!";   
tie %content_db,   $db_package, $CONTENT_DB_FILE, O_RDONLY, 0755 or die "Cannot open $CONTENT_DB_FILE: $!"; 
tie %titles_db,    $db_package, $TITLES_DB_FILE, O_RDONLY, 0755    or die "Cannot open $TITLES_DB_FILE: $!";   
tie %dates_db,     $db_package, $DATES_DB_FILE, O_RDONLY, 0755 or die "Cannot open $DATES_DB_FILE: $!";   
tie %terms_db,     $db_package, $TERMS_DB_FILE, O_RDONLY, 0755 or die "Cannot open $TERMS_DB_FILE: $!";   

my (@force, @not, @other);
my (@docs, @valid_docs);
my %answer;

build_char_string();
my %stopwords_hash = load_stopwords();
my @stopwords = keys(%stopwords_hash);
my @stopwords_ignored;    # stopwords that are in the user's query
my $punct = ',.!?:"\'/%()-';
my $query;
if( !$ENV{'REQUEST_METHOD'} ) {
  # we are called on the command line
  my $pseudo_lang = 'text';
  $pseudo_lang = 'qa' if( $ARGV[1] && $ARGV[1] eq 'qa' );
  $query = new CGI({'q' => $ARGV[0], 'lang' => $pseudo_lang });    # TODO: add more options
} else {
  # we are called as a CGI
  $query = new CGI;
}
main();
exit;

sub main {
  if( $query->param('showurl') && $HIGHLIGHT_MATCHES ) {
    my $highlight_doc = showdocument();
    print $highlight_doc;
  } else {
    # initialize everything with empty values (because we might run under mod_perl)
    @force = ();
    @not = ();
    @other = ();
    @docs = ();
    @valid_docs = ();
    %answer = ();
    if (create_query()) { #if some valid documents exist
      apply_booleans();
      answer_query();
    }  
    my $html = cast_template();
    if( $ENV{'REQUEST_METHOD'} ) {
      print "Content-Type: text/html\n\n";
    }
    print $html;
    log_query();
  }
}

# Highlight the term(s) in a result document:
sub showdocument {
  print "Content-Type: text/html\n\n";
  my $content = "";
  # security: check if this file was indexed. If not, don't load
  # it, as this would allow loading attacks on any file (or cross site scripting
  # if using $HTTP_START_URL)
  my $url = $query->param('showurl');
  my $file = $url;
  $file =~ s/^$BASE_URL//;
  if( $HTTP_START_URL && isHTML($file) && $urls_db{$url} ) {
    # require = check at run time, so people who don't use $HTTP_START_URL
    # don't need this module
    require LWP::UserAgent;
    my $http_user_agent = LWP::UserAgent->new;
    my $dummy;
    ($dummy,$dummy,$dummy,$content) = get_url($http_user_agent, $url, 1);
    if( ! defined($content) ) {
      $content = "Error: could not retrieve '".cleanup($url)."'\n";
    }
  } elsif( ! $HTTP_START_URL && isHTML($file) && $urls_db{$file} ) {
    $file = $DOCUMENT_ROOT.'/'.$file;    # TODO: make_path() function
    $file =~ s#/{2,}#/#g;
    open(INP, $file) or (return "Error: could not open '".cleanup($url)."': $!\n");
    undef $/;
    $content = (<INP>);
    close(INP);
  } else {
    $content = "Error: getting the file '".cleanup($url)."' is not allowed\n";
  }

  my $query_str = cleanup($query->param('q'));
  $query_str =~ s/[+-]//g;
  my @terms = split(" ", $query_str);
  my $ct = 0;
  foreach my $term (@terms) {
    # TODO: add some text at top of <body> (Google style)?
    # fixme: umlaut highlighting!
    $term = normalize_special_chars($term);
    if( is_ignored(remove_accents($term)) ) {
      next;
    }
    $content = highlighthtml($term, $content, $HIGHLIGHT_COLORS[$ct]);
    $ct++;
    if( $ct >= scalar(@HIGHLIGHT_COLORS) ) {
      $ct = 0;
    }
  }
  # Remove old <base> tag:
  $content =~ s/<base.*?>//igs;
  # Insert our own <base> tag:
  $url = cleanup($url);
  my ($count_repl) = ($content =~ s/<head>/<head>\n<base href="$url">\n/is);
  if( ! defined($count_repl) ) {
    # maybe the HTML is broken and has no <head>:
    $content = "<base href=\"$url\">\n".$content;
  }
  # don't "forget" line breaks in text files:
  if( $url =~ m/\.txt/i ) {  # TODO: find a better solution (using mime-types)
    $content =~  s/[\r\n]/<br>\n/gs;
  }
  return $content;
}

# Make sure to replace the term only in the content of the 
# file, i.e. in that part that's typically visible to the 
# user (requires <style> and <script> content to be commented out!!)
sub highlighthtml {
  my $term = shift;
  my $content = shift;
  my $color = shift;
  my $content_new = "";
  my @comments = split(/(<!--.*?-->)/is, $content);
  my $in_ignore = 0;
  foreach my $c (@comments) {
    my @tags = split(/(<.*?>)/is, $c);
    foreach my $part (@tags) {
      if( $part !~ m/^</ && ! $in_ignore ) {
        $part = normalize_special_chars($part);
        $part =~ s/\b($term)\b/<highlight>$1<\/highlight>/igs;
        # repair possibly damaged entities:
        $part =~ s/(&\w*)<b>$term<\/b>(\w*;)/$1$term$2/igs;
        # now really highlight:
        $part =~ s/<highlight>($term)<\/highlight>/<span style="color:black;background:$color">$1<\/span>/igs;
      }
      if( $part =~ /<title/i ) {
        $in_ignore = 1;
      } else {
        $in_ignore = 0;
      }
      $content_new .= $part;
    }
  }
  return $content_new;
}

sub is_ignored {
  my $buffer = shift;
  my $save = shift;
  if( ! $INDEX_NUMBERS && $buffer =~ m/^\d+$/ ) {
    add_ignored($buffer, $save);
    return 1;
  }
  if( grep(/^\Q$buffer\E$/, @stopwords) || length($buffer) < $MINLENGTH ) {
    add_ignored($buffer, $save);
    return 1;
  } else {
    return 0;
  }
}

sub add_ignored {
  my $term = shift;
  my $save = shift;
  if( $save && ! grep(/^\Q$term\E$/, @stopwords_ignored) ) {
    # don't show words twice:
    push(@stopwords_ignored, $term);
  }
}

sub create_query {
  my $query_str = cleanup($query->param('q'));
  my $mode = cleanup($query->param('mode'));
  my @terms = split(/\s+/, $query_str);
  my $buffer;
  my ($sterm, $nterm);
  
  # Use an extra loop because the loop below will stop
  # on the first term that's not found if there's an AND search:
  foreach my $term (@terms) {
    is_ignored($term, 1);
  }
  
  foreach my $term (@terms) {
    if( is_ignored($term, 0) ) {
      next;
    }
    $buffer = normalize($term);
    foreach my $nterm (split " ",$buffer) {
      $sterm = stem($nterm);
      # For "Match all words" just add a "+" to every term that has no operator:
      if ( $mode eq 'all' && $term !~ m/^(\+|\-)/ ) {
        $term = '+'.$term;
      }
      if ($term =~ /^\+/) {
        if ($terms_db{$sterm}) {
          push @force, $terms_db{$sterm};
        } else {
          return 0;    # this term was not found, we can stop already
        }
      } elsif ($term =~ /^\-/) {
        push @not, $terms_db{$sterm} if $terms_db{$sterm};
      } else {
        push @other, $terms_db{$sterm} if $terms_db{$sterm};
      }
    }
  }

  return 1;
}

sub apply_booleans {
  #locate the valid documents by applying the booleans
  my ($term_id, $doc_id, $first_doc_id);
  my %v = ();
  my @ary = ();
  my @not_docs = ();

  my %not_docs = ();
  map { $not_docs{$_} = 1 } @not_docs;

  foreach $term_id (@not) {
    %v = unpack("S*", $inv_index_db{$term_id});
    foreach $doc_id (keys %v) {
      push @not_docs, $doc_id unless exists $not_docs{$doc_id};
    }
  }
  
  if (@force) {
    $first_doc_id = pop @force;
    %v  = unpack("S*", $inv_index_db{$first_doc_id});
    @valid_docs = keys %v; 
    foreach $term_id (@force) {
      %v = unpack("S*", $inv_index_db{$term_id});
      @ary = keys %v;
      @valid_docs = intersection(\@valid_docs, \@ary);
    }
    push @force, $first_doc_id;
  } else {
    @valid_docs = keys %docs_db;
  }

  @valid_docs = minus(\@valid_docs, \@not_docs);
}

sub answer_query {
  my @term_ids = (@force, @other);

  my %valid_docs = ();
  map { $valid_docs{$_} = 1 } @valid_docs;

  foreach my $term_id (@term_ids) {
    my %v = unpack('S*', $inv_index_db{$term_id});
    foreach my $doc_id (keys %v) {
      # optionally include only certain files:
      my $include_exp = $query->param('include');
      # TODO: escaping $include_exp/$exclude_exp would disable use of RegExp
      next if( $include_exp && $docs_db{$doc_id} !~ m/$include_exp/i );
      # optionally exclude certain files:
      my $exclude_exp = $query->param('exclude');
      next if( $exclude_exp && $docs_db{$doc_id} =~ m/$exclude_exp/i );
      if( exists $valid_docs{$doc_id} ) {
        my $boost = $answer{$doc_id};
        $answer{$doc_id} += $v{$doc_id};
        $answer{$doc_id} *= $MULTIPLE_MATCH_BOOST if( $MULTIPLE_MATCH_BOOST && $boost );
        if( $query->param('penalty') && $query->param('penalty') != 0 && $dates_db{$doc_id} != -1 ) {
          # increase the rank of new documents by giving old ones a penalty:
          my $age_in_days = (time() - $dates_db{$doc_id})/60/60/24;
          my $penalty = $age_in_days * $query->param('penalty');
          $penalty = 100 if( $penalty > 100 );
          $answer{$doc_id} = $answer{$doc_id} - (($answer{$doc_id}/100) * $penalty);
        }
      }
    }
  }
}

# Populate the template with search results. All external data has to be
# accessed via cleanup(), to avoid cross site scripting attacks.
sub cast_template {
  my %h = ();
  my $rank = 0;

  my $p = cleanup($query->param('p'));
  my $lang = cleanup($query->param('lang'));
  if( ! ($lang && $SEARCH_TEMPLATE{$lang} && $NO_MATCH_TEMPLATE{$lang}) ) {
    $lang = $DEFAULT_LANG;
  }
  my $include = cleanup($query->param('include'));
  my $exclude = cleanup($query->param('exclude'));
  my $penalty = cleanup($query->param('penalty'));
  my $mode = cleanup($query->param('mode'));
  my $sort = cleanup($query->param('sort'));
  my $q = cleanup($query->param('q'));

  my $file;
  if( keys(%answer) == 0 ) {
    # No match found
    $file = $NO_MATCH_TEMPLATE{$lang};
  } else {
    $file = $SEARCH_TEMPLATE{$lang};
  }
  my $template = new Perlfect::Template($file);

  # %h carries values that will show up in the result page at <!--cgi: key-->:
  $h{'script_name'} = "Perlfect Search $VERSION";
  if( -e $UPDATE_FILE ) {
    $h{'index_update'} = POSIX::strftime($INDEX_DATE_FORMAT,
      localtime((stat($UPDATE_FILE))[9]));
  } else {
    # cannot not happen, an error stops the script anyway if there's
    # no index:
    $h{'index_update'} = "No index built yet";
  }
  $h{'query_str'}   = $q;
  $h{'query_str_escaped'} = my_uri_escape($q);    # can be used to link to other search engines
  $h{'docs_total'} = keys %docs_db;
  $h{'baseurl'} = $BASE_URL;
  $h{'lang'} = $lang;
  $h{'include'} = $include;
  $h{'exclude'} = $exclude;
  $h{'penalty'} = $penalty;
  $h{'sort'} = $sort;
  if( $mode eq 'all' ) {
    $h{'match_all'} = " selected=\"selected\"";
    $h{'match_any'} = "";
  } else {
    $h{'match_all'} = "";
    $h{'match_any'} = " selected=\"selected\"";
  }

  if( scalar(@stopwords_ignored) > 0 ) {
    my $ignored_terms = join(" ", @stopwords_ignored);
    if( $IGNORED_WORDS{$lang} ) {
      $IGNORED_WORDS{$lang} =~ s/<WORDS>/$ignored_terms/gs;
      $h{'ignored_terms'} = $IGNORED_WORDS{$lang};
    }
  } else {
    $h{'ignored_terms'} = "";
  }

  my $current_page = $p;
  $current_page ||= 1;

  my ($first, $last); 
  if( !$ENV{'REQUEST_METHOD'} ) {
    # Called in a shell, don't limit results
    $first = 0;
    $last = values(%answer);
  } else {
    $first = ($current_page - 1) * $RESULTS_PER_PAGE; 
    $last  = $first + $RESULTS_PER_PAGE - 1;
  }
  
  my $percent_factor = 0;
  if( $PERCENTAGE_RANKING ) {
    my $max_score = 0;
    foreach my $doc_ranking (values %answer) {
      $max_score = $doc_ranking if( $doc_ranking > $max_score );
    }
    $percent_factor = 100/$max_score if( $max_score );
  }
  
  my @keys;
  if( defined($query->param('sort')) && $query->param('sort') eq 'title' ) {
    @keys = sort {uc($titles_db{$a}) cmp uc($titles_db{$b})} (keys %answer);
  } else {
    @keys = sort {$answer{$b} <=> $answer{$a}} (keys %answer);
  }
  my $real_last = keys(%answer);
  if( $MAX_RESULTS > 0 ) {
    if( $real_last > $MAX_RESULTS ) {
      $real_last = $MAX_RESULTS;
    }
  }
  if ($last >= $real_last) {
    $last = $real_last - 1;
  }
  $h{'first_number'} = $first+1;
  $h{'last_number'} = $last+1;
  
  my $result_count = 0;
  foreach (@keys[$first..$last]) {
    my $score = $answer{$_};
    if( $PERCENTAGE_RANKING ) {
      $score = sprintf("%.f", $score*$percent_factor);
      $score .= '%';
    } else {
      $score = sprintf("%.2f", $score/100);
    }
    my $desc = get_summary($_, $q);
    my $visible_url;
    if( $HTTP_START_URL ) {
      # we've been fetching pages via http - no need to escape (again):
      $url = $docs_db{$_};
      $visible_url = $docs_db{$_};
    } else {
      $url = $BASE_URL.my_uri_escape($docs_db{$_});
      $visible_url = $BASE_URL.$docs_db{$_};
    }
    my $show_url = CGI::escape($docs_db{$_});
    my $date;
    if( $dates_db{$_} != -1 ) {
      $date = POSIX::strftime($DATE_FORMAT, localtime($dates_db{$_}));
    } else {
      $date = '-';
    }
    my $highlight_link = "";
    if( $HIGHLIGHT_MATCHES && isHTML($url) && $HIGHLIGHT_TERMS{$lang} ) {    # TODO: solve this better...
      $highlight_link = "(<a href=\"$SEARCH_URL?q=".my_uri_escape($q).
        "&amp;showurl=$show_url\">$HIGHLIGHT_TERMS{$lang}</a>)";
    }
    my $title = get_title_highlight($titles_db{$_}, $q);
    $template->cast_loop ("results", [{rank => $first+(++$rank), 
                       url => $url,
                       highlight_link => $highlight_link,
                       visibleurl => $visible_url, 
                       title => $title, 
                       date => $date, 
                       score => $score,
                       description => $desc,
                       size => sprintf("%.0f", $sizes_db{$_}/1000) || 1,
                      }]);
    $result_count++;
  }
  $template->finalize("results");
  $h{'results_num'} = $real_last;
  
  my $last_page = ceil($real_last, $RESULTS_PER_PAGE);
  $last_page ||= 1;
  $lang = CGI::escape($lang);
  # Note: Keep order of arguments as in search_form.html to get correct visited link recognition:
  # Note that using "&amp;" is correct, "&" isn't. 
  my $queries = "&amp;lang=".CGI::escape($lang);
  $queries .= "&amp;include=".CGI::escape($include);
  $queries .= "&amp;exclude=".CGI::escape($exclude);
  $queries .= "&amp;penalty=".CGI::escape($penalty);
  if( defined($query->param('sort')) ) {
    $queries .= "&amp;sort=".CGI::escape($query->param('sort'));
  }
  $queries .= "&amp;mode=".CGI::escape($mode);
  $queries .= "&amp;q=".CGI::escape($q);
  if( $lang eq 'text' ) {
    # avoid warnings for $NEXT_PAGE{$lang}
    $lang = 'en';
  }
  if ($current_page == 1) {
    $h{'previous'} = "";
    if ($last_page > $current_page) {
      $h{'next'} = "<a href=\"$SEARCH_URL?p=2$queries\">$NEXT_PAGE{$lang}</a>";
    } else {
      $h{'next'} = "";
    }
  } elsif ($current_page == $last_page) {
    $h{'previous'} = "<a href=\"$SEARCH_URL?p=".($last_page-1)."$queries\">$PREV_PAGE{$lang}</a>";
    $h{'next'} = "";
  } else {
    $h{'previous'} = "<a href=\"$SEARCH_URL?p=".($current_page-1)."$queries\">$PREV_PAGE{$lang}</a>";
    $h{'next'} = "<a href=\"$SEARCH_URL?p=".($current_page+1)."$queries\">$NEXT_PAGE{$lang}</a>";
  }
  
  for (1..$last_page) {
    if ($_ != $current_page) {
      $h{'navbar'} .= "<a href=\"$SEARCH_URL?p=$_$queries\">$_</a> ";
    } else {
      $h{'navbar'} .= "<strong>$_</strong> ";
    }
  }

  $h{'current_page'} = $current_page;
  $h{'total_pages'}  = $last_page;
  $h{'search_url'}   = $SEARCH_URL;

  $h{'search_time'} = '';
  # Show time needed to search:
  if( $start_time ) {
    $h{'search_time'} = sprintf(" in %.2f seconds", Time::HiRes::tv_interval($start_time));
  }
  
  $template->cast(\%h);
  return $template->html;
}

sub get_title_highlight {
  my $title = $_[0];
  my @terms = split(" ", normalize_special_chars($_[1]));
  foreach my $term (@terms) {
    $title = term_emphasize($title, $term);
  }
  return $title;
}

# Log the query in a file, using this format:
# REMOTE_HOST;date;terms;matches;current page;(time to search in seconds);
# For the last value you need to use Time::HiRes (see top of the script)
sub log_query {
  return if( ! $LOG );

  my $elapsed_time = sprintf("%.2f", Time::HiRes::tv_interval($start_time)) if( $start_time );
  my @line = ();
  my $addr = $ENV{'REMOTE_HOST'} || $ENV{'REMOTE_ADDR'};
  push(@line, $addr || '-',
              get_iso_date(), 
              $query->param('q') || '-',
              scalar(keys %answer),
              $query->param('p') || 1,
              $elapsed_time || '-');
  
  use Fcntl ':flock';        # import LOCK_* constants
  open(LOG, ">>$LOGFILE") or die "Cannot open logfile '$LOGFILE' for writing: $!";
  flock(LOG, LOCK_EX);
  seek(LOG, 0, 2);
  print LOG join(';', @line).";\n";
  flock(LOG, LOCK_UN);
  close(LOG);
}

sub normalize {
  my $buffer = $_[0];

  $buffer =~ s/-(\s*\n\s*)?//g; # join parts of hyphenated words

  if( $SPECIAL_CHARACTERS ) {
    # We don't have special characters in our index, so don't try to search for them:
    $buffer =~ s/[∆Ê]/ae/gs;
    $buffer =~ s/[ﬁ˛]/th/igs;
    $buffer =~ s/ﬂ/ss/gs;
    $buffer =~ tr/ƒ≈∆«»“…‹” Ê›‘ÀÁﬁ’Ã˙ÒËﬂ÷Õ˚ÚÈ‡Œ¸ÛÍ·ÿœ˝ÙÎ‚Ÿ–˛ıÏ„⁄—ˇˆÌ‰€¿ÓÂ¡¯Ô¬˘√/AAACEOEUOEaYOEecTOIunesOIuoeaIuoeaOIyoeaUEtoiaUNyoiaUAiaAoiAuA/;
  }

  if ($INDEX_NUMBERS) {
    $buffer =~ s/(<[^>]*>)/ /gs;
  } else {
    $buffer =~ s/(\b\d+\b)|(<[^>]*>)/ /gs;
  }

  $buffer =~ tr/a-zA-Z0-9_/ /cs;
  $buffer =~ s/^\s+//;
  $buffer =~ s/\s+$//;
  return lc $buffer;
}

# Returns the content of the META description tag or the context of the match,
# if $CONTEXT_SIZE is enabled:
sub get_summary {
  my $id = $_[0];
  my @terms = split(" ", normalize_special_chars($_[1]));
  # +/- operators aren't interesting here:
  foreach my $term (@terms) {
    $term =~ s/^(\+|\-)//;
  }
  my $desc;
  if( $CONTEXT_SIZE ) {
    $desc = get_context($content_db{$id}, @terms);
  }    
  if( ! defined($desc) ) {
    $desc = $desc_db{$id};
    foreach my $term (@terms) {
      $desc = term_emphasize($desc, $term);
    }
  }
  return $desc;
}

# Get contexts for all the queried terms. Return "" if no context is found.
sub get_context {
  my $buf = shift;
  my @terms = @_;
  my @contexts;
  foreach my $term (@terms) {
    if( ! is_ignored(remove_accents(normalize_special_chars($term))) ) {
      push(@contexts, get_context_for_term($buf, $term));
    }
  }
  my $context = "";
  my $ct = 0;
  foreach my $result (@contexts) {
    $context .= "...".$result."...";
    $context .= "<br>" if( $ct < scalar(@contexts)-1 );
    $context .= "\n";
    $ct++;
  }
  return $context;
}

# Get up to $CONTEXT_EXAMPLES strings for a term.
sub get_context_for_term {
  my $desc = shift;
  my $term = shift;    # is normalized already
  my @contexts = ();
  my $ct = -1;
  my $context_ct = 0;
  # find occurences of a single term:
  my @desc_array_normalized = split(" ", $desc);
  my @desc_array = split(" ", $desc);
  my $last_prev = 0;
  foreach my $term_in_desc (@desc_array_normalized) {
    $ct++;
    $term_in_desc = normalize_special_chars($term_in_desc);
    $term_in_desc = remove_accents($term_in_desc);
    my $term_normalized = remove_accents($term);  # hopefully we don't need normalize_... here
    $term_normalized =~ s/[$punct]//g;
    $term_in_desc =~ s/[$punct]//g;
    if( lc($term_normalized) eq lc($term_in_desc) ) {

       # get surroundings of matched word:
       my $first = $ct - int(($CONTEXT_DESC_WORDS/2));
       my $last = $ct + int(($CONTEXT_DESC_WORDS/2));
       if( $first <= 0 ) {
         $first = 0;
       }
       if( $last > scalar(@desc_array) ) {
         $last = scalar(@desc_array)-1;
       }
       # don't repeat context (if matched term are near each other):
       next if ( $first < $last_prev );
       $last_prev = $last;

       $context_ct++;
       last if( $context_ct > $CONTEXT_EXAMPLES );

       my $context = join(" ", @desc_array[$first..$last]);
       if( $ENV{'REQUEST_METHOD'} ) {
         $context = term_emphasize($context, $term);
       }
       push(@contexts, $context);
    }
  }
  return @contexts;
}

sub term_emphasize {
  my $str = $_[0];
  my $term = $_[1];
  # "H‰user" also matches "Hauser" so be fair and emphasize that, too:
  my $term_no_accents = lc(remove_accents($term));
  # Emphasize the term. Using a RegEx with \b is not enough, as the term may 
  # contain "&" which would be taken as a word boundary:
  # TODO?: foo&nbsp;bar -- "foo" will not be emphasized
  my @str_array = split(" ", $str);
  foreach $term_in_str (@str_array) {
    my $term_in_str_compare = $term_in_str;
    $term_in_str_compare =~ s/[$punct]//g;
    $term_in_str_compare =~ s/;;$/;/g;    # special char at the end
    my $term_in_str_no_accents = lc(remove_accents($term_in_str_compare));
    if( lc($term_in_str_compare) eq lc($term) || lc($term_in_str_compare) eq $term_no_accents ||
         $term_in_str_no_accents eq $term_no_accents ) {
      $term_in_str = "<strong>$term_in_str</strong>";
      # do not emphasize punctuation (doesn't work for semicolon):
      $term_in_str =~ s/<strong>([$punct]+)/$1<strong>/;
      $term_in_str =~ s/([$punct]+)<\/strong>/<\/strong>$1/;
    }
  }
  return join(" ", @str_array);
}

sub stem {
  my $str = $_[0];
  $str = substr $str, 0, $STEMCHARS if $STEMCHARS;
  return $str;
}

sub ceil {
  my $x = $_[0];
  my $y = $_[1];

  if ($x % $y == 0) {
    return $x / $y;
  } else {
    return int($x / $y + 1);
  }
}

# Returns an array with elements that are in both @{$ra} and @{$rb}.
sub intersection {
  my ($ra, $rb) = @_;
  my @i;
  # use a hash (instead of grep) for much better speed:
  my %check = ();
  foreach my $element (@{$rb}) {
    $check{$element} = 1;
  }
  foreach my $doc_id (@{$ra}) {
    push @i, $doc_id if( $check{$doc_id} );
  }
  return @i;
}

# Returns an array with the elements of @{$ra} minus those of @{$rb}.
sub minus {
  my ($ra, $rb) = @_;
  my @i;
  # use a hash (instead of grep) for much better speed:
  my %check = ();
  foreach my $element (@{$rb}) {
    $check{$element} = 1;
  }
  foreach my $doc_id (@{$ra}) {
    push @i, $doc_id if( ! defined($check{$doc_id}) );
  }
  return @i;
}

# Return current date and time in ISO 8601 format, i.e. yyyy-mm-dd hh:mm:ss
sub get_iso_date {
  use Time::localtime;
  my $date = (localtime->year() + 1900).'-'.two_digit(localtime->mon() + 1).'-'.two_digit(localtime->mday());
  my $time = two_digit(localtime->hour()).':'.two_digit(localtime->min()).':'.two_digit(localtime->sec());
  return "$date $time";
}

# Returns "0x" for "x" if x is only one digit, otherwise it returns x unmodified.
sub two_digit {
  my $value = $_[0];
  $value = '0'.$value if( length($value) == 1 );
  return $value;  
}

# Escape some special characters in URLs. This function escapes each part
# of the path (i.e. parts delimited by "/") on its own.
sub my_uri_escape {
    my $str = shift;
    my @parts = split("(/)", $str);
    foreach my $part (@parts) {
      if( $part ne '/' ) {
        $part = CGI::escape($part);
      }
    }
    $str = join("", @parts);
    return $str;
}

# Shut up misguided -w warnings about "used only once". Has no functional meaning.
sub CGI_pl_sillyness {
  my $zz;
  $zz = $DOCUMENT_ROOT;
  $zz = $SPECIAL_CHARACTERS;
  $zz = $VERSION;
  $zz = $INDEX_NUMBERS;
  $zz = $DEFAULT_LANG;
  $zz = $BASE_URL;
  $zz = $CONTEXT_EXAMPLES;
  $zz = $CONTEXT_SIZE;
  $zz = $HTTP_START_URL;
  $zz = $DATE_FORMAT;
  $zz = $INDEX_DATE_FORMAT;
  $zz = $HIGHLIGHT_TERMS;
  $zz = $MINLENGTH;
}

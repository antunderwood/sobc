# Perlfect Search - file system indexing
#$rcs = ' $Id: indexer_filesystem.pl,v 1.15 2003/02/24 22:45:42 daniel Exp $ ' ;

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

# Currently empty.
sub init_filesystem {
}

# Recursively traverse the filesystem, but ignore the files on @no_index.
sub crawl_filesystem {
  my $dir = $_[0];
  my $doc_id;
  my $file;

  my $tempdir = $dir;
  if( $ENV{'REQUEST_METHOD'} ) {
    $tempdir = html_escape($tempdir);
  }
  print "$em$tempdir$em_end$br";

  chdir $dir or (warn "Cannot chdir $dir: $!" and return);
  opendir(DIR, $dir) or (warn "Cannot open $dir: $!" and return);
  my @contents = readdir DIR;
  closedir(DIR);

  # to ignore symbolic links, add "and not -l" to both greps:
  my @dirs  = grep {-d and not /^\.{1,2}$/} @contents; 
  my @files = grep {-f and /^.+\.(.+)$/ and grep {/^\Q$1\E$/} @EXT} @contents;

  FILE: foreach my $f (@files) {
    $file = $dir."/".$f;
    $file =~ s/\/\//\//og;

    next FILE if( to_be_ignored($file) );

    # loading the file:
    my $buffer = "";
    my $ext = get_suffix($file);
    if( $ext ) {
      if( $EXT_FILTER{$ext} ) {
        $buffer = filterFile($file, $ext);
      } else {
        my $tmp = $/;
        undef $/;
        open(FILE, $file) or (warn "Cannot open '$file': $!" and $DN-- and next);
        binmode(FILE);        # for reading PDF files under Windows NT
        $buffer = <FILE>;
        close(FILE);
        $/ = $tmp;
      }
    }

    # check robot meta tags (but NOT nofollow, it doesn't make sense for local indexing):
    my $meta_tags = robot_meta_tag(\$buffer);
    if( $meta_tags eq "noindex" || $meta_tags eq "none" ) {
        print STDERR "'$file': META tags forbid indexing\n" if( $HTTP_DEBUG );
        next;
    }

    $doc_id = record_file($file);
    $filesize = (-s $file);
    my $date = (stat($file))[9];
    index_file($file, $doc_id, $filesize, $date, \$buffer);
  }

  DIR: foreach my $d (@dirs) {
    $file = $dir."/".$d;
    $file =~ s/\/\//\//og;

    next DIR if( to_be_ignored($file) );

    crawl_filesystem($file);
  }
}

1;

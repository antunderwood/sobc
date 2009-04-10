#!/usr/bin/perl -w
# $rcs = ' $Id: setup.pl,v 1.26 2003/02/24 15:23:44 daniel Exp $ ' ;    

# Perlfect Search - Setup Utility
#
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

my $VERSION = '3.31';
use File::Copy;

# people who install manually might leave this script in cgi-bin, which is a bad idea:
if( $ENV{'REQUEST_METHOD'} ) {
  print "Content-Type: text/plain\n\n";
  print "Error: for security reasons, this program is not supposed to be called via CGI.\n";
  exit;
}

print "
Perlfect Search $VERSION Setup Utility

WARNING: There is no guarantee implicit or explicit that this program 
will work correctly. By using this program you automatically indemnify 
Perlfect Solutions of any damage or harm directly or indirectly caused 
by its operation. Use it at your own risk!

";
exit if(input("Are you sure you want to continue? [y/n]", "y", ["y","n"]) eq "n");

# Check for DB_File
if( ! eval("require DB_File") ) 
  {
    print "*** ERROR: The required DB_File module was not found on your system.\n";
    print "*** Please check the FAQ at\n";
    print "*** http://www.perlfect.com/freescripts/search/faq.shtml\n\n";
    exit;
  }

my $os = input("What operating system is your site running on? [unix/nt]", "unix", ["unix", "nt"]);

my $perl;
if($os eq 'unix')
  {
    $perl = `which perl`;
    chomp $perl;
    $perl='/usr/bin/perl' unless ($perl);
    $perl = input("Where is perl? [$perl]", "$perl", []);
    print "Ok, I will configure the scripts to run with $perl\n";
    set_perl_path("search.pl", $perl);
    set_perl_path("indexer.pl", $perl);
  }
print "\n";

my $baseurl = input("What is the base URL of your site? (e.g. http://www.perlfect.com/)", "", []);
my $cgiurl = input("And what is the URL of your cgi-bin directory? (e.g. http://www.perlfect.com/cgi-bin/)", "", []);

my $documentroot = input("Which directory is your site in? (e.g. /home/httpd/html/)", "", []);
my $cgidir = input("Where is your cgi-bin directory? (e.g. /home/httpd/cgi-bin/)", "", []);

# Add slashes at the end (but no slash for $baseurl)
foreach ($documentroot, $cgidir, $cgiurl)
  {
    $_ =~ s/\/$//;
    $_ .= '/';
  }
$baseurl =~ s/\/$//;
my $instdir=$cgidir."perlfect/search/";
my $insturl=$cgiurl."perlfect/search/";

print "
I will now install Perlfect Search $VERSION in
$instdir

";
# Note that setup.pl does not get installed, as it's only needed once
install_dir($cgidir."perlfect", "0755");
install_dir($cgidir."perlfect/search", "0755");
install_file("search.pl", $instdir."search.pl", "0755");
# For security reasons, only the user can start the indexer:
install_file("indexer.pl", $instdir."indexer.pl", "0700");
# The user will have to set permissions manually:
install_file("indexer_web.pl", $instdir."indexer_web.pl", "0600");
install_file("indexer_filesystem.pl", $instdir."indexer_filesystem.pl", "0600");
install_file("tools.pl", $instdir."tools.pl", "0644");
install_file("conf.pl", $instdir."conf.pl", "0644");
install_dir($instdir."data", "0755");
install_dir($instdir."temp", "0755");
install_dir($instdir."conf", "0755");
install_file("conf/stopwords.txt", $instdir."conf/stopwords.txt", "0644", "keep");
install_file("conf/stopwords_dutch.txt", $instdir."conf/stopwords_dutch.txt", "0644", "keep");
install_file("conf/stopwords_german.txt", $instdir."conf/stopwords_german.txt", "0644", "keep");
install_file("conf/stopwords_french.txt", $instdir."conf/stopwords_french.txt", "0644", "keep");
install_file("conf/stopwords_italian.txt", $instdir."conf/stopwords_italian.txt", "0644", "keep");
install_dir($instdir."templates", "0755");
install_file("templates/search.txt", $instdir."templates/search.txt", "0644", "keep");
install_file("templates/search.html", $instdir."templates/search.html", "0644", "keep");
install_file("templates/search_de.html", $instdir."templates/search_de.html", "0644", "keep");
install_file("templates/search_fr.html", $instdir."templates/search_fr.html", "0644", "keep");
install_file("templates/search_it.html", $instdir."templates/search_it.html", "0644", "keep");
install_file("templates/no_match.txt", $instdir."templates/no_match.txt", "0644", "keep");
install_file("templates/no_match.html", $instdir."templates/no_match.html", "0644", "keep");
install_file("templates/no_match_de.html", $instdir."templates/no_match_de.html", "0644", "keep");
install_file("templates/no_match_fr.html", $instdir."templates/no_match_fr.html", "0644", "keep");
install_file("templates/no_match_it.html", $instdir."templates/no_match_it.html", "0644", "keep");
install_dir($instdir."Perlfect", "0755");
install_file("Perlfect/Template.pm", $instdir."Perlfect/Template.pm", "0644");


print "
Now I need you to tell me what file types will be indexed by Perlfect Search.

";
my @filetypes = ();
push(@filetypes, '"htm"') if(input("Do you want to index .htm files? [y/n]", "y", ['y','n']) eq "y");
push(@filetypes, '"html"') if(input("Do you want to index .html files? [y/n]", "y", ['y','n']) eq "y");
push(@filetypes, '"shtml"') if(input("Do you want to index .shtml files? [y/n]", "y", ['y','n']) eq "y");
#push(@filetypes, '"stm"') if(input("Do you want to index .stm files? [y/n]", "y", ['y','n']) eq "y");
push(@filetypes, '"asp"') if(input("Do you want to index .asp files? [y/n]", "n", ['y','n']) eq "y");
#push(@filetypes, '"stx"') if(input("Do you want to index .stx files? [y/n]", "n", ['y','n']) eq "y");
push(@filetypes, '"txt"') if(input("Do you want to index .txt files? [y/n]", "n", ['y','n']) eq "y");
my $other_filetypes = input("Any other filetypes? (enter a comma-separated list of file extensions or press return)", "", []);
foreach (split(/,/, $other_filetypes))
  {
    $_ =~ s/\s//g;
    $_ =~ s/\'//g;
    $_ =~ s/^\.//;
    $_ = "\"$_\"";
    push(@filetypes, $_);
  }
my $filetype_list = join(",", @filetypes);


print "Configuring Perlfect Search...\n";

open(CONF, "./conf.pl")
  or die "\n** Could not open './conf.pl': $!\n";
my $slash = $/;
undef $/;
my $conf = <CONF>;
$/ = $slash;
close(CONF);

$conf = replace_option($conf, '\$DOCUMENT_ROOT', "'$documentroot'");
$conf = replace_option($conf, '\$BASE_URL', "'$baseurl'");
$conf = replace_option($conf, '\$CGIBIN', "'$insturl'");
$conf = replace_option($conf, '\$INSTALL_DIR', "'$instdir'");
$conf = replace_option($conf, '\@EXT', "($filetype_list)");

open(CONF, ">$instdir/conf.pl")
  or die "\n** Could not open '$instdir/conf.pl': $!\n";
print CONF $conf;
close CONF;



unless(-e "$instdir/conf/no_index.txt")
  {
    open(EXCLUDE, ">$instdir/conf/no_index.txt")
      or die "Cannot open '$instdir/conf/no_index.txt': $!\n";
    print EXCLUDE $cgidir."*";
    close EXCLUDE;
  }

print "
Perlfect Search $VERSION has been installed on your system.
";
input("-- press enter to continue --", "", []);
system('clear') if($os eq 'unix');

if($os eq 'unix')
  {
    if(input("Do you want me to test the indexer? (this might take some time) [y/n]", "y", ["y", "n"]) eq "y")
      {
    my $rv = system("cd $instdir; ./indexer.pl");
    if($rv)
      {
        print "
It seems the indexer failed to index the site. Please refer to
http://www.perlfect.com/freescripts/search/faq.shtml for 
troubleshooting information.
";
        exit;
      }
      }
    input("-- press enter to continue --", "", []);
    system('clear') if($os eq 'unix');
    my $sendmail;
    my $whereis = `whereis sendmail`;
    if($whereis=~m/^sendmail: (\S+)/)
      {
	    my @sendmails = split(/\s+/, $whereis);
	    foreach my $sendmail (@sendmails)
		{
		  if( $sendmail =~ m/\/sendmail$/ ) {
		    # Suse 7.2 lists /usr/sbin/sendmail.nissl first, which fails

    			print "
We would like to know the people that use Perlfect Search so that we
may notify them by email when upgrades become available. I can try to 
send your registration email automatically if you are online right now.
It will only take a few seconds and it will ensure you are up to
date with the development of Perlfect Search.
";
    			if(input("Do you want to register by email now? [y/n]", "y", ["y", "n"]) eq "y")
    			  {
        			my $name = input("What is you name?", "", []);
        			my $email = input("What is your email address?", "", []);
        			my $date = localtime(time());
        			if(open (MAIL, "|$sendmail -t"))
        			  {
        			print MAIL "From: $email\n";
        			print MAIL "To: perlfect-search-announce-request\@perlfect.com\n";
        			print MAIL "Subject: subscribe\n";
        			print MAIL "Content-type: text/plain\n\n";
        			print MAIL "subscribe\n";
        			print MAIL "-- \n";
        			print MAIL "Name      $name\n";
        			print MAIL "Email     $email\n";
        			print MAIL "Version   $VERSION\n";
        			print MAIL "Site      $baseurl\n";
        			print MAIL "Date      $date\n";
        			close MAIL;
        			print "
Thank you. Your registration email has been sent. To make sure nobody
else can subscribe you, you'll soon receive an email that you need to
reply to. After that, you'll be on the mailing list.
			";
        			input("-- press enter to continue --", "", []);
        			system('clear');
        			  }
        			else
        			  {
        			print "
There was an error using your sendmail program. IF you want, you can register
by going to Perlfect Search's website http://www.perlfect.com/freescripts/search/
and following the instructions there to subscribe to our announcements mailing
list.
			";
        			  }
    			  }

		    last;
		  }
	    }
      }
  }

print "
Perlfect Search should now be installed correctly. To find out 
how to index your site and integrate Perlfect Search with your pages, 
please refer to the README or to the FAQ which can be found at
http://www.perlfect.com/freescripts/search/faq.shtml
Also have a look at the file perlfect/search/conf.pl, which contains
many options for tuning Perlfect Search.

If you think you have found a bug, or have a comment/suggestion to
make that is not covered in the FAQ, please subscribe to the mailing list at
http://perlfect.com/mailman/listinfo/perlfect-search

Thanks for choosing Perlfect Search for your site.
Perlfect Solutions - http://www.perlfect.com

";

exit;


sub install_dir
  {
    my ($dir, $permissions) = @_;
    print "Setting up $dir\n";
    if(-e $dir)
      {
    if(-d $dir)
      {
        print "**Directory already exists.\n";
      }
    else
      {
        print "**$dir is not a directory.\n";
        print "**I'd better not touch it then\n**Aborting.\n";
        exit(1);
      }
      }
    else
      {
    unless(mkdir($dir, oct($permissions)))
      {
        print "**Cannot create $dir: $!\n";
        print "**Aborting.\n";
        exit(1);
      }
      }
    unless(chmod(oct($permissions), $dir))
      {
    print "**Cannot set permissions for $dir: $!\n";
    print "**Aborting.\n";
    exit(1);
      }
  }



sub install_file
  {
    my ($source, $destination, $permissions, $keepold) = @_;
    print "Installing $source to $destination\n";
    my $uninstall;
    if(-e $destination)
      {
    print "**$destination already exists.\n";
    if($keepold)
      {
        print "**Preserving existing $destination\n";
        return;
      }
    if(rename("$destination", "$destination.bak"))
      {
        print "**I kept a backup in $destination.bak\n";
      }
    else
      {
        print "**Cannot backup the file: $!\n**Aborting.\n";
        exit(1);
      }
      }
    if( ! copy($source, $destination) )
      {
    print "**Cannot copy $source to $destination: $!\n**Aborting.";
    exit(1);
      }
    unless(chmod(oct($permissions), $destination))
      {
    print "**Cannot set permissions for $destination: $!\n**Aborting.\n";
    exit(1);
      }
  }


sub set_perl_path
  {
    my ($file, $path) = @_;
    print "Setting perl path in $file.\n";
    my $source = "#!$path -w\n";
    open(SRC, "$file") or die "Cannot open '$file': $!\n";
    my $dump = <SRC>;
    while(<SRC>)
      {
    $source .= $_;
      }
    close SRC;
    open(DST, ">$file") or die "Cannot open '$file': $!\n";
    print DST $source;
    close DST;
  }


sub input
  {
    my ($question, $default, $options) = @_;
    print "$question\n: ";
    my $answer = <>;
    chomp $answer;
    print "\n";
    $answer = $default unless $answer;
    unless(scalar(@$options)==0 or member($options, $answer))
      {
    print "Invalid option. Please select one of: ";
    print join(",", @$options)."\n";
    return input($question, $default, $options);
      }
    return $answer;
  }


sub member
  {
    my ($ary, $el) = @_;
    foreach (@$ary)
      {
    return 1 if($_ eq $el);
      }
    return 0;
  }


sub replace_option
  {
    my $str = shift;
    my $option = shift;
    my $value = shift;
    my $optionnew = $option;
    $optionnew =~ s/\\//;
    $str =~ s/^$option.*$/$optionnew = $value;/gm;
    return $str;
  }

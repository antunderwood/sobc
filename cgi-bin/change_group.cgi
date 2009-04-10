#!/usr/bin/perl 
use CGI;
use CGI::Carp qw(fatalsToBrowser);
my $sitepath="/web/sites/341/sobc/www.southoxheybaptistchurch.org.uk/images/";
my $cgi=new CGI;
print $cgi->header();
print $cgi->start_html();
my $error=`chgrp www $sitepath`;
print "error:", $error;
@args=("chgrp",  "www", $sitepath);
system(@args) == 0
	or die "system @args failed: $?";
print $cgi->end_html();

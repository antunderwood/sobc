#!/usr/bin/perl
use lib "/web/sites/341/sobc/www.southoxheybaptistchurch.org.uk/perllibs";
use CGI;
use CGI::Carp qw(fatalsToBrowser);
require "sendmail.pl";


my $cgi=new CGI;
print $cgi->header();
print $cgi->start_html();
my $to="ants\@f2s.com";
my $cc="";
my $from="ants\@f2s.com";
my $subject="Test from sendmail";
my $message="Here are the contents";

sendmail(to=>$to, cc=>$cc, from=>$from, subject=>$subject, message=>$message);
print "<br>Mail Sent";
print $cgi->end_html();

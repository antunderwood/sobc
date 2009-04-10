#!/usr/bin/perl 
my $sitepath="/web/sites/341/sobc/www.southoxheybaptistchurch.org.uk"; 
my $website="http://www.southoxheybaptistchurch.org.uk"; 
use CGI;
use CGI::Carp qw(fatalsToBrowser);


my $cgi=new CGI;
print $cgi->header();
print $cgi->start_html(-title=>"Site Map Generator");

`python sitemap_gen.py --config=config.xml --testing`;

print "site map generated at http://www.southoxheybaptistchurch.org.uk/sitemap.xml";

print $cgi->end_html();
#!/usr/bin/perl
use CGI;
use CGI::Carp qw(fatalsToBrowser);
use lib "/home/southorg/public_html/perllibs";
use HTML::Mason::CGIHandler;

my $cgi=new CGI;


my $h = HTML::Mason::CGIHandler->new(
                  data_dir  => '/home/southorg/tmp/',
                  allow_globals => [qw(%session $u)],
        );
                        
$h->handle_request; 

#!/usr/bin/perl 
my $sitepath="/home/southorg/public_html"; 
my $website="http://www.southoxheybaptistchurch.org.uk"; 
use CGI;
use CGI::Carp qw(fatalsToBrowser);


my $cgi=new CGI;
print qw(<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
&nbsp;5 &ldquo;No, we don&rsquo;t know, Lord,&rdquo; Thomas said. &ldquo;We have no idea where you are going, so how can we know the way?&rdquo;<br>Site Config Done
</body>
</html>);
# print $cgi->header();
# print $cgi->start_html();
# 
# print "&nbsp;5 &ldquo;No, we don&rsquo;t know, Lord,&rdquo; Thomas said. &ldquo;We have no idea where you are going, so how can we know the way?&rdquo;";
# print "<br>Site Config Done";
# print $cgi->end_html();

# print "<html><head><title>Bible Passade</title></head><body>
# &nbsp;5 &ldquo;No, we don&rsquo;t know, Lord,&rdquo; Thomas said. &ldquo;We have no idea where you are going, so how can we know the way?&rdquo;
# </body></html>";
#!/usr/bin/perl 
my $sitepath="/home/southorg/public_html"; 
my $website="http://www.southoxheybaptistchurch.org.uk"; 
use CGI;
use CGI::Carp qw(fatalsToBrowser);


my $cgi=new CGI;
print $cgi->header();
print $cgi->start_html();

chdir($sitepath); 

@stuff=`find . -type f -name "*.mhtml"`; 
open(O,">sitemap.xml") or die "Can't open xml file for writing : $!";; 
print O <<EOF;
<?xml version="1.0" encoding="UTF-8"?> 
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd"> 
EOF
foreach (@stuff) { 
 chomp; 
 $badone=$_; 
 $badone =~ tr/-_.\/a-zA-Z0-9//cd; 
 print if ($badone ne $_); 
 s/^..//; 
$rfile="$sitepath/$_"; 
($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$mtime,$ctime,$blksize ,$blocks)=stat 
$rfile; 
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst)=localtime($mtime); 
$year +=1900; 
$mon++; 
$mod=sprintf("%0.4d-%0.2d-%0.2dT%0.2d:%0.2d:%0.2d+00:00",$year,$mon,$mday,$ hour,$min,$sec); 
$mod=sprintf("%0.4d-%0.2d-%0.2d",$year,$mon,$mday); 
$freq="monthly"; 
$freq="daily" if /index.html/; 
$priority="0.5"; 
$priority="0.7" if /index.html/; 
$priority="0.9" if /\/index.html/; 

if ($_ !~ /holding/ && $_ !~ /google/ && $_ !~ /editor/ && $_ !~ /templates/ && $_ !~ /edit/ && $_ !~ /mason/ && $_ !~ /^_/){
	print O <<EOF;
	<url> 
	      <loc>$website/$_</loc> 
	      <lastmod>$mod</lastmod> 
	      <changefreq>$freq</changefreq> 
	      <priority>$priority</priority> 
	</url> 
EOF
}

} 

print O <<EOF; 
</urlset> 
EOF
close O; 
#unlink("sitemap.xml"); 
# system("gzip sitemap");
print "<br>Site Config Done";
print $cgi->end_html();
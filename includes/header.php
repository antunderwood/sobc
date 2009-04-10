<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="Keywords" content="Church,Christian,Jesus,Baptist,South Oxhey,Watford,Hertfordshire">
	<meta name="description" content="South Oxhey Baptist Church - Friendly Bible-believing church in South Oxhey near Watford.">
	<style type="text/css" media="all">
		@import "/css/sobc.css";
	</style>
	<title>South Oxhey Baptist Church</title>
	<script language="javascript">
	sfHover = function() {
		var sfEls = document.getElementById("linkList2").getElementsByTagName("LI");
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() {
				this.className+=" sfhover";
			}
			sfEls[i].onmouseout=function() {
				this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
			}
		}
	} 
	if (window.attachEvent) window.attachEvent("onload", sfHover);
	</script>
	<script src="http://maps.google.co.uk/maps?file=api&v=2&key=ABQIAAAAOXRDObQXKO6TqkaeH1QD_hSxASmYSXfKd_MzuqJoMusPKVzvPRSSpzzVYz3Ai8q1idvrzSiPfI4EqQ" type="text/javascript">
	</script>

<?if (preg_match("/\/teaching\//", $_SERVER['REQUEST_URI'])) {?>
	<!-- thickbox stuff -->
	<script type="text/javascript" src="<?= $html_root?>/javascript/jquery.js"></script>
	<script type="text/javascript" src="<?= $html_root?>/javascript/thickbox.js"></script>
	<link rel="stylesheet" href="<?= $html_root?>css/thickbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?= $html_root?>/css/bible_passage.css" type="text/css" media="screen" />
	<!-- end of thickbox stuff -->
<?}?>
</head>


<?if (preg_match("/\/about\/where\.php/", $_SERVER['REQUEST_URI'] )) {?>
<body id="sobc" onload="showMap(map);">
<?}else{?>
<body id="sobc">
<?}?>

<div id="container">
	<div id="top">
<?if (preg_match("/index.*\.php/", $_SERVER['REQUEST_URI']) ||  $_SERVER['REQUEST_URI']  == "" || $_SERVER['REQUEST_URI'] == "/") {?>
		<div id="pageHeader">
			<a href="/index.php"><h1>South Oxhey<br>Baptist Church</h1></a>
			<h3>140 Gosforth Lane South Oxhey WD19 7BX : 0208 421 4054 <br> <a HREF="mailto:&#105;&#110;&#102;&#111;&#064;&#115;&#111;&#117;&#116;&#104;&#111;&#120;&#104;&#101;&#121;&#098;&#097;&#112;&#116;&#105;&#115;&#116;&#099;&#104;&#117;&#114;&#099;&#104;&#046;&#111;&#114;&#103;&#046;&#117;&#107;">&#105;&#110;&#102;&#111;&#064;&#115;&#111;&#117;&#116;&#104;&#111;&#120;&#104;&#101;&#121;&#098;&#097;&#112;&#116;&#105;&#115;&#116;&#099;&#104;&#117;&#114;&#099;&#104;&#046;&#111;&#114;&#103;&#046;&#117;&#107;</a></h3>
			<h2></h2>
		</div>
<?}else{?>
		<div id="short_pageHeader">
			<a href="/index.php"><h1>South Oxhey<br>Baptist Church</h1></a>
			<h3>140 Gosforth Lane South Oxhey WD19 7BX : 0208 421 4054 <br> <a HREF="mailto:&#105;&#110;&#102;&#111;&#064;&#115;&#111;&#117;&#116;&#104;&#111;&#120;&#104;&#101;&#121;&#098;&#097;&#112;&#116;&#105;&#115;&#116;&#099;&#104;&#117;&#114;&#099;&#104;&#046;&#111;&#114;&#103;&#046;&#117;&#107;">&#105;&#110;&#102;&#111;&#064;&#115;&#111;&#117;&#116;&#104;&#111;&#120;&#104;&#101;&#121;&#098;&#097;&#112;&#116;&#105;&#115;&#116;&#099;&#104;&#117;&#114;&#099;&#104;&#046;&#111;&#114;&#103;&#046;&#117;&#107;</a></h3>
		</div>
<?}?>
	</div>	

		<!--    LOGO DIV
		
		<a href="/index.php"><div id="logo">
			<p class="p1">&nbsp;</p>
		</div></a>-->
<!-- OLD URL CHECK  %if ($r->uri=~/\/cgi-bin\/mason_handler\.cgi\/index.php/) {-->
<?if (preg_match("/index.*\.php/", $_SERVER['REQUEST_URI']) ||  $_SERVER['REQUEST_URI']  == "" || $_SERVER['REQUEST_URI'] == "/") {?>
	<div id="intro">
		<h3><span>Church Mission Statement</span></h3>
		<p class="p1"><span>We aim to be a welcoming community of people with Jesus Christ at the Centre who</span></p>
		<p class="p2"><span>Love God,</span></p>
		<p class="p2"><span>Love one another, and</span></p>
		<p class="p3"><span>Love the lost<br>&nbsp;</span></p>
	</div>
	<div id="introImage">
		&nbsp;
	</div>
<?}?>		
	<div id="supportingText">
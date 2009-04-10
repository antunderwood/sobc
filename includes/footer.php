<div id="footer">  
	140 Gosforth Lane South Oxhey WD19 7BX: 0208 421 4054: <a HREF="mailto:&#105;&#110;&#102;&#111;&#064;&#115;&#111;&#117;&#116;&#104;&#111;&#120;&#104;&#101;&#121;&#098;&#097;&#112;&#116;&#105;&#115;&#116;&#099;&#104;&#117;&#114;&#099;&#104;&#046;&#111;&#114;&#103;&#046;&#117;&#107;">&#105;&#110;&#102;&#111;&#064;&#115;&#111;&#117;&#116;&#104;&#111;&#120;&#104;&#101;&#121;&#098;&#097;&#112;&#116;&#105;&#115;&#116;&#099;&#104;&#117;&#114;&#099;&#104;&#046;&#111;&#114;&#103;&#046;&#117;&#107;</a>
</div>
</div>

<?if (preg_match("/index.*\.php/", $_SERVER['REQUEST_URI']) ||  $_SERVER['REQUEST_URI']  == "" || $_SERVER['REQUEST_URI'] == "/") {?>
<div id="linkList">
<?}else{?>
<div id="short_linkList">
<?}?>
<!--extra div for flexibility - this list will probably be the trickiest spot you'll deal with -->
	<div id="linkList2">
	
	<!-- If you're wondering about the extra &nbsp; at the end of the link, it's a hack to meet WCAG 1 Accessibility. -->
	<!-- I don't like having to do it, but this is a visual exercise. It's a compromise. -->
		<ul><li><a href="/index.php" title="Home Page" accesskey="1">Home Page &#187;</a></li></ul>
		<div id="sunday_links">
			<h3 class="sunday"><span>Sunday<br>Services:</span></h3>
			<!-- list of links begins here. There will be no more than 8 links per page -->
			<ul>
				<li><a href="/sundays/services.mhtml" title="Sundays: Worship Services" accesskey="a">Worship Services &raquo;</a></li>
				<li><a href="/sundays/special_sundays.mhtml" title="Sundays: Special Sundays" accesskey="b">Special Sundays &raquo;</a></li>
				<li><a href="/sundays/youth.mhtml" title="Sundays: Children and Youth" accesskey="c">Children and Youth &raquo;</a></li>
				<!--<li><a href="/sundays/youth.mhtml#creche" title="Sundays: Under 2's" accesskey="c">Creche</a>
				<li><a href="/sundays/youth.mhtml#sparklers" title="Sundays: Ages 2 to 5" accesskey="d">Ages 2 to 5</a>
				<li><a href="/sundays/youth.mhtml#g-team" title="Sundays: Ages 6 to 11" accesskey="e">Ages 6 to 11</a>
				<li><a href="/sundays/youth.mhtml#action-attack" title="Sundays: Ages 11 to 14" accesskey="f">Ages 11 to 14</a>
				<li><a href="/sundays/youth.mhtml#focus" title="Sundays: Ages 15 to young adult" accesskey="g">Ages 15 to 18+</a>-->
			</ul>
		</div>
	
		<div id="midweek_links">
			<h3 class="mid_week"><span>Mid-Week<br>Activities</span></h3>
			<ul>
				<li><a href="/midweek/rendezvous.mhtml" title="Older people" accesskey="h">Older People &raquo;</a>&nbsp;</li>
				<li><a href="/midweek/youth.mhtml" title="Youth group" accesskey="i">Youth Group &raquo;</a></li>
				<li><a href="/midweek/younger_children.mhtml" title="Younger Children" accesskey="j">Younger children &raquo;</a></li>
			</ul>
		</div>
		<div id="teaching_links">
			<h3 class="teaching"><span>Teaching</span></h3>
			<ul>
				<li><a href="/teaching/sundays.mhtml" title="On Sundays" accesskey="k">On Sundays &raquo;</a></li>
				<li><a href="/teaching/downloads.mhtml" title="On Sundays" accesskey="l">Service Downloads &raquo;</a></li>
				<li><a href="/teaching/bible.mhtml" title="Bible teaching" accesskey="m">Bible &raquo;</a></li>
				<li><a href="/teaching/christian.mhtml" title="What is a Christan?" accesskey="n">What is a Christan? &raquo;</a></li>
			</ul>
		</div>
		<div id="about_links">
			<h3 class="about"><span>About Us<br>&nbsp;</span></h3>
			<ul>
				<li><a href="/about/more_about_us.mhtml" title="More about us" accesskey="o">More about us &raquo;</a>&nbsp;</li>
				<li><a href="/about/outreach.mhtml" title="Outreach" accesskey="p">Outreach &raquo;</a>&nbsp;</li>
				<li><a href="/about/building.mhtml" title="Building Project" accesskey="q">Building Project &raquo;</a>&nbsp;</li>
				<li><a href="/about/where.mhtml" title="Where are we?" accesskey="r">Where are we? &raquo;</a>&nbsp;</li>
			</ul>
		</div>
		<div id="search">
			<h3 class="search"><span>Search</span></h3>
			<form method="get" action="/cgi-bin/search/search.pl">
				<input type="hidden" name="p" value="1">
				<input type="hidden" name="lang" value="en">
				<input type="hidden" name="include" value="">
				<input type="hidden" name="exclude" value="">
				<input type="hidden" name="penalty" value="0">
				<select name="mode">
					<option value="all">Match ALL words</option>
					<option value="any">Match ANY word</option>
				</select>
				<input type="text" name="q"><input type="submit" value="Search">
			</form>
		</div>	

	</div>

</div>

<!-- These extra divs/spans may be used as catch-alls to add extra imagery. -->
<!-- Add a background image to each and use width and height to control sizing, place with absolute positioning -->
<div id="extraDiv1"><span></span></div><div id="extraDiv2"><span></span></div><div id="extraDiv3"><span></span></div>
<div id="extraDiv4"><span></span></div><div id="extraDiv5"><span></span></div><div id="extraDiv6"><span></span></div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2280402-1";
urchinTracker();
</script>
</body></html>

<?php include("includes/header.php");?>
<!-- function to test for expiring pages  -->
<?php $expired1 = expired("coming_soon_expiry.txt");
$expired2 = expired("coming_soon_expiry2.txt");
function expired($file){
	$fh = fopen($file, 'r');
	$expiry_date = fgets($fh);
	fclose($fh);
	list($expiry_day,$expiry_month,$expiry_year)=split("/",$expiry_date);
	$year=date('Y');
	$mon=date('m');
	$mday=date('j');
	// routine to check if coming soon section expired or not
	$expired=1;
	if ($year<$expiry_year){
		$expired=0;
	}
	else if ($year == $expiry_year){
		if ($mon<$expiry_month){
			$expired=0;
		}
		else if($mon==$expiry_month){
			if ($mday<$expiry_day){
				$expired=0;
			}
		}
	}
	return $expired;
} 
if (!$expired1 || !$expired2){ ?>
	<div id="coming_soon">
	<h3><span>Coming Soon</span></h3>
<?php } ?>
<?php if (!$expired1){ ?>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
		<tr>
            <td  ><span class="title">Christmas Services</span><br />
			</td>
		</tr>
		<tr><td>
      <b>Jesus: The gift of Hope.</b><br/> 
      Come and join us for one or all of the special Christmas services.<br/><br/>
    </td></tr>
    <tr><td>
      <b>Sunday 21st</b> at 11am Christmas Family Service   (with our 'Explorers' children's group taking part)<br/><br/>
    </td></tr>
    <tr><td style="background-image:url(/images/christmas_candle.jpg);background-repeat: no-repeat;"><span style="font-size: 40px; color: #ffffff;float:left;margin-left: 5px;">Carols by<br /> Candlelight<br></span><span style="font-size: 40px; color: #ffffff; float:right;text-align:right; margin-right: 5px;">Christmas<br>Eve<br>6pm</span>
    </td></tr>
    <tr><td>
      <br/>
      <b>Christmas Day</b>, Thursday 25th at 9:30am Christmas Day celebration. 40 minute service to celebrate this special day.
    </td></tr>
    </tbody>
</table>
<hr>
<?php }
if (!$expired2){?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	    <tbody>
      <tr>
              <td  ><span class="title">Discipleship Course</span><br />
  			</td>
  		</tr>
			<tr>
			    <td style="background-image:url(/images/freedom_in_christ.jpg);background-repeat: no-repeat;height: 88px">
			        &nbsp;
			        </td>
	        </tr>
      <tr><td>
        Every Thursday evening 8-10pm, starting 15th January and finishing 9th April. There will also be an away day on Saturday 14th March.<br />
        <br/>
        Main topics include Key Truths to build your life on, The World, The Flesh and the Devil, Breaking the hold of the past, Growing as Disciples and Steps to Freedom<br />
        <br />
        The 'Freedom in Christ' Discipleship course is designed to help every Christian take hold of the truth of who they are in Christ, resolve personal and spiritual conflicts and move to maturity. Example sessions include  "where did I come from?", "who am I now", "forgiving from the heart" and "walking in freedom every day".<br />
         This is a 13 part course plus an away day (Saturday) to go through 'steps to Freedom in Christ'. The course is suitable for new and mature Christians. The layout will feel similar to Alpha with a DVD presentation followed by group discussion and sharing.
         </td></tr>
	    </tbody>
	</table>
	<br>
<?php }
if (!$expired1 || !$expired2){?>
	</div>
<?php } ?>
<a name="building_news"></a>
<div id="building_project">
<h3><span>New Building Plans</span></h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
        <tr>
            <td width="530"><img width="530" height="236" src="/images/new_building_small.jpg" alt="New Building" id="new_building"/></td>
            <script type="text/javascript" language="javascript">
			new Tip('new_building', "We are building the outer shell with the money we have and looking to continue with the inside as money becomes available. We have been talking about 'stepping out of the boat' for years. This is it. The rain and mud of January made the idea of the boat and water all very literal!<span style='text-align: center'><h2>South Oxhey Baptist Church</h2>Building to serve the peopleof South Oxhey<br>New worship area<br>Activity rooms for all ages<br>Open house with catering facilities<h2>… aiming to be a welcoming community of people with Jesus Christ at the centre</h2></span>For a slideshow of the current building work in progress please <a href='javascript:;' onclick=\"$('new_building').prototip.hide();Lightview.show('slideshow');\">click here</a>", { 
				hideOn: { element: 'closeButton', event: 'click' },
				style: 'protogrey',
				stem: 'topMiddle',
				hook: { target: 'bottomMiddle', tip: 'topMiddle' },
				offset: { x: 0, y: -10 },
				width: 400,
				border: 1,
				radius: 1 });
			
			
			//]]>
			</script>
            <td style="vertical-align: top; padding: 0px 0px 0px 10px;">
              We have outgrown our existing building and so are embarking on an exciting project to build an extension to of the church.<br>
              We have identified a 3 phase approach to the work. Our builders are preparing to start phase 1 - the shell of the new building. We are in the process of raising the finances for phase 2 - the completion of the new part of the building. Our immediate target is to raise &#163;100,000 to add to what has been given and pledged so far. <br>
<br>For more detailed information on the building project <a href="/about/building.php">click here</a><br>
				For a slideshow of the current building work in progress please <a id='slideshow' href='/images/building/digger small.png' class='lightview' title="Digger" rel='gallery[building]' onclick="$('new_building').prototip.hide();">click here</a>
				<a href='/images/building/digger 2 small.png' class='lightview' title="Digger again" rel='gallery[building]'a>
				<a href='/images/building/foundations small.png' class='lightview' title="Foundations" rel='gallery[building]'a>
				<a href='/images/building/crane small.png' class='lightview' title="Crane" rel='gallery[building]'a>
				<a href='/images/building/structure small.png' class='lightview' title="Steel framework" rel='gallery[building]'a>
				<a href='/images/building/bricks small.png' class='lightview' title="Brickwork going up" rel='gallery[building]'a>
				<a href='/images/building/sign small.png' class='lightview' title="Sign about building"rel='gallery[building]'a>

			</td>
        </tr>
    </tbody>
</table>
</div>
<div id="bottom_left">
<h3><span>Welcome to our website</span></h3>
<p class="p1"><span>We are pleased you've found the South Oxhey Baptist Church website, we hope that you find it helpful, informative, easy to get around, and that you will be encouraged to find out more about South Oxhey Baptist Church (SOBC).  
<br>Whether you've just moved into the area, or going to church would be a new thing for you, whether you are a Christian looking for a place to get started again or to grow and serve... we would love to welcome you to a Sunday service or one of our other events. You can also contact Steve Hobbis, the minister by phone or email.
</span></p>
</div>
<div id="bottom_right1">
<h3><span>At SOBC we're a mixed bunch! </span></h3>
<p class="p1"><span>We are made up of young and old, including children and young people of almost every age. We have people who've lived in the area since South Oxhey was built and lots of more recent arrivals; families and single people; people who've been Christians for years, some who have more recently become Christians and others who are exploring what it's all about. We could say more about different occupations, variety of nationalities, life experiences and so on... a variety of different people growing to know a wonderful God who loves each one.</span></p>
</div>
<?php include("includes/footer.php");?>
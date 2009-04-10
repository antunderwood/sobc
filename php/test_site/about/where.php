<?include "../includes/header.php"?>
<? $html_root="/php/test_site";?>
<div id="main_section">
	<h2><span>How to find us</span></h2>
	<div id="directions_div" style="display:none">
		<iframe name="directions" id="directions" width="800px" height="800px" scroling="yes"></iframe>
		<br><input type="button" id="mapNewWindow" value="Open in new window for printing" onclick="mapNewWindow();">
		<input type="button" id="backToMap" value="Go back to the map" onclick="revealMap();">
	</div>
	<div id="map_header">
	<p>We are located on Gosforth Lane in South Oxhey which is just south of Watford (see map below).</p>
	</div>
	
	<div id="map" style="width: 800px; height: 400px"></div>
	    <script type="text/javascript">
	    //<![CDATA[
	    var map=new GMap(document.getElementById("map"));
	    var marker;
	    var to_html="";
	    var from_html="";
	    function showMap(map){
	    
		    map.addControl(new GLargeMapControl());
		    map.addControl(new GOverviewMapControl(new GSize(125,125)));
			setTimeout("positionOverview()",1);
	        //setTimeout("positionOverview(890,450)",1);
		    map.centerAndZoom(new GPoint(-0.399353, 51.64), 4);
		    
		    var start_html="";
		    
		    var baseIcon  = new GIcon();
		    baseIcon.iconSize = new GSize(125, 76);
		    baseIcon.iconAnchor = new GPoint(63, 76)
		    baseIcon.infoWindowAnchor = new GPoint(63, 76);
		    
		    var markerIcon = new GIcon(baseIcon);
		    markerIcon.image="<?= $html_root?>/images/sobc_marker.gif";
		    
		    marker = createMarker(new GPoint(-0.399353, 51.628105),"South Oxhey Baptist Church", "<h3>South Oxhey<br>Baptist Church</h3>",markerIcon);
		    
	
		    map.addOverlay(marker);
		    //marker.openInfoWindowHtml(start_html);
		    marker.showMapBlowup(2);
		    
		    
		    
		    // A function to create the marker and set up the event window
		    
		    function createMarker(point,name,html,icon) {
				var marker = new GMarker(point,icon);
				
				// The info window version with the "to here" form open
				to_html = html + '<br>Directions: <br><b>To Church</b> from <b>Start Address</b> (enter below):<form action="http://maps.google.co.uk/maps" method="get" target="directions">' +
				'<input type="text" SIZE=40 MAXLENGTH=40 name="saddr" id="saddr" value="" /><br>' +
				'<INPUT value="Get Directions" TYPE="SUBMIT" onclick="revealDirections();">' +
				'<input type="hidden"  id="daddr" name="daddr" value="' + name + '@51.628105,-0.399353"/>' + '<br> <a href="javascript:fromhere(marker)">From Church</a>';
				//'<input type="hidden" name="daddr" value="51.628105,-0.399353(' + name + ")" + '"/>';
				// The info window version with the "to here" form open
				from_html = html + '<br>Directions: <br><b>From Church</b> to <b>End address</b> (enter below):<form action="http://maps.google.co.uk/maps" method="get" target="directions">' +
				'<input type="text" SIZE=40 MAXLENGTH=40 name="daddr" id="daddr" value="" /><br>' +
				'<INPUT value="Get Directions" TYPE="SUBMIT" onclick="revealDirections();">' +
				'<input type="hidden" id="saddr" name="saddr" value="' + name + '@51.628105,-0.399353"/>'+ '<br><a href="javascript:tohere(marker)">To Church</a>';
				//'<input type="hidden" name="saddr" value="51.628105,-0.399353(' + name + ")" + '"/>';
				// The inactive version of the direction info
				start_html = html + '<br>Directions: <br><a href="javascript:tohere(marker)">To Church</a> - <a href="javascript:fromhere(marker)">From Church</a>';
				
				GEvent.addListener(marker, "click", function() {
				marker.openInfoWindowHtml(start_html);
				});
				return marker;
		      }
		      
		}
		//function positionOverview(x,y) {
		function positionOverview() {
			var omap=document.getElementById("map_overview");
			//omap.style.left = x+"px";
			//omap.style.top = y+"px";
			
			// == restyling ==
			omap.firstChild.style.border = "1px solid gray";
			
			omap.firstChild.firstChild.style.left="4px";
			omap.firstChild.firstChild.style.top="4px";
		}

		function tohere(marker) {
			marker.openInfoWindowHtml(to_html);
		}
	        function fromhere(marker) {
			marker.openInfoWindowHtml(from_html);
	        }
		function zoomIn(){
			map.clearOverlays();
			map.addOverlay(marker);
		  	map.centerAndZoom(new GPoint(-0.399353, 51.6281052), 2);
			document.getElementById("zoom").value="Zoom back out";
			document.getElementById("zoom").setAttribute('onclick','zoomOut();');
		}
		function zoomOut(){
		  	map.centerAndZoom(new GPoint(-0.399353, 51.64), 4);
			document.getElementById("zoom").value="Zoom in to view South Oxhey";
			document.getElementById("zoom").setAttribute('onclick','zoomIn();');
		}
		function revealDirections(){
			document.getElementById("directions_div").style.display = 'block';
			document.getElementById("map_header").style.display = 'none';
			document.getElementById("map").style.display = 'none';
			document.getElementById("map_instructions").style.display = 'none';
      		}
		function revealMap(){
			document.getElementById("map_header").style.display = 'block';
			document.getElementById("map").style.display = 'block';
			document.getElementById("map_instructions").style.display = 'block';
			document.getElementById("directions_div").style.display = 'none';
      		}
		function mapNewWindow(){
			var mapSrc="http://maps.google.co.uk/maps?saddr=" +  document.getElementById("saddr").value + "&daddr=" + document.getElementById("daddr").value;
			mapSrc=mapSrc.replace(/\s/g,'+');
			window.open(mapSrc);
		}

	    
	    
		//]]>
		</script>
		<div id="map_instructions">
			<input type="button" id="zoom" value="Zoom in to view South Oxhey" onclick="zoomIn();">
			<p>
			<b>Instructions for using the map</b><br>
			Click on the + and - symbols, or drag the slider to zoom in and out. Click and drag the map to move around. For directions to the church, close
			the zoomed pop up view by clicking on the X in the top right corner (Alternatively you can click on the "Zoom in to view South Oxhey" button just below the map). Now click on "South Oxhey Baptist Church" in the white bubble and then on 
			the "To Church" or "From Church" links in the new pop up box. Enter a road name (e.g Prestwick Road South Oxhey) or a postcode (e.g WD19 7BX) or even just a place (e.g St. Albans).
			A new window will open showing you directions to or from that place.
			<br>If the map is not working on your browser please click <a href="where_static.php">here</a> for a static map.
			</p>
		</div>
	
</div>
<?include "../includes/footer.php"?>
<?php
// ical_concat.php; written by Douglas Waldron 2006-11-28
// Works with any iCal calendar, including Google Calendar
// Add each calendar URL on a separate line:
$ical[] = 'http://homepage.mac.com/theunderwood_family/.calendars/Home.ics';
$ical[] = 'http://homepage.mac.com/theunderwood_family/.calendars/Work.ics';
$ical[] = 'http://homepage.mac.com/theunderwood_family/.calendars/SOBC.ics';
$ical[] = 'http://webdav:tropshop@www.hpa-bioinfodatabases.org.uk/webdav/Birthdays_email.ics';

$fp = fopen("calendars.ics", "w");

fwrite($fp,"BEGIN:VCALENDAR\n");
fwrite($fp,"VERSION:2.0\n");
fwrite($fp,"PRODID:-//DWW/ical_concat.php\n");
$i=0;
while ($i<count($ical)) {
	$ical_contents = file($ical[$i++],0);
	$okay=0;
	foreach ($ical_contents as $ical_line) {
		if (!$okay)
		if ((strpos($ical_line,'BEGIN') !== false) && (strpos($ical_line,'BEGIN:VCALENDAR') === false))
		$okay=1;
		if ($okay && strpos($ical_line,'END:VCALENDAR') === false ) fwrite($fp, $ical_line);
	}
}
fwrite($fp,"END:VCALENDAR\n");
fclose($fp);
?>

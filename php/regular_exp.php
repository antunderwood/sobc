<?
$string="
		}
	}
</%perl>
%if (!\$expired){
	<div id=\"coming_soon\">";
	echo $string;
$string= preg_replace("/^.+(<div)/s", "$1", $string);
echo $string;
?>

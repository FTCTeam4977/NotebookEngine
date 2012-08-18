<?php
/* 
 * Lab Notebook Generator
 * Created by FTC Team 4977, LANLords
 */

date_default_timezone_set("America/New_York");

require_once("Smarty.class.php");
require_once("markdown.php");

function compare($a, $b)
{
        $aT = strtotime($a['time']);
        $bT = strtotime($b['time']);
        if ( $aT == $bT )
                return 0;
        return ( $aT < $bT ) ? -1 : 1;
}

function filenameToTime($fn)
{	
	$a = str_split($fn);
	$output = array();
	$hitNumber = false;
	$hitDash = false;
	foreach ( $a as $c )
	{
		if ( intval($c) != 0 && !$hitNumber )
		{
			$output[] = " ";
			$output[] = $c;
			$hitNumber = true;
		}
		else if ( $c == "-" && !$hitDash )
		{
			$output[] = ", ";
			$hitDash = true;
		}
		else
			$output[] = $c;
	}
	return strtotime(implode("", $output));
}

$files = scandir("EngineeringNotebook2012-2013");
$files = array_reverse($files);
$entries = array();
$smarty = new Smarty();

foreach ( $files as $file )
{
	if ( $file != "." && $file != ".." && strpos($file, ".md") !== false )
	{
		$noExt = substr($file, 0, -3);
		$ts = strtotime($noExt);
		$time = filenameToTime($noExt);
		$data = array("content" => Markdown(file_get_contents("EngineeringNotebook2012-2013/".$file)),
					  "date" => date("M j, Y", $time),
					  "time" => $time,
					  "link" => substr($file, 0, -3).".html");
		
		$entries[] = $data;
	}
}


$pivot = array();
foreach ( $entries as $k=>$v )
{
	$pivot[$k] = $v['time'];
}

array_multisort($pivot, SORT_DESC, $entries);

// Generate index
$smarty->assign("entries", $entries);
$smarty->assign("isSingleEntry", false);

file_put_contents("index.html", $smarty->fetch("template.html"));

// Generate permalink pages
foreach ( $entries as $entry )
{
		$smarty->assign("entries", array($entry));
		$smarty->assign("isSingleEntry", true);
		$res = file_put_contents($entry['link'], $smarty->fetch("template.html"));
		echo "wrote ".$res." bytes to ".$entry['link']."\n";
}

?>

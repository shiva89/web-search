<?php
require("google-search.php");
require("bing-search.php");
require("yahoo-search.php");

$query = "";

if($_GET && $_GET["q"]){
	$query = $_GET["q"];
}else{
	die("no search param supplied");
}


$allResults = "";
$allResults .= getGoogleResults($query);
$allResults .= "<hr>";
$allResults .= getBingResults($query);
$allResults .= "<hr>";
$allResults .= getYahooResults($query);
$allResults .= "<hr>";
echo $allResults;


?>
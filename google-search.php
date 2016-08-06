<?php

function getGoogleResults($query){

$gUrl = "https://www.googleapis.com/customsearch/v1?key=AIzaSyALVVm5VMnCUrMoVV6x3t4QDaf9JQ5xi3s&cx=010948399805921847241%3Am0mvxfmh7im&start=1&num=3&q=".$query;

$body = file_get_contents($gUrl);
$json = json_decode($body);

$results = "";
$resultsArray = $json->items;
$length = count($resultsArray);

$results .= "<h3>Results from Google :</h3>";
for($x=0;$x<$length; $x++){
$results .= "<br><b>URL:</b> ";
$results .= "<a target='_blank' href='".$resultsArray[$x]->link."'>".$resultsArray[$x]->link."</a>";
$results .= "<br><b>Title:</b> ";
$results .= $resultsArray[$x]->htmlTitle;
$results .= "<br><b>Content:</b> ";
$results .= $resultsArray[$x]->htmlSnippet;
$results .= "<br><br>";
}

return $results;

}
?>
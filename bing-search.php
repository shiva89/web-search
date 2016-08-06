<?php

function getBingResults($query){

    $accountKey = 'a6aa96cf98c34198bcb717e2f401fb39';            

    $context = stream_context_create(array(
        'http' => array(
        	'header'  => 'Ocp-Apim-Subscription-Key : '. $accountKey
        )
    ));

    $request = 'https://api.cognitive.microsoft.com/bing/v5.0/search?q='.$query.'&count=3&responseFilter=Webpages,relatedSearches';

    $response = file_get_contents($request, 0, $context);
     // return $response;
    $json = json_decode($response);

$results = "";
$resultsArray = $json->webPages->value;
$length = count($resultsArray);

$results .= "<h3>Results from Bing :</h3>";
for($x=0;$x<$length; $x++){
$results .= "<br><b>URL:</b> ";
$results .= "<a target='_blank' href='".$resultsArray[$x]->url."'>".$resultsArray[$x]->displayUrl."</a>";
$results .= "<br><b>Title:</b> ";
$results .= $resultsArray[$x]->name;
$results .= "<br><b>Content:</b> ";
$results .= $resultsArray[$x]->snippet;
$results .= "<br><br>";
}


//related search items
$relatedSearches = $json->relatedSearches->value;
$rLength = count($relatedSearches);

$results .= "<b>Related searches from Bing :</b><br>";

for($x=0;$x<$rLength; $x++){
$results .= "<a target='_blank' href='".$relatedSearches[$x]->webSearchUrl."'>".$relatedSearches[$x]->displayText."</a>";
$results .= ", ";
}

return $results;

}
?>
<?php
require("OAuth.php");

function getYahooResults($query){

	$cc_key = 'dj0yJmk9M2VQalJKQWE1aTFPJmQ9WVdrOVNqZDZhMnRITXpJbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1mMQ--';
	$cc_secret = 'e9fcf17d5a2fb1a3d5432f823e15e6a8979433db';


	$url = 'https://yboss.yahooapis.com/ysearch/web';

	$args = array();
	$args["q"] = $query;
	$args["format"] = "json";

	$consumer = new OAuthConsumer($cc_key, $cc_secret);
	$request = OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);
	$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
	$url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($args));

	$ch = curl_init();
	$headers = array($request->to_header());

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$rsp = curl_exec($ch);
	if (FALSE === $rsp)
		throw new Exception(curl_error($ch), curl_errno($ch));


	$json = json_decode($rsp);

	$results = "";

	if(isset($json->web)){
		$resultsArray = $json->web->results;
		$length = count($resultsArray);

		$results .= "<h3>Results from Yahoo :</h3>";
		if($length >0){
			for($x=0;$x<$length; $x++){
				$results .= "<br><b>URL:</b> ";
				$results .= "<a target='_blank' href='".$resultsArray[$x]->url."'>".$resultsArray[$x]->dispurl."</a>";
				$results .= "<br><b>Title:</b> ";
				$results .= $resultsArray[$x]->title;
				$results .= "<br><b>Content:</b> ";
				$results .= $resultsArray[$x]->abstract;
				$results .= "<br><br>";
			}
		}
	}


	return $results;

}
?>
<?php
function getJobs ($from) {
	// set error level
	$internalErrors = libxml_use_internal_errors(true);

	$dom = new DomDocument();
	$dom->loadHTMLFile($from);
	libxml_use_internal_errors($internalErrors);

	$output = array();
	foreach ($dom->getElementsByTagName('a') as $item) {
	   $output[] = array (
	      'str' => $dom->saveHTML($item),
	      'href' => $item->getAttribute('href'),
	      'anchorText' => $item->nodeValue
	   );
	}

	$word_pool = ["developer needed", "developer wanted", "needed for a job", "professional needed", "vacant position", "designer needed", "Designer wanted", "webdeveloper needed", "webdeveloper wanted", "webdesigner needed", "writter needed", "writer wanted", "professional web developer needed", "Professional Website Designer", "I Need An Website", "I Need A Website", "Professional website developer", "Professional web developer", "Professional web designer", "software developers needed", "software developers wanted", "programmer needed",  "programmer wanted", "experienced developer", "experienced fullstack developer" , "developers needed", "we are hiring", "looking for an developer", "looking for a developer", "a crazy developer", "awesome developers"]; //not case sensitive


	foreach ($output as $outputkey => $outputvalue) {
		$text = $outputvalue["anchorText"];
		$href = $outputvalue["href"];
		foreach ($word_pool as $wordkey => $wordvalue) {
			$word_exists =  strpos(strtolower($text), strtolower($wordvalue));
			if ($word_exists !== false) {
				$site = "";
				// heads up, scrappy logic upcoming... 
				// @todo make this smart enough to remove "/new" and "/c/jobs": can't be that hard... 
				$url=parse_url($from);
				$site=$url['scheme'].'://'.$url['host'];
				echo "<a href='$site$href'>$text</a><br>";
			}
		}


	}
}

$from = 'http://nairaland.com/webmasters/new';
getJobs($from);
$from = 'http://radar.techcabal.com/c/jobs';
getJobs($from);

?>

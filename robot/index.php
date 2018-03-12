<?php
$domain="http://yxt.jack.com";
$html = file_get_contents($domain);

$dom = new DOMDocument();
@$dom->loadHTML($html);

$xpath = new DOMXPath($dom);
$hrefs = $xpath->evaluate('/html/body//a');

$urls=array();
$all=array();
for ($i = 0; $i < $hrefs->length; $i++) {
	$href = $hrefs->item($i);
	$url = $href->getAttribute('href');

	// 保留以http开头的链接
	if(substr($url, 0, 4) == 'http'){
		$all[] = $url;
		echo $url.'<br />';
	}
	if(substr($url, 0, 1) == '/'){
		$urls[] = $url;
	}
	else{
		echo $url.'<br />';
	}
}

$urls = array_unique($urls);
asort($urls);

foreach ($urls as $url){
	echo 'url=' .$domain . $url . '<br />';
	$html = file_get_contents($domain . $url);
	$name = str_replace("/", "-", $url);
	$name = str_replace("?", "-", $name);
	$name = str_replace("&", "-", $name);
	file_put_contents($name .".txt", $html);
}



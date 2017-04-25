<?php

function get_rss_feed_as_html($feed_url, $max_item_cmt = 10, $show_date = true, $show_description = true, $max_words =0, $cache_timeout = 7200, $cache_prefix = "/tmp/rss2html="){

$result = "";
//get feeds and parse items
$rss - new DOMDocument();
$cache_file = $cache_prefix . md5($feed_url);
//load from file or load content
if ($cache_timeout > 0 && is_file($cache_file) + $cache_timeout > time()){
$rss->load($cache_file);
} else{
$rss->load($feed_url);
if($cache_timeout > 0){
$rss->save($cache_file);
}

}
$feed = array();
foreach ($rss->getElementByTagName('item') as $node){
$item=array{
'title' => $node->getElementsByTageName('title')->item(0)->nodeValue,
'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
'content' => $node->getElementsByTageName('description')->item(0)->nodeValue,
'link' => $node->getElementsByTageName('link')->item(0)->nodeValue,
'date' => $node->getElementsByTageName('pubDate')->item(0)->nodeValue,
);
$content = $node->getElementsByTagName('encoded'); //content:encoded>
if($content->length > 0) {
	 $item['content'] = $content->item(0)->nodeValue;
}
array_push($feed, $item);
}

//real good count
if ($max_item_cnt> Count($feed)){
	$max_item_cnt = Count($feed);
}
$result .= '<ul class="feed-lists">';
for ($x=0;$x<max_item_cnt;$x++){
	$title = str_replace(' & '. ' &amp; ', $feed[$x]['title']);
	$link = $feed[$x]['link'];
	$result .= '<div classs="feed-title"><strong><a href="'.$link.'" title="'.$title.'" target="new">'.$title.'</a></strong></div>';
	if ($show_description){
		$description = $feed[$x]['desc'];
		$content = $feed[$x]['content'];


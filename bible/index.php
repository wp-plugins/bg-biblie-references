<?php 
//echo "\n";
$title = $_GET["title"];
$chapter = $_GET["chapter"];
if (!$chapter) $chapter = '1-99';
$type = $_GET["type"];
if (!$type) $type = 'verses';
//include_once (realpath (substr(__FILE__, 0, strpos(__FILE__, 'wp-content')).'wp-blog-header.php'));
include_once ('../includes/quotes.php');
echo bg_bibfers_getQuotes($title, $chapter, $type);
<?php 
$wpblogheader = substr(__FILE__, 0, strpos(__FILE__, 'wp-content')).'wp-blog-header.php'; 
if (!file_exists($wpblogheader))exit($wpblogheader." - not found.");
include_once ($wpblogheader);
include_once ('../includes/quotes.php');
echo bg_bibfers_getQuotes($_GET["title"], $_GET["chapter"], $_GET["type"]);

# facebook-instant-article-api
Manage your Facebook Instant Article using API

Sample:

<?php
require_once __DIR__ . '/autoload.php';


$article = new Instant_Article();
$article->pageAccessToken("XXX");
$article->loadURL("XXX");


$fields = [
	'page_id' => 'XXX', //Page ID
  'html_source' => 'XXX', //HTML code
  'published' => false, //defaults to FALSE
  'development_mode' => true, //defaults to TRUE
];

$article->create_article($fields);
?>

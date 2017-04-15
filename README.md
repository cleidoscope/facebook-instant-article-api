# facebook-instant-article-api
Manage your Facebook Instant Articles using API

Example:
```php
<?php
require_once __DIR__ . '/autoload.php';

$page_access_token = "XXXXX"; // Required for all requests

$url = "XXXXX"; // Required for Get and Delete Article methods

// Get Article
$article = Instant_Article::getArticle($url, $page_access_token);


// Delete Article
$article = Instant_Article::deleteArticle($url, $page_access_token);


// Create/Update Article
$fields = [
	'page_id' => '121', // Page ID
    	'html_source' => '', // HTML code
    	'published' => FALSE, // defaults to FALSE
    	'development_mode' => TRUE, // defaults to TRUE
];

$article = Instant_Article::createArticle($fields, $page_access_token);
?>
```

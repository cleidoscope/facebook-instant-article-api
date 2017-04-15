# facebook-instant-article-api
### Requirements:
* Facebook Page
* Facebook App
* Page Access Token

Retrieving a Page Access Token is discussed in the [API Documentation](https://developers.facebook.com/docs/instant-articles/api) (Authentication section).



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

When updating an Instant Article (excerpt from Facebook Instant Article API Documentation):
>"Updates to existing Instant Articles follow the same approach used to creating a new Instant Article. If the article being posted contains the same canonical URL if an existing Instant Article, the markup of the existing article will be updated with the new markup included in the POST."

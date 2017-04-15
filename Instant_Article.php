<?php
class Instant_Article
{

    /*
    * Get Article
    *
    */
    public static function getArticle($url, $page_access_token)
    {
        $curl = self::cURL("https://graph.facebook.com?id={$url}&fields=instant_article&access_token={$page_access_token}");


        if( isset($curl->instant_article) ) :
            $response = $curl->instant_article;
        else :
            $response = isset($curl->id) ? "Article does not exist" : $curl;
            print_r($response);
        endif;

        return $response;
    }

    /*
    * Delete Article
    *
    */
    public static function deleteArticle($url, $page_access_token)
    {
        $article = self::cURL("https://graph.facebook.com?id={$url}&fields=instant_article&access_token={$page_access_token}");

        if( !isset($article->instant_article) ) :
            $response = isset($article->id) ? "Article does not exist" : $article;
            print_r($response);
            return $response;
        endif;

        $options = [
            CURLOPT_CUSTOMREQUEST => "DELETE",
        ];

        $curl = self::cURL("https://graph.facebook.com/{$article->instant_article->id}?access_token={$page_access_token}", $options);
        print_r($curl);
        return $curl;
    }


    /*
    * Create/Update Article
    *
    */
    public static function createArticle($fields, $page_access_token)
    {
        $post_fields = [
                'access_token' => $page_access_token,
                'html_source' => $fields['html_source'],
                'published' => isset($fields['published']) ? $fields['published'] : false,
                'development_mode' => isset($fields['development_mode']) ? $fields['development_mode'] : true,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post_fields),
        ];

        $curl = self::cURL("https://graph.facebook.com/{$fields['page_id']}/instant_articles", $options); 

        print_r($curl);
        return $curl;
    }


    /*
    * Process cURL Requests
    *
    */
    public static function cURL($url, $options = NULL)
    {
        $ch = curl_init($url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if( !is_null($options) ) :
            foreach($options as $key => $val) :
            curl_setopt($ch, $key, $val);
            endforeach;
        endif;

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);

        if( isset($response->error) ) :
            return $response->error->message;
        endif;

        return $response;
    }
}

?>

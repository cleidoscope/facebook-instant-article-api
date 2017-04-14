<?php
class Instant_Article
{
    protected $page_access_token;

    /*
    * Set Page Access Token (required)
    *
    */
    public function pageAccessToken($token)
    {
        $this->page_access_token = $token;
    }

    /*
    * Get article data
    *
    */
    public function get_article($url)
    {
        $curl = $this->cURL("https://graph.facebook.com?id={$url}&fields=instant_article&access_token={$this->page_access_token}");
        return $curl;
    }

    /*
    * Create article
    *
    */
    public function create_article($fields)
    {
        if( !isset($this->page_access_token) ) :
            echo "ERROR: Page Access Token not set";
            return false; 
        endif;

        $post_fields = [
                'access_token' => $this->page_access_token,
                'html_source' => $fields['html_source'],
                'published' => isset($fields['published']) ? $fields['published'] : false,
                'development_mode' => isset($fields['development_mode']) ? $fields['development_mode'] : true,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post_fields),
        ];
        $response = $this->cURL("https://graph.facebook.com/{$fields['page_id']}/instant_articles", $options); 
        print_r($response);
    }

    /*
    * Process cURL requests
    *
    */
    public function cURL($url, $options = NULL)
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

<?php
class Instant_Article
{
    protected $url;
    protected $page_access_token;

    public function loadURL($url)
    {
        $this->url = $url;
    }

    public function pageAccessToken($token)
    {
        $this->page_access_token = $token;
    }

    public function get_ID()
    {
        if( !isset($this->url) || !isset($this->page_access_token) ) :
            echo "ERROR: URL and Page Access Token not set";
            return; 
        endif;

        $curl = $this->cURL("https://graph.facebook.com?id=$this->url&fields=instant_article&access_token=$this->page_access_token");

        if( $this->has_errors($curl) || !isset($curl->instant_article->id) ) :
            return false;
        endif;
        return $curl->instant_article->id;
    }

    public function has_errors($response)
    {
        if(isset($response->error)) :
            return true;
        else :
            return false;
        endif;
    }

    public function get_HTML()
    {   
        $id = $this->get_ID();
        if( $id ) :
            $curl = $this->cURL("https://graph.facebook.com/{$id}?access_token={$this->page_access_token}");
            return $curl->html_source;
        endif;
    }

    public function create_article($fields)
    {
        if( !isset($this->url) || !isset($this->page_access_token) ) :
            echo "ERROR: URL, Page ID, and/or Page Access Token not set";
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

    //cURL requests
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
        return $response;
    }
}

?>

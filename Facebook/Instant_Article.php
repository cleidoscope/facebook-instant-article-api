<?php

class Instant_Article
{

    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function data()
    {
        $page_access_token = \Settings::page_access_token();
        $ch = curl_init("https://graph.facebook.com/".$this->post->import_id."?access_token=".$page_access_token); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data);
        return $data;
    }

    public function status()
    {   
        if(empty($this->post->import_id)) :
            return false;
        endif;
       
        $data = $this->data();
        $response = '<div class="article_status">';
        $response .= 'STATUS: ' . $data->status . "<br />";
        $response .= 'IMPORT ID: ' . $this->post->import_id . "<br />";
        $response .= '</div>';

        return $data->status;
    }

    public function errors()
    {
        if(!empty($this->data()->errors)) :
            return $this->data()->errors;
        endif;
        return [];
    }



}

?>

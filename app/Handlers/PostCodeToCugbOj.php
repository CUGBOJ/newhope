<?php

namespace App\Handlers;

class PostCodeToCugbOj
{
    public function post($url, $data)
    {
        $postdata = http_build_query(
            $data
        );

        $opts = array('http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata,
        ),
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
}

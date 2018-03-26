<?php

namespace App\Handlers;

use App\Models\Status;
use Auth;

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
    public function post_to_cugb_oj($request)
    {
        $lang_change = array(
            0, 2, 1, 3, 6, 5, 16, 0, 9, 7,
        );
        $lang = $lang_change[$request->lang];
        if ($lang == 0) {
            $info = 'fail submit';
        } else {
            $data = array(
                'user_id' => 'virtual_judger',
                'problem_id' => $request->pid + 999,
                'language' => $lang,
                'isshare' => 0,
                'source' => $request->code,
                'login' => 'Submit',
            );
            $url = "http://acm.cugb.edu.cn/ajax/problem_submit.php";
            $res = $this->post($url, $data);
            $result_change = array(
                'Accepted' => 1,
                'Wrong Answer' => 2,
                'Presentation Error' => 3,
                'Time Limit Exceed' => 4,
                'Runtime Error' => 5,
                'Memory Limit Exceed' => 6,
                'Output limit' => 7,
                'Judge Error' => 8,
                'Compile Error' => 9,
                'Restricted Function' => 10,
            );
            $result = json_decode(substr($res, 3))->info;
            $ce_info = $result[3];
            $status = Status::create([
                'username' => Auth::user()->username,
                'pid' => $request->pid,
                'result' => $result_change[$result[0]],
                'lang' => $request->lang,
                'submit_time' => now(),
                'code' => $request->code,
                'length' => strlen($request->code),
                'time' => $result[1],
                'memory' => $result[2],
                'ce_info' => $ce_info,
            ]);
            $info = $res;
        }
        return $info;
    }
}

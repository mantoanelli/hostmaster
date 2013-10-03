<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Myemail {

    public function enviarAuth($from, $fromName, $subject, $body, $to, $copy = null, $attach = null) {
        $CI =& get_instance();
        $CI->load->library('email');
        $CI->email->initialize();
        $CI->email->subject($subject);
        $CI->email->from($from,$fromName);
        $CI->email->to($to);
        $CI->email->message($body);
        if ($copy) {
            if (is_array($copy)) {
                foreach ($copy as $v) {
                    $CI->email->bcc($v);
                }
            } else {
                $CI->email->bcc($copy);
            }
        }

        if ($CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }

}
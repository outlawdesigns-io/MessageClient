<?php

abstract class MessageClient{

  const MSGEND = 'https://api.outlawdesigns.io:9667/';
  const AUTHERR = 'Auth token required to send message';

  public static function authenticate($username,$password){
    $headers = array('request_token: ' . $username,'password: ' . $password);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,self::MSGEND . "authenticate");
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $output = json_decode(curl_exec($ch));
    curl_close($ch);
    if(isset($output->error)){
      throw new \Exception($output->error);
    }
    return $output;
  }
  public static function verifyToken($token){
    $headers = array('auth_token: ' . $token);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,self::MSGEND . "verify");
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $output = json_decode(curl_exec($ch));
    curl_close($ch);
    if(isset($output->error)){
      throw new \Exception($output->error);
    }
    return $output;
  }
  public static function send($message,$token){
    $headers = array('auth_token: ' . $token,'Content-Type: application/json');
    $post = json_encode($message);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,self::MSGEND . "send");
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
  }
  public static function isSent($msg_name,$flag,$token){
    $headers = array('auth_token: ' . $token);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,self::MSGEND . "sent/" . $msg_name . "/" . $flag);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output = curl_exec($ch);
    curl_close($ch);
    if($output === 'true'){
      return true;
    }elseif(isset(json_decode($output)->error)){
      throw new \Exception(json_decode($output)->error);
    }
    return false;
  }
}

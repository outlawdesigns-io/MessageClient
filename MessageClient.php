<?php

class MessageClient{

  protected $_msgServiceUrl;
  protected $_accessToken;

  public function __construct($msgServiceUrl, $accessToken){
    if($msgServiceUrl[strlen($msgServiceUrl) - 1] != '/') $msgServiceUrl .= '/';
    $this->_msgServiceUrl = $msgServiceUrl;
    $this->_accessToken = $accessToken;
  }

  public function send($message){
    $headers = array('Authorization: Bearer ' . $this->_accessToken,'Content-Type: application/json');
    $post = json_encode($message);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$this->_msgServiceUrl . "send");
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output = curl_exec($ch);
    $json = json_decode($output);
    curl_close($ch);
    if(isset($json->error)){
      throw new \Exception($json->error);
    }
    return $json;
  }
  public function isSent($msg_name,$flag){
    $headers = array('Authorization Bearer: ' . $this->_accessToken);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$this->_msgServiceUrl . "sent/" . $msg_name . "/" . $flag);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output = curl_exec($ch);
    curl_close($ch);
    if($output === 'true'){
      return true;
    }
    if(isset(json_decode($output)->error)){
      throw new \Exception(json_decode($output)->error);
    }
    return false;
  }
}

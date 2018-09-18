<?php
Class Application {
//object 변수
  var $param;
//생성자
  function __construct(){
    $this->getParam();
    new $this->param->page_type($this->param);
  }
//get param
  function getParam(){
    //URL로 받은 주소를 '/' 단위로 나눠서 parameter 배열 내 변수로 저장
    if(isset($_GET['param'])){
      $get = explode("/",$_GET['param']);
    }
    $param = '';
    $param['page_type'] = isset($get[0]) && $get[0] != '' ? $get[0] : 'main';
    $param['action'] = isset($get[1]) && $get[1] != '' ? $get[1] : NULL;
    $param['idx'] = isset($get[2]) && $get[2] != '' ? $get[2] : NULL;
//    $param['page_num'] = isset($get[2]) && $get[2] != '' ? $get[2] : 1;
    $param['include_file'] = isset($param['action']) ? $param['action'] : $param['page_type'];
    $param['get_page'] = _URL."{$param['page_type']}";

    //parameter array를 object 형태로 저장
    $this->param = (object)$param;
  }
}
?>
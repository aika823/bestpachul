<?php

  class Model_manage extends Model
  {
    function action(){
      if(isset($_POST)){
        $employeeName = $_POST['employeeName'];
        $companyName = $_POST['companyName'];
        $detail = $_POST['detail'];
        $type = $_POST['type'];
        $employeeID = $this->select('employee', "employeeName = $employeeName",'employeeID');
        $companyID = $this->select('company', "companyName = $companyName",'companyID');
        $this->executeSQL("INSERT INTO blackList SET employeeID = '{$employeeID}', companyID = '{$companyID}', detail = '{$detail}', ceoReg = '{$type}'");
        unset($_POST);
      }
    }
  }
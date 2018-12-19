<?php
  
  Class Functions {
    function content()
    {
      $dir = _VIEW . "{$this->param->page_type}/{$this->param->include_file}.php";
      if (file_exists($dir)) require_once($dir);
      echo "<script src='/public/js/common.js'></script>";
      echo "<script src='/public/js/functions.js'></script>";
      echo "<script src='/public/js/ajax.js'></script>";
      echo "<script src='/public/js/call.js'></script>";
      echo "<script src='/public/js/ceo.js'></script>";
    }
    
    function initJoin($tableName)
    {
      $todayTime = strtotime(date("Y-m-d"));
      switch ($tableName) {
        case 'company':
          $days = 15;//만기임박 날짜 설정
          $joinList = $this->model->getTable("SELECT * FROM join_{$tableName} WHERE deleted = 0 AND point IS NULL AND deposit IS NULL");
          break;
        case 'employee':
          $days = 5;//만기임박 날짜 설정
          $joinList = $this->model->getTable("SELECT * FROM join_{$tableName} WHERE deleted = 0");
          break;
      }
      foreach ($joinList as $key => $value) {
        $joinID = $value["join_" . $tableName . "ID"];
        $endTime = strtotime($value['endDate']);
        $targetTime = strtotime($value['endDate'] . " -{$days} days");
        //imminent (만기임박)
        if (($targetTime <= $todayTime && $todayTime < $endTime) || ($tableName == 'employee' && $value['paid'] == 0)) {
          $this->model->executeSQL("UPDATE join_{$tableName} SET imminent = 1 WHERE join_{$tableName}ID = {$joinID} LIMIT 1");
        } //가입 자동 만기시킴
        else{
          if ($todayTime >= $endTime) {
            $this->model->executeSQL("UPDATE join_{$tableName} SET activated = 0 WHERE join_{$tableName}ID = {$joinID} LIMIT 1");
          }
          else{
            $this->model->executeSQL("UPDATE join_{$tableName} SET imminent = 0 WHERE join_{$tableName}ID = {$joinID} LIMIT 1");
          }
        }
        
      }
    }
    function initActCondition($list, $tableName)
    {
      foreach ($list as $key => $value) {
        $tableID = $value[$tableName . "ID"];
        $joinList = $this->model->getTable("SELECT * FROM `join_{$tableName}` WHERE {$tableName}ID = {$tableID} AND activated = 1");
        if (sizeof($joinList) > 0) {
          $this->model->executeSQL("UPDATE {$tableName} SET activated = 1 WHERE {$tableName}ID = {$tableID} LIMIT 1");
          foreach ($joinList as $key2 => $data) {
            if ($data['imminent'] == 1) {
              $this->model->executeSQL("UPDATE {$tableName} SET activated = 1, imminent = 1 WHERE {$tableName}ID = {$tableID} LIMIT 1");
              break;
            }
            else{
              $this->model->executeSQL("UPDATE {$tableName} SET activated = 1, imminent = 0 WHERE {$tableName}ID = {$tableID} LIMIT 1");
              break;
            }
          }
        } else {
          $this->model->executeSQL("UPDATE {$tableName} SET activated = 0, imminent = 0 WHERE {$tableName}ID = {$tableID} LIMIT 1");
        }
      }
      return $list;
    }
    function getActCondition($list, $tableName)
    {
      $tableID = $tableName . 'ID';
      $imminentArray = $this->model->getColumnList($this->model->getList([$this->imminentCondition]), $tableID);
      $deactivatedArray = $this->model->getColumnList($this->model->getList([$this->deactivatedCondition]), $tableID);
      $deletedArray = $this->model->getColumnList($this->model->getList([$this->deletedCondition]), $tableID);
      foreach ($list as $key => $value) {
        $tableID = $tableName . 'ID';
        $tableID = $list[$key][$tableID];
        if (in_array($tableID, $deactivatedArray)) {
        $actCondition = "만기됨";
        $class = "deactivated";
        } elseif (in_array($tableID, $imminentArray)) {
          $actCondition = "만기임박";
          $class = "imminent";
        } elseif (in_array($tableID, $deletedArray)) {
          $actCondition = "삭제됨";
          $class = "deleted";
        } else {
          $actCondition = "가입중";
          $class = 'activated';
        }
        $list[$key]['actCondition'] = $actCondition;
        $list[$key]['class'] = $class;
      }
      return $list;
    }
    
    function get_joinType($data)
    {
      if (isset($data['deposit'])) {
        return "보증금+콜비";
      } elseif (isset($data['point'])) {
        return "포인트";
      } elseif (isset($data['price'])) {
        return "구좌";
      } else {
        return "만기됨";
      }
    }
    function get_joinPrice($data)
    {
      switch ($this->get_joinType($data)) {
        case '구좌':
          echo number_format($data['price']) . " 원";
          break;
        case '보증금+콜비':
          echo number_format($data['deposit']) . " 원 (보증금)";
          break;
        case '포인트':
          echo number_format($data['point']) . " 원 (포인트)";
          break;
      }
    }
    function get_endDate($data, $tableName)
    {
      switch ($tableName) {
        case 'company':
          $days = 15;
          break;
        case 'employee':
          $days = 5;
          break;
      }
      $condition1 = strtotime($data['endDate'] . " -{$days} days") <= strtotime(_TODAY);
      $condition2 = strtotime(_TODAY) <= strtotime($data['endDate']);
      $string = $data['endDate'];
      $leftDays = leftDays($data['endDate']);
      if ($condition1 && $condition2) {
        $string .= " (D{$leftDays})";
      }
      return $string;
    }
  
    function get_joinDetail($data)
    {
      if(isset ($data['detail']) && $data['detail']!=""){
        echo $data['detail'];
        if($data['deleted'] == 1){
          echo "<br/>(".$data['deleteDetail'].")";
        }
        elseif($data['deleted'] == 0 && $data['activated'] == 0) {
          echo "<br/>(가입 만기됨)";
        }
        if(isset($data['cancelDetail']) && $data['cancelDetail']!=''){
          echo "<br/>(".$data['cancelDetail'].")";
        }
      }
      else{
        if ($data['deleted'] == 1) echo "(삭제사유: " . $data['deleteDetail'] . ")";
        elseif ($data['deleted'] == 0 && $data['activated'] == 0) {
          echo "(가입 만기됨)";
        }
        if(isset($data['cancelDetail']) && $data['cancelDetail']!=''){
          echo "<br/>(".$data['cancelDetail'].")";
        }
      }
    }
    function get_callDetail($data){
      if(isset($data['detail']) && $data['detail']!=''){
        echo $data['detail'];
        if($data['cancelled']==1){
          if(isset($data['cancelDetail'])){
            echo "<br/>".$data['cancelDetail'];
          }
        }
      }
      else{
        if($data['cancelled']==1){
          if(isset($data['cancelDetail'])){
            echo $data['cancelDetail'];
          }
        }
      }
    }
    function get_joinDeleteBtn($data, $tableName)
    {
      if ($data['activated'] == 1) {
        $id = "join_" . $tableName . "ID";
        return "<button class = \"join-cancel-modal-btn\" value = \"{$data[$id]}\" > X</button>";
      } else {
        return $data['deletedDate'];
      }
    }
    function get_deleteBtn($data, $tableName)
    {
      $tableID = $tableName . "ID";
      if ($data['deleted'] == 0) {
        return <<<HTML
          <button class="delete-modal-btn" value="{$data[$tableID]}">X</button>
HTML;
      } else {
        return <<<HTML
        <form action="" method="post">
              <input type="hidden" name="action" value="restore">
              <input type="hidden" name="{$tableID}" value="">
              <input class="btn" type="submit" value="복구">
        </form>
HTML;
      }
    }
    function get_paidBtn($data,$table,$column)
    {
      if($data[$column]>0){
        if($data['paid']==0){
          return <<<HTML
<button type="button" class="btn btn-default getMoneyBtn_{$table}" id="{$data[$table.'ID']}">{$data[$column]}</button>
HTML;
        }
        else return '수금완료';
      }
      else return '무료';
    }
    function makeDetail($array)
    {
      foreach ($array as $key => $value) {
        $value .= " : ";
        $newArray[] = $value;
      }
      $string = implode("\n", $newArray);
      return $string;
    }
    function get_detail($data, $tableName)
    {
      $companyDetail = array('좌탁여부', '테이블수', '그릇종류', '식기세척기', '상주직원수', '주방환경', '교통환경', '주요업무', '가입경로', '기타사항');
      $employeeDetail = array('경력', '특기', '체류비자', '월급제', '4대보험', '자차소유', '추천인', '외모', '이상여부', '지각', '빵꾸', '기타사항', '상담자');
      if (isset($data['detail'])) {
        return $data['detail'];
      } else {
        switch ($tableName) {
          case 'company':
            return $this->makeDetail($companyDetail);
          case 'employee':
            return $this->makeDetail($employeeDetail);
        }
      }
    }
    
    function joinColor($data, $tableName)
    {
      $today = date('Y-m-d');
      switch ($tableName) {
        case 'company' :
          $imminent = 15;
          break;
        case 'employee':
          $imminent = 5;
          break;
      }
      if ($data['activated'] == 0) echo "gray";
      elseif (
        strtotime($data['endDate'] . " -{$imminent} days") <= strtotime($today)
        && strtotime($today) < strtotime($data['endDate']))
        echo "orange";
      else echo "white";
    }
    function companyName($id)
    {
      return $this->model->select('company', "`companyID`={$id}", 'companyName');
    }
    function employeeName($id)
    {
      return $this->model->select('employee', "`employeeID`={$id}", 'employeeName');
    }
    function callType($data)
    {
      if (isset($data['point'])) return '포인트';
      if (isset($data['price'])) return '유료';
      else return '일반';
    }
    
//    function joinType($list)
//    {
//      $result = array();
//      if (isset ($list[0])) {
//        foreach ($list as $key => $value) {
//          if (isset($value['point'])) {
//            if (!in_array('포인트', $result)) $result[] = '포인트';
//          } elseif (isset($value['deposit'])) {
//            if (!in_array('보증금', $result)) $result[] = '보증금';
//          } elseif (isset($value['price'])) {
//            if (!in_array('구좌', $result)) $result[] = '구좌';
//          }
//        }
//        return implode(',', $result);
//      }
//      else return null;
//    }
    
    function assignType($data)
    {
      if (isset($data['point'])&&$data['point']>0) return '(P)';
      if (isset($data['price'])&&$data['price']>0) return '(유)';
    }
    function timeType($data)
    {
      $start = $data['startTime'];
      $end = $data['endTime'];
      $workTime = $end - $start;
      if ($workTime >= 10) $result = '종일';
      else {
        if ($start < 12) $result = '오전'; else $result = '오후';
      }
      return $result . ' (' . date('H:i', strtotime($data['startTime'])) . "~" . date('H:i', strtotime($data['endTime'])) . ')';
    }
    function getTime($i)
    {
      if ($i < 12) {
        $time = '오전 ' . $i . '시';
      } elseif ($i == 12) {
        $time = '정오';
      } elseif (12 < $i && $i < 24) {
        $time = $i - 12;
        $time = '오후 ' . $time . '시';
      } elseif ($i == 24) {
        $time = '자정';
      } elseif ($i > 24) {
        $time = $i - 24;
        $time = '익일오전 ' . $time . '시';
      }
      return $time;
    }
  }
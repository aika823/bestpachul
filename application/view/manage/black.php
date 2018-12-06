<div class="board_list auto-center" style="margin: 0 200px; width: auto;">
    <h1>블랙리스트 관리</h1>
    <div class="form-style-1">
        <form id="company_form" action="" method="post">
            <fieldset>
                <input type="hidden" name="action" value="black">
                <div class="table">
                    <div class="tr">
                        <div class="td-label">인력명</div>
                        <div class="td">
                            <input id="employeeName" type="text" list="employeeList" name="employeeName">
                            <datalist id="employeeList" class="input-field">
                              <?php foreach ($this->employee_List as $key => $data): ?>
                                  <option value="<?php echo $data['employeeName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td-label">업체명</div>
                        <div class="td">
                            <input type="text" list="companyList" name="companyName">
                            <datalist id="companyList" class="input-field">
                              <?php foreach ($this->company_List as $key => $data): ?>
                                  <option value="<?php echo $data['companyName'] ?>"></option>
                              <?php endforeach ?>
                            </datalist>
                        </div>
                        <div class="td">
                            <select name="type">
                                <option value="0">안가요</option>
                                <option value="1">오지마세요</option>
                            </select>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td-label">비고</div>
                        <textarea name="detail" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </fieldset>
            <div class="btn_group">
                <button class="btn btn-submit" type="submit">추가</button>
            </div>
        </form>
    </div>

    <table id="blackListTable" width="100%">
        <colgroup>
            <col width="5%">
            <col width="15%">
            <col width="25%">
            <col width="5%">
            <col width="45%">
            <col width="5%">
        </colgroup>
        <thead>
        <tr>
            <th class="link" onclick="sortTable('blackListTable', 0)">#</th>
            <th class="link" onclick="sortTable('blackListTable', 1)">인력명</th>
            <th class="link" onclick="sortTable('blackListTable', 2)">업체명</th>
            <th class="link" onclick="sortTable('blackListTable', 3)">구분</th>
            <th class="link" onclick="sortTable('blackListTable', 4)">비고</th>
            <th>삭제</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->blackList_List as $key => $data): ?>
            <tr>
                <td class="al_c"><?php echo $data['blackListID'] ?></td>
                <td class="al_l link" onClick='location.href="<?php echo _URL."employee/view/{$data['employeeID']}" ?>"'>
                  <?php echo $this->model->select('employee', "employeeID = $data[employeeID]",'employeeName')?>
                </td>
                <td class="al_l link" onClick='location.href="<?php echo _URL."company/view/{$data['companyID']}" ?>"'>
                  <?php echo $this->model->select('company', "companyID = $data[companyID]",'companyName')?>
                </td>
                <td class="al_l"><?php if($data['ceoReg']==1) echo '오지마세요'; else echo '안가요'?></td>
                <td class="al_l"><?php echo $data['detail'] ?></td>
                <td class="al_c"><button type="button" class="btn btn-danger blackDelBtn" value="<?php echo $data['blackListID']?>">X</button></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
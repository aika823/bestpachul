<table id="employee_table" width="100%">
    <colgroup>
        <col width="5%">
        <col width="5%">
        <col width="10%">
        <col width="35%">
        <col width="25%">
        <col width="15%">
        <col width="2%">
        <col width="3%">
    </colgroup>
    <thead>
    <tr>
        <th class="link" onclick="sortTable('employee_table', 0)">#</th>
        <th class="link" onclick="sortTable('employee_table', 1)">성명</th>
        <th class="link" onclick="sortTable('employee_table', 2)">연령</th>
        <th class="link" onclick="sortTable('employee_table', 3)">간단주소</th>
        <th class="link" onclick="sortTable('employee_table', 4)">전화번호</th>
        <th class="link" onclick="sortTable('employee_table', 5)">점수</th>
        <th onclick="sortTable('employee_table', 6)"><span class="link fa fa-star"></span></th>
        <th class="link" onclick="sortTable('employee_table', 7)">X</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->list as $key => $data): ?>
        <tr style="background-color: <?php echo $data['color'] ?>">
            <td class="al_c"><?php echo $data['employeeID'] ?><a href="<?php echo "{$this->param->get_page}/view/{$data['idx']}" ?>"></td>
            <td class="al_l link" onClick='location.href="<?php echo "{$this->param->get_page}/view/{$data['employeeID']}" ?>"'><?php echo $data['employeeName'] ?></td>
            <td class="al_l"><?php echo getAge($data['birthDate']) ?></td>
            <td class="al_l"><?php echo $data['address'] ?></td>
            <td class="al_l"><?php echo $data['employeePhoneNumber'] ?></td>
            <td class="al_l"><?php echo $data['grade'] ?></td>
            <td><span class="fa fa-star selectable <?php echo ($data['bookmark'] == 1) ? 'checked' : 'unchecked' ?>" id="<?php echo $data['employeeID'] ?>"></span></td>
            <td class="al_c"><?php echo $this->get_DeleteBtn($data, 'employee') ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
<div class="mobile_view">
    <form action="" id="callForm" method="post">
        <input type="hidden" name="action" value="<?php if ($_POST['action'] == 'paidCall') echo 'paidCall'; else echo 'call' ?>">
        <input type="hidden" name="startTime" id="startTime">
        <input type="hidden" name="endTime" id="endTime">
        <input type="hidden" name="salary" id="salary">

        <?php if ($_POST['action'] != 'paidCall'): ?>
          <!--날짜-->
          <div class="container">
              <div class="tr tr-title">
                  <div class="lbl">날짜</div>
              </div>
              <div class="tr tr-body">
                  <div class="td td-50">
                      <input class="date" id="date" type="date" name="workDate" min="<?php echo date("Y-m-d", strtotime('+1 day'))?>"
                             max="<?php echo $this->lastJoinDate()?>" required
                             value="<?php echo $tomorrow ?>">
                  </div>
                  <div class="td td-50">
                      <button class="btn-day" type="button" id="1day">
                          내일(<? echo $this->day[date("w", strtotime("+1 day"))] ?>)
                      </button>
                      <button class="btn-day" type="button" id="2day">
                          모레(<? echo $this->day[date("w", strtotime("+2 day"))] ?>)
                      </button>
                  </div>
              </div>
          </div>

          <!--시간-->
          <div class="container">
              <div class="tr tr-title">
                  <div class="lbl">시간</div>
              </div>
              <div class="tr tr-body">
                  <div class="td td-70" id="">
                      <select class="time hour" id="startHour" form="callForm" required>
                          <option value="" selected disabled hidden>근무 시작 시간</option>
                        <?php for ($i = 1; $i < 25; $i++): ?>
                            <option class="startOption" value="<?php echo $i ?>">
                              <?php echo $this->getTime($i); ?>
                            </option>
                        <?php endfor; ?>
                      </select>
                      <select class="time minute" id="startMin" form="callForm" required>
                          <option value="00">00분</option>
                          <option value="30">30분</option>
                      </select>
                      <select class="time hour" id="endHour" form="callForm" required>
                          <option value="" selected disabled hidden>근무 종료 시간</option>
                        <?php for ($i = 1; $i < 37; $i++): ?>
                            <option class="endOption" value="<?php echo $i ?>">
                              <?php echo $this->getTime($i); ?>
                            </option>
                        <?php endfor; ?>
                      </select>
                      <select class="time minute" id="endMin" form="callForm" required>
                          <option value="00">00분</option>
                          <option value="30">30분</option>
                      </select>
                  </div>
                  <div class="td td-30">
                      <button type="button" class="timeSelect" id="morningBtn">오전</button>
                      <button type="button" class="timeSelect" id="afternoonBtn">오후</button>
                      <button type="button" class="timeSelect" id="allDayBtn">종일</button>
                  </div>
              </div>
              <div class="tr-title">
                  <div class="td">
                      <h1 id="salaryInfo">근무시간을 선택해주세요</h1>
                  </div>
              </div>
          </div>

          <div class="container">
              <div class="tr tr-title">
                  <div class="lbl">업종</div>
              </div>
              <div class="tr">
                  <div class="td">
                      <button type="button" id="dish">설거지</button>
                      <button type="button" id="kitchen">주방보조</button>
                      <button type="button" id="hall">홀서빙</button>
                      <select name="workField" id="workField" form="callForm" required>
                        <?php foreach ($this->workField_List as $key => $data): ?>
                            <option value="<?php echo $data['workField']; ?>">
                              <?php echo $data['workField'] ?>
                            </option>
                        <?php endforeach ?>
                      </select>
                  </div>
              </div>
          </div>

          <div class="container">
              <div class="tr tr-title">
                  <div class="lbl">기타요청사항</div>
              </div>
              <div class="tr tr-body">
                  <textarea name="detail" id="detail" cols="30" rows="10"></textarea>
              </div>
          </div>
      <?php endif; ?>
      
      <?php if ($_POST['action'] == 'paidCall'): ?>
        <?php $submitName = "'유료콜' 보내기 (콜비: '6,000원')";$type = 'paidCall'; ?>
          <input type="hidden" name="price" id="price" value="6000">
          <input type="hidden" name="workDate" value="<?php echo $_POST['workDate']?>">
          <input type="hidden" name="startTime" value="<?php echo $_POST['startTime']?>">
          <input type="hidden" name="endTime" value="<?php echo $_POST['endTime']?>">
          <input type="hidden" name="workField" value="<?php echo $_POST['workField']?>">
          <input type="hidden" name="salary" value="<?php echo $_POST['salary']?>">
          <input type="hidden" name="detail" value="<?php echo $_POST['detail']?>">
        <div>
            <p>아래와 같이 유료콜을 보내시겠습니까?</p>
            <h1>근무날짜 : <?php echo $_POST['workDate']?></h1>
            <h1>근무시간 : <?php echo $_POST['startTime'].' ~ '.$_POST['endTime']?></h1>
            <h1>업종 : <?php echo $_POST['workField']?></h1>
            <h1>기타요청사항 : <?php echo $_POST['detail']?></h1>
        </div>
        
      <?php else: $submitName = "콜 보내기"; $type = 'call' ?>
      <?php endif; ?>
        <div class="tr al_r">
            <input id="submitBtn" class="btn btn-insert" type="submit" value="<?php echo $submitName ?>">
        </div>
    </form>
        <?php if ($_POST['action'] == 'paidCall'): ?>
            <form>
                <input type="hidden" name="action" value="reset">
                <div class="tr al_r">
                    <input id="cancelBtn" class="btn btn-danger" type="submit" value="취소">
                </div>
            </form>
      <?php endif;?>
</div>

<script>
    let startHour = $('#startHour');
    let endHour = $('#endHour');
    let endMin = $('#endMin');
    let minute = $('.minute');
    let salary = $('#salaryInfo');
    let submit = $('#submitBtn');
    let date = $('#date');
    
    $(document).ready(function () {
        $('#startHour').val('10');
        $('#endHour').val('15');
    });

    function holiday(date) {
        let array = [<?php echo $this->dateFormat($this->holidayList)?>];
        let sat = (new Date(date)).getDay() === 0;
        let sun = (new Date(date)).getDay() === 6;
        let holiday = array.includes(date);
        if ((sat || sun) || holiday) return true;
        else return false;
    }

    function calculate(time) {
        let money;
        let date = $('#date').val();
        let day = new Date($('#date').val()).getDay();
        //주말
        if (holiday(date)) {
            $('#date').css('color', 'red');
            $('#date').css('font-weight', 'bold');
            if (parseInt(endHour.val()) * 100 + parseInt(endMin.val()) > 2400) {//야간
                switch (time) {
                    case 5:money = 57000;break;
                    case 6:money = 64000;break;
                    case 7:money = 71000;break;
                    case 8:money = 78000;break;
                    case 9:money = 85000;break;
                    case 10:money = 92000;break;
                    case 11:money = 96000;break;
                    case 12:money = 100000;break;
                    default:money = 0;break;
                }
            }
            else {
                switch (time) {
                    case 5:money = 47000;break;
                    case 6:money = 54000;break;
                    case 7:money = 61000;break;
                    case 8:money = 68000;break;
                    case 9:money = 75000;break;
                    case 10:money = 82000;break;
                    case 11:money = 86000;break;
                    case 12:money = 90000;break;
                    default:money = 0;break;
                }
            }
        }
        //평일
        else {
            $('#date').css('color', 'black');
            if (parseInt(endHour.val()) * 100 + parseInt(endMin.val()) > 2400) {
                switch (time) {
                    case 5:money = 52000;break;
                    case 6:money = 59000;break;
                    case 7:money = 66000;break;
                    case 8:money = 73000;break;
                    case 9:money = 80000;break;
                    case 10:money = 87000;break;
                    case 11:money = 91000;break;
                    case 12:money = 95000;break;
                    default:money = 0;break;
                }
            }
            else {
                switch (time) {
                    case 5:money = 42000;break;
                    case 6:money = 49000;break;
                    case 7:money = 56000;break;
                    case 8:money = 63000;break;
                    case 9:money = 70000;break;
                    case 10:money = 77000;break;
                    case 11:money = 81000;break;
                    case 12:money = 85000;break;
                    default:money = 0;break;
                }
            }
        }
        salary.html("근무시간: " + time + " 시간 / 일당: " + money + " 원");
        $('#salary').val(money);
    }

    $(document).ready(function () {
        $('#workField').val('주방보조');
        startHour.val('10');
        endHour.val('15');
        calculate(endHour.val() - startHour.val());
    });

    $('#1day').click(function () {
        date.val('<?php echo date("Y-m-d", strtotime("+1 day"))?>');
        date.trigger('change');
    });
    $('#2day').click(function () {
        date.val('<?php echo date("Y-m-d", strtotime("+2 day"))?>');
        date.trigger('change');
    });
    $('#morningBtn').click(function () {
        startHour.val('10');
        endHour.val('15');
        minute.val('00');
        startHour.trigger('change');
    });
    $('#afternoonBtn').click(function () {
        startHour.val('18');
        endHour.val('23');
        minute.val('00');
        startHour.trigger('change');
    });
    $('#allDayBtn').click(function () {
        startHour.val('10');
        endHour.val('22');
        minute.val('00');
        let starth = parseInt(startHour.val());
        for (let i = 0; i < 50; i++) {
            if ((i < starth + 5) || (i > starth + 11)) {
                $('.endOption').eq(i).css('display', 'none');
            }
            else {
                $('.endOption').eq(i).css('display', 'block');
            }
        }
        calculate(endHour.val() - startHour.val())
    });
    $('#dish').click(function () {
        $('#workField').val('설거지');
    });
    $('#kitchen').click(function () {
        $('#workField').val('주방보조');
    });
    $('#hall').click(function () {
        $('#workField').val('홀서빙');
    });
    minute.on('change', function () {
        minute.val($(this).val());
    });
    date.on('change', function () {
        calculate(endHour.val() - startHour.val());
    });
    submit.on('click', function () {
        $('#startTime').val(startHour.val() + ":" + $('#startMin').val()); //HH:MM
        $('#endTime').val(endHour.val() + ":" + $('#endMin').val()); //HH:MM
    });
    startHour.on('change', function () {
        let starth = parseInt(startHour.val());
        endHour.val(starth + 5);
        for (let i = 0; i < 50; i++) {
            if ((i < starth + 4) || (i > starth + 11)) {
                $('.endOption').eq(i).css('display', 'none');
            }
            else {
                $('.endOption').eq(i).css('display', 'block');
            }
        }
        calculate(endHour.val() - startHour.val());
    });
    endHour.on('change', function () {
        calculate(endHour.val() - startHour.val())
    })
</script>
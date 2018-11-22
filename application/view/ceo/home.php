<div class="mobile_view">
    <h1>업체명: <?php echo $this->companyData['companyName'] ?></h1>
    <div class="table">
        <div class="tr">
            <div class="lbl">가입유형 :</div>
            <div class="td"><?php echo $this->get_joinTypes($this->joinData) ?></div>
        </div>
      <?php $i = 1; ?>

        <?php foreach ($this->joinData as $key => $value): ?>
        <?php if ($value['activated'] == 1): ?>
              <div class="tr">
                  <div class="lbl"><?php echo "가입{$i} ({$this->get_joinType($value)}) : " ?></div>
                  <div class="td">
                    <?php echo $value['startDate'] . " ~ " ?>
                    <?php if (isset($value['endDate'])) : ?>
                      <?php echo $value['endDate'] ?>
                      <?php echo "(" . (strtotime($value['endDate']) - strtotime(date('Y-m-d'))) / 3600 / 24 . "일 남음)" ?>
                    <?php endif; ?>
                  </div>
              </div>
          <?php $i = $i + 1; ?>
        <?php endif; ?>
      <?php endforeach; ?>
        <?php if($this->get_joinTypes($this->joinData)!='보증금'):?>
        <div class="tr">
            <div class="lbl">
                금주 부른 콜 :
            </div>
            <div class="td">
                평일 : <?php echo sizeof($this->weekdayCount)?> 콜 / 주말 : <?php echo sizeof($this->weekendCount)?> 콜
            </div>
        </div>
        <?php endif;?>
      <?php if($this->get_joinTypes($this->joinData)!='포인트'):?>
        <div class="tr">
            <div class="lbl">
                금주 유료 콜 :
            </div>
            <div class="td">
                평일 : <?php echo sizeof($this->weekdayPaidCount)?> 콜 / 주말 : <?php echo sizeof($this->weekendPaidCount)?> 콜
            </div>
        </div>
        <?php endif;?>
        <?php if($this->get_joinTypes($this->joinData)!='포인트'):?>
        <div class="tr">
            <div class="lbl">콜비 누적 :</div>
            <div class="td">
                <?php echo $this->callPrice;?>
            </div>
        </div>
          <?php else:?>
            <div class="tr">
                <div class="lbl">잔여 포인트 :</div>
                <div class="td">
                  <?php echo $this->joinData[0]['point'];?>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>

<script>
    $(document).ready(function () {
      <?php if($_POST['action']=='paidCall'):?>
        document.getElementById('tabCall').click();
      <?php endif;?>
    });
    
</script>
<div class="board_list scroll_list right auto-center" style="overflow: hidden">
  <?php if (in_array($this->param->page_type, ['company', 'employee'])): ?>
      <h1>펑크 내역</h1>
  <?php else: ?>
    <?php require_once 'datepicker.php' ?>
  <?php endif; ?>
  <?php $type = 'punk'; require 'callTable.php' ?>
</div>
<?php require_once 'call_modal.php' ?>
<?php require_once 'call_js.php' ?>
<!-- Cancel Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input id="modal-deleteID" type="hidden" name="deleteID">
            <textarea name="deleteDetail"></textarea>
            <input class="btn btn-insert" type="submit" value="삭제하기">
            <input class="btn btn-danger closeModal" type="button" value="취소">
        </form>
    </div>
</div>

<!-- Join Cancel Modal -->
<div id="joinCancelModal" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="delete">
            <input id="modal-joinID" type="hidden" name="joinID">
            <textarea name="deleteDetail"></textarea>
            <input class="btn btn-default closeModal" type="button" value="취소">
            <input class="btn btn-danger" type="submit" value="삭제">
        </form>
    </div>
</div>

<!-- Join Update Modal -->
<div id="joinUpdateModal" class="modal">
    <div class="modal-content">
        <form action="" method="post">
            <input type="hidden" name="action" value="join_update">
            <input id="updateID" type="hidden" name="joinID">
            <input type="number" id="updatePrice" name="price">
            <textarea id="updateDetail" name="detail"></textarea>
            <input class="btn btn-default closeModal" type="button" value="취소">
            <input class="btn btn-insert" type="submit" value="수정">
        </form>
    </div>
</div>
<div class="modal-content" data-width="500">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Pay Date: <?php echo date('F d, Y', strtotime($_POST['payroll_date'])) ?></h4>
    </div>    
    <?php echo $content?>
</div>

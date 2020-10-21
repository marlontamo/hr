<div class="modal-body padding-bottom-0">
    <table class="table table-striped" id="tblGrid">
        <thead id="tblHead">
            <tr>
                <th style="width: 30%;">Transaction</th>
                <th style="width: 25%;" class="text-left">Date</th>
                <th style="width: 25%;" class="text-left">Original<br>Pay Date</th>
                <th style="width: 20%;" class="text-center">Unit<br>(in hours)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($details as $detail): ?>
            <tr>
                <td>
                    <span class="text-success"><?php echo $detail['transaction_label']; ?></span>
                </td>
                <td class="text-left"><?php echo date('F-j', strtotime($detail['date'])); ?></td>
                <?php $payroll_date = ($detail['latefile'] == 1) ? date('F-j', strtotime($detail['original_payroll_date'])) : '&nbsp;'; ?>
                <td class="text-left"><?php echo $payroll_date; ?></td>
                <td class="text-center"><?php echo $detail['quantity']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>    
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
</div>

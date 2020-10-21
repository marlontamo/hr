<?php
    $this->db->order_by('transaction_label');
    $compben = $this->db->get_where('payroll_transaction', array('deleted' => 0, 'show_in_recruitment' => 1));
    $cbopt = array('' => 'Select...');
    foreach( $compben->result() as $cb )
    {
        $cbopt[$cb->transaction_id] = $cb->transaction_label;
    }

    $rates = $this->db->get_where('payroll_rate_type', array('deleted' => 0));
    $rateopt = array('' => 'Select...');
    foreach( $rates->result() as $rate )
    {
        $rateopt[$rate->payroll_rate_type_id] = $rate->payroll_rate_type;
    }
?>
<tr class="combenefits">
    <td>
        <?php echo form_dropdown('compben[benefit_id][]',$cbopt, '', 'class="form-control select2me" data-placeholder="Select..."')?>
    </td>
    <td>
        <input type="text" class="form-control" name="compben[amount][]" value="" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false">
    </td>
    <td>
        <?php echo form_dropdown('compben[rate_id][]',$rateopt, '', 'class="form-control select2me" data-placeholder="Select..."')?>
    </td>
    <td>
        <div class="make-switch" data-off="success" data-on="danger" data-on-label="&nbsp;No&nbsp;&nbsp;" data-off-label="&nbsp;Yes&nbsp;">
            <input type="checkbox" value="0" name="" checked="checked" id="" class="recruitment-permanent-temp dontserializeme toggle"/>
            <input type="hidden" name="compben[permanent][]" class="recruitment-permanent-val" value="0"/>
        </div> 
    </td>      
    <td>
        <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_benefit_row($(this))"><i class="fa fa-trash-o"></i> Delete</a>
    </td>
</tr>

<script type="text/javascript">

    $(document).ready(function(){

        $('select.select2me').select2();       

    });

</script>
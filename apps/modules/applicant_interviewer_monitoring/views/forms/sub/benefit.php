<?php
    $compben = $this->db->get_where('recruitment_benefit', array('deleted' => 0));
    $cbopt = array('' => 'Select...');
    foreach( $compben->result() as $cb )
    {
        $cbopt[$cb->benefit_id] = $cb->benefit;
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
        <input type="text" <?php if($is_disabled == 1) echo "disabled='true'" ?> class="form-control" name="compben[amount][]" value="" >
    </td>
    <td>
        <?php echo form_dropdown('compben[rate_id][]',$rateopt, '', 'class="form-control select2me" data-placeholder="Select..."')?>
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
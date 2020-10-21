
        <tr class="step1_interview">
            <td>
                <div class="input-group date form_datetime"  data-date-start-date="+0d">                                       
                    <input type="text" size="16" class="form-control sched_datetime" name="final_sched_date[]" />
                    <span class="input-group-btn">
                        <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>
            </td> 
            <td>
                <input type="hidden"  name="final_sched_user_id[]" class="form-control">
                <input type="text" name="final_partner_name" type="text" class="form-control" autocomplete="off">
            </td>
            <td>
            <?php                        
                $option = $this->db->get_where('recruitment_interview_location', array('deleted' => 0));
                $options = array('' => 'Select...');
                foreach ($option->result() as $opt) {
                    $options[$opt->interview_location_id] = $opt->interview_location;
                }
                echo form_dropdown('final_location_id[]',$options, '', 'class="form-control select2me" data-placeholder="Select..."');
            ?>
                <!-- <input type="text" name="location[]" id="location" type="text" class="form-control" > -->
            </td>
            <td>
                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
            </td>
        </tr>

<script type="text/javascript">

    $('select.select2me').select2();
    
</script>
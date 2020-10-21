
<?php
    $value['key_value'] = '';
    $value['other_remarks'] = '';
    foreach($data['keys'] as $key):
        $multiple_qry = "SELECT * FROM ww_recruitment_interview_details 
                        WHERE `key` = '{$key['key_code']}' AND interview_id = {$interview->id}";
        $multiple_sql = $db->query($multiple_qry);
        if($multiple_sql && $multiple_sql->num_rows() > 0){
            $value = $multiple_sql->row_array();
        }

        $disabled = "";
        if($key['key_code'] == 'hrd_remarks' && !$edit_remarks){
            $disabled = "disabled";
        }
?>
<div>
<?php
    	if($key['show_key_label']):
?>
			<span class="bold"><?php echo $key['key_label'] ?>:</span>
<?php
		endif;
        $readonly = '';
        if ($key['hidden']){
            $readonly = 'readonly';
        }
        switch($key['uitype_id']){
            case 2://TextArea
?>
			<textarea <?php echo $disabled ?> <?php echo $readonly ?> class="form-control" rows="3" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]"><?php echo $value['key_value'] ?></textarea>
<?php
			break;
            case 3://textfield
?>          
                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy" >
                    <input type="text" class="form-control" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]" id="date_interview" value="<?php echo $value['key_value'] ?>" placeholder="Enter Requested on" readonly>
                    <span class="input-group-btn">
                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>

<!-- 			<span>
				<input id="maxlength_defaultconfig" class="form-control <?php echo $key['key_code']?>" type="text" value="<?php echo $value['key_value'] ?>" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]">
			</span> -->
<?php
			break;
            case 4://Passed/Failed
	            // $passed = '';
             //    $failed = '';
             //    $w_reservation = '';
            	// if($value['key_value'] == "Passed"){
            	// 	$passed = 'selected';
            	// }else if($value['key_value'] == "Failed"){
            	// 	$failed = 'selected';
            	// }else{
             //        $w_reservation = 'selected';
             //    }

                $option = $this->db->get_where('recruitment_process_interview_result', array('deleted' => 0));
                $options = array('' => 'Select...');
                foreach ($option->result() as $opt) {
                    $options[$opt->result] = $opt->result;
                }
                echo form_dropdown('recruitment_interview_details['.$key['key_code'].'][key_value]',$options, $value['key_value'], 'class="form-control select2me" data-placeholder="Select..."');
?>
            <!-- <select name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]" class="form-control select2me" data-placeholder="Select...">
                <option value="Passed" <?php echo $passed ?>>Passed</option>
                <option value="Failed" <?php echo $failed ?>>Failed</option>
                <option value="With Reservation" <?php echo $w_reservation ?>>With Reservation</option>
            </select> -->
<?php
			break;
            case 5://interview_remarks                      
                $option = $this->db->get_where('recruitment_interview_remarks', array('deleted' => 0));
                $options = array('' => 'Select...');
                foreach ($option->result() as $opt) {
                    $options[$opt->remarks] = $opt->remarks;
                }
                echo form_dropdown('recruitment_interview_details['.$key['key_code'].'][key_value]',$options, $value['key_value'], 'class="form-control select2me" data-placeholder="Select..."');
            break;
		
?>
<?php
            break;
            case 6://employment type  
                $passed = '';
                $failed = '';
                if($value['key_value'] == "Probationary"){
                    $passed = 'selected';
                }else if($value['key_value'] == "Contractual"){
                    $failed = 'selected';
                }  
?>       
                <select name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]" class="form-control select2me" data-placeholder="Select...">
                    <option value=""></option>
                    <option value="Probationary" <?php echo $passed ?>>Probationary</option>
                    <option value="Contractual" <?php echo $failed ?>>Contractual</option>
                </select>         
<?php           break;
            case 7://recommendation  
                switch ($key['key_code']) {
                    case 'technical_recommendation':
                            $option = $this->db->get_where('recruitment_process_interview_result', array('deleted' => 0));
                            $options = array('' => 'Select...');
                            foreach ($option->result() as $opt) {
                                $options[$opt->result] = $opt->result;
                            }
                        break;
                    case 'interviewer':
                            $this->db->where('deleted',0);
                            $this->db->where('user_id !=',1);
                            $this->db->order_by('full_name');
                            $option = $this->db->get('users');
                            $options = array('' => 'Select...');
                            foreach ($option->result() as $opt) {
                                $options[$opt->user_id] = $opt->full_name;
                            }
                        break;                        
                    default:
                        # code...
                        break;
                }
                echo form_dropdown('recruitment_interview_details['.$key['key_code'].'][key_value]',$options, $value['key_value'], 'class="form-control select2me" data-placeholder="Select..."');
?>             
<?php           break;
            case 8:
?>
                <br />
                <span class="btn green fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span>
                        Add files...
                    </span>
                    <input type="file" id="applicant_monitoring_interview-photo-fileupload" name="files[]" multiple>
                </span>                                     
                <!-- The table listing the files available for upload/download -->
                <br /><br />
                <table role="presentation" class="table table-striped clearfix">
                <tbody class="files">
                    <?php
                    if ($attachement && $attachement->num_rows() > 0){
                        foreach ($attachement->result() as $attach_row) {
                            $filename = urldecode(basename($attach_row->photo)); 
                            if(strtolower($filename) == 'avatar.png'){
                                $record['applicant_monitoring_interview.photo'] = '';
                                $filename = '';
                            }                                                   
                    ?>
                            <tr class="template-download">
                                <input type="hidden" name="applicant_monitoring_interview[photo][]" value="<?php echo $attach_row->photo ?>"/>
                                <input type="hidden" name="applicant_monitoring_interview[type][]" value="<?php echo $attach_row->type ?>"/>
                                <input type="hidden" name="applicant_monitoring_interview[filename][]" value="<?php echo $attach_row->filename ?>"/>
                                <input type="hidden" name="applicant_monitoring_interview[size][]" value="<?php echo $attach_row->size ?>"/>                                                       
                                <td>
                                    <?php if ($attach_row->type == 'img') { ?>
                                    <span class="preview">
                                           <a href="javascript:void(0)" title="<?php echo $attach_row->photo ?>" data-gallery><img src="<?php echo base_url() ?>uploads/movement/thumbnail/<?php echo $filename?>"></a>
                                    </span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <p class="name">
                                        <a href="javascript:void(0)" title=""><?php echo $filename ?></a>
                                    </p>
                                </td>
                                <td>
                                    <span class="size"><?php echo $attach_row->size ?></span>
                                </td>
                                <td>
                                    <a data-dismiss="fileupload" class="btn red delete_attachment">
                                        <i class="glyphicon glyphicon-trash"></i>
                                        <span>Delete</span>
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>                                      
                </tbody>
                </table>                                        
<?php
            break;
            case 9://textfield
?>          
           <span>
                <input id="maxlength_defaultconfig" <?php echo $readonly ?> class="form-control <?php echo $key['key_code']?>" type="text" value="<?php echo ($value['key_value'] != '' ? $value['key_value'] : $schedule->full_name) ?>" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]">
            </span>
<?php
            break;            
}
?>

</div>
	<br>

<?php
	endforeach;
?>

<script type="text/javascript">
    var list = new Array();
    $(document).ready(function(){
        if (jQuery().datepicker) {
            $('#date_interview').parent('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });
            $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

        $('#applicant_monitoring_interview-photo-fileupload').fileupload({ 
            url: base_url + module.get('route') + '/single_upload',
            autoUpload: true,
            contentType: false,
        }).bind('fileuploadadd', function (e, data) {
            list = new Array();
            $.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
        }).bind('fileuploaddone', function (e, data) { 

            $.unblockUI();
            var file = data.result.file;
            if(file.error != undefined && file.error != "")
            {
                notify('error', file.error);
            }
            else{
                if($.inArray(data.result.filenames, list)<0) {
                    list.push(data.result.filenames);
                    $('.files').append(data.result.html);
                }
            }
        }).bind('fileuploadfail', function (e, data) { 
            $.unblockUI();
            notify('error', data.errorThrown);
        });

        $('.delete_attachment').live('click', function(){
            $(this).closest('tr').remove();
        });         
    });
</script>

<?php
    $value['key_value'] = '';
    $value['other_remarks'] = '';
    foreach($data['keys'] as $key):
        $multiple_qry = "SELECT * FROM ww_recruitment_interview_details 
                        WHERE `key` = '{$key['key_code']}' AND interview_id = {$interview->id}";
        $multiple_sql = $db->query($multiple_qry);
        if($multiple_sql->num_rows() > 0){
            $value = $multiple_sql->row_array();
        }
?>
<div>
<?php
    	if($key['show_key_label']):
?>
			<span class="bold"><?php echo $key['key_label'] ?>:</span> <br/>
<?php
		endif;
        switch($key['uitype_id']){
            case 2://TextArea
                echo nl2br($value['key_value']);
?>
			<!-- <textarea class="form-control" rows="3" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]"><?php echo $value['key_value'] ?></textarea> -->
<?php
			break;
            case 3://textfield
            case 7:
            case 9:
                echo $value['key_value'];
?>
			<span>
				<!-- <input id="maxlength_defaultconfig" class="form-control <?php echo $key['key_code']?>" type="text" value="<?php echo $value['key_value'] ?>" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]"> -->
			</span>
<?php
			break;
            case 4://Passed/Failed
                echo $value['key_value'];
	            $passed = '';
	            $failed = '';
            	if($value['key_value'] == "Passed"){
            		$passed = 'selected';
            	}else{
            		$failed = 'selected';
            	}
?>
           <!--  <select name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]" class="form-control select2me" data-placeholder="Select...">
                <option value="Passed" <?php echo $passed ?>>Passed</option>
                <option value="Failed" <?php echo $failed ?>>Failed</option>
            </select> -->
<?php
			break;
            case 8:
?>
                <div class="form-group">
                    <div class="col-md-7">
                        <?php 
                            if ($attachement && $attachement->num_rows() > 0){
                                foreach ($attachement->result() as $value) {                                       
                                    if ( !empty($value->photo)) {
                                        $file = FCPATH . urldecode( $value->photo );
                                        if( file_exists( $file ) )
                                        {
                                            $f_type = '';

                                            if (function_exists('get_file_info')) {
                                                $f_info = get_file_info( $file );
                                                $f_type = filetype( $file );
                                            }

                                            if (function_exists('finfo_open')) {
                                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                                $f_type = finfo_file($finfo, $file);
                                            }

                                            switch( $f_type )
                                            {
                                                case 'image/jpeg':
                                                    $icon = 'fa-picture-o';
                                                    break;
                                                case 'video/mp4':
                                                    $icon = 'fa-film';
                                                    break;
                                                case 'audio/mpeg':
                                                    $icon = 'fa-volume-up';
                                                    break;
                                                default:
                                                    $icon = 'fa-file-text-o';
                                            }
                                            
                                            $filepath = base_url()."applicant_monitoring/download_file/".$value->recruitment_interview_attachment_id;
                                            echo '<li class="padding-3 fileupload-delete-'.$value->recruitment_interview_attachment_id.'" style="list-style:none;">
                                                <a href="'.$filepath.'">
                                                <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
                                                <span>'. basename($f_info['name']) .'</span>
                                                <span class="padding-left-10"></span>
                                            </a></li>'; 
                                        }
                                    }
                                }
                            }                                                   
                        ?>
                    </div>  
                </div>  
<?php
            break;
		}
?>

</div>
	<br>

<?php
	endforeach;
?>
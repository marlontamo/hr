<?php
    $value['key_value'] = '';
    $value['other_remarks'] = '';
    foreach($data['keys'] as $key):

        switch($key['uitype_id']){
            case 1://Multiple Textfield
            $multiple_qry = "SELECT * FROM ww_recruitment_interview_details 
                            WHERE `key` = '{$key['key_code']}' AND interview_id = {$interview->id}";
            $multiple_sql = $db->query($multiple_qry);

            $multiple_data= array();
            if($multiple_sql->num_rows() > 0){
                $multiple_data = $multiple_sql->result_array();
            }
?>
            <tbody class="multiple_add">
                <?php if(count($multiple_data) > 0): 
                        foreach($multiple_data as $index =>$value):
                            if( $index == (count($multiple_data)-1) ){
                                $astyle = '';
                            }else{
                                $astyle = 'style="display:none"';
                            }
                ?>
                <tr class="multiple-itemrow">
                    <td width="50%" class="active multiple_item" style="font-size:13px !important;">                
                        <span class="pull-right small text-muted delete-item" >
                           <a class="pull-right small text-muted" href="#" onclick="delete_item($(this).closest('tr'))">Delete</a>
                        </span>

                        <input id="maxlength_defaultconfig" class="form-control" type="text" 
                        name="recruitment_interview_details[<?php echo $key['key_code']?>][key_name][]"
                        value="<?php echo $value['key_name'] ?>">
                        <br class="add-item" <?php echo $astyle ?> >
                        <span class="add-item" <?php echo $astyle ?>>
                            <button href="#" data-toggle="modal" class="btn btn-success btn-xs" type="button" onclick="add_item('<?php echo $data['header_text'] ?>', '<?php echo $key['key_code']?>')" >Add <?php echo $data['header_text'] ?></button>
                        </span>
                    </td>
                    <td width="50%">
                        <textarea class="form-control" rows="3" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value][]"><?php echo $value['key_value'] ?></textarea>
                    </td>
                    <?php include 'other_remarks.php'; ?>
                </tr>
                <?php endforeach;
                    else: 
                ?>
                <tr>
                    <td width="50%" class="active multiple_item" style="font-size:13px !important;">                
                        <span class="pull-right small text-muted delete-item" style="display:none">
                           <a class="pull-right small text-muted" href="#" onclick="delete_item($(this).closest('tr'))">Delete</a>
                        </span>

                        <input id="maxlength_defaultconfig" class="form-control" type="text" 
                        name="recruitment_interview_details[<?php echo $key['key_code']?>][key_name][]"
                        value="">
                        <br class="add-item">
                        <span class="add-item">
                            <button href="#" data-toggle="modal" class="btn btn-success btn-xs" type="button" onclick="add_item('<?php echo $data['header_text'] ?>', '<?php echo $key['key_code']?>')" >Add <?php echo $data['header_text'] ?></button>
                        </span>
                    </td>
                    <td width="50%"><textarea class="form-control" rows="3" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value][]"></textarea>
                    </td>

                    <?php include 'other_remarks.php'; ?>
                </tr>
                <?php endif; ?>
            </tbody>
    <?php   
            break;
            case 2://textarea
            $multiple_qry = "SELECT * FROM ww_recruitment_interview_details 
                            WHERE `key` = '{$key['key_code']}' AND interview_id = {$interview->id}";
            $multiple_sql = $db->query($multiple_qry);
            if($multiple_sql->num_rows() > 0){
                $value = $multiple_sql->row_array();
            }
    ?>
            <tr>
                <td width="20%" class="active" style="font-size:13px !important;">
                    <?php if($key['show_key_label']) echo $key['key_label']; ?>
                </td>
                <td width="40%">
                    <textarea class="form-control" rows="3" name="recruitment_interview_details[<?php echo $key['key_code']?>][key_value]"><?php echo $value['key_value'] ?></textarea>
                </td>
                <?php include 'other_remarks.php'; ?>
            </tr>
    <?php 
            break;
            case 5://interview_remarks   
            $multiple_qry = "SELECT * FROM ww_recruitment_interview_details 
                            WHERE `key` = '{$key['key_code']}' AND interview_id = {$interview->id}";
            $multiple_sql = $db->query($multiple_qry);
            if($multiple_sql->num_rows() > 0){
                $value = $multiple_sql->row_array();
            }                   
                $option = $this->db->get_where('recruitment_interview_remarks', array('deleted' => 0));
                $options = array('' => 'Select...');
                foreach ($option->result() as $opt) {
                    $options[$opt->remarks] = $opt->remarks;
                }
    ?>

            <tr>
                <td width="20%" class="active" style="font-size:13px !important;">
                    <?php if($key['show_key_label']) echo $key['key_label']; ?>
                </td>
                <td width="40%">
                <?php  
                echo form_dropdown('recruitment_interview_details['.$key['key_code'].'][key_value]',$options, $value['key_value'], 'class="form-control select2me" data-placeholder="Select..."');
                ?>
                </td>
                <?php include 'other_remarks.php'; ?>
            </tr>
    <?php
            break;
            case 6://Mutltiple Interview Remarks
            $multiple_qry = "SELECT * FROM ww_recruitment_interview_details 
                            WHERE `key` = '{$key['key_code']}' AND interview_id = {$interview->id}";
            $multiple_sql = $db->query($multiple_qry);

            $multiple_data= array();
            if($multiple_sql->num_rows() > 0){
                $multiple_data = $multiple_sql->result_array();
            }
?>
            <tbody class="multiple_add">
                <?php if(count($multiple_data) > 0): 
                        foreach($multiple_data as $index =>$value):
                            if( $index == (count($multiple_data)-1) ){
                                $astyle = '';
                            }else{
                                $astyle = 'style="display:none"';
                            }
                ?>
                <tr class="multiple-itemrow">
                    <td width="50%" class="active multiple_item" style="font-size:13px !important;">                
                        <span class="pull-right small text-muted delete-item" >
                           <a class="pull-right small text-muted" href="#" onclick="delete_item($(this).closest('tr'))">Delete</a>
                        </span>

                        <input id="maxlength_defaultconfig" class="form-control" type="text" 
                        name="recruitment_interview_details[<?php echo $key['key_code']?>][key_name][]"
                        value="<?php echo $value['key_name'] ?>">
                        <br class="add-item" <?php echo $astyle ?> >
                        <span class="add-item" <?php echo $astyle ?>>
                            <button href="#" data-toggle="modal" class="btn btn-success btn-xs" type="button" onclick="add_item_remarks('<?php echo $data['header_text'] ?>', '<?php echo $key['key_code']?>')" >Add <?php echo $data['header_text'] ?></button>
                        </span>
                    </td>
                    <td width="50%">
                    <?php 
                        $option = $this->db->get_where('recruitment_interview_remarks', array('deleted' => 0));
                        $options = array('' => 'Select...');
                        foreach ($option->result() as $opt) {
                            $options[$opt->remarks] = $opt->remarks;
                        }
                        echo form_dropdown('recruitment_interview_details['.$key['key_code'].'][key_value]',$options, $value['key_value'], 'class="form-control select2me" data-placeholder="Select..."');
                    ?>
                    </td>
                    <?php include 'other_remarks.php'; ?>
                </tr>
                <?php endforeach;
                    else: 
                ?>
                <tr>
                    <td width="50%" class="active multiple_item" style="font-size:13px !important;">                
                        <span class="pull-right small text-muted delete-item" style="display:none">
                           <a class="pull-right small text-muted" href="#" onclick="delete_item($(this).closest('tr'))">Delete</a>
                        </span>

                        <input id="maxlength_defaultconfig" class="form-control" type="text" 
                        name="recruitment_interview_details[<?php echo $key['key_code']?>][key_name][]"
                        value="">
                        <br class="add-item">
                        <span class="add-item">
                            <button href="#" data-toggle="modal" class="btn btn-success btn-xs" type="button" onclick="add_item_remarks('<?php echo $data['header_text'] ?>', '<?php echo $key['key_code']?>')" >Add <?php echo $data['header_text'] ?></button>
                        </span>
                    </td>
                    <td width="50%">
                    <?php 
                        $option = $this->db->get_where('recruitment_interview_remarks', array('deleted' => 0));
                        $options = array('' => 'Select...');
                        foreach ($option->result() as $opt) {
                            $options[$opt->remarks] = $opt->remarks;
                        }
                        echo form_dropdown('recruitment_interview_details['.$key['key_code'].'][key_value]',$options, $value['key_value'], 'class="form-control select2me" data-placeholder="Select..."');
                    ?>
                    </td>

                    <?php include 'other_remarks.php'; ?>
                </tr>
                <?php endif; ?>
            </tbody>
    <?php   
            break;
        }

    ?>
    </tr>
<?php            
        endforeach;     
?>
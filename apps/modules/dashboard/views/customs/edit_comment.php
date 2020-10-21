
<?php

    $image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
    $image_dir_full  = FCPATH.'uploads/users/';
    $user_data = new stdClass();

    $user_qry = "SELECT 
                `up`.`user_id`, 
                `up`.`display_name` AS `user_name`, 
                `upos`.`position`,
                `up`.`company`,
                `up`.`photo`,
                `u`.`email` 
            FROM 
                `users_profile` `up` 
                LEFT JOIN `users_position` `upos` ON `up`.`position_id` = `upos`.`position_id`
                LEFT JOIN `users` `u` ON `u`.`user_id` = `up`.`user_id`

            WHERE 
                `up`.`user_id` = '$user_id' 
            
            LIMIT 1";

    $user_result = $this->db->query($user_qry);

    if ($user_result->num_rows() > 0){
        $user_data   = $user_result->row();
        $user_avatar = basename(base_url( $user_data->photo ));
        // determine image/photo
        $file_name_thumbnail = $image_dir_thumb . $user_avatar;
        $file_name_full = $image_dir_full . $user_avatar;


        if(file_exists(urldecode($file_name_thumbnail))){
			$file_name_full = base_url() . "uploads/users/" . $user_avatar;
            $user_avatar = base_url() . "uploads/users/thumbnail/" . $user_avatar;
        }
        else if(file_exists(urldecode($file_name_full))){
            $user_avatar = base_url() . "uploads/users/" . $user_avatar;
			$file_name_full = $user_avatar;
        }
        else{
            $user_avatar = base_url() . "uploads/users/avatar.png";
			$file_name_full = $user_avatar;
        }
    }

    $user_contacts = array();

    // $user_qry2 = "SELECT `ucc`.`contacts_id`, `ucc`.`contact_type`, `ucc`.`contact_no`
    //         FROM (`ww_users_company_contact` `ucc` JOIN `users_profile` `up`)
    //         WHERE `ucc`.`company_id` = `up`.`company_id`
    //         AND `up`.`user_id` = '$user_id'";

    // $user_result2 = $this->db->query($user_qry2);
    
    // if ($user_result2->num_rows() > 0){

    //     foreach( $user_result2->result_array() as $user_contact ){

    //         $user_contacts[] = $user_contact;
    //     }
    // }
    // $comment_count++;
?>
<img class="avatar img-responsive user_preview popovers" alt="" 
        src="<?php echo $user_avatar; ?>" 
        style="border-radius:5% !important;" />

    <div class="message"> 
        <span class="user_popover">
        <small>
            <a 
            class="user_preview popovers" 
            data-trigger="hover" 
            data-placement="top"
            data-html="true" 
            data-content="
                <div class='clearfix'>
                    <div class='pull-left' style='padding:0; width: 120px;'>
                        <img class='img-responsive' alt='' src='<?php echo $file_name_full; ?>' style='border-radius:2% !important; height:100px; width: 100px;' />
                    </div>
                    <div class='pull-right' style='padding:0; width: 200px;'>
                        <p style='margin-bottom:5px;'><strong><?php echo $user_data->position; ?></strong></p>
                        <p style='margin-bottom:10px;'><?php echo $user_data->company; ?></p>

                        <?php

                            if(count($user_contacts)):

                                for( $j=0; $j < count($user_contacts); $j++ ): 

                                    switch ($user_contacts[$j]['contact_type']):

                                        case 'Phone':
                                            $fa = 'phone';
                                            break;
                                        
                                        case 'Mobile':
                                            $fa = 'mobile';
                                            break;

                                        case 'Fax':
                                            $fa = 'fax';
                                            break;

                                        default:
                                            $fa = 'phone';
                                            break;
                                    
                                    endswitch;
                        ?>
                                    <p class='text-muted small' style='margin-bottom:2px !important;'>
                                        <i class='fa fa-<?php echo $fa; ?>'></i> &nbsp;
                                        <?php echo $user_contacts[$j]['contact_no']; ?>
                                    </p>
                        <?php
                                endfor;
                            endif;
                        ?>

                        <p class='text-muted small' style='margin-bottom:2px !important;'><i class='fa fa-envelope'></i> <?php echo $user_data->email;  ?><p>
                    </div>
                </div>"
            data-original-title = "<?php echo $user_data->user_name ?>" >
            <?php echo $user_data->user_name ?>
            </a>   
        </small>                                 
        </span>
<br>
    <span>
<textarea class="form-control comment_box" 
rows="1"
data-min-rows='1'
data-feeds-id="<?php echo $id; ?>"
data-feeds-userid="<?php echo $fuserid; ?>"
data-comment-id="<?php echo $comment_feeds_id; ?>"
data-comment-count=""
id="comment_box_<?php echo $id; ?>"
style="margin:0px;resize:none;overflow:hidden"><?php echo $comment; ?></textarea>
    </span>
    </div>
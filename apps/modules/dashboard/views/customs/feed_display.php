<?php  
    
    $image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
    $image_dir_full  = FCPATH.'uploads/users/';

    foreach( $feeds as $feed ) : 

        $avatar = basename(base_url( $feed->avatar ));

        // determine image/photo

        $file_name_thumbnail = $image_dir_thumb . $avatar;
        $file_name_full = $image_dir_full . $avatar;


        if(file_exists(urldecode($file_name_thumbnail))){
			$file_name_full = base_url() . "uploads/users/" . $avatar;
            $avatar = base_url() . "uploads/users/thumbnail/" . $avatar;
        }
        else if(file_exists(urldecode($file_name_full))){
            $avatar = base_url() . "uploads/users/" . $avatar;
			$file_name_full = $avatar;
        }
        else{
            $avatar = base_url() . "uploads/users/avatar.png";
			$file_name_full = $avatar;
        }
        
        $feeds_bg = '';
        $allow_comment = 1;
        if($feed->message_type == 'Announcement' OR $feed->message_type == 'Company News'){
            $feeds_bg = '#fefacf';

            $this->db->select('memo_id');
            $result = $this->db->get_where('memo', array('memo_id' => $feed->record_id, 'comments' => 0), 1);
            if ($result->num_rows() > 0)
                $allow_comment = 0;

        }else if($feed->message_type == 'Feedback') {
            $feeds_bg = '#FCF8E3';
        }
        
?>

                <li class="<?php echo $current_user === $feed->user_id ? 'in' : 'in'; ?> feed_content">
                    <img class="avatar img-responsive" alt="" src="<?php echo $avatar; ?>" />
                    <div class="message" style="<?php echo "background-color:{$feeds_bg}"?>">
                        <span class="arrow2"></span>
                        <span class="<?php echo $current_user === $feed->user_id ? 'datetime pull-right' : 'datetime pull-right'; ?>">
                            <?php if( $localize_time ){?>
                                <small id="feed-time-<?php echo $feed->id; ?>" class="text-muted"><?php echo localize_timeline( $feed->createdon_datetime, $user['timezone'] ); ?></small>
                            <?php }else{?>
                                <small id="feed-time-<?php echo $feed->id; ?>" class="text-muted"><?php echo $feed->createdon; ?></small>
                            <?php }?>
                            
                        </span>
                        
                        <?php

                            $data = new stdClass();
                            $data->user_id = 0;
                            $data->user_name = '';
                            $data->position = '';
                            $data->company = '';
                            $data->photo = '';
                            $data->email = '';

                            $qry = "SELECT 
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
                                        `up`.`user_id` = '$feed->user_id' 
                                    
                                    LIMIT 1";

                            $result = $this->db->query($qry);

                            if ($result->num_rows() > 0)
                                $data   = $result->row();

                            $contacts = array();
                        ?>

                        <?php if($current_user <> $feed->user_id) { ?>
                        <span class="user_popover">
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
                                            <p style='margin-bottom:5px;'><strong><?php echo $data->position;  ?></strong></p>
                                            <p style='margin-bottom:10px;'><?php echo $data->company;  ?></p>

                                            <?php

                                                if(count($contacts)): 

                                                    for( $i=0; $i < count($contacts); $i++ ):

                                                        switch ($contacts[$i]['contact_type']):

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
                                                            <?php echo $contacts[$i]['contact_no']; ?>
                                                        </p>
                                            <?php
                                                    endfor;
                                                endif;
                                            ?>
                                            <p class='text-muted small' style='margin-bottom:2px !important;'><i class='fa fa-envelope'></i> <?php echo $data->email;  ?><p>
                                        </div>
                                    </div>
                                "
                                data-original-title = "<?php echo $data->user_name; ?>"  
                                style="cursor:pointer;"><?php echo $feed->display_name; ?>
                            </a>
                            <?php if(isset($business_group) && sizeof($business_group) > 1){ ?>
                            <br/>
                            <span class="text-success small">
                                <span><?php echo $feed->group?></span><span>&nbsp;/&nbsp;</span>
                                <span><?php echo $feed->company?></span>
                            </span>
                            <?php } ?>
                        </span>
                        <?php } ?>
                        
                        <?php  if( empty($feed->recipients) && !empty($feed->message_type) ): ?>
                            <br/>
                            <span>
                                <small class="text-muted" ><?php echo $feed->message_type ?></small>
                            </span>
                        <?php endif;?>
                        <?php  /* if( !empty($feed->recipients) ): ?>
                            <br />
                            <span class="text-muted"><?php echo $feed->recipients; ?></span>
                        <?php endif; */ ?>
                        <br />
                        <br />
                        <span class="body" >
                        <!--  onclick='view_post(<?php echo $feed->id?>, $(this))' -->
							<div style="">
                            <?php if( !empty( $feed->uri ) && $feed->record_id > 0 ):
                                $notification_link = base_url().$feed->uri.'/detail/'.$feed->record_id;
                                echo '<a href="'.$notification_link.'" class="pop-uri">';
                                endif;
                            ?>
                            <?php
                                $doc = new DOMDocument();
                                @$doc->loadHTML($feed->feed_content);
                                $imgs = $doc->getElementsByTagName('img');
                                foreach($imgs as $img) {
                                    $src = $img->getAttribute('src');
                                    $src_pdf = $img->getAttribute('src');
                                    $href_src = str_replace('/dashboard/', '/', $img->getAttribute('src'));
                                    $thumbFormat = 'image';
                                    if ($img->getAttribute('class') == 'pdf') {
                                        $thumbFormat = 'pdf';
                                        $src_pdf = substr($src, 0, strrpos( $src, '.')).'.'.$thumbFormat;
                                        $src_pdf = str_replace('/dashboard/','/',$src_pdf);
                                    }

                                    if( file_exists( urldecode(FCPATH . $src) ) ){
                                        $img_src = $src;
                                        $src = base_url( $src );
                                        $src_pdf = base_url( $src_pdf );
                                        $href_src = base_url( $href_src );
                                        
                                        if($thumbFormat == 'pdf'){
                                            $img->setAttribute('width', '100%'); 

                                            $anchor = $doc->createElement("a", "");
                                            $anchor->setAttribute('onclick', "view_post({$feed->id})");
                                            $anchor->setAttribute('class', 'fancybox-buttonPDF');
                                            $anchor->setAttribute('href', $src_pdf);
                                            $img->parentNode->insertBefore($anchor, $img);
                                            $img->setAttribute( 'src', base_url($img->getAttribute('src')) );
                                            $anchor->appendChild($img);
                                        }else{
                                            $size = getimagesize( urldecode($img_src) );
                                            $img->setAttribute('src', $src);
                                            // if( $size[0] > 400 ){
                                                $h = $size[1] / $size[0] * 400;
                                                $img->setAttribute('width', '100%'); 
                                                //$img->setAttribute('height', $h.'px');

                                                $anchor = $doc->createElement("a", "");
                                                $anchor->setAttribute('onclick', "view_post({$feed->id})");
                                                $anchor->setAttribute('class', 'fancybox-buttond');
                                                $anchor->setAttribute('href', $href_src);
                                                $img->parentNode->insertBefore($anchor, $img);
                                                $img->setAttribute('src', $src);
                                                $anchor->appendChild($img);
                                            // }
                                        }
                                    }
                                    else{
                                        $span = $doc->createElement("span", lang('dashboard.no_image'));
                                        $img->parentNode->insertBefore($span, $img);
                                        $img->parentNode->removeChild($img);
                                    }
                                }
                            ?>

                            <?php echo $doc->saveHTML($doc->documentElement) ?>
                             <?php if( !empty( $feed->uri ) && $feed->record_id > 0 ):
                                echo '</a>';
                                endif;
                            ?>
							</div>
                        </span>

                        <!-- like post -->
                        <?php 
                        if( $feed->message_type <> 'Time Record') { 
                        if( $feed->like ) { ?>
                            <span class="btn btn-sm btn-success margin-bottom-15" onclick="feed_like(<?php echo $feed->id?>, $(this))">
                        <?php } else {?>
                            <span class="btn btn-sm btn-default margin-bottom-15"  onclick="feed_like(<?php echo $feed->id?>, $(this))">
                        <?php } ?>
                                <i class="fa fa-hand-o-right"></i><?php echo lang('dashboard.like') ?>
                            </span>
                        <?php } ?>
                    </div>

                    <div class="message portlet-body comments-<?php echo $feed->id?> 
                    <?php if(in_array($feed->message_type, array('Time Record')) ) echo ' hidden '; ?> "> 
                    <?php
                        echo $mod->feed_like_str($feed->id);

                         

                        $comments = array();
                        $select_comments = "SELECT *
                                            FROM ww_system_feeds_comments 
                                            WHERE id = {$feed->id}
                                            AND deleted = 0
                                            ORDER BY feeds_comment_id ASC";
                        $comments_result = $this->db->query($select_comments);
                        
                        if ($comments_result->num_rows() > 0){

                            foreach( $comments_result->result_array() as $comment ){

                                $comments[] = $comment;
                            }
                        }

                        if( $allow_comment == 1 ) {

                        ?>
                            <ul id="comment-list-<?php echo $feed->id; ?>">
                                <?php
                                $count_comment = 0;
                                $hide_count = (count($comments)>4) ? count($comments) - 5 : 5;
                                $counted_comments = count($comments);
                                if (count($comments) >0 ){
                                    foreach ($comments as $comment){

                                        $user_comment_data = new stdClass();
                                        $user_comment_data->user_id = 0;
                                        $user_comment_data->user_name = '';
                                        $user_comment_data->position = '';
                                        $user_comment_data->company = '';
                                        $user_comment_data->photo = '';
                                        $user_comment_data->email = '';

                                        $user_comment_qry = "SELECT 
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
                                                    `up`.`user_id` = '{$comment['user_id']}' 
                                                
                                                LIMIT 1";

                                        $user_comment_result = $this->db->query($user_comment_qry);

                                        if ($user_comment_result->num_rows() > 0){
                                            $user_comment_data  = $user_comment_result->row();
                                            $user_comment_avatar = basename(base_url( $user_comment_data->photo ));
                                            // determine image/photo
                                            $file_name_thumbnail = $image_dir_thumb . $user_comment_avatar;
                                            $file_name_full = $image_dir_full . $user_comment_avatar;


                                            if(file_exists(urldecode($file_name_thumbnail))){
												$file_name_full = base_url() . "uploads/users/" . $user_comment_avatar;
                                                $user_comment_avatar = base_url() . "uploads/users/thumbnail/" . $user_comment_avatar;
                                            }
                                            else if(file_exists(urldecode($file_name_full))){
                                                $user_comment_avatar = base_url() . "uploads/users/" . $user_comment_avatar;
												$file_name_full = $user_comment_avatar;
                                            }
                                            else{
                                                $user_comment_avatar = base_url() . "uploads/users/avatar.png";
												$file_name_full = $user_comment_avatar;
                                            }
                                        }

                                        $user_comment_contacts = array();

                                    if( (($counted_comments) % 5 == 0 || $count_comment == 0) && count($comments) > 5 ){
                                ?>
                                    <li class=" comment-toggler-<?php echo $count_comment; ?> <?php if( $count_comment < $hide_count) echo 'hidden' ?>" style="margin: 0px 0px 1px 0px;padding: 1px 0px;">
                                        <span class="btn btn-xs blue" onclick="comments_showmore(<?php echo $count_comment+1; ?>, '', <?php echo $feed->id; ?>)"> <?php echo lang('dashboard.previous_comment') ?> <i class="fa fa-arrow-circle-o-down"></i> </span>
                                    </li>
                                <?php
                                    }
                                    ?>
                                <li class="comment-list-item-<?php echo $comment['feeds_comment_id']; ?> comment-toggle-<?php echo $count_comment; ?> <?php if( $count_comment < $hide_count && count($comments) > 5 ) echo 'hidden'; ?>" 
                                    style="padding:none !important;">
                                    <img class="avatar img-responsive user_preview popovers" alt="" src="<?php echo $user_comment_avatar; ?>" 
                                        style="border-radius:5% !important;" />
                            
                                    <div class="message com"> 
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
                                                        <p style='margin-bottom:5px;'><strong><?php echo $user_comment_data->position; ?></strong></p>
                                                        <p style='margin-bottom:10px;'><?php echo $user_comment_data->company; ?></p>

                                                        <?php

                                                            if(count($user_comment_contacts)):

                                                                for( $j=0; $j < count($user_comment_contacts); $j++ ): 

                                                                    switch ($user_comment_contacts[$j]['contact_type']):

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
                                                                        <?php echo $user_comment_contacts[$j]['contact_no']; ?>
                                                                    </p>
                                                        <?php
                                                                endfor;
                                                            endif;
                                                        ?>

                                                        <p class='text-muted small' style='margin-bottom:2px !important;'><i class='fa fa-envelope'></i> <?php echo $user_comment_data->email;  ?><p>
                                                    </div>
                                                </div>"
                                            data-original-title = "<?php echo $user_comment_data->user_name ?>" >
                                            <?php echo $user_comment_data->user_name ?>
                                            </a>   
                                        </small>                                 
                                        </span>
                                <span class="<?php echo $current_user === $feed->user_id ? 'datetime pull-right' : 'datetime pull-right'; ?>">
                                    <?php 
                                        if ($current_user == $comment['user_id']){
                                    ?>
                                    <div class="btn-group <?php echo $current_user === $feed->user_id ? 'datetime pull-right' : 'datetime pull-right'; ?>">
                                        <a data-toggle="dropdown" data-close-others="true" href="#" class="btn btn-xs"><i class="fa fa-gear"></i></a>
                                        <ul class="dropdown-menu <?php echo $current_user === $feed->user_id ? 'pull-left' : 'pull-right'; ?>">
                                            <li><a class="pull-left edit-comment" 
                                                data-comment-commentid="<?php echo $comment['feeds_comment_id']; ?>"
                                                data-comment-feedsid="<?php echo $comment['id']; ?>"
                                                data-comment-userid="<?php echo $comment['user_id']; ?>"
                                                data-comment-comment="<?php echo $comment['comment']; ?>"
                                                data-comment-fuserid="<?php echo $feed->user_id; ?>">
                                                <i class="fa fa-pencil"></i> <?php echo lang('dashboard.comment_edit') ?></a></li>
                                            <li><a href="javascript: delete_comment(<?php echo $comment['feeds_comment_id']; ?>)" class="pull-left"><i class="fa fa-trash-o"></i> <?php echo lang('dashboard.comment_delete') ?></a></li>            
                                        </ul>
                                    </div>
                                    <?php
                                        }elseif($feed->user_id == $current_user){
                                    ?>
                                    <div class="btn-group <?php echo $current_user === $feed->user_id ? 'datetime pull-right' : 'datetime pull-right'; ?>">
                                        <a href="javascript: delete_comment(<?php echo $comment['feeds_comment_id']; ?>)" class="btn btn-sm pull-right"><i class="close"></i></a>
                                    </div>
                                    <?php 
                                        }
                                    ?>
                                    <small id="feed-time-<?php echo $comment['feeds_comment_id']; ?>" class="text-muted"><?php echo date('F d \a\t g:iA', strtotime($comment['createdon'])); ?></small>
                                </span>
                                <br>
                                    <span id="editable-comment-<?php echo $comment['feeds_comment_id']; ?>">
                                        <?php echo $comment['comment']; ?>
                                    </span>
                                    </div>
                                </li>
                                <?php   
                                $count_comment++;
                                $counted_comments--;
                                    }
                                }
                                    $user_data = new stdClass();
                                    $user_data->user_id = 0;
                                    $user_data->user_name = '';
                                    $user_data->position = '';
                                    $user_data->company = '';
                                    $user_data->photo = '';
                                    $user_data->email = '';

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
                                                `up`.`user_id` = '$current_user' 
                                            
                                            LIMIT 1";

                                    $user_result = $this->db->query($user_qry);

                                    if ($user_result->num_rows() > 0){
                                        $user_data   = $user_result->row();
                                        $user_avatar = basename(base_url( $user_data->photo ));
                                        // determine image/photo
                                        $file_name_thumbnail = $image_dir_thumb . $user_avatar;
                                        $file_name_full = $image_dir_full . $user_avatar;


                                        if(file_exists(urldecode($file_name_thumbnail))){
                                            $user_avatar = base_url() . "uploads/users/thumbnail/" . $user_avatar;
                                        }
                                        else if(file_exists(urldecode($file_name_full))){
                                            $user_avatar = base_url() . "uploads/users/" . $user_avatar;
                                        }
                                        else{
                                            $user_avatar = base_url() . "uploads/users/avatar.png";
                                        }
                                    }

                                    $user_contacts = array();

                                    $user_qry2 = "SELECT `ucc`.`contacts_id`, `ucc`.`contact_type`, `ucc`.`contact_no`
                                            FROM (`ww_users_company_contact` `ucc` JOIN `users_profile` `up`)
                                            WHERE `ucc`.`company_id` = `up`.`company_id`
                                            AND `up`.`user_id` = '$current_user'";

                                    $user_result2 = $this->db->query($user_qry2);
                                    
                                    if ($user_result2->num_rows() > 0){

                                        foreach( $user_result2->result_array() as $user_contact ){

                                            $user_contacts[] = $user_contact;
                                        }
                                    }
                                ?>
                                <li class="comment-list-item-" style="padding:none !important;" id="insert_comment-<?php echo $feed->id; ?>">
                                    <img class="avatar img-responsive user_preview popovers" alt="" src="<?php echo $user_avatar; ?>" 
                                        style="border-radius:5% !important;" 
                                        />
                                    <div class="message">
                                    <span>
                                        <textarea class="form-control comment_box" 
                                        rows="1"
                                        data-min-rows='1'
                                        data-feeds-id="<?php echo $feed->id; ?>"
                                        data-feeds-userid="<?php echo $feed->user_id; ?>"
                                        data-comment-id=""
                                        data-comment-count="<?php echo count($comments); ?>"
                                        placeholder="<?php echo lang('dashboard.write_comment') ?>" 
                                        id="comment_box_<?php echo $feed->id; ?>"
                                        style="margin:0px;resize:none;overflow:hidden"></textarea>

                                    </span>
                                    </div>
                                </li>
                            </ul>

                        <?php } ?>

                    </div>
                </li>

<?php
    endforeach;
?>

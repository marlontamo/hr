<?php
  foreach( $feeds as $feed ) : 
    $photo = get_photo( $feed->avatar );
    $feeds_bg = '';

    if($feed->message_type == 'Announcement' OR $feed->message_type == 'Company News'){
        $feeds_bg = '#fefacf';
    }else if($feed->message_type == 'Feedback') {
        $feeds_bg = '#FCF8E3';
    } ?>
    <li class="<?php echo $current_user === $feed->user_id ? 'out' : 'in'; ?> feed_content">
        <img class="avatar img-responsive" alt="" src="<?php echo $photo['avatar']; ?>" />
        <div class="message" style="<?php echo "background-color:{$feeds_bg}"?>">
            <span class="arrow2"></span>
            <span class="<?php echo $current_user === $feed->user_id ? 'datetime' : 'datetime pull-right'; ?>">
                <?php if( $localize_time ){?>
                    <small id="feed-time-<?php echo $feed->id; ?>" class="text-muted"><?php echo localize_timeline( $feed->createdon_datetime, $user['timezone'] ); ?></small>
                <?php }else{?>
                    <small id="feed-time-<?php echo $feed->id; ?>" class="text-muted"><?php echo $feed->createdon; ?></small>
                <?php }?> 
            </span><?php
            $data = new stdClass();

            $qry = "SELECT `up`.`user_id`, `up`.`display_name` AS `user_name`, `upos`.`position`,`up`.`company`,`up`.`photo`,`u`.`email` 
            FROM `users_profile` `up` 
            LEFT JOIN `users_position` `upos` ON `up`.`position_id` = `upos`.`position_id`
            LEFT JOIN `users` `u` ON `u`.`user_id` = `up`.`user_id`
            WHERE `up`.`user_id` = '$feed->user_id' 
            LIMIT 1";

            $result = $this->db->query($qry);

            if ($result->num_rows() > 0)
                $data   = $result->row();
            
            if($current_user <> $feed->user_id) { ?>
                <span class="user_popover">
                    <a  class="user_preview popovers" data-trigger="hover" data-placement="top" data-html="true" data-content="
                        <div class='clearfix'>
                            <div class='pull-left' style='padding:0; width: 120px;'>
                                <img class='img-responsive' alt='' src='<?php echo $photo['full']; ?>' style='border-radius:2% !important; height:100px; width: 100px;' />
                            </div>
                            <div class='pull-right' style='padding:0; width: 200px;'>
                                <p style='margin-bottom:5px;'><strong><?php echo $data->position;  ?></strong></p>
                                <p style='margin-bottom:10px;'><?php echo $data->company;  ?></p>

                               
                                <p class='text-muted small' style='margin-bottom:2px !important;'><i class='fa fa-envelope'></i> <?php echo $data->email;  ?><p>
                            </div>
                        </div>" data-original-title = "<?php echo $data->user_name; ?>" style="cursor:pointer;"><?php echo $feed->display_name; ?>
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

            <?php  if( !empty($feed->recipients) ): ?>
                <br />
                <span class="text-muted"><?php echo $feed->recipients; ?></span>
            <?php endif;?>

            <br />
            <br />
            <span class="body mix-grid">
    			<div style=""><?php
                    if( !empty( $feed->uri ) && $feed->record_id > 0 ):
                        $notification_link = base_url().$feed->uri.'/detail/'.$feed->record_id;
                        echo '<a href="'.$notification_link.'" class="pop-uri">';
                    endif;

                    $doc = new DOMDocument();
                    $doc->loadHTML($feed->feed_content);
                    $imgs = $doc->getElementsByTagName('img');
                    foreach($imgs as $img) {
                        $src = $img->getAttribute('src');
                        $href_src = str_replace('/dashboard/', '/', $img->getAttribute('src'));
                        $thumbFormat = 'image';
                        if ($img->getAttribute('class') == 'pdf') {
                            $thumbFormat = 'pdf';
                            $src = substr($src, 0, strrpos( $src, '.')).'.'.$thumbFormat;
                        }

                        if( file_exists( urldecode(FCPATH . $src) ) ){
                            $src = base_url( $src );
                            $href_src = base_url( $href_src );
                            
                            if($thumbFormat == 'pdf'){
                                $img->setAttribute('width', '100%'); 

                                $anchor = $doc->createElement("a", "");
                                $anchor->setAttribute('class', 'fancybox-buttonPDF');
                                $anchor->setAttribute('href', $href_src);
                                $img->parentNode->insertBefore($anchor, $img);
                                $img->setAttribute( 'src', base_url($img->getAttribute('src')) );
                                $anchor->appendChild($img);
                            }else{
                                $size = getimagesize( urldecode($src) );
                                $img->setAttribute('src', $src);
                                $h = $size[1] / $size[0] * 400;
                                $img->setAttribute('width', '100%'); 
                                
                                $anchor = $doc->createElement("a", "");
                                $anchor->setAttribute('class', 'fancybox-buttond');
                                $anchor->setAttribute('href', $href_src);
                                $img->parentNode->insertBefore($anchor, $img);
                                $img->setAttribute('src', $src);
                                $anchor->appendChild($img);
                            }
                        }
                        else{
                            $span = $doc->createElement("span", lang('dashboard.no_image'));
                            $img->parentNode->insertBefore($span, $img);
                            $img->parentNode->removeChild($img);
                        }
                    }
                    echo $doc->saveHTML($doc->documentElement);
                    if( !empty( $feed->uri ) && $feed->record_id > 0 ):
                        echo '</a>';
                    endif; ?>
    			</div>
            </span>
            
        </div>

        <div class="text-muted small margin-top-10"><?php
            if( $feed->message_type <> 'Time Record'): ?>
                <span class="padding-5 like-str-<?php echo $feed->id?>"><?php echo $mod->feed_like_str( $feed->id, true )?></span>
            <?php endif;?>
            <?php $comments = $mod->get_feed_comments( $feed->id ); ?>
            <span class="padding-5 feed-comments-<?php echo $feed->id?>"><?php if( sizeof($comments) > 0 ) echo sizeof( $comments ) .' Comments'?> </span>
        </div>
        
        <div class="btn-group btn-group-justified border-top-hr"><?php 
            if( $feed->message_type <> 'Time Record') { 
                if( $feed->like ) { ?>
                    <a class="btn btn-sm btn-success no-border" onclick="feed_like(<?php echo $feed->id?>, $(this))"><i class="fa fa-thumbs-up"></i> <small>Like</small></a>
                <?php } else {?>
                    <a class="btn btn-sm btn-default no-border" onclick="feed_like(<?php echo $feed->id?>, $(this))"><i class="fa fa-thumbs-up"></i> <small>Like</small></a>
                <?php } ?>
            <?php } ?>
            <a class="btn btn-sm btn-default no-border" id="view-comments" href="javascript:view_feed_comments(<?php echo $feed->id?>)"><i class="fa fa-comments-o"></i> <small>Comment</small></a>
        </div>
    </li><?php
endforeach; ?>

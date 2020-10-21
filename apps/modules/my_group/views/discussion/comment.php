
<?php
    $photo = get_photo( $comment->photo );
?>
<li class="comment-list-item-<?php echo $comment->comment_id; ?>" style="padding:none !important;">
    <img class="avatar img-responsive user_preview popovers" alt="" src="<?php echo $photo['avatar']; ?>" style="border-radius:5% !important;" />
    <div class="message com"> 
        <span class="user_popover <?php echo $comment->created_by !== $this->user->user_id ? 'pull-left' : 'pull-right'; ?>">
            <small>
                <a class="user_preview popovers" data-trigger="hover" data-placement="top" data-html="true" style="cursor:pointer;"
                data-content="
                    <div class='clearfix'>
                        <div class='pull-left' style='padding:0; width: 120px;'>
                            <img class='img-responsive' alt='' src='<?php echo $comment->full_name; ?>' style='border-radius:2% !important; height:100px; width: 100px;' />
                        </div>
                        <div class='pull-right' style='padding:0; width: 200px;'>
                            <p style='margin-bottom:5px;'><strong><?php echo $comment->position; ?></strong></p>
                            <p style='margin-bottom:10px;'><?php echo $comment->company; ?></p>
                            <p class='text-muted small' style='margin-bottom:2px !important;'><i class='fa fa-envelope'></i> <?php echo $comment->email;  ?><p>
                        </div>
                    </div>" 
                    data-original-title = "<?php echo $comment->full_name ?>" ><?php echo $comment->full_name ?>
                </a>   
            </small>                                 
        </span>
        <span class="datetime <?php echo $comment->created_by === $this->user->user_id ? 'pull-left' : 'pull-right'; ?>">
            <?php if( $comment->user_id == $this->user->user_id ):?>
                <div class="btn-group <?php echo $comment->created_by === $this->user->user_id ? 'pull-left' : 'pull-right'; ?>">
                    <a data-toggle="dropdown" data-close-others="true" href="#" class="btn btn-xs text-muted"><i class="fa fa-gear"></i></a>
                    <ul class="dropdown-menu <?php echo $comment->created_by === $this->user->user_id ? 'pull-left' : 'pull-right'; ?>>">
                        <li>
                            <a class="pull-left edit-comment" href="javascript:edit_comment(<?php echo $comment->comment_id; ?>)">
                            <i class="fa fa-pencil"></i> Edit</a></li>
                        <li>
                        <a href="javascript: delete_comment(<?php echo $comment->comment_id; ?>)" class="pull-left"><i class="fa fa-trash-o"></i> Delete</a></li>            
                    </ul>
                </div>
            <?php endif;?>
            <small id="feed-time-<?php echo $comment->comment_id; ?>" class="text-muted"><?php 
                if( $localize_time ){
                    echo localize_timeline( $comment->created_on, $user['timezone'] );
                }
                else{
                    echo $comment->timeline;
                }?>
            </small>
        </span>
        <br>
        <div>
            <?php echo $comment->comment; ?>
        </div>
    </div>
</li>
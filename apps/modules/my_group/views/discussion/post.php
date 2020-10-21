<?php  
    $photo = get_photo( $post->photo );
    $myphoto = get_photo( $user['photo'] );
?>
<li class="record <?php echo $this->user->user_id === $post->created_by ? 'out' : 'in'; ?>">
	<img class="avatar img-responsive" alt="" src="<?php echo $photo['avatar']; ?>" />
	<div class="message">
		<span class="arrow2"></span>
		<span class="datetime <?php if($this->user->user_id !== $post->created_by) echo 'pull-right';?>">
			<?php if( $localize_time ){?>
                <small class="text-muted"><?php echo localize_timeline( $post->created_on, $user['timezone'] ); ?></small>
            <?php }else{?>
                <small class="text-muted"><?php echo $post->timeline; ?></small>
            <?php }?>
        </span><?php
		$info = new stdClass();

		$qry = "SELECT `up`.`user_id`, 
		CONCAT(`up`.`firstname`, ' ', `up`.`middlename`, ' ', `up`.`lastname`) AS `user_name`, 
		`upos`.`position`,
		`up`.`company`,
		`up`.`photo`,
		`u`.`email` 
		FROM  `users_profile` `up` 
		LEFT JOIN `users_position` `upos` ON `up`.`position_id` = `upos`.`position_id`
		LEFT JOIN `users` `u` ON `u`.`user_id` = `up`.`user_id`
		WHERE  `up`.`user_id` = {$post->created_by} LIMIT 1";
		$emp = $this->db->query($qry);

		if ($emp->num_rows() == 1):
			$info   = $emp->row(); ?>
			<span class="user_popover <?php if($this->user->user_id === $post->created_by) echo 'pull-right';?>">
				<a  class="user_preview popovers" data-trigger="hover" data-placement="top" data-html="true" data-content="
					<div class='clearfix'>
	                    <div class='pull-left' style='padding:0; width: 120px;'>
	                        <img class='img-responsive' alt='' src='<?php echo $photo['full']; ?>' style='border-radius:2% !important; height:100px; width: 100px;' />
	                    </div>
	                    <div class='pull-right' style='padding:0; width: 200px;'>
	                        <p style='margin-bottom:5px;'><strong><?php echo $info->position;  ?></strong></p>
	                        <p style='margin-bottom:10px;'><?php echo $info->company;  ?></p>
	                        <p class='text-muted small' style='margin-bottom:2px !important;'><i class='fa fa-envelope'></i> <?php echo $info->email;  ?><p>
	                    </div>
	                </div>" data-original-title = "<?php echo $info->user_name; ?>" style="cursor:pointer;"><?php echo $post->full_name; ?>
				</a>
			</span><?php
		endif;?>
		<br />
		<span class="body"><?php echo $post->post?></span>
		<?php
		$pic = new stdClass();

		$qry_up = "SELECT `gpu`.`upload_id`
		FROM  `ww_groups_post_upload` `gpu` 
		LEFT JOIN `ww_groups_post` `gp` ON `gpu`.`post_id` = `gp`.`post_id`
		WHERE  `gp`.`post_id` = {$post->post_id}";
		$photo_upload = $this->db->query($qry_up);

		if ($photo_upload->num_rows() > 0):
			
			foreach($photo_upload->result_array() as $row){
				//$pic   = $photo_upload->row();
				//$filepath = base_url()."time/application/download_file/".$row['upload_id']; 


						$upload = $db->get_where('system_uploads', array('upload_id' => $row['upload_id']))->row();
						
						if($upload){
						$filepath = base_url().$upload->upload_path;
						$file = FCPATH . urldecode( $upload->upload_path );
						$thumbnail = base_url().'uploads/my_group/thumbnail/'.basename($filepath);
						if( file_exists( $file ) )
						{
						//$f_info = get_file_info( $file );
						$f_type = filetype( $file );
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$f_type = finfo_file($finfo, $file);
						if ($f_type == 'application/pdf') {
							

			?>
			<a href="<?php echo $filepath ?>" rel="gallery" class="fancybox-buttonPDF btn btn-default btn-sm" >
			<i class="fa fa-file-text-o"></i><?php echo basename($filepath); ?>
	        </a>
	        
	        <?php } else if ($f_type == 'image/jpeg') { ?>
	        <a href="<?php echo $filepath ?>" rel="gallery" class="fancybox-buttond" >
	        <img class="image" src="<?php echo $thumbnail ?>"></a>

		<?php
		 }
}
			}
		}
		endif;?>




		<br/><br /><?php
		if( $mod->liked( $post->post_id, $this->user->user_id ) ) { ?>
            <span class="btn btn-sm btn-success margin-bottom-15" onclick="like_post(<?php echo $post->post_id?>, $(this))">
        <?php } else {?>
            <span class="btn btn-sm btn-default margin-bottom-15"  onclick="like_post(<?php echo $post->post_id?>, $(this))">
        <?php } ?>
            <i class="fa fa-hand-o-right"></i> Like this post</span>
        <div class="message portlet-body comments-<?php echo $post->post_id?>"> <?php
        	echo $mod->post_like_str($post->post_id); ?>
        	<ul id="comment-list-<?php echo $post->post_id; ?>"><?php
        		$comments = $mod->get_comments( $post->post_id );
        		if ( $comments ){
                	foreach ($comments as $comment){
                		$this->load->view('discussion/comment', array('comment' => $comment));		
                	}
        		}?>

        		<li style="padding:none !important;" id="insert_comment-<?php echo $post->post_id; ?>">
	                <img class="avatar img-responsive user_preview popovers" alt="" src="<?php echo $myphoto['avatar']; ?>" style="border-radius:5% !important;" />
	                <div class="message">
		                <span>
		                    <textarea class="form-control comment_box" name="comment[<?php echo $post->post_id?>]" rows="1" post_id="<?php echo $post->post_id?>" placeholder="Add Comment" style="margin:0px;resize:none;overflow:hidden"></textarea>
		                </span>
	                </div>
	            </li>
        	</ul>
        </div>
	</div>
</li>
<?php
if( $birthdays ){
	for($i=0; $i<count($birthdays); $i++) :
        $photo = get_photo( $birthdays[$i]['photo'] ); ?>
        <li class="in2 toggle-<?php echo $i;?>">
            <img class="avatar img-responsive" alt="loading" src="<?php echo $photo['avatar']?>" style="border-radius:5% !important" />
            <div class="message2">
        		<span class="arrow2"></span><?php
                $data = new stdClass();
                $qry = "SELECT 
                `up`.`user_id`, 
                CONCAT(`up`.`firstname`, ' ', `up`.`middlename`, ' ', `up`.`lastname`) AS `user_name`, 
                `upos`.`position`,
                `up`.`company`,
                `up`.`photo`,
                `u`.`email` 
                FROM 
                `users_profile` `up` 
                LEFT JOIN `users_position` `upos` ON `up`.`position_id` = `upos`.`position_id`
                LEFT JOIN `users` `u` ON `u`.`user_id` = `up`.`user_id`

                WHERE 
                `up`.`user_id` = '" . $birthdays[$i]['celebrant_id'] . "' 
                LIMIT 1";

                $result = $db->query($qry);

                if ($result->num_rows() > 0)
                    $data   = $result->row(); ?>

        		<span class="user_popover"><a><?php echo $birthdays[$i]['display_name'] ?></a></span> <?php
                if(strtotime($birthdays[$i]['birth_date']) === strtotime(date('Y-m-d'))){ ?>
            		<a class="btn btn-sm green pull-right" href="javascript: get_celebrant_greetings(<?php echo $birthdays[$i]['celebrant_id'] ?>);">
            			<i class="fa fa-gift"></i>
            		</a> <?php
                }
                else{ ?>
            		<span class="datetime pull-right"><small class="text-muted"><?php echo $birthdays[$i]['time_line'] ?></small></span><?php
                } ?>

                <span class="body" id="pulsate-regular"><?php
                    echo $birthdays[$i]['position'];
                    if(isset($business_group) && sizeof($business_group) > 1){ ?>
                        <br/>
                        <span class="text-success small"><span><?php echo $birthdays[$i]['group'] ?></span><span>&nbsp;/&nbsp;</span><span><?php echo $birthdays[$i]['company'] ?></span></span><?php 
                    }?>
                </span>
            </div>
        </li><?php
    endfor;
}
else{ ?>
	<li class="in" style="margin: 0px 0px 1px 20px;padding: 1px 0px;"><?php echo lang('dashboard.bday_none') ?></li>				            	
<?php } ?>
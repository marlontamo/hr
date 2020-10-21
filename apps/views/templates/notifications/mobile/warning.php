<li class="in2" href="<?php echo $notification_link ?>">
    <div class="iconlist">
        <a class="btn btn-warning"><?php
            switch( $message_type )
            {
                case 'Birthday': ?>
                    <i class="fa fa-gift"></i> <?php
                    break;
                case 'Comment': ?>
                    <i class="fa fa-comment"></i> <?php
                    break;
                
                case 'Feedback': ?>
                    <i class="fa fa-edit"></i> <?php
                    break;
                case 'Partners': ?>
                    <i class="fa fa-user"></i> <?php
                    break;
                case 'Personnel': ?>
                    <i class="fa fa-group"></i> <?php
                    break;
                case 'System': ?>
                    <i class="fa fa-gears"></i> <?php
                    break;
                case 'Time Record': ?>
                    <i class="fa fa-clock-o"></i> <?php
                    break;
                case 'Company News':
                default: ?>
                    <i class="fa fa-bullhorn"></i> <?php
                    break;
            }?>
        </a>
    </div>
    <div class="datetime">
        <span class="small"><?php
        if( $localize_time ){
            echo localize_timeline( $createdon, $user['timezone'] );
        }
        else{
           echo $timeline;
        } ?></span>
    </div>
    <div style="min-height: 35px; padding-left: 55px"><?php echo $feed_content?></div>
</li>
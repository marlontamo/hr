<?php
    foreach( $observations as $observation ) {
?>
    <li class="in">
        <img src="<?php echo base_url().$observation->avatar ?>" alt="" class="avatar img-responsive">
        <div class="message">
            <span class="arrow"></span>
            <a class="name text-success" href="#"><?php echo $observation->display_name ?></a>
            <span class="datetime pull-right"><small class="text-muted"><?php echo $observation->createdon ?></small></span>
            <br/>
            <span class="text-muted small"><?php echo $department ?></span>
            <br/>
            <span class="body"><?php echo $observation->feed_content ?></span>
        </div>
    </li>
<?php
    }
?>
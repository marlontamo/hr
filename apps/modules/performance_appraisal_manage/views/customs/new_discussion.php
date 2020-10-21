<?php
    if($note['user_id'] == $note['created_by']){
        $time_position = 'left';
?>
    <li class="out">
<?php
    }else{
        $time_position = 'right';
?>
    <li class="in">
<?php
    }
?>
        <img src="<?php echo base_url().$note['photo'] ?>" alt="" class="avatar img-responsive">
        <div class="message">
            <span class="arrow"></span>
            <a class="name text-success" href="#"><?php echo $note['full_name'] ?></a>
            <span class="datetime pull-<?php echo $time_position ?>">
                <small class="text-muted"><?php echo $note['timeline'] ?></small></span>
            <br/>
            <span class="text-muted small"><?php echo $note['department'] ?></span>
            <br/>
            <span class="body"><?php echo $note['notes'] ?></span>
        </div>
    </li>
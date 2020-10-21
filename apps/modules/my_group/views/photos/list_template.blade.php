




<tr class="record">
    <!--<td width="1%">
        <span><i class="fa fa-picture-o"></i></span>
    </td>-->
    <?php  
        

        $filepath = base_url().$upload_path;
        $file = FCPATH . urldecode( $upload_path );
        $thumbnail = base_url().'uploads/my_group/thumbnail/'.basename($filepath);

        if( file_exists( $file ) )
        {
        //$f_info = get_file_info( $file );
        $f_type = filetype( $file );
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $f_type = finfo_file($finfo, $file);
        if ($f_type == 'image/jpeg') { 
    ?>
   

    <td width="1%">        
        <a href="<?php echo $filepath; ?>" class="fancybox-buttond">
            <img src="<?php echo $thumbnail ?>"
             class="pull-right" style="height: 48px;">
        </a>
    </td>

    <td>
    
        <span class="text-success">
            <a href="<?php echo $filepath ?>" class="fancybox-buttond">
            <?php echo basename($filepath); ?>
            </a>
        </span>
        <br/>
        <span class="text-muted small">
        <?php $date = new DateTime($modified_on);
echo $date->format('F d, Y')." at ".$date->format('h:i a') ; ?></span>
    </td>
        
    </td>
    <td width="1%" class="text-right">
       <a href="<?php echo $filepath ?>" class="btn btn-default btn-sm" download>
            <i class="fa fa-download"></i> Download
            </a>
    </td>
    <?php } 
    else{
        echo 'idk';
    }
    } ?>
</tr>


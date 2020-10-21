
<tr class="record" rel="1">
    <td>
        <span class="text-info">{{ $form }}</span><br>
        <span class="text-muted small"><?php echo date("F d, Y",strtotime($created_on)); ?></span>
    </td>
    <td><?php echo date("M-d",strtotime($date_from)); ?> <span class="text-muted small"><?php echo date("D",strtotime($date_from)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($date_from)); ?></span>
    </td>
    <td><?php echo date("M-d",strtotime($date_to)); ?> <span class="text-muted small"><?php echo date("D",strtotime($date_to)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($date_to)); ?></span>
    </td>
    
    <td>
        <?php 
            switch($form_status_id){ 
                case 1:
                    ?><span class="badge badge-danger">{{ $form_status }}</span><?php
                break;
                case 2:
                    ?><span class="badge badge-warning">{{ $form_status }}</span><?php
                break;
                case 3:
                    ?><span class="badge badge-warning">{{ $form_status }}</span><?php
                break;
                case 4:
                    ?><span class="badge badge-info">{{ $form_status }}</span><?php
                break;
                case 5:
                    ?><span class="badge badge-info">{{ $form_status }}</span><?php
                break;
                case 6:
                    ?><span class="badge badge-success">{{ $form_status }}</span><?php
                break;
                case 7:
                    ?><span class="badge badge-important">{{ $form_status }}</span><?php
                break;
                case 8:
                    ?><span class="badge badge-default">{{ $form_status }}</span><?php
                break;
         } ?>
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> View</a>
        </div>    	
        <!-- <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div> -->
    </td>
</tr>
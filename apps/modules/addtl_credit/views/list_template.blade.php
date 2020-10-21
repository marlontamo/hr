
<tr class="record" rel="1">
    <td><?php echo date("F d, Y",strtotime($date_from)); ?> 
        <!-- <span class="text-muted small"><?php echo date("D",strtotime($date_from)); ?></span><br> -->
        <!-- <span class="text-muted small"><?php echo date("Y",strtotime($date_from)); ?></span> -->
    </td>
    <td>
        <span class="text-success">{{ $display_name }}</span>
    </td>
    <td>
        {{ $reason }}</span>
    </td>
    <td>
        {{ $credit }}</span>
    </td>
    <td><?php echo date("M-d",strtotime($expiration_date)); ?> <span class="text-muted small"><?php echo date("D",strtotime($expiration_date)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($expiration_date)); ?></span>
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
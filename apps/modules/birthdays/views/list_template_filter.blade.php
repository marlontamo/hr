<span id="goto" class="event-block label label-info list-filter" filter_by="year" filter_value="<?php echo $prev_year?>"><?php echo $prev_year?></span>
<span id="goto" class="event-block label label-info list-filter" filter_by="year" filter_value="<?php echo $cur_year?>"><?php echo $cur_year?></span>
<?php for($i=1; $i<=12; $i++){ ?>
	<span id="goto" class="event-block label list-filter <?php echo (date('n') == $i ? 'label-success' : 'label-default') ?>" filter_by="month" filter_value="<?php echo $year?>-<?php echo sprintf('%02d', $i);?>"><?php echo int_to_month($i)?></span> <?php
}?>
<span id="goto" class="event-block label list-filter label-info" filter_by="year" attrib="<?php echo $next_year?>"><?php echo $next_year?></span>
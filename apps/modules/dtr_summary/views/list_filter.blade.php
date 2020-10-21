<div class="portlet-title margin-top-20" style="margin-bottom:3px;">
    <div class="caption">{{ lang('dtr_summary.pay_dates') }}</div>
</div>
<div class="portlet-body">
    <span class="small text-muted">{{ lang('dtr_summary.show_inclusive_date_last5') }}</span>
    <div id="period-filter-container" class="margin-top-10">
    	<?php foreach( $payroll_dates as $ppf ){
			$date = $ppf['payroll_date']. ', '. $ppf['period_year'];
			$date = date('Y-m-d', strtotime($date));
			echo '<span 
					payroll_date="'.$date.'"  
					class="event-block label label-default external-event period-filter">'
					.$ppf['payroll_date'].
				'</span>';
		} ?>

    </div>
</div>

<style>
    .event-block {
        cursor: pointer;
        margin-bottom: 5px;
        display: inline-block;
        position: relative;
    }
</style>
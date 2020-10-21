<style>
    .event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
</style>
<div class="clearfix margin-bottom-20">
    <h4>Filter Items:</h4><hr class="margin-none">
	<p class="small text-muted margin-bottom-20 margin-top-10">Note: Filter items by processing type.</p>
    <div class="list-group">
        <a href="javascript:void(0)" class="list-filter list-group-item active" filter_by="" filter_value=""><i class="fa fa-check-square-o"></i> All Processing Type</a>
        <a href="javascript:void(0)" class="list-filter list-group-item" filter_by="period_processing_type_id" filter_value="3"><i class="fa fa-square-o"></i> Final Pay</a>
        <a href="javascript:void(0)" class="list-filter list-group-item" filter_by="period_processing_type_id" filter_value="1"><i class="fa fa-square-o"></i> Regular Cycle</a>
        <a href="javascript:void(0)" class="list-filter list-group-item" filter_by="period_processing_type_id" filter_value="2"><i class="fa fa-square-o"></i> Special Processing</a>
    </div>

    <h4>Filter by Company</h4><hr class="margin-none">
    <p class="small text-muted margin-bottom-20 margin-top-10">Note: Filter items by company.</p>
    <div class="red-flag">
        <?php
            $company = $mod->get_company();
            if($company->num_rows() > 0):
                foreach( $company->result() as $row ) :?>
                    <span class="event-block label label-default company-filter" value="{{ $row->company_id }}">{{ $row->company }}</span> <?php
                endforeach; ?>
                <?php
            endif;
        ?>
    </div>

    <h4>Red Flag</h4><hr class="margin-none">
	<p class="small text-muted margin-bottom-20 margin-top-10">Employee payroll needing your attention.</p>
    <div class="red-flag">
        <?php
        	$reds = $mod->get_red_flags();
        	if($reds->num_rows() > 0):
                foreach( $reds->result() as $row ) :?>
            		<span class="event-block label label-default red-filter" value="{{ $row->user_id }}">{{ $row->full_name }}</span> <?php
            	endforeach; ?>
                <br/><button onclick="recompute_all()" class="btn red btn-sm" type="button"><i class="fa fa-refresh"></i> Recompute All</button>
                <?php
            endif;
        ?>
    </div>
</div>
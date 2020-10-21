
	<div class="col-md-4">
		<div class="easy-pie-chart">
			<div class="attendance number transactions" data-percent="<?php echo $stat->attendance?>"><span class="small"><?php echo $stat->attendance.' %'?></span></div>
			<a class="small title" href="#"><?php echo lang('dashboard.tk_attendance') ?></a>
		</div>
	</div>
	<div class="margin-bottom-10 visible-sm"></div>
	<div class="col-md-4">
		<div class="easy-pie-chart">
			<div class="dispute number transactions" data-percent="<?php echo $stat->dispute?>"><span class="small"><?php echo $stat->dispute.' %'?></span></div>
			<a class="title" href="#"><?php echo lang('dashboard.tk_late') ?></a>
		</div>
	</div>
        <div class="margin-bottom-10 visible-sm"></div>
        <div class="col-md-4">
                <div class="easy-pie-chart">
                        <div class="attendance number transactions" data-percent="<?php echo $stat->overtime?>"><span class="small"><?php echo $stat->overtime?></span></div>
                        <a class="title" href="#"><?php echo lang('dashboard.tk_ot') ?></a>
                </div>
        </div>

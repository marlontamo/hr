<li>
		<a href="<?php echo site_url('dashboard');?>" menu_id="1" parent="0">
			<i class="fa fa-home"></i> 
			<span class="title">Dashboard</span>
					</a>
			</li>
	<li>
		<a href="javascript:;" menu_id="2" parent="0">
			<i class="fa fa-user"></i> 
			<span class="title">My Record</span>
							<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
				 
					<li ><a rel="<?php echo site_url('account/calendar');?>" href="<?php echo site_url('account/calendar');?>" menu_id="24" parent="2">Schedule</a></li>
				 
					<li ><a rel="<?php echo site_url('account/profile');?>" href="<?php echo site_url('account/profile');?>" menu_id="23" parent="2">201</a></li>
				 
					<li ><a rel="<?php echo site_url('account/payslip');?>" href="<?php echo site_url('account/payslip');?>" menu_id="95" parent="2">Payroll</a></li>
							</ul>
			</li>
	<li>
		<a href="javascript:;" menu_id="3" parent="0">
			<i class="fa fa-folder-open-o"></i> 
			<span class="title">Employee</span>
							<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
				 
					<li ><a rel="<?php echo site_url('birthdays');?>" href="<?php echo site_url('birthdays');?>" menu_id="35" parent="3">Birthdays</a></li>
				 
					<li ><a rel="<?php echo site_url('partners/admin/movement');?>" href="<?php echo site_url('partners/admin/movement');?>" menu_id="86" parent="3">Movement</a></li>
				 
					<li ><a rel="<?php echo site_url('partner/code_of_conduct');?>" href="<?php echo site_url('partner/code_of_conduct');?>" menu_id="106" parent="3">Code of Conduct</a></li>
				 
					<li ><a rel="<?php echo site_url('partner/resources');?>" href="<?php echo site_url('partner/resources');?>" menu_id="107" parent="3">Resources</a></li>
							</ul>
			</li>
	<li>
		<a href="javascript:;" menu_id="5" parent="0">
			<i class="fa fa-clock-o"></i> 
			<span class="title">Timekeeping</span>
							<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
				 
					<li ><a rel="<?php echo site_url('time/application');?>" href="<?php echo site_url('time/application');?>" menu_id="46" parent="5">Application</a></li>
				 
					<li ><a rel="<?php echo site_url('time/leave_balance');?>" href="<?php echo site_url('time/leave_balance');?>" menu_id="84" parent="5">Leave Balance</a></li>
				 
					<li ><a rel="<?php echo site_url('time/timerecords');?>" href="<?php echo site_url('time/timerecords');?>" menu_id="45" parent="5">Daily Time Records</a></li>
							</ul>
			</li>
	<li>
		<a href="javascript:;" menu_id="96" parent="0">
			<i class="fa fa fa-trophy"></i> 
			<span class="title">Appraisal</span>
							<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
				 
					<li ><a rel="<?php echo site_url('appraisal/individual_planning');?>" href="<?php echo site_url('appraisal/individual_planning');?>" menu_id="98" parent="96">Target Setting</a></li>
				 
					<li ><a rel="<?php echo site_url('appraisal/individual_rate');?>" href="<?php echo site_url('appraisal/individual_rate');?>" menu_id="97" parent="96">Appraisal</a></li>
							</ul>
			</li>

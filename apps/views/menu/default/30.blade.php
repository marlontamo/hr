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
				 
					<li ><a rel="<?php echo site_url('partners/list');?>" href="<?php echo site_url('partners/list');?>" menu_id="31" parent="3">Employee List</a></li>
				 
					<li ><a rel="<?php echo site_url('partners/immediate');?>" href="<?php echo site_url('partners/immediate');?>" menu_id="34" parent="3">Subordinates</a></li>
				 
					<li ><a rel="<?php echo site_url('birthdays');?>" href="<?php echo site_url('birthdays');?>" menu_id="35" parent="3">Birthdays</a></li>
				 
					<li ><a rel="<?php echo site_url('partners/201_update');?>" href="<?php echo site_url('partners/201_update');?>" menu_id="32" parent="3">Update 201 Manage</a></li>
				 
					<li ><a rel="<?php echo site_url('partners/memo');?>" href="<?php echo site_url('partners/memo');?>" menu_id="75" parent="3">Announcement</a></li>
				 
					<li ><a rel="<?php echo site_url('partners/admin/movement');?>" href="<?php echo site_url('partners/admin/movement');?>" menu_id="86" parent="3">Movement</a></li>
				 
					<li ><a rel="<?php echo site_url('partner/code_of_conduct');?>" href="<?php echo site_url('partner/code_of_conduct');?>" menu_id="106" parent="3">Code of Conduct</a></li>
				 
					<li ><a rel="<?php echo site_url('partners/clearance');?>" href="<?php echo site_url('partners/clearance');?>" menu_id="33" parent="3">Clearance</a></li>
				 
					<li ><a rel="<?php echo site_url('partner/clearance_manage');?>" href="<?php echo site_url('partner/clearance_manage');?>" menu_id="116" parent="3">Clearance Manage</a></li>
				 
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
				 
					<li ><a rel="<?php echo site_url('time/admin/leave_balance');?>" href="<?php echo site_url('time/admin/leave_balance');?>" menu_id="83" parent="5">Leave Balance - Admin</a></li>
				 
					<li ><a rel="<?php echo site_url('time/timerecords');?>" href="<?php echo site_url('time/timerecords');?>" menu_id="45" parent="5">Daily Time Records</a></li>
				 
					<li ><a rel="<?php echo site_url('admin/timerecords');?>" href="<?php echo site_url('admin/timerecords');?>" menu_id="79" parent="5">Time Records - Admin</a></li>
				 
					<li ><a rel="<?php echo site_url('time/calendar');?>" href="<?php echo site_url('time/calendar');?>" menu_id="44" parent="5">Work Schedule</a></li>
							</ul>
			</li>
	<li>
		<a href="<?php echo site_url('payroll/setup');?>" menu_id="74" parent="0">
			<i class="fa fa-money"></i> 
			<span class="title">Payroll</span>
					</a>
			</li>
	<li>
		<a href="javascript:;" menu_id="6" parent="0">
			<i class="fa fa-search-plus"></i> 
			<span class="title">Recruitment</span>
							<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
				 
					<li ><a rel="<?php echo site_url('recruitment/mrf');?>" href="<?php echo site_url('recruitment/mrf');?>" menu_id="55" parent="6">Manpower Request</a></li>
				 
					<li ><a rel="<?php echo site_url('recruitment/applicant_monitoring');?>" href="<?php echo site_url('recruitment/applicant_monitoring');?>" menu_id="56" parent="6">Applicant Monitoring</a></li>
				 
					<li ><a rel="<?php echo site_url('recruitment/applicants');?>" href="<?php echo site_url('recruitment/applicants');?>" menu_id="57" parent="6">Applicant List</a></li>
				 
					<li ><a rel="<?php echo site_url('recruitment/appform');?>" href="<?php echo site_url('recruitment/appform');?>" menu_id="58" parent="6">Applicant Registration (External)</a></li>
				 
					<li ><a rel="<?php echo site_url('recruitment/form');?>" href="<?php echo site_url('recruitment/form');?>" menu_id="115" parent="6">Applicant Registration (Internal)</a></li>
							</ul>
			</li>
	<li>
		<a href="javascript:;" menu_id="9" parent="0">
			<i class="fa fa-th"></i> 
			<span class="title">Master</span>
							<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
				 
					<li ><a rel="<?php echo site_url('admin/user/manager');?>" href="<?php echo site_url('admin/user/manager');?>" menu_id="64" parent="9">Employee Master</a></li>
				 
					<li ><a rel="<?php echo site_url('admin/signatories');?>" href="<?php echo site_url('admin/signatories');?>" menu_id="20" parent="9">Employee Approver</a></li>
				 
					<li ><a rel="<?php echo site_url('admin/partner/manager');?>" href="<?php echo site_url('admin/partner/manager');?>" menu_id="65" parent="9">Employee Master 2</a></li>
				 
					<li ><a rel="<?php echo site_url('time/reference');?>" href="<?php echo site_url('time/reference');?>" menu_id="67" parent="9">Time Keeping Master</a></li>
				 
					<li ><a rel="<?php echo site_url('admin/clearance_sign');?>" href="<?php echo site_url('admin/clearance_sign');?>" menu_id="108" parent="9">Clearance Signatory</a></li>
							</ul>
			</li>
	<li>
		<a href="javascript:;" menu_id="8" parent="0">
			<i class="fa fa-bar-chart-o"></i> 
			<span class="title">Reports</span>
							<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
				 
					<li ><a rel="<?php echo site_url('dashboard');?>/reports" href="<?php echo site_url('dashboard');?>/reports" menu_id="89" parent="8">Generate Reports</a></li>
				 
					<li ><a rel="<?php echo site_url('demographics');?>" href="<?php echo site_url('demographics');?>" menu_id="93" parent="8">Demographics</a></li>
							</ul>
			</li>
	<li>
		<a href="<?php echo site_url('admin/system');?>" menu_id="10" parent="0">
			<i class="fa fa-cogs"></i> 
			<span class="title">System Configuration</span>
							<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
				 
					<li ><a rel="<?php echo site_url('admin/system');?>" href="<?php echo site_url('admin/system');?>" menu_id="13" parent="10">Settings</a></li>
							</ul>
			</li>
	<li>
		<a href="<?php echo site_url('admin/system');?>" menu_id="120" parent="0">
			<i class="fa fa-cogs"></i> 
			<span class="title">Utilities</span>
							<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
				 
					<li ><a rel="<?php echo site_url('admin/emails');?>" href="<?php echo site_url('admin/emails');?>" menu_id="114" parent="120">Outgoing Emails</a></li>
							</ul>
			</li>

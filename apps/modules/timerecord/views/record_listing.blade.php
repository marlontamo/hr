@extends('layouts.master')

@section('page_styles')
	@parent
	
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/pages/blog.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/pages/news.css"/>
	<style>
		div.spinner {
			/*//position:relative;*/
			background: none;
			border: none;
			/*display: none;*/
			padding-top: 5px;
			padding-bottom: 5px;
			overflow: hidden;
			/*//width: 550px;
			//height: 300px;
			//border:1px solid red;*/
		}
		
		div.spinner img{
			margin-top: 5px;
			margin-bottom: 5px;
			position:absolute;
			top:50%;
			left: 50%;
		}
    </style>    
    
@stop

@section('page_content')
	@parent
   
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
        
			<div class="col-md-9">

				<!-- Listing -->
				<div class="portlet" id="list">
                
                	<div class="breadcrumb hidden-lg hidden-md">
                        <div class="block input-icon right">
                            <i class="fa fa-search"></i>
                            <input type="text" placeholder="Search..." class="form-control">
                        </div>
                    </div>
                
					<div class="portlet-title">
						<div class="caption">&nbsp;</div>
						<div class="actions margin-bottom-10">
							<a class="text-muted btn btn-default prev_page" href="#"><i class="fa fa-chevron-left"></i></a>
							<a class="text-muted btn btn-default next_page" href="#"><i class="fa fa-chevron-right"></i></a>
						</div>
					</div>		

					<div class="portlet-body">
						<!-- Table -->
						<input type="hidden" name="current_month" id="current_month" value="{{ date('Y-m') }}">
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th width="1%" class="hidden-xs"><i class="fa fa-align-justify"></i></th>
									<th width="1%" class=""><i class="fa fa-bell"></i></th>
									<th width="1%" class="">&nbsp;</th>
									<th width="15%">Date</th>
									<th width="15%">IN</th>
									<th width="15%">OUT</th>
									<th width="1%" class="hidden-xs">&nbsp;</th>
									<th width="30%" class="hidden-xs">Remarks</th>
									<th width="15%" class="hidden-xs">Actions</th>
								</tr>
							</thead>
							<tbody id="dtr_list">
							</tbody>
						</table>

						<!-- End Table -->
					</div>

				</div>

                
			</div>
            
            <div class="col-md-3 visible-lg visible-md">
				<div class="portlet">
                    <!-- <div class="actions clearfix">
                    	<span class="pull-left"><a href="admin_timekeeping.php" class="text-muted">Back to List &nbsp;<i class="m-icon-swapright"></i></a></span>
					</div> -->

					<!-- <div class="clearfix margin-bottom-20">
                    	<div class="input-icon right margin-bottom-10">
                            <i class="fa fa-search"></i>
                            <input type="text" placeholder="Search..." class="form-control">
                        </div>

                        <div class="actions margin-top-20 clearfix">
                        	<span class="pull-left"><a href="admin_timekeeping.php" class="text-muted">Back to List &nbsp;<i class="m-icon-swapright"></i></a></span>
						</div>

					</div> -->
					<style>
						.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
					</style>

					<div class="portlet-body util-btn-margin-bottom-5">
						<div class="clearfix">
							<h4 class="block">Filter</h4>
							<div id="filter">
								@include('list_template_filter')
							</div>
						</div>
					</div>

					<div class="portlet-body util-btn-margin-bottom-5">
						<!-- LINK TO MY CALENDAR-->    
						<h4>Link</h4>
						<a href="time_workcalendar.php" class="label label-success">My Calendar</a>
					</div>

				</div>
			</div>

		</div>
		<!-- END PAGE CONTENT-->   
    
    <!--START MODAL DIALOG ELEMENTS-->
    @include('common/modals')
    <!--END MODAL DIALOG ELEMENTS-->
    
@stop

@section('page_plugins')
	@parent
    
	<script type="text/javascript" src="{{ theme_path() }}plugins/data-tables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/data-tables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/additional-methods.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/jquery.lazyload.js"></script>    
@stop

@section('page_scripts')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script>	     
	<script src="{{ theme_path() }}scripts/table-managed.js"></script>   
    <script src="{{ theme_path() }}scripts/form-wizard.js"></script> 
@stop

@section('view_js')
	@parent
    <script type="text/javascript">
		
		$(document).ready(function(e) { 

            $.ajax({
                url: '{{ site_url('timerecord/get_list') }}',
                type: 'post',
                cache: false,
                dataType: 'json',
                beforeSend: function(){ 
                    // do some preloading stuffs here...
                    //console.log('submitting form data...');
                }, 
                success: function(data) {
                	$('#dtr_list').html(data.list);  
                }
            });	

			$('.filter_year').live('click',function(){
				var year = $(this).attr('attrib');
                $.ajax({
                    url: '{{ site_url('timerecord/get_filter') }}',
                    type: 'post',
                    data: 'year=' + year,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function(){ 
                        // do some preloading stuffs here...
                        //console.log('submitting form data...');
                    }, 
                    success: function(data) {
                        $('#filter').html(data.html);
                    }
                });
			});

			$('.filter_month').live('click',function(){
				var month = $(this).attr('attrib');	
				$('#current_month').val(month);			
		
                $.ajax({
                    url: '{{ site_url('timerecord/get_list') }}',
                    type: 'post',
                    data: 'search=' + month,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function(){ 
                        // do some preloading stuffs here...
                        //console.log('submitting form data...');
                    }, 
                    success: function(data) {
                    	$('#dtr_list').html(data.list);  
                    }
                });
			});

			$('.prev_page').on('click',function(){
				var current_month = $('#current_month').val();
                $.ajax({
                    url: '{{ site_url('timerecord/get_list') }}',
                    type: 'post',
                    data: 'search=' + current_month + '&type=prev',
                    cache: false,
                    dataType: 'json',
                    beforeSend: function(){ 
                        // do some preloading stuffs here...
                        //console.log('submitting form data...');
                    }, 
                    success: function(data) {
                    	$('#current_month').val(data.current_month);
                    	$('#dtr_list').html(data.list);  
                    }
                });				
			})

			$('.next_page').on('click',function(){
				var current_month = $('#current_month').val();
                $.ajax({
                    url: '{{ site_url('timerecord/get_list') }}',
                    type: 'post',
                    data: 'search=' + current_month + '&type=next',
                    cache: false,
                    dataType: 'json',
                    beforeSend: function(){ 
                        // do some preloading stuffs here...
                        //console.log('submitting form data...');
                    }, 
                    success: function(data) {
                    	$('#current_month').val(data.current_month);
                    	$('#dtr_list').html(data.list);  
                    }
                });				
			})			
        });
	</script>

@stop
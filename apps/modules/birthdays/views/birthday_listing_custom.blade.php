@extends('layouts.master')

@section('page_styles')

@stop

@section('page_content')
	@parent
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
        
			<div class="col-md-9">
				<!-- Listing -->
				<div class="portlet" id="list">
                
                	<div class="breadcrumb hidden-lg hidden-md hidden-sm hidden-xs">
                        <div class="block input-icon right">
                            <i class="fa fa-search"></i>
                            <input type="text" placeholder="Search..." class="form-control">
                        </div>
                    </div>
                
					<div class="portlet-title">
						<div class="caption">{{ lang('birthdays.celebrants') }} <span class="small text-muted current-filter">{{ date('F Y') }}</span> </div>
					</div>		


			  <!-- /.modal greetings -->
				<!-- 	<div id="bday_greetings" class="modal fade" tabindex="-1" data-width="600">
					</div> -->
				<div class="clearfix">
					<!-- Table -->
							<table class="table table-condensed table-striped table-hover">
								<thead>
									<tr>
										<th width="10%" class="hidden-xs"></th>
										<th width="25%">{{ lang('birthdays.user') }}</th>
										<th width="25%" class="hidden-xs">{{ lang('birthdays.date') }}</th>
										<th width="20%">{{ lang('common.status') }}</th>
										<th width="20%">{{ lang('common.actions') }}</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							<tbody id="bday_list">
							</tbody>
						</table>
						<!-- End Table -->

					<div id="loader" class="text-center"><img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('common.get_record') }}</div>
				</div>
				</div>

                
			</div>
            
            <div class="col-md-3 visible-lg visible-md">
				<div class="portlet">
					<style>
						.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
					</style>

					<div class="portlet-title" style="margin-bottom:3px;">
						<div class="caption">{{ lang('birthdays.filter') }}</div>
					</div>
					<div class="portlet-body">
						<span class="small text-muted">{{ lang('birthdays.month_note') }}</span>
						<div class="margin-top-10">
							<div id="filter">
								@include('list_template_filter')	
							</div>
							
						</div>
					</div>

				</div>
			</div>

		</div>
		<!-- END PAGE CONTENT-->   
    
    <!--START MODAL DIALOG ELEMENTS-->
    <div id="greetings_dialog" class="modal fade" tabindex="-1" data-width="600">
	</div>
    @include('common/modals')
    <!--END MODAL DIALOG ELEMENTS-->
@stop


@section('page_plugins')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
@stop

@section('view_js')
	@parent
    <script type="text/javascript">

    	//check if from notifications
    	parseURLParams(document.URL)
		// get_greetings();
		function parseURLParams(url) {
		    var queryStart = url.indexOf("?") + 1,
		        queryEnd   = url.indexOf("#") + 1 || url.length + 1,
		        query = url.slice(queryStart, queryEnd - 1),
		        pairs = query.replace(/\+/g, " ").split("&"),
		        parms = {}, i, n, v, nv;

		    if (query === url || query === "") {
		        return;
		    }

		    for (i = 0; i < pairs.length; i++) {
		        nv = pairs[i].split("=");
		        n = decodeURIComponent(nv[0]);
		        v = decodeURIComponent(nv[1]);

		        if (!parms.hasOwnProperty(n)) {
		            parms[n] = [];
		        }

		        parms[n].push(nv.length === 2 ? v : null);
		    }
		    // return parms;
		    
			var request_data = {
			    bday: parms.bday,
			    celebrant_id: parms.celebrant_id,
			    birth_date: parms.birth_date,
			};

			get_greetings(request_data);
			/*$("#input-greetings-update").emojioneArea({
		      pickerPosition: "bottom",
		      filtersPosition: "bottom",
		      shortnames: true,
		      autoHideFilters: true
		    });*/
		    
		}


		$(document).on('click','.greetings', function(e){

			e.preventDefault();

			var request_data = {
			    celebrant_id: $(this).data('celebrant-id'),
			    celebrant_name: $(this).data('celebrant-name'),
			    birth_date: $(this).data('birth-date'),
			};

			get_greetings(request_data);
			/*$("#input-greetings-update").emojioneArea({
		      pickerPosition: "bottom",
		      filtersPosition: "bottom",
		      shortnames: true,
		      autoHideFilters: true,
		      filters: {
		      	people: {
	                icon: "yum",
	                emoji: "grinning,smile,stuck_out_tongue,sob,pray,"+
	                	"hamburger,fries,pizza,cake,"+
	                	"gift,birthday,balloon,heart,two_hearts"
	            }
		      }
		    });*/
		    
		});	
		
		function get_greetings(request_data){
			$.ajax({
			    url: base_url + module.get('route') + '/get_birthday_greetings',
			    type: "POST",
			    async: false,
			    data: request_data,
			    dataType: "json",
			    beforeSend: function () {
			        $.blockUI({
			        	message: '<img src="{{ base_url() }}assets/img/ajax-modal-loading.gif"><br />Processing, please wait...',
			        	css: {
							background: 'none',
							border: 'none',		
					    	'z-index':'99999'		    	
						},
						baseZ: 20000,
			        });
			    },
			    success: function (response) {

			        $.unblockUI();

			        if (typeof (response.greetings) != 'undefined') {

			        	$('#greetings_dialog').html(response.greetings);
						$('#greetings_dialog').modal('show');	            
			        }

			        for (var i in response.message) {
			            if (response.message[i].message != "") {
			                notify(response.message[i].type, response.message[i].message);
			            }
			        }
			    }
			});
			/*$(".body").each(function() {
                $(this).html(emojione.unicodeToImage($(this).html())); 
            });*/

            // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
            /*$(".body").each(function() {
                $(this).html(emojione.shortnameToImage($(this).html()));
            });*/
		}

		$(document).on('click', '#btn-greetings-update', function(e){

			e.preventDefault();
			//console.log('greetings! CLICK');
			submitBirthdayGreetings();
		});

		var submitBirthdayGreetings = function(){

			if(!$("#input-greetings-update").val()){
				$("#input-greetings-update").focus();
				return false;
			}

			var data = {new_greetings: $("#input-greetings-update").val(), birthday: $("#input-greetings-update").data('birthday'), celebrant: $("#input-greetings-update").data('celebrant-id') }; 
			//console.log(data); return false;

			$.ajax({
			    url: base_url + module.get('route') + '/update_greetings',
			    type: "POST",
			    async: false,
			    data: data,
			    dataType: "json",
			    beforeSend: function () {

			    	$("#input-greetings-update").attr('disabled', true);
			    	//$("#btn-greetings-update").attr('disabled', true);
			    	$("#icn-greetings-update").removeClass().addClass('fa fa-spinner icon-spin'); 
			    },
			    success: function (response) {

			        setTimeout(function(){

						$("#input-greetings-update").val('');
						$("#input-greetings-update").attr('disabled', false);
				    	$("#btn-greetings-update").attr('disabled', false);
				    	$("#icn-greetings-update").removeClass().addClass('fa fa-check icon-white');

						if (typeof (response.greetings) != 'undefined') {
			        		$(".greetings_container").prepend(response.greetings).fadeIn();            
			        	}
			        	/*$(".body").each(function() {
                			$(this).html(emojione.unicodeToImage($(this).html())); 
            			});*/

            			// if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
			            /*$(".body").each(function() {
			                $(this).html(emojione.shortnameToImage($(this).html()));
			            });*/

			        },1000);

			        $.unblockUI();

			        for (var i in response.message) {
			            if (response.message[i].message != "") {
			                notify(response.message[i].type, response.message[i].message);
			            }
			        }
			    }
			});

		}


		$(document).ready(function(e) { 

            $('.list-filter[filter_by="year"]').live('click',function(){
				var year = $(this).attr('attrib');

				$.ajax({
                    url: '{{ site_url('birthdays/get_filter') }}',
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

				create_list();

  
			});

        });


		function create_list()
		{
			var search = $('input[name="list-search"]').val();
			var filter_by = $('.list-filter.active').attr('filter_by');
			var filter_value = $('.list-filter.active').attr('filter_value');
			
			$('#bday_list').empty().die().infiniteScroll({
				dataPath: base_url + module.get('route') + '/get_list',
				itemSelector: 'tr.record',
				onDataLoading: function(){ 
					$("#loader").show();
					$("#no_record").hide();
				},
				onDataLoaded: function(page, records){ 
					$("#loader").hide();
					if( page == 0 && records == 0)
					{
						$("#no_record").show();
					}
				},
				onDataError: function(){ 
					return;
				},
				search: search,
				filter_by: filter_by,
				filter_value: filter_value
			});
		}

	</script>

@stop
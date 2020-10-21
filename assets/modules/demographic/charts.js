$(document).ready(function(){
	filter();

	$('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });

    $('select[name="temp-company_id"]').change(function(){
    	$('input[name="company_id"]').val( $(this).val() );
    	update_department( $(this).val() );
    	filter();
    });
    $('select[name="department_id"]').change(filter);
    $('input[name="date"]').change(filter);
    update_department( $('input[name="company_id"]').val() );

    $('a[href="#tab2"]').click(function(){
			        get_long_lat();
		            update_map();	
	});

	$(window).resize(function() {	
		get_long_lat();
	});

});

function filter()
{
	chart_gender_per_status();
	age_profile_pie();
	chart_type_per_status();
	tenure_pie();
	get_long_lat();
}

function chart_gender_per_status()
{
	var data = {
		'company_id': $('input[name="company_id"]').val(),
		'department_id': $('select[name="department_id"]').val(),
		'date': $('input[name="date"]').val()
	};

	$.ajax({
		url: base_url + module.get('route') + '/get_gender_per_status_data',
		type:"POST",
		data: data,
		dataType: "json",
		async: true,
		success: function ( response ) {
			var temp = null;
			var data = [];
			var ticks = [];
			var stat_ctr = 0;
			
			var tick_mid = Math.ceil((response.data.status_count/2)) - 1;

			var male = response.data.male;
			var male_grand_total = male.grand_total;
			var male_total = male.total;
			var female = response.data.female;
			var female_grand_total = female.grand_total;
			var female_total = female.total;
			var grand_grand_total = male_grand_total + female_grand_total;
			
			$('#gender_per_status_table tbody').html('');
			var statuses = response.data.statuses;
			var row = "";
			for(var i in statuses)
			{
				temp = null;
				temp = {
					data:[ [ stat_ctr, male_total[i] ], [ stat_ctr+response.data.status_count, female_total[i] ] ], 
					label: statuses[i].employment_status, 
					color:"#"+statuses[i].color
				}

				data.push(temp);
				if( tick_mid == stat_ctr )
					ticks.push([stat_ctr, 'Male']);
				stat_ctr++;

				row = '<tr>';
				row = row + '<td>'+statuses[i].employment_status+'</td>';
				row = row + '<td class="text-center">'+ male_total[i] +'</td>';
				row = row + '<td class="text-center">'+ round( (male_total[i] / grand_grand_total*100), 2) +'%</td>';
				row = row + '<td class="text-center">'+ female_total[i] +'</td>';
				row = row + '<td class="text-center">'+ round( (female_total[i] / grand_grand_total*100), 2) +'%</td>';
				row = row + '<tr>';

				$('#gender_per_status_table tbody').append(row);
				row = "";
			}

			var male_percentage = round( (male_grand_total / grand_grand_total*100), 2);
			var female_percentage = round( (female_grand_total / grand_grand_total*100), 2);

			row = '<tr class="warning">';
			row = row + '<td class="bold">Total:</td>';
			row = row + '<td class="text-center">'+ male_grand_total + '<br></td>';
			row = row + '<td class="text-center">' + male_percentage + '%' + '</td>';
			row = row + '<td class="text-center">'+ female_grand_total + '</td>';
			row = row + '<td class="text-center">' + female_percentage + '%' + '</td>';
			row = row + '</tr>';
			row = row + '<tr class="success">';
			row = row + '<td class="bold">Grand Total:</td>';
			row = row + '<td colspan="4" class="text-center">'+ grand_grand_total +'</td>';
			row = row + '</tr>';
			$('#gender_per_status_table tbody').append(row);
			
			for(var i in statuses)
			{
				if( (tick_mid+response.data.status_count) == stat_ctr )
					ticks.push([stat_ctr, 'Female']);
				stat_ctr++;	
			}

			var options = {
			    series:
			    {
			        bars:
			        {
			            show: true,
			            align: "center",
			        }
			    },
			    xaxis:
			    {
			        ticks: ticks,
			        axisLabel: "Gender",
			        axisLabelUseCanvas: true,
	                axisLabelFontSizePixels: 12,
	                axisLabelFontFamily: 'Verdana, Arial',
	                axisLabelPadding: 10,
			    },
			    yaxis: {
	                axisLabel: "Employee Count",
	                axisLabelUseCanvas: true,
	                axisLabelFontSizePixels: 12,
	                axisLabelFontFamily: 'Verdana, Arial',
	                axisLabelPadding: 3,
	                tickFormatter: function (v, axis) {
	                    return v;
	                }
	            },
	            grid: {
		            hoverable: true,
		            clickable: false,
		            borderWidth: 1
		        }
			};
			$.plot("#gender_per_status",data, options);
			gender_per_status_tooltip();
		}
	});
}

function age_profile_pie()
{
	var data = {
		'company_id': $('input[name="company_id"]').val(),
		'department_id': $('select[name="department_id"]').val(),
		'date': $('input[name="date"]').val()
	};

	$.ajax({
		url: base_url + module.get('route') + '/get_age_profile_data',
		type:"POST",
		data: data,
		dataType: "json",
		async: true,
		success: function ( response ) {
			var total = response.data.total;
			var age_bracket = response.data.age_bracket;
			var data = [];
			var ctr = 0;
			for(var i in age_bracket)
			{
				data[ctr] = {
					label: i + ' y.o ('+age_bracket[i]+')',
					data: round( age_bracket[i] / total, 2)
				}
				ctr++;
			}

			var options = {
	            series: {
	                pie: {
	                    show: true,
	                    radius: 1,
	                    label: {
	                        show: true,
	                        radius: 4/5,
	                        formatter: function (label, series) {
	                            return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' + round(series.percent,2) + '%</div>';
	                        },
	                        background: {
	                            opacity: 0.5
	                        }
	                    }
	                }
	            },
	            legend: {
	                show: true
	            },
                grid: {
                    hoverable: true,
                    clickable: true
                }
	        };
			$.plot($("#age_profile_pie"), data, options);

			var rows = "";
			for(var i in age_bracket)
			{
				rows = rows + "<tr>";
				rows = rows + '<td>'+i+" y.o</td>";
				rows = rows + '<td align="center">'+age_bracket[i]+"</td>";
				rows = rows + '<td align="center">'+round( age_bracket[i] / total * 100, 2)+"%</td>";
				
				rows = rows + "</tr>";
			}
			rows = rows + '<tr class="bold ">';
			rows = rows + '<td class="warning">Total</td>';
			rows = rows + '<td align="center" class="success" colspan="2">'+total+'</td>';
			rows = rows + "</tr>";
			$('#age_profile_table tbody').html(rows);
		}
	});	
}

function tenure_pie()
{
	var data = {
		'company_id': $('input[name="company_id"]').val(),
		'department_id': $('select[name="department_id"]').val(),
		'date': $('input[name="date"]').val()
	};

	$.ajax({
		url: base_url + module.get('route') + '/get_tenure_data',
		type:"POST",
		data: data,
		dataType: "json",
		async: true,
		success: function ( response ) {
			var tenure = response.data.tenure;
			var total = response.data.total;
			var ctr = 0;
			var data = [];
			for(var i in tenure)
			{
				data[ctr] = {
					label: i + ' ('+tenure[i]+')',
					data: tenure[i]/total*100
				}
				ctr++;
			}

			var options = {
	            series: {
	                pie: {
	                    show: true,
	                    radius: 1,
	                    label: {
	                        show: true,
	                        radius: 3 / 4,
	                        formatter: function (label, series) {
	                            return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' + round(series.percent,2) + '%</div>';
	                        },
	                        background: {
	                            opacity: 0.5
	                        }
	                    }
	                }
	            },
	            legend: {
	                show: true
	            },
                grid: {
                    hoverable: true,
                    clickable: true
                }
	        };
			$.plot($("#tenure_pie"), data, options);

			var rows = "";
			for(var i in tenure)
			{
				rows = rows + "<tr>";
				rows = rows + '<td>'+i+"</td>";
				rows = rows + '<td align="center">'+tenure[i]+"</td>";
				rows = rows + '<td align="center">'+round( tenure[i] / total * 100, 2)+"%</td>";
				
				rows = rows + "</tr>";
			}
			rows = rows + '<tr class="bold ">';
			rows = rows + '<td class="warning">Total</td>';
			rows = rows + '<td align="center" class="success" colspan="2">'+total+'</td>';
			rows = rows + "</tr>";
			$('#tenure_table tbody').html(rows);
		}
	});	
}

function showTooltip(x, y, contents, z) {
	$('<div id="flot-tooltip">' + contents + '</div>').css({
        top: y - 20,
        left: x - 90,
        'border-color': z,
    }).appendTo("body").show();
}

var previousPoint = null, previousLabel = null;
function gender_per_status_tooltip()
{
	$("#gender_per_status").bind("plothover", function (event, pos, item) {
	    if (item) {
	        if (previousPoint != item.datapoint) {
	            previousPoint = item.datapoint;
	            $("#flot-tooltip").remove();

	            var originalPoint;
	            if (item.datapoint[0] == item.series.data[0][0]) {
	                originalPoint = "Male";
	            } else if (item.datapoint[0] == item.series.data[1][0]){
	                 originalPoint = "Female";
	            }

	            y = item.datapoint[1];
	            z = item.series.color;

	            showTooltip(item.pageX, item.pageY,
	                "<b>" + item.series.label + "</b><br /> " + originalPoint + " = " + y,
	                z);
	        }
	    } else {
	        $("#flot-tooltip").remove();
	        previousPoint = null;
	    }
	});
}

function chart_type_per_status_tooltip()
{
	$("#chart_type_per_status").bind("plothover", function (event, pos, item) {
	    if (item) {
	    	if (previousPoint != item.datapoint) {
	            previousPoint = item.datapoint;
	            $("#flot-tooltip").remove();

	            var sublabel = null;
	            for( var i in item.series.data )
	            {
	            	if( item.datapoint[0] == item.series.data[i][0] )
	            	{
	            		sublabel = item.series.xaxis.ticks[i].label;
	            		break;
	            	}
	            }

	            y = item.datapoint[1];
	            z = item.series.color;

	            showTooltip(item.pageX, item.pageY,
	                "<b>" + item.series.label + "</b><br /> " + sublabel + " = " + y,
	                z);
	        }
	    } else {
	        $("#flot-tooltip").remove();
	        previousPoint = null;
	    }
	});
}

function chart_type_per_status()
{
	var data = {
		'company_id': $('input[name="company_id"]').val(),
		'department_id': $('select[name="department_id"]').val(),
		'date': $('input[name="date"]').val()
	};

	$.ajax({
		url: base_url + module.get('route') + '/get_type_per_status_data',
		type:"POST",
		data: data,
		dataType: "json",
		async: true,
		success: function ( response ) {
			var tick_mid = Math.ceil((response.data.total_types/2));
			var ticks = [];
			var stat_ctr = 0;
			var bar_ctr = 0;
			var status = response.data.status;
			var type = response.data.type;
			var temp1 = null;
			var temp2 = [];
			var data = [];
			
			var count = response.data.count;
			for (var status_id in status)
			{
				temp1 = null;
				temp2 = [];
				for( var type_id in type )
				{
					if( typeof count[status_id][type_id] === "undefined" )
						temp2.push( [bar_ctr, 0] );
					else
						temp2.push( [bar_ctr, count[status_id][type_id] ] );

					if( bar_ctr % tick_mid == 0 && bar_ctr % response.data.total_types != 0)
					{
						ticks.push([bar_ctr-1, type[type_id].employment_type]);
					}
					bar_ctr = bar_ctr + response.data.total_types;
				}

				temp1 = {
					data:temp2, 
					label: status[status_id].employment_status, 
					color:"#"+status[status_id].color
				}

				data.push(temp1);
				stat_ctr++
				bar_ctr = stat_ctr;
			}
		
			var options = {
			    series:
			    {
			        bars:
			        {
			            show: true,
			            align: "center",
			        }
			    },
			    xaxis:
			    {
			        ticks: ticks,
			        axisLabel: "Employment Type",
			        axisLabelUseCanvas: true,
	                axisLabelFontSizePixels: 12,
	                axisLabelFontFamily: 'Verdana, Arial',
	                axisLabelPadding: 10,
			    },
			    yaxis: {
	                axisLabel: "Employee Count",
	                axisLabelUseCanvas: true,
	                axisLabelFontSizePixels: 12,
	                axisLabelFontFamily: 'Verdana, Arial',
	                axisLabelPadding: 3,
	                tickFormatter: function (v, axis) {
	                    return v;
	                }
	            },
	            grid: {
		            hoverable: true,
		            clickable: false,
		            borderWidth: 1
		        }
			};
			$.plot("#chart_type_per_status",data, options);
			chart_type_per_status_tooltip();

			$('#chart_type_per_status_table th:not(#type)').remove();
			for(var i in type)
			{
				$('#chart_type_per_status_table thead tr').append('<th>'+type[i].employment_type+'</th>');
			}

			$('#chart_type_per_status_table tbody').html('');
			var str = "";
			for( var status_id in count )
			{
				str = "<tr>";
				str = str + '<td>'+status[status_id].employment_status+'</td>';
				for(var type_id in type)
				{
					if( typeof count[status_id][type_id] === "undefined"  )
						str = str + '<td></td>';
					else
						str = str + '<td align="center">'+count[status_id][type_id]+'</td>';
				}
				str = str + "</tr>";
				$('#chart_type_per_status_table tbody').append(str);
			}

			str = '<tr class="warning">';
			str = str + '<td class="bold">Total</td>';
			var tots = [];
			for( var status_id in count )
			{
				for( var type_id in count[status_id] )
				{
					if( typeof tots[type_id] === "undefined"  )
						tots[type_id] = count[status_id][type_id];
					else
						tots[type_id] = tots[type_id] + count[status_id][type_id];
					
				}
			}
			for( var type_id in tots  )
			{
				str = str + "<td align=\"center\">"+tots[type_id]+"</td>";
			}
			str = str + '</tr>';
			$('#chart_type_per_status_table tbody').append(str);

			/*var tots = [];
			for( var status_id in count )
			{
				for( var type_id in count[status_id] )
				{
					if( typeof tots[type_id] === "undefined"  )
						tots[type_id] = count[status_id][type_id];
					else
						tots[type_id] = tots[type_id] + count[status_id][type_id];
					
				}
			}

			var str = "";
			for( var type_id in tots  )
			{
				str = str + "<tr>";
				str = str + "<td>"+type[type_id].employment_type+"</td>";
				str = str + "<td align=\"center\">"+tots[type_id]+"</td>";
				str = str + "</tr>";
			}
			$('#chart_type_per_status_table tbody').html(str);*/
		}
	});
}

function update_department( company_id )
{
	$('select[name="department_id"]').select2("val","");
	$.ajax({
	    url: base_url + module.get('route') + '/update_department',
	    type: "POST",
	    async: true,
	    data: {company_id: company_id},
	    dataType: "json",
	    beforeSend: function () {
    		$("#dept_loader").show();
    		$("#department_div").hide();
	    },
	    success: function (response) {
	    	$('select[name="department_id"]').html(response.departments);
    		$("#dept_loader").hide();
    		$("#department_div").show();
	    }
	});		
}

function get_long_lat()
{
	var data = {
		'company_id': $('input[name="company_id"]').val(),
		'department_id': $('select[name="department_id"]').val(),
		'date': $('input[name="date"]').val()
	};

	$.ajax({
		url: base_url + module.get('route') + '/get_long_lat_data',
		type:"POST",
		data: data,
		dataType: "json",
		async: true,
		success: function ( response ) {
			var data = response.data.data;
			var long_lat = '';
			var alias = '';
			var photo='';
			var position='';
			var company='';

			var w = $('.tab-content').width();
			w = w+'px';

			$(window).resize(function() {
			    w = $('.tab-content').width();
				w = w+'px';
			});

		    var map = new GMaps({
	            div: '#gmap_marker',
	            lat: 0,
	            lng: 0,
	            width: w,
		        height: '500px',
		        zoom: 12,
		        zoomControl: true,
		        zoomControlOpt: {
		            style: 'SMALL',
		            position: 'TOP_LEFT'
		        },
		        panControl: false,
	        });


	        // Define user location
	      	GMaps.geolocate({
	          success: function(position) {
	            map.setCenter(position.coords.latitude, position.coords.longitude);


	        // Creating marker of user location
	              map.addMarker({
	                  lat: position.coords.latitude,
	                  lng: position.coords.longitude,
	                  title: 'Current Location',
	                  infoWindow: {
	                      content: '<span style="color:#000">You are here!</span>'
	                    }
	            });
	          },
	          error: function(error) {
	            alert('Geolocation failed: '+error.message);
	          },
	          not_supported: function() {
	            alert("Your browser does not support geolocation");
	          }
	      	});

		 	$.each(data, function() {
			  $.each(this, function(k, v) {
			  		if ( k == 'long_lat' ) {
			            long_lat = v;
			        }

			        var coor = long_lat.split(',',2);

			        if( k == 'alias' ) {
			        	alias = v;
			        }

			        if( k == 'position' ){
			        	position = v;
			        }

			        if( k == 'photo' ){
			        	photo = v;
			        }

			        if( k == 'company' ){
			        	company = v;
			        }

			        map.addMarker({
			        	lat: coor[0],
			        	lng: coor[1],
			            title: 'Marker',
			            icon: photo,
			            infoWindow: {
			                content: 
			                	'<div style="padding:0;">'
			                	+
			                	'<p style="margin-bottom:5px;color:#000000"><strong>'
			                	+
			                	alias
			                	+
			                	'</strong></p>'
			                	+
			                	'<p class="text-muted">'
			                	+
			                	position
			                	+
			                	'<br>'
			                	+
			                	company
			                	+
			                	'</p>'
			                	+
			                	'</div>'
			            }
			        });
			  });
			});
			
		}
	});
}

//For updating map_location of user
	// $(document).on('keypress', '#partners_personal-mobile', function (e) {  
	//     if (e.which == 13) {
	//         e.preventDefault();
	//         update_mobilephone($(this));
	//     } else return;
	// });

	function update_map(){    
	    $.ajax({
	        url: base_url + module.get('route') + '/update_map',
	        type:"POST",
	        async: false,
	        dataType: "json",
	        beforeSend: function(){
	                    // $('body').modalmanager('loading');
	                },
	                success: function ( response ) {
	                    if( typeof(response.update_map) != 'undefined' )
	                    {

	                        // if ($.cookie('page_visited') != 'yes' ){
	                            $('#prompt_map').html(response.update_map);
	                            $('#prompt_map').modal('show');    

	                            $('#prompt_map').on('shown.bs.modal', function (e) {
									   	var map2;
			                            map2 = new GMaps({
			                            	div:'#plot_map',
			                            	lat: 0,
			                            	lng: 0,
			                            	width: '100%',
									        height: '250px',
									        zoom: 12,
									        zoomControl: true,
									        zoomControlOpt: {
									            style: 'SMALL',
									            position: 'TOP_LEFT'
									        },
									        panControl: false,
			                            });

			                            // Define user location
								      	GMaps.geolocate({
								          success: function(position) {
								            map2.setCenter(position.coords.latitude, position.coords.longitude);


								        // Creating marker of user location
								              map2.addMarker({
								                  lat: position.coords.latitude,
								                  lng: position.coords.longitude,
								                  title: 'Current Location',
								                  infoWindow: {
								                      content: '<span style="color:#000">You are here!</span>'
								                    }
								            });
								          },
								          error: function(error) {
								            alert('Geolocation failed: '+error.message);
								          },
								          not_supported: function() {
								            alert("Your browser does not support geolocation");
								          }
								      	});

								      	GMaps.on('click',map2.map,function(event){
								      		map2.removeMarkers();

								      		var lat = event.latLng.lat();
								      		var lng = event.latLng.lng();

								      		map2.addMarker({
								      			lat: lat,
								      			lng: lng,
								      			title: 'Marker',
								      			infoWindow:{
								      				content: 'Here'
								      			}
								      		});
								      	});

								      	GMaps.on('marker_added', map2, function(marker) {
	    									$('#partners-personal_lat').val(marker.getPosition().lat());
	    									$('#partners-personal_lng').val(marker.getPosition().lng());
	    								});
								});

								$('#prompt_map').on('hidden',function(){
									get_long_lat();
								});
	                           

	                            $.cookie("page_visited", 'yes', { path: '/' });  
	                            for( var i in response.message )
	                            {
	                                if(response.message[i].message != "")
	                                {
	                                    var message_type = response.message[i].type;
	                                    notify(response.message[i].type, response.message[i].message);
	                                }
	                            } 
	                        // }else{
	                            // console.log($.cookie('page_visited'));
	                            // console.log("else");
	                        // }
	                    }

	                }
	        }); 
	}

	function update_map_coor(form){
	    var lng = $('#partners-personal_lng').val();
	    var lat = $('#partners-personal_lat').val();

	    var long_lat = lat+','+lng;
	    $.ajax({
	        url: base_url + module.get('route') + '/update_mapcoor',
	        type:"POST",
	        async: false,
	        data : "partners_personal[map_location]=" + long_lat ,
	        dataType: "json",
	        beforeSend: function(){
	                    // $('body').modalmanager('loading');
	                },
	                success: function ( response ) {

	                    if(response)
	                    {   
	                        for( var i in response.message )
	                        {
	                            if(response.message[i].message != "")
	                            {
	                                var message_type = response.message[i].type;
	                                notify(response.message[i].type, response.message[i].message);
	                            }
	                        }

	                        if(response.invalid){
	                            $('#invalid_coor').html(response.invalid_message);
	                        }else{
	                            $('#invalid_coor').html('');                        
	                            $('#prompt_map').modal('hide');
	                        }
	                    }

	                }
	        }); 
	}


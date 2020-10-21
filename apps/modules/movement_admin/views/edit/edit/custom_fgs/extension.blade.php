<?php if($type_id == 17) //for Developmental Assignment 
 { ?>
<div class="form-group">
	<label class="control-label col-md-3">
		Grade
	</label>
	<div class="col-md-7">	
	    <input type="text" class="form-control" name="partners_movement_action[grade]" id="partners_movement_action-grade" value="<?php echo $record['partners_movement_action.grade'] ?>" placeholder="Enter Grade" /> 			
	</div>	
</div>	
<?php } ?>	

<div class="form-group">
	<label class="control-label col-md-3">
		Months
	</label>
	<div class="col-md-7">
	    <input type="hidden" name="partners_movement_action_extension[id]" id="partners_movement_action_extension-id" 
	    value="<?php echo $record['partners_movement_action_extension.id']; ?>" />				
		<input type="text" class="form-control" name="partners_movement_action_extension[no_of_months]" id="partners_movement_action_extension-no_of_months" value="<?php echo $record['partners_movement_action_extension.no_of_months'] ?>" placeholder="Enter Months" /> 				
	</div>	
</div>

<div class="form-group">
	<label class="control-label col-md-3">
		<span class="required">* </span>End Date
	</label>
	<div class="col-md-7">							
		<div class="input-group input-medium date date-picker end_date" data-date-format="MM dd, yyyy">
			<input type="text" class="form-control" name="partners_movement_action_extension[end_date]" 
			value="<?php echo $record['partners_movement_action_extension.end_date']; ?>"
			id="partners_movement_action_extension-end_date"  value="<?php echo $record['partners_movement_action_extension.end_date'] ?>" placeholder="Enter End Date" readonly>
			<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div> 				
	</div>	
</div>	

<script language="javascript">
    $(document).ready(function(){

        if (jQuery().datepicker) {
            $('#partners_movement_action_extension-end_date').parent('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });
            $('body').removeClass("modal-open"); 
        }
        
		$('#partners_movement_action_extension-no_of_months').on('keyup', function() {
			var type = $('#partners_movement_action-type_id').val();
			if(type==13 && $.trim($(this).val()) > 0){
				no_months = $(this).val();
				var endDate = new Date($('#partners_movement_action-effectivity_date').val());
				var start_day = endDate.getDate();
				endDate.setMonth(endDate.getMonth() + parseInt(no_months));			

				d = new Date(endDate);
				var m_names = new Array("January", "February", "March", 
				"April", "May", "June", "July", "August", "September", 
				"October", "November", "December");

				var day = d.getDay();
				var month = d.getMonth();
				var year = d.getFullYear();
				end_date = m_names[month] + " " + start_day + ", " + year;	

				$('.end_date').datepicker('update',endDate);
			}
		});

		$("#partners_movement_action_extension-no_of_months").keypress(function (e) {
		     //if the letter is not digit then display error and don't type anything
		     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		        //display error message
		        //$("#errmsg").html("Digits Only").show().fadeOut("slow");
		               return false;
		    }
	   });

		$( "#partners_movement_action_extension-no_of_months" ).keyup(function() {
			get_end_date($('#partners_movement_action-user_id').val());
		});

		$("#partners_movement_action-effectivity_date").change(function(){
			if($( "#partners_movement_action_extension-no_of_months" ).val() != ""){
	        	get_end_date($('#partners_movement_action-user_id').val());
	        }else{
	        	//nothing
	        }
	    });
    });
</script>


<div id="training_session">
    <?php 
   // $employment_tab = 1;
    //$employment_count = count($employment_tab); ?>
    <input type="hidden" name="employment_count" id="employment_count" value="{{ $employment_count }}" />
    <?php 
   
    //foreach($employment_tab as $index => $employment){ 
        //$count_employment++;
    ?>
    <div class="portlet">
    	<div class="portlet-title">
    		<!-- <div class="caption" id="education-category">Company Name</div> -->
    		<div class="tools">
    			<a class="text-muted" id="delete_employment-<?php echo $count_employment;?>" onclick="remove_form(this.id, 'employment', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
    			<!-- <a class="collapse pull-right" href="javascript:;"></a> -->
    		</div>
    	</div>
    	<div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
    		<!-- START FORM -->	
                    <div class="form-group">
                        <label class="control-label col-md-3"><span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="partners_personal_history[employment-company][]" id="partners_personal_history-employment-company" 
                            value="" placeholder="Enter Company"/>
                        </div>
                    </div>
    				

    			</div>
    		</div>
    	</div>
    </div>
    <?php //} ?>
</div>



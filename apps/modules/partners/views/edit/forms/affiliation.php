<div class="portlet">
	<div class="portlet-title">
		<!-- <div class="caption" id="education-category">Company Name</div> -->
		<div class="tools">
            <a class="text-muted" id="delete_affiliation-<?php echo $count;?>" onclick="remove_form(this.id, 'affiliation', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
			<!-- <a class="collapse pull-right" href="javascript:;"></a> -->
		</div>
	</div>
	<div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
		<!-- START FORM -->
               <div class="form-group">
                    <label class="control-label col-md-3">Affiliation Name<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[affiliation-name][]" id="partners_personal_history-affiliation-name" placeholder="Enter Name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Position<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[affiliation-position][]" id="partners_personal_history-affiliation-position" placeholder="Enter Position"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Date Started<span class="required">*</span></label>                    
                    <div class="col-md-9">
                        <div class="input-group input-medium pull-left">
                            <select  class="form-control form-select" data-placeholder="Select Month.." name="partners_personal_history[affiliation-month-start][]" id="partners_personal_history-affiliation-month-start">
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <span class="pull-left padding-left-right-10">-</span>
                        <span class="pull-left"><input type="text" class="form-control input-small" maxlength="4" name="partners_personal_history[affiliation-year-start][]" id="partners_personal_history-affiliation-year-start" placeholder="Year"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Date End<span class="required">*</span></label>
                    <div class="col-md-9">
                    <div class="input-group input-medium pull-left">
                        <select  class="form-control form-select" data-placeholder="Select Month.." name="partners_personal_history[affiliation-month-end][]" id="partners_personal_history-affiliation-month-end">
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <span class="pull-left padding-left-right-10">-</span>
                    <span class="pull-left"><input type="text" class="form-control input-small" maxlength="4" name="partners_personal_history[affiliation-year-end][]" id="partners_personal_history-affiliation-year-end" placeholder="Year"></span>
                </div>
                </div>
			</div>
		</div>
	</div>
</div>
<script language="javascript">
    $(document).ready(function(){
        $('select.form-select').select2();
    });
</script>
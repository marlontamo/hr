<form action="#" class="form-horizontal">
    <div class="modal-body padding-bottom-0">
		<div class="row">
			<div class="portlet-body form">
                <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="form-group margin-bottom-25">
                            <label class="control-label col-md-3">Year<span class="required">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="year" id="partners_clearance_exit_interview_answers-item" value="" placeholder="Enter Year" />
                            </div>
                        </div>
                    </div>
                <!-- END FORM--> 
            </div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn default btn-sm">Close</button>
		<button type="button" class="btn green btn-sm" onclick="populate_save($(this).closest('form'))">Submit</button>
	</div>
</form>
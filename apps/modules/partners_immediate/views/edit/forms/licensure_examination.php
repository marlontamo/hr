<div class="portlet">
	<div class="portlet-title">
		<!-- <div class="caption" id="education-category">Company Name</div> -->
		<div class="tools">
            <a class="text-muted" id="delete_licensure-<?php echo $count;?>" onclick="remove_form(this.id, 'licensure', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
			<!-- <a class="collapse pull-right" href="javascript:;"></a> -->
		</div>
	</div>
	<div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
		<!-- START FORM -->	                
                <div class="form-group">
                    <label class="control-label col-md-3">Title<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[licensure-title][]" id="partners_personal_history-licensure-title" placeholder="Enter Title"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">License No.</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[licensure-number][]" id="partners_personal_history-licensure-number" placeholder="Enter License Number"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Date Taken<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-group input-medium pull-left">
                            <select  class="form-control form-select" data-placeholder="Select Month.." name="partners_personal_history[licensure-month-taken][]" id="partners_personal_history-licensure-month-taken">
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
                        <span class="pull-left"><input type="text" class="form-control input-small" maxlength="4" name="partners_personal_history[licensure-year-taken][]" id="partners_personal_history-licensure-year-taken" placeholder="Year"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Remarks</label>
                    <div class="col-md-6">
                        <textarea rows="3" class="form-control"name="partners_personal_history[licensure-remarks][]" id="partners_personal_history-licensure-remarks" ></textarea>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label class="control-label col-md-3">Supporting Documents</label>
                    <div class="col-md-6">                          
                        <div data-provides="fileupload" class="fileupload fileupload-new" id="users_profile-photo-container"> -->
                                    <!-- @if( !empty($record['users_profile.photo']) ) -->
                                        <?php 
                                            // $file = FCPATH . urldecode( $record['users_profile.photo'] );
                                            // if( file_exists( $file ) )
                                            // {
                                            //     $f_info = get_file_info( $file );
                                            // }
                                        ?>
                                        <!-- @endif -->
                            <!-- <input type="hidden" name="users_profile[photo]" id="users_profile-photo" value=""/>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="uneditable-input">
                                        <i class="fa fa-file fileupload-exists"></i> 
                                        <span class="fileupload-preview"> -->
                                            <!-- @if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif -->
                                        <!-- </span>
                                    </span>
                                </span>
                                <span class="btn default btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                    <input type="file" id="users_profile-photo-fileupload" type="file" name="files[]">
                                </span>
                                <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
                            </div>
                        </div>
                    </div>
                </div> -->

			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function(){
        $('select.form-select').select2();

    });
</script>
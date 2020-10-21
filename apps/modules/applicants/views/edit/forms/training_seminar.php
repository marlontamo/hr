<div class="portlet">
    <div class="portlet-title">
        <div class="caption" id="training-category">
            <input type="hidden" name="recruitment_personal_history[training-category][]" id="recruitment_personal_history-training-category" 
            value="<?php echo $category; ?>" />
            <?php echo $category; ?></div>
            <div class="tools">
                <a class="text-muted" id="delete_training-<?php echo $count;?>" onclick="remove_form(this.id, 'training', 'history')"  style="margin-botom:-15px;" href="#"><i class="fa fa-trash-o"></i> Delete</a>
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
                            <input type="text" class="form-control" name="recruitment_personal_history[training-title][]" id="recruitment_personal_history-training-title" placeholder="Enter Title"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Venue<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="recruitment_personal_history[training-venue][]" id="recruitment_personal_history-training-venue" placeholder="Enter Venue"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Start Date<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium pull-left">
                                <select  class="form-control form-select" data-placeholder="Select Month.." name="recruitment_personal_history[training-start-month][]" id="recruitment_personal_history-training-start-month">
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
                            <span class="pull-left"><input type="text" class="form-control input-small" maxlength="4" name="recruitment_personal_history[training-start-year][]" id="recruitment_personal_history-training-start-year" placeholder="Year"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">End Date<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium pull-left">
                                <select  class="form-control form-select" data-placeholder="Select Month.." name="recruitment_personal_history[training-end-month][]" id="recruitment_personal_history-employment-training-end-month">
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
                            <span class="pull-left"><input type="text" class="form-control input-small" maxlength="4" name="recruitment_personal_history[training-end-year][]" id="recruitment_personal_history-training-end-year" placeholder="Year"></span>
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
<div class="portlet">
	<div class="portlet-title">
		<!-- <div class="caption" id="education-category">Company Name</div> -->
		<div class="tools">
            <a class="text-muted" id="delete_skills-<?php echo $count;?>" onclick="remove_form(this.id, 'skills', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
            <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
              <!-- START FORM -->
              <div class="form-group">
                <label class="control-label col-md-3">Skill Type</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="partners_personal_history[skill-type][]" id="partners_personal_history-skill-type" placeholder="Enter Type"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Skill Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="partners_personal_history[skill-name][]" id="partners_personal_history-skill-name" placeholder="Enter Name"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Proficiency Level</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                         <i class="fa fa-star"></i>
                     </span>
                        <select  class="form-control form-select" data-placeholder="Select..." name="partners_personal_history[skill-level][]" id="partners_personal_history-skill-level">
                            <option value="Advance">Advance</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Beginner">Beginner</option>
                        </select>
                 </div>
             </div>
         </div>
         <div class="form-group">
            <label class="control-label col-md-3">Remarks</label>
            <div class="col-md-6">
                <textarea rows="3" class="form-control" name="partners_personal_history[skill-remarks][]" id="partners_personal_history-skill-remarks" ></textarea>
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
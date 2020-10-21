
<h5>Filter Employees:</h5>

    <div class="form-group">
        <label class="control-label col-md-5"> Employee<span class="required">*</span></label>
        <div class="col-md-6">
            <select class="form-control" data-placeholder="Select..." name="partners[partner_id][]" id="partners-partner_id" multiple="multiple">
                <?php 
                    foreach($partner_id_options as $index => $val) {
                    // $selected_duration = ($value[key($value)] == $val['duration_id']) ? "selected" : "";
                    ?>
                <option value="<?php echo $index ?>" <?php //echo $selected_duration; ?> ><?php echo $val; ?></option>
                <?php } ?>
            </select>

        </div>

    </div>

<div class="fluid">
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-offset-4 col-md-8">
                <button class="btn btn-default btn-sm" type="button" id="backto_mainform_emp" onclick="back_to_mainform_emp(1)">Cancel</button>
                <button class="btn green btn-sm" type="button" id="backto_mainform_emp" onclick="back_to_mainform_emp()">Continue</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $('select.select2me').select2();
    });

</script>

<h5><?php echo lang('form_application.change_opt') ?></h5>
    <?php foreach ($dates as $index => $value){

        // $array_keys = array_keys($value);
        // $array_values = array_values($value);

    ?>
    <div class="form-group">
        <label class="control-label col-md-5"> <?php echo $index; ?> <span class="small text-muted"> - <?php echo key($value); ?> </span></label>
        <div class="col-md-6">

            <select class="duration form-control form-select" data-placeholder="Select..." name="duration[]" id="duration[]" class="duration">
                <?php foreach($duration as $val) {
                    $selected_duration = ($value[key($value)] == $val['duration_id']) ? "selected" : "";
                    ?>
                <option value="<?=$val['duration_id']?>" <?php echo $selected_duration; ?> ><?=$val['duration']?></option>
                <?php } ?>
            </select>

        </div>

    </div>
    <?php } ?>

<div class="fluid">
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-offset-4 col-md-8">
                <button class="btn btn-default btn-sm" type="button" id="backto_mainform" onclick="back_to_mainform(1)"><?php echo lang('form_application.cancel') ?> </button>
                <button class="btn green btn-sm" type="button" id="backto_mainform" onclick="back_to_mainform()"> <?php echo lang('form_application.continue') ?> </button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $('select.form-select').select2();

    });

</script>
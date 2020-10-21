
    <?php foreach ($dates as $index => $value){

        // $array_keys = array_keys($value);
        // $array_values = array_values($value);

    ?>
    <div class="form-group">
        <label class="control-label col-md-4"> <?php echo $index; ?> <span class="small text-muted"> - <?php echo key($value); ?> </span></label>
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
    <div class="form-group">
        <label class="control-label col-md-4"> </label>
        <div class="col-md-6">

                <button class="btn default btn-sm" type="button" id="backto_mainform" onclick="back_to_mainform()"> Close Options </button>

        </div>

    </div>


<script>

    $(document).ready(function(){
        $('select.form-select').select2();

    });

</script>
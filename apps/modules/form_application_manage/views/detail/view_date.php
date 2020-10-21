
<h5>View Options:</h5>
<div class="portlet-body form">
    <!-- BEGIN FORM-->

    <?php foreach ($dates as $index => $value){

        $array_keys = array_keys($value);
        $array_values = array_values($value);

    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 text-right text-muted"><?php echo $index; ?>  <span class="small text-muted"> - <?php echo $array_keys[0]; ?> :</span></label>
                <div class="col-md-7 col-sm-7">
                    <span>
                        <?php 
                            foreach( $duration as $duration_info ){
                                if( $duration_info['duration_id'] == $array_values[0] ){
                                    echo $duration_info['duration'];
                                }
                            }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>


    <?php } ?>


    <div class="fluid">
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-offset-4 col-md-8">
                    <a href="#" onclick="back_to_mainform()" id="back_form_details" class="btn btn-default btn-sm"><?php echo lang('form_application_manage.back') ?></a>
                </div>
            </div>
        </div>
    </div>
    <!-- END FORM--> 
</div>



<script>

    $(document).ready(function(){
        // $('.selectM3').select2('destroy');   
        // $('.selectM3').select2();

    });

</script>
<div id="loader_form" class="text-center">
    <img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." />{{ lang('timerecord.loading') }}...
    <hr class='margin-top-10 margin-bottom-10'>
    <div class='clearfix'>
        <a href='#' class='btn btn-success btn-sm close-pop small'><i class='fa fa-long-arrow-right'></i> {{ lang('common.close') }}</a>
    </div>
</div>

<div id="time_forms_info" class="hidden">
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted text-left small'>{{ lang('timerecord.employee') }}:</label>
        <div class='col-md-9'>
            <span> {{ $display_name }}</span>
        </div>
    </div>
<?php 
foreach($ot_details as $ot):
    ?>
        <div class='clearfix'>
                <label class='control-label col-md-9 text-muted text-left small'><?php echo $ot['transaction_label']; ?></label>
                <div class='col-md-3'>
                    <span class="small"><?php echo $ot['quantity']; ?></span>
                </div>
        </div>
    <?php
endforeach;
?>
    <hr class='margin-top-10 margin-bottom-10'>
    <div class='clearfix'>
        <a href='#' class='btn btn-success btn-sm close-pop small'><i class='fa fa-long-arrow-right'></i> {{ lang('common.close') }}</a>
    </div>
</div>
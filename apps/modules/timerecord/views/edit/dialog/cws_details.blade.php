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
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('timerecord.current_sched') }}</label>
        <div class='col-md-9'>
            <span class="small"> <?php echo $curr_shift; ?></span>
        </div>
    </div>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('timerecord.new_sched') }}</label>
        <div class='col-md-9'>
            <span class="small"> <?php echo $to_shift; ?></span>
        </div>
    </div>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('timerecord.date') }}</label>
        <div class='col-md-9'>
            <span class="small"> <?php echo date("F d, Y", strtotime($date)); ?></span>
        </div>
    </div>
    <div class='clearfix'>
        <label class='control-label col-md-3 text-muted small'>{{ lang('timerecord.reason') }}</label>
        <div class='col-md-9'>
            <span class="small"><?php echo $reason; ?></span>
        </div>
    </div>

    <?php if(count($remarks)): ?>
    <div class='clearfix'>
        <?php
        for($j=0; $j < count($remarks); $j++):
            if(array_key_exists('comment', $remarks[$j])): ?>
                <label class='control-label col-md-3 text-muted small'>
                    <?php if($j==0) { ?>
                         {{ lang('timerecord.approvers') }}
                    <?php } ?></label>
                <div class='col-md-9'>
                    <span class="small italic" style='display:block; word-wrap:break-word;'>
                        <?php
                            echo '<b>'.$remarks[$j]['display_name'].'</b><br>';
                            echo '<span class="text-success">[ '.$remarks[$j]['comment_date'].' ]</span>';
                        ?>
                    </span>
                    <span class="small" style='display:block; word-wrap:break-word;'>
                        <?php
                            if(empty($remarks[$j]['comment']))
                                echo '-';
                            else
                                echo $remarks[$j]['comment'];
                        ?>
                    </span>
                </div>
            <?php       
            endif;
        endfor;
        ?>
    </div>
    <?php endif; ?>

    <hr class='margin-top-10 margin-bottom-10'>
    <div class='clearfix'>
        <a href='#' class='btn btn-success btn-sm close-pop small'><i class='fa fa-long-arrow-right'></i> {{ lang('common.close') }}</a>
    </div>
</div>
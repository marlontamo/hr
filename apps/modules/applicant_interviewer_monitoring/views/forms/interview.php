<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title margin-bottom-5"><?php echo $recruit->fullname?></h4> 
    <p class="margin-bottom-10 text-muted"><?php echo date('M d, Y', strtotime( $sched->date ))?></p> 

</div>
<div class="modal-body padding-bottom-0">
    <div class="">        
        <div class="portlet">
            <div class="portlet-body form">
                <!-- START FORM -->
                <form action="#" class="form-horizontal" name="interview-form">
                    <input type="hidden" name="interview[schedule_id]" value="<?php echo $schedule_id?>">
                    <input type="hidden" name="process_id" value="<?php echo $recruit->process_id?>">
                    <input type="hidden" name="status_id" value="<?php echo $recruit->status_id?>">
                    <input type="hidden" name="interview_id" value="<?php echo $interview->id?>">
                    <div class="form-body">

                        <div class="portlet">                            
                            <div class="portlet-body" >

                            <?php
                                foreach($details as $data):

                                    switch($data['layout']){
                                        case 'Tabular':
                            ?>
                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption"><?php echo $data['key_class'] ?></div>
                                        <div class="tools">
                                            <a class="collapse" href="javascript:;"></a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <table class="table table-bordered table-hover">

                                        <?php include '/sub/tabular_header.php'; ?>

                                            <tbody>
                                            <?php include '/sub/tabular_content.php'; ?>                                                    
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                            <?php
                                        break;
                                        case 'By Field':
                            ?>
        
                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption"><?php echo $data['key_class'] ?></div>
                                        <div class="tools">
                                            <a class="collapse" href="javascript:;"></a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <?php include '/sub/byfield_content.php'; ?>  
                                    </div>
                                </div>

                            <?php
                                        break;
                                    }
                                endforeach;
                            ?>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
                            
    </div>
</div>

<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
    <?php 
        if($user_id == $sched->user_id): ?>
            <button type="button" class="demo-loading-btn btn btn-success btn-sm" onclick="save_interview();"><?=lang('common.save')?></button>
    <?php
        endif;
    ?>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('select.select2me').select2();

        $('.salary_expectation').keyup(function () {
           
            var num = $('.salary_expectation').val();
            num = num.toString().replace(/\$|\,/g, '');
            if (isNaN(num)) num = "0";
            sign = (num == (num = Math.abs(num)));
            num = Math.floor(num * 100 + 0.50000000001);
            cents = num % 100;
            num = Math.floor(num / 100).toString();
            if (cents < 10) cents = "0" + cents;
            for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
                num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
              
            
            $('.salary_expectation').val((((sign) ? '' : '-') + num));
        });
    });

</script>
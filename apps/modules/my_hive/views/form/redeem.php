<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Redeem Item</h4>
    <span class="text-muted padding-3 small">
        <?php echo date('F d, Y - D') ?>
    </span>

</div>
<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal">
                    <div class="form-body">

                        <div class="thumbnail">
                            <img src="<?php echo base_url($redemption['image_path']) ?>" alt="" style="height: 200px;">
                            <div class="caption">
                                <h4 class="text-primary bold text-center"><?php echo $redemption['item'] ?></h4>
                                <p class="small"><?php echo $redemption['description'] ?> </p>

                                <div class="block">
                                    <img src="<?php echo theme_path().'/img/honey-points-26x26.png' ?>" class="pull-left" height="18px">
                                    <span style="margin-left: 8px;"><?php echo $redemption['points'] ?> honey points</span>
                                </div>
                            </div>
                        </div>

                        <p class=""> Are you sure you want to redeem this item?</p>


                    </div>
                </form>
                <!-- END FORM--> 
            </div>
        </div>
    </div>
</div>
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Cancel</button>
    <button type="button" data-loading-text="Loading..." class="demo-loading-btn btn btn-success btn-sm" onclick="save_item(<?php echo $redemption['item_id'] ?>)">Yes, I will.</button>
</div>
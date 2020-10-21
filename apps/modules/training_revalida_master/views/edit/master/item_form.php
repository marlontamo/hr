<div class="portlet header_item_container" >
    <div class="portlet-title">
        <div class="caption">Item List</div>
    </div>    
    <div class="portlet-body form"> 
        <div class="form-group" style="padding-left:15px">
            <button type="button" class="btn red btn-sm pull-left delete-detail" rel="item"> Delete</button>
        </div>
    </div>  

    <div class="form-group">
        <label class="control-label col-md-3">Item No</label>
        <div class="col-md-7">                          
            <input type="text" class="form-control" name="training_revalida_master[<?php echo $category_rand ?>][training_revalida_item_no][<?php echo $item_count ?>]" id="training_revalida-item_no" value="<?php echo $item_count; ?>" placeholder="Enter Item No" />                 
        </div>   
    </div>

    <div class="form-group">
        <label class="control-label col-md-3"><span class="required">* </span>Description</label>
        <div class="col-md-7">                          
            <input type="text" class="form-control" name="training_revalida_master[<?php echo $category_rand ?>][description][<?php echo $item_count ?>]" id="training_revalida-description" value="" placeholder="Enter Description" />              
        </div>  
    </div>

    <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>Rating Type</label>
            <div class="col-md-7">                       
                <div class="input-group">
                    <span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    <select class="form-control select2me" name="training_revalida_master[<?php echo $category_rand ?>][score_type][<?php echo $item_count ?>]">
                        <option value="" selected>Please Select</option>
                        <?php foreach( $item_score_type_list as $item_score_type_info ){ ?>
                            <option value="<?= $item_score_type_info['score_type_id'] ?>" ><?= $item_score_type_info['score_type'] ?></option>
                        <?php } ?>
                    </select>                    
                </div>              
            </div>  
    </div>

    <div class="form-group">
        <label class="control-label col-md-3"><span class="required">* </span>Weight</label>
        <div class="col-md-7">                          
            <input type="text" class="form-control item_weigth" name="training_revalida_master[<?php echo $category_rand ?>][item_weigth][<?php echo $item_count ?>]" id="training_revalida-item_weigth" value="" placeholder="Enter Item Weight" />              
        </div>  
    </div>
</div>
 
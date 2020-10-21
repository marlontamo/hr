<div class="portlet header_container">
    <div class="portlet-title">
        <div class="caption">Category List</div>
    </div>
    <div class="portlet-body form"> 
        <div class="form-group" style="padding-left:15px">
            <button type="button" class="btn red btn-sm pull-left delete-detail" rel="category"> Delete</button>
        </div>
    </div>        
    <div class="form-multiple-add-category" style="display: block;">
        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>Category</label>
            <div class="col-md-7">                          
                <input type="text" class="form-control" name="training_revalida_master[revalida_category][<?php echo $category_count ?>]" id="training_revalida-category" value="" placeholder="Enter Category" />                 
            </div>   
        </div>

        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>Weight</label>
            <div class="col-md-7">                          
                <input type="text" class="form-control category_weigth" name="training_revalida_master[revalida_category_weight][<?php echo $category_count ?>]" id="training_revalida-weight" value="" placeholder="Enter Weight" />              
            </div>  
        </div>

        <div class="portlet-body form"> 
            <div class="form-group" style="padding-left:15px">
                <button type="button" class="btn green btn-sm pull-right add-more" rel="item">+ Add Item</button>
            </div>
        </div>

        <div class="form-multiple-add-item-group" >
            <input type="hidden" class="item_count" value="0" />
            <input type="hidden" class="category_rand" name="training_revalida_master[item_rand][<?php echo $category_count ?>]" value="<?= $category_rand; ?>" />
            <fieldset class="item">
        	</fieldset>
        </div>

        <div class="clear"></div>
    </div> 
</div>
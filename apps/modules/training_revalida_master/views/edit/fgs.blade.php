<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Level 2 and 3 Training Evaluation Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Evaluation Type</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_revalida_master[revalida_type]" id="training_revalida_master-revalida_type" value="{{ $record['training_revalida_master.revalida_type'] }}" placeholder="Enter Evaluation Type" /> 				
			</div>	
		</div>			
	</div>
	<div class="portlet-title">
		<div class="caption">Category</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<div class="form-group">
			<button type="button" class="btn green btn-sm pull-right add-more" rel="category"><i class="fa fa-plus"></i> Add Category</button>
		</div>
	</div>
	<div class="portlet-body form">	
		<div class="form-group form-multiple-add-item-group">
    		<input type="hidden" class="draft" name="draft" value="0" />
    		<input type="hidden" class="category_count" value="<?= count($category); ?>" />			

		    <fieldset class="category" style="padding-left:10px">

		        <?php 
		            if (count($category) > 0):

		            $category_count = 0;
		            foreach ($category as $category_data):

		        ?>

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
				                <input type="text" class="form-control" name="training_revalida_master[revalida_category][<?php echo $category_count ?>]" id="training_revalida-category" value="<?= $category_data['revalida_category'] ?>" placeholder="Enter Category" />                 
				            </div>   
				        </div>

				        <div class="form-group">
				            <label class="control-label col-md-3"><span class="required">* </span>Weight</label>
				            <div class="col-md-7">                          
				                <input type="text" class="form-control category_weigth" name="training_revalida_master[revalida_category_weight][<?php echo $category_count ?>]" id="training_revalida-weight" value="<?= $category_data['revalida_category_weight'] ?>" placeholder="Enter Weight" />              
				            </div>  
				        </div>

				        <div class="portlet-body form"> 
				            <div class="form-group" style="padding-left:15px">
				                <button type="button" class="btn green btn-sm pull-right add-more" rel="item"><i class="fa fa-plus"></i> Add Item</button>
				            </div>
				        </div>
				    </div> 

		            <div class="" >
		                <input type="hidden" class="item_count" value="<?= count($category_data['items']) ?>" />
		                <input type="hidden" class="category_rand" name="training_revalida_master[item_rand][<?php echo $category_count ?>]" value="<?= $category_data['category_rand']; ?>" />
		                <fieldset class="item">

		                    <?php

		                        if (count($category_data['items']) > 0):

		                        	$item_count = 0;
		                        	foreach ($category_data['items'] as $item_data):

		                    ?>

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
										            <input type="text" class="form-control" name="training_revalida_master[<?php echo $category_data['category_rand']; ?>][training_revalida_item_no][<?php echo $item_count ?>]" id="training_revalida-item_no" value="<?= $item_data['training_revalida_item_no']; ?>" placeholder="Enter Item No" />                 
										        </div>   
										    </div>

										    <div class="form-group">
										        <label class="control-label col-md-3"><span class="required">* </span>Description</label>
										        <div class="col-md-7">                          
										            <input type="text" class="form-control" name="training_revalida_master[<?php echo $category_data['category_rand']; ?>][description][<?php echo $item_count ?>]" id="training_revalida-description" value="<?= $item_data['description']; ?>" placeholder="Enter Description" />              
										        </div>  
										    </div>

										    <div class="form-group">
										            <label class="control-label col-md-3"><span class="required">* </span>Rating Type</label>
										            <div class="col-md-7">                       
										                <div class="input-group">
										                    <span class="input-group-addon">
										                    <i class="fa fa-list-ul"></i>
										                    </span>
										                    <select class="form-control select2me" name="training_revalida_master[<?php echo $category_data['category_rand']; ?>][score_type][<?php echo $item_count ?>]">
										                        <option value="" selected>Please Select</option>
										                        <?php foreach( $item_score_type_list as $item_score_type_info ){ ?>
										                            <option value="<?= $item_score_type_info['score_type_id'] ?>" <?php if( $item_data['score_type'] == $item_score_type_info['score_type_id'] ){ ?>selected<?php } ?>><?= $item_score_type_info['score_type'] ?></option>
										                        <?php } ?>
										                    </select>                    
										                </div>              
										            </div>  
										    </div>

										    <div class="form-group">
										        <label class="control-label col-md-3"><span class="required">* </span>Weight</label>
										        <div class="col-md-7">                          
										            <input type="text" class="form-control item_weigth" name="training_revalida_master[<?php echo $category_data['category_rand']; ?>][item_weigth][<?php echo $item_count ?>]" id="training_revalida-item_weigth" value="<?= $item_data['item_weight']; ?>" placeholder="Enter Item Weight" />              
										        </div>  
										    </div>
										</div>
		                    <?php

		                        		$item_count++;

		                        	endforeach;
		                        endif;
		                    ?>

		                </fieldset>
		            </div>

		            <div class="clear"></div>
		        </div>

		        <?php

		            $category_count++;

		            endforeach;
		            endif;
		        ?>


		    <fieldset>    		
		</div>
	</div>			
</div>
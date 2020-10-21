<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Level 2 and 3 Training Evaluation Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">Evaluation Type</label>
			<div class="col-md-7">							
				<input disabled="disabled" type="text" class="form-control" name="training_revalida_master[revalida_type]" id="training_revalida_master-revalida_type" value="{{ $record['training_revalida_master.revalida_type'] }}" placeholder="Enter Evaluation Type" /> 				
			</div>	
		</div>			
	</div>
	<div class="portlet-title">
		<div class="caption">Category</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	
	<div class="portlet-body form">	
		<div class="form-group form-multiple-add-item-group">
    		<input type="hidden" class="draft" name="draft" value="0" />
    		<input type="hidden" class="category_count" value="<?= count($category); ?>" />	


    		<?php 
	            if (count($category) > 0):

	            $category_count = 0;
	            foreach ($category as $category_data):

	        ?>

	    	<div class="form-group">
	            <label class="control-label col-md-3">Category</label>
	            <div class="col-md-7">                          
	                <input disabled="disabled" type="text" class="form-control" name="training_revalida_master[revalida_category][<?php echo $category_count ?>]" id="training_revalida-category" value="<?= $category_data['revalida_category'] ?>" placeholder="Enter Category" />                 
	            </div>   
	        </div>

	        <div class="form-group">
	            <label class="control-label col-md-3">Weight</label>
	            <div class="col-md-7">                          
	                <input disabled="disabled" type="text" class="form-control category_weigth" name="training_revalida_master[revalida_category_weight][<?php echo $category_count ?>]" id="training_revalida-weight" value="<?= $category_data['revalida_category_weight'] ?>" placeholder="Enter Weight" />              
	            </div>  
	        </div>

			<div class="col-md-3"></div>
    		
			<div class="col-md-7">	
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<th width="20%" style="text-align:center">Item No.</th>
							<th class="hidden-xs" width="20%" style="text-align:center">Description</th>
							<th class="hidden-xs" width="20%" style="text-align:center">Rating Type</th>
							<th class="hidden-xs" width="20%" style="text-align:center">Weight</th>
						</tr>
					</thead>
					<tbody id="form-list">
						<?php

		                    if (count($category_data['items']) > 0):

		                    	$item_count = 0;
		                    	foreach ($category_data['items'] as $item_data):

		                ?>
							<tr>
					    		<td style="text-align:center">
					    		<?php echo $item_data['training_revalida_item_no'];  ?></td>
					    		<td style="text-align:center"><?php echo $item_data['description'];  ?></td>
					    		<td style="text-align:center">
					    		<?php foreach( $item_score_type_list as $item_score_type_info ){ 
					    			if( $item_data['score_type'] == $item_score_type_info['score_type_id'] ){ 
					    				echo $item_score_type_info['score_type'];
					    			} 
					    				
			    				} ?></td>
					    		<td style="text-align:center"><?php echo $item_data['item_weight'];  ?></td>
					    		
					    		
					    	</tr>

						<?php

			                		$item_count++;

			                	endforeach;
			                endif;
			            ?>
					</tbody>
				</table>
			</div>

            	

			 <?php

	            $category_count++;

	            endforeach;
	            endif;
	        ?>
					
		</div>
	</div>			
</div>
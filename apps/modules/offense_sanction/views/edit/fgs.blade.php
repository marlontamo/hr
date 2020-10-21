<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Offense Sanction</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Category</label>
				<div class="col-md-7">
				<?php									                            		
					$db->select('offense_sanction_category_id,offense_sanction_category');
                    $db->order_by('offense_sanction_category', '0');
            		$db->where('deleted', '0');
            		$options = $db->get('partners_offense_sanction_category'); 	                            
            		$partners_offense_sanction_sanction_category_id_options = array('' => 'Select...');
                    foreach($options->result() as $option){
                    	$partners_offense_sanction_sanction_category_id_options[$option->offense_sanction_category_id] = $option->offense_sanction_category;
					} 
				?>							
					<div class="input-group">
						<span class="input-group-addon">
                        <i class="fa fa-list-ul"></i>
                        </span>
                        {{ form_dropdown('partners_offense_sanction[sanction_category_id]',$partners_offense_sanction_sanction_category_id_options, $record['partners_offense_sanction.sanction_category_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_offense_sanction-sanction_category_id"') }}
                    </div> 				
	            </div>
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Level</label>
				<div class="col-md-7"><?php									                            		$db->select('offense_level_id,offense_level');
	                            			                            		$db->order_by('offense_level', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_offense_level'); 	                            $partners_offense_sanction_sanction_level_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_offense_sanction_sanction_level_id_options[$option->offense_level_id] = $option->offense_level;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_offense_sanction[offense_level_id]',$partners_offense_sanction_sanction_level_id_options, $record['partners_offense_sanction.offense_level_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_offense_sanction-sanction_level_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Sanction</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_offense_sanction[sanction]" id="partners_offense_sanction-sanction" placeholder="Enter Sanction" rows="4">{{ $record['partners_offense_sanction.sanction'] }}</textarea> 				</div>	
			</div>	</div>
</div>
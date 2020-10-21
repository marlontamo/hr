<div class="add_more_training_cost">
					<div class="portlet">
					        <div class="portlet-title">
					            <div class="tools">
					                <a class="text-muted delete_training_cost" href="javascript:void(0)" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
					            </div>
					        </div>
					            <div class="portlet-body form">
					                <!-- BEGIN FORM-->
					                <form class="form-horizontal training_cost_form" id="training-cost">
					                    <input type="hidden" name="training_cost[calendar_budget_id][]" />
					                    <!-- <input type="hidden" id="evaluation_template_id" name="evaluation_template_id" value="{{ $evaluation_template_id }}" /> -->
					                    <div class="form-body">
					                        <div class="form-group">
					                            <label class="control-label col-md-3">Training Cost Name <span class="required">*</span></label>
					                            <div class="col-md-7">
					                            	<?php
					                                    $training_cost_options = array('' => 'Select');
					                                    $training_costs = $db->get_where( 'training_source', array('deleted' => 0) );
					                                    foreach( $training_costs->result() as $row )
					                                    {
					                                        $training_cost_options[$row->source_id] =  $row->source;
					                                    }
					                                ?>
					                                <?php echo form_dropdown('training_cost[source_id][]',$training_cost_options, '', 'class="form-control"'); ?>
					                            </div>
					                        </div>

					                        <div class="form-group">
					                            <label class="control-label col-md-3">Remarks</label>
					                            <div class="col-md-7">
					                                <textarea class="form-control" name="training_cost[remarks][]"></textarea>
					                            </div>
					                        </div>
					                        
					                        <div class="form-group">
					                            <label class="control-label col-md-3">Cost</label>
					                            <div class="col-md-7">
					                                <input type="text" class="form-control cost"  name="training_cost[cost][]" data-inputmask="'alias': 'integer', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false">
					                            </div>
					                        </div>

					                        <div class="form-group">
					                            <label class="control-label col-md-3">No. of Pax <span class="required">*</span></label>
					                            <div class="col-md-7">
					                                <input type="text" class="form-control pax"  name="training_cost[pax][]" data-inputmask="'alias': 'integer', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false">
					                            </div>
					                        </div>

					                        <div class="form-group">
					                            <label class="control-label col-md-3">Total </label>
					                            <div class="col-md-7">
					                                <input type="text" class="form-control total"  name="training_cost[total][]" data-inputmask="'alias': 'integer', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false">
					                            </div>
					                        </div>

					                    </div>
					                </form>
					                <!-- END FORM--> 
					            </div>
					        </div>
					</div>
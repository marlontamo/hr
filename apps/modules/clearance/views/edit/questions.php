
							<?php 
							$count = (isset($count) ? $count : 0);
								foreach( $records as $value)
								{
							?>
									<div class="panel panel-info">
										<div class="panel-heading">
											<h3 class="panel-title"><?php echo ++$count.". ".$value['item'] ?>
												<span class="pull-right "><a class="small text-muted" onclick="delete_item($(this))" href="#">Delete</a></span>
											</h3>
											<input type="hidden" name="item[]" value="<?php echo $value['item'] ?>">
											<input type="hidden" name="exit_interview_layout_item_id[]" value="<?php echo $value['exit_interview_layout_item_id'] ?>">
										</div>
										
										<table class="table">
											
											<tr >
												<td class="active"><span class="bold">Answer</td>
												<td><textarea rows="2" class="form-control" name="interview[]"></textarea></td>
											</tr>
											<?php if ($value['wiht_yes_no']) { ?>
												<tr >
													<td class="active"><span class="bold">&nbsp;</td>
													<td>
								                        <div class="form-group">
								                            <div class="col-md-4">                          
								                                <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
								                                    <input type="checkbox" value="1" checked="checked" name="yes_no_tmp[temp]" class="wiht_yes_no-temp" class="dontserializeme toggle"/>
								                                    <input type="hidden" name="yes_no[<?php echo $value['exit_interview_layout_item_id'] ?>]" class="wiht_yes_no" value="1"/>
								                                </div>           
								                            </div>  
								                        </div>	
													</td>
												</tr>	
											<?php 
												} 	
												$this->db->where('deleted',0);
												$this->db->where('exit_interview_layout_item_id',$value['exit_interview_layout_item_id']);
												$result = $this->db->get('partners_clearance_exit_interview_layout_item_sub');
												if ($result && $result->num_rows() > 0){
													$ctr = 1;
													foreach ($result->result() as $row) {
											?>
														<tr >
															<td class="active"><span class="bold">Question <?php echo $ctr ?>.</td>
															<td>
																<?php echo $row->question ?>
																<span class="pull-right "><a class="small text-muted" onclick="delete_sub_question($(this))" href="javascript:void(0)">Delete</a></span>
																<br />
																<textarea rows="2" class="form-control" name="sub_answer[<?php echo $value['exit_interview_layout_item_id'] ?>][<?php echo $row->exit_interview_layout_item_sub_id ?>][]"></textarea>
															</td>
														</tr>				
											<?php
														$ctr++;
													}
												}
											?>																															
										</table>
									</div>
							<?php
								}
							?>

<script language="javascript">
    $(document).ready(function(){
        $('.make-switch').not(".has-switch")['bootstrapSwitch']();

        $('.wiht_yes_no-temp').change(function(){
            if( $(this).is(':checked') ){
                $(this).closest('td').find('.wiht_yes_no').val('1');
            }else{
                $(this).closest('td').find('.wiht_yes_no').val('5');            	
            }
        });
    });
</script>							
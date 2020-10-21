<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Participant Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3">Participant Name</label>
			<div class="col-md-7">
				<input type="text" class="form-control" value="{{ $record['training_revalida.name'] }}" readonly="readonly" /> 
			</div>	
		</div>			
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Session Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<table class="table">
			<thead>
				<tr>
					<th>Start Date</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Instructor</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ date('F d, Y', strtotime($record['training_revalida.start_date'])) }}</td>
					<td>{{ date('H:i a', strtotime($record['training_revalida.start_time'])) }}</td>
					<td>{{ date('H:i a', strtotime($record['training_revalida.end_time'])) }}</td>
					<td>{{ $record['training_revalida.instructor'] }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Feedback Questionnaire</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">	
			<table class="table table-striped table-bordered table-advance table-hover">
		    <tbody>
			<?php 
				if( $revalida_questionnaire_item_count > 0 ){
					$current_score_type = 0;
					$current_revalida_category = 0;
					foreach( $revalida_questionnaire_items as $questionnaire_info ){
						if( $current_revalida_category != $questionnaire_info['training_revalida_category_id'] ){
			?>
				<tr>
			        <th style="vertical-align:middle; text-align:left; font-weight:bold;" colspan="7" class="odd">
			        	<?= $questionnaire_info['revalida_category'] ?>
			        </th>
			    </tr>
				<?php
					$current_score_type = 0;
				 	}

					if( $questionnaire_info['score_type'] == 1 ) { // 5-point scale
						if( $current_score_type == $questionnaire_info['score_type'] ){
							$qi1 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 1.00 ? "checked" : '';
							$qi2 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 2.00 ? "checked" : '';
							$qi3 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 3.00 ? "checked" : '';
							$qi4 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 4.00 ? "checked" : '';
							$qi5 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 5.00 ? "checked" : '';
						?>
							<tr>
					            <td style="text-align:left; vertical-align:top;" colspan="2"><?= $questionnaire_info['description'] ?></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="1" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi1; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="2" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi2; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="3" class="revalida_average" name="revalida_item[<?= $questionnaire_info['feedback_item_id'] ?>]" <?php echo $qi3; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="4" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi4; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi5; ?> /></label></td> 
					        </tr>
						<?php
						}
						else{
						?>
							<tr>
						        <th style="vertical-align:middle; width:40%;" class="odd" colspan="2">
						        </th>
						        <th style="vertical-align:middle; width:12%; text-align:center;" class="odd">
						        	Strongly Agree
						        </th>
						        <th style="vertical-align:middle; width:12%; text-align:center;" class="odd">
						        	Agree
						        </th>
						        <th style="vertical-align:middle; width:12%; text-align:center;" class="odd">
						        	Neutral
						        </th>
						        <th style="vertical-align:middle; width:12%; text-align:center;" class="odd">
						        	Disagree
						        </th>
						        <th style="vertical-align:middle; width:12%; text-align:center;" class="odd">
						        	Strongly Disagree
						        </th>
						    </tr>
						    <?php 
					    		$qi1 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 1.00 ? "checked" : '';
								$qi2 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 2.00 ? "checked" : '';
								$qi3 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 3.00 ? "checked" : '';
								$qi4 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 4.00 ? "checked" : '';
								$qi5 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 5.00 ? "checked" : '';
						    ?>
					    	<tr>
	 							<td style="text-align:left; vertical-align:top;" colspan="2"><?= $questionnaire_info['description'] ?></td>
   					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="1" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi1; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="2" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi2; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="3" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi3; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="4" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi4; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi5; ?> /></label></td> 
				            </tr>
						<?php
						}
					} 
					elseif( $questionnaire_info['score_type'] == 2 ){ // Yes or No
						if( $current_score_type == $questionnaire_info['score_type'] ){

						$yes = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 5.00 ? "checked" : '';
						$no = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 0 ? "checked" : '';
						?>
							<tr>
					            <td style="text-align:left; vertical-align:top;" colspan="2"><?= $questionnaire_info['description'] ?></td>
					            <td style="text-align:left;"><input type="radio" value="5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $yes; ?>/>Yes</td>
					            <td style="text-align:left;" colspan="5"><input type="radio" value="0" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php $no; ?>/>No</td>
					        </tr>
						<?php
						}
						else{
						?>
							<tr>
						        <th style="vertical-align:middle; width:100%;" colspan="7" class="odd"></th>
						    </tr>
					    <?php 
					    $yes = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 5.00 ? "checked" : '';
						$no = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 0 ? "checked" : '';
					    ?>
					    	<tr>
					            <td style="text-align:left; vertical-align:top;" colspan="2"><?= $questionnaire_info['description'] ?></td>
					            <td style="text-align:left;"><input type="radio" value="5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $yes; ?>/>Yes</td>
					            <td style="text-align:left;" colspan="5"><input type="radio" value="0" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php $no; ?>/>No</td>
					        </tr>
					    <?php
						}
					}
					elseif( $questionnaire_info['score_type'] == 3 ){ // Essay
						if( $current_score_type == $questionnaire_info['score_type'] ){
						?>
							<tr>
					            <td style="text-align:left; vertical-align:top;"><?= $questionnaire_info['description'] ?></td>
					            <?php $questionnaire_info_remarks = isset($questionnaire_info['remarks'])  ? $questionnaire_info['remarks'] : ''; ?>
					            <td style="text-align:left;" colspan="6"><textarea class="form-control" style="width:100%;" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]"><?php echo $questionnaire_info_remarks; ?></textarea></td>
					        </tr>
						<?php
						}
						else{
						?>
							<tr>
						        <th style="vertical-align:middle; width:100%;" colspan="7" class="odd"></th>
						    </tr>
					    	<tr>
					            <td style="text-align:left; vertical-align:top;"><?= $questionnaire_info['description'] ?></td>
					            <?php $questionnaire_info_remarks = isset($questionnaire_info['remarks'])  ? $questionnaire_info['remarks'] : ''; ?>
					            <td style="text-align:left;" colspan="6"><textarea class="form-control" style="width:100%;" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]"><?php echo $questionnaire_info_remarks; ?></textarea></td>
					        </tr>
						<?php
						}
					}
					elseif( $questionnaire_info['score_type'] == 4 ){ // 6-point scale
						if( $current_score_type == $questionnaire_info['score_type'] ){
							$qi0 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 0.00 ? "checked" : '';
							$qi1 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 1.00 ? "checked" : '';
							$qi2 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 2.00 ? "checked" : '';
							$qi3 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 3.00 ? "checked" : '';
							$qi4 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 4.00 ? "checked" : '';
							$qi5 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 5.00 ? "checked" : '';
						?>
							<tr>
					            <td style="text-align:left; vertical-align:top;"><?= $questionnaire_info['description'] ?></td>  
					        	<td style="text-align:center;"><label class="radio-inline"><input type="radio" value="1" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi0; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="1" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi1; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="2" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi2; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="3" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi3; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="4" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi4; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['training_revalida_item_id'] ?>]" <?php echo $qi5; ?> /></label></td> 
					        </tr>
						<?php
						}
						else{
						?>
							<tr>
						        <th style="vertical-align:middle; width:40%;" class="odd">
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Not Much
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Basic
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Average
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Good
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Very Good
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Excellent
						        </th>
						    </tr>
						    <?php 
						    $qi0 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 0.00 ? "checked" : '';
							$qi1 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 1.00 ? "checked" : '';
							$qi2 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 2.00 ? "checked" : '';
							$qi3 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 3.00 ? "checked" : '';
							$qi4 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 4.00 ? "checked" : '';
							$qi5 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 5.00 ? "checked" : '';
						    ?>
					    	<tr>
					            <td style="text-align:left; vertical-align:top;"><?= $questionnaire_info['description'] ?></td>
								<td style="text-align:center;"><label class="radio-inline"><input type="radio" value="1" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi0; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="1" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi1; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="2" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi2; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="3" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi3; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="4" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi4; ?> /></label></td>
					            <td style="text-align:center;"><label class="radio-inline"><input type="radio" value="5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi5; ?> /></label></td>  
					        </tr>
						<?php
						}
					}
					elseif( $questionnaire_info['score_type'] == 5 ){ // 4-point scale
						if( $current_score_type == $questionnaire_info['score_type'] ){

						$qi1 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 1.25 ? "checked" : '';
						$qi2 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 2.5 ? "checked" : '';
						$qi3 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 3.75 ? "checked" : '';
						$qi4 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 5 ? "checked" : '';
						?>
							<tr>
					            <td style="text-align:left; vertical-align:top;" colspan="3"><?= $questionnaire_info['revalida_item'] ?></td>
					            <td style="text-align:center;"><input type="radio" value="1.25" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi1; ?> /></td>
					            <td style="text-align:center;"><input type="radio" value="2.5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi2; ?>/></td>
					            <td style="text-align:center;"><input type="radio" value="3.75" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi3; ?>/></td>
					            <td style="text-align:center;"><input type="radio" value="5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi4; ?>/></td>
					        </tr>
						<?php
						}
						else{
						?>
							<tr>
						        <th style="vertical-align:middle; width:40%;" class="odd" colspan="3">
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Unsatisfactory
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Needs improvement
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Meets requirements
						        </th>
						        <th style="vertical-align:middle; width:12%;" class="odd">
						        	Excellent
						        </th>
						    </tr>
						    <?php 
						    $qi1 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 1.25 ? "checked" : '';
							$qi2 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 2.5 ? "checked" : '';
							$qi3 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 3.75 ? "checked" : '';
							$qi4 = isset($questionnaire_info['score']) && $questionnaire_info['score'] == 5 ? "checked" : '';
						    ?>
					    	<tr>
	 							<td style="text-align:left; vertical-align:top;" colspan="3"><?= $questionnaire_info['revalida_item'] ?></td>
					            <td style="text-align:center;"><input type="radio" value="1.25" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi1; ?> /></td>
					            <td style="text-align:center;"><input type="radio" value="2.5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi2; ?>/></td>
					            <td style="text-align:center;"><input type="radio" value="3.75" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi3; ?>/></td>
					            <td style="text-align:center;"><input type="radio" value="5" class="revalida_average" name="revalida_item[<?= $questionnaire_info['revalida_item_id'] ?>]" <?php echo $qi4; ?>/></td>
					        </tr>
						<?php
						}
					} 
					$current_score_type = $questionnaire_info['score_type'];
					$current_revalida_category = $questionnaire_info['training_revalida_category_id'];
					}
				}
			?>
		    </tbody>
		</table>
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Total Score</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="training_revalida[total_score]" id="training_library-library" value="{{ $record['training_revalida.total_score'] }}" placeholder="Enter  Total Score" /> 
				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Average Score</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="training_revalida[average_score]" id="training_library-library" value="{{ $record['training_revalida.average_score'] }}" placeholder="Enter Average Score" /> 
				</div>	
			</div>
		</div>
</div>
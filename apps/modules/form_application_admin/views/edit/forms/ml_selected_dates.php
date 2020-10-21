<?php 
if(count($selected_dates['dates']) > 0 ){
	$countSelectedDates = 0;
	foreach ($selected_dates['dates'] as $index => $value){

		$array_keys = array_keys($value);
		$array_values = array_values($value);
		?>
		<span style="display:block; word-wrap:break-word;" class="<?php if( $countSelectedDates > 4 ) echo 'hidden'; ?> toggle-<?php echo $countSelectedDates; ?>">
			<?php echo $index; ?> 
			<span class="small"> - <?php echo $array_keys[0]; ?> :
			</span>
			<span class="text-info">
				<?php 
				foreach( $selected_dates['duration'] as $duration_info ){
					if( $duration_info['duration_id'] == $array_values[0] ){
						echo $duration_info['duration'];
					}
				}
				?>
			</span>
		</span>
		<?php if( ($countSelectedDates+1) % 5 == 0 && $countSelectedDates > 1 && (($countSelectedDates+1) < count($selected_dates['dates'])) ){ ?>
		<span class="<?php if( $countSelectedDates != 4 ) echo 'hidden'; ?> toggler-<?php echo $countSelectedDates; ?>" style="display:block; word-wrap:break-word;">
			<span class="btn btn-xs blue btn-border-radius" onclick="selectedDates_showmore(<?php echo $countSelectedDates; ?>)"> see more <i class="fa fa-arrow-circle-o-right"></i> 
			</span>
		</span>						            		
		<?php 
		}
	$countSelectedDates++;
	}
}
?>
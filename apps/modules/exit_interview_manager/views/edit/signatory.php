<?php 
	$count = 0;
	foreach( $records as $value)
	{
?>			
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo ++$count.". ".$value['item'] ?>
					<span class="pull-right "><a class="small text-muted" onclick="delete_signatories(<?php echo $value['exit_interview_layout_item_id']?>)" href="javascript:void(0)">Delete</a></span>
					<span class="pull-right "><a class="small text-muted"> &nbsp;|&nbsp; </a></span>
					<span class="pull-right "><a class="small text-muted"  onclick="add_sign(<?php echo $value['exit_interview_layout_item_id']?>)" href="javascript:void(0)">Edit</a></span>
					<span class="pull-right "><a class="small text-muted"> &nbsp;|&nbsp; </a></span>
					<span class="pull-right "><a class="small text-muted"  onclick="add_sign_sub(<?php echo $value['exit_interview_layout_item_id']?>)" href="javascript:void(0)">Add Sub Question</a></span>
				</h3>
			</div>
			
			<table class="table">
				
				<tr >
					<td class="active"><span class="bold">Answer</td>
					<td><textarea rows="2" class="form-control"></textarea></td>
				</tr>
				<tr >
					<td class="active"><span class="bold">With Yes / No</td>
					<td><?php echo ($value['wiht_yes_no'] == 1 ? 'Yes' : 'No') ?></td>
				</tr>
				<?php
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
									<span class="pull-right "><a class="small text-muted" onclick="delete_sub_question(<?php echo $row->exit_interview_layout_item_sub_id?>)" href="javascript:void(0)">Delete</a></span>
									<span class="pull-right "><a class="small text-muted"> &nbsp;|&nbsp; </a></span>
									<span class="pull-right "><a class="small text-muted"  onclick="add_sign_sub(<?php echo $value['exit_interview_layout_item_id']?>,<?php echo $row->exit_interview_layout_item_sub_id ?>)" href="javascript:void(0)">Edit Sub Question</a></span>									
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
        $('select.select2me').select2();
    });
</script>
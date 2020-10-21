<?php 
	$count = 0;
	foreach( $records as $value)
	{
?>			
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo ++$count.". ".$value['item'] ?>
					<!-- <span class="pull-right "><a class="small text-muted" onclick="delete_signatories(<?php echo $value['exit_interview_layout_item_id']?>)" href="#">Delete</a></span>
					<span class="pull-right "><a class="small text-muted"> &nbsp;|&nbsp; </a></span>
					<span class="pull-right "><a class="small text-muted"  onclick="add_sign(<?php echo $value['exit_interview_layout_item_id']?>)" href="#">Edit</a></span> -->
				</h3>
			</div>
			
			<table class="table">
				
				<tr >
					<td class="active"><span class="bold">Remarks</td>
					<td><textarea disabled="disabled" rows="2" class="form-control"></textarea></td>
				</tr>
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
<?php
foreach( $companies as $company ): ?>
	<tr>
		<td>
			<a class="text-success"><?php echo  $company->company ?></a><br>
			<span class="small text-muted"><?php echo  $company->company_code ?></span>
		</td>
		<td>
			<div class="btn-group">
				<a class="btn btn-xs text-muted" href="javascript:edit_company(<?php echo  $company->company_id ?>)" ><i class="fa fa-pencil"></i> Edit</a>
				<a class="btn btn-xs text-muted" href="javascript:delete_company(<?php echo  $company->company_id ?>)"><i class="fa fa-trash-o"></i> Delete</a></a>
			</div>
		</td>	
	</tr> <?php
endforeach; ?>
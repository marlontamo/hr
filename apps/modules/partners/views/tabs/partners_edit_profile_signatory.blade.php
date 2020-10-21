<div class="tab-content col-md-12">
	<div class="row">
		<div class="col-md-12 margin-bottom-10">
			<button class="btn btn-md label-success" onclick="assign_all('user', {{ $record['users_profile.company_id'] }}, {{ $record['users_profile.department_id'] }}, {{ $record['users_profile.position_id'] }}, {{ $record['record_id'] }})">Assign All</button>
		</div>
	</div>
	@foreach($signatory['class'] as $category => $categories)
		<div class="row">
			<div class="col-md-12 margin-bottom-10">
				<strong>{{ $category }}</strong>
			</div>
			@foreach($categories as $class_id => $class)
			<div class="row">
				<div class="col-md-3 margin-left-20 margin-bottom-50" >
					<h5>{{ $class }}</h5>
				</div>
				<div class="col-md-2 margin-bottom-50">
					<h5>(1) User <i class="fa fa-arrow-right"></i></h5>
					
					<?php $user_signatories = $signatory_model->get_user_signatories( $class_id, $record['record_id'], $record['users_profile.position_id'], $record['users_profile.department_id'], $record['users_profile.company_id']); 
					?>
					@if($user_signatories)
						@foreach($user_signatories as $user_signatory)
							<div class="small">
								<p>{{ $user_signatory->alias }} <br><span class="italic text-success">({{ $user_signatory->sequence }}-{{ $user_signatory->condition }})</span></a>
							</div>
						@endforeach
					@else
						<div class="small"> - </div>
					@endif
					<br/>
					<div class="">
						<button class="btn btn-sm label-success" onclick="edit_signatory({{ $class_id }}, 'user', {{ $record['users_profile.company_id'] }}, {{ $record['users_profile.department_id'] }}, {{ $record['users_profile.position_id'] }}, {{ $record['record_id'] }})">Assign</button>
					</div>
				</div>
				<div class="col-md-2 margin-bottom-50">
					<h5>(2) Position <i class="fa fa-arrow-right"></i></h5>
					<?php $position_signatories = $signatory_model->get_position_signatories( $class_id, $record['users_profile.position_id'], $record['users_profile.department_id'], $record['users_profile.company_id']); 
					?>
					@if($position_signatories)
						@foreach($position_signatories as $position_signatory)
							<div class="small">
								{{ $position_signatory->alias }} <br><span class="italic text-success">({{ $position_signatory->sequence }}-{{ $position_signatory->condition }})</span>
							</div>
						@endforeach
					@else
						<div class="small"> - </div>
					@endif
				</div>
				<div class="col-md-2 margin-bottom-50">
					<h5>(3) Department <i class="fa fa-arrow-right"></i></h5>
					<?php $department_signatories = $signatory_model->get_department_signatories( $class_id,  $record['users_profile.department_id'], $record['users_profile.company_id']); 
					?>
					@if($department_signatories)
						@foreach($department_signatories as $department_signatory)
							<div class="small">
								{{ $department_signatory->alias }} <br><span class="italic text-success">({{ $department_signatory->sequence }}-{{ $department_signatory->condition }})</span>
							</div>
						@endforeach
					@else
						<div class="small"> - </div>
					@endif

				</div>
				<div class="col-md-2 margin-bottom-50">
					<h5>(4) Company</h5>
					<?php $company_signatories = $signatory_model->get_company_signatories( $class_id,  $record['users_profile.company_id']); 
					?>
					@if($company_signatories)
						@foreach($company_signatories as $company_signatory)
							<div class="small">
								{{ $company_signatory->alias }} <br><span class="italic text-success">({{ $company_signatory->sequence }}-{{ $company_signatory->condition }})</span>
							</div>
						@endforeach
					@else
						<div class="small"> - </div>
					@endif
				</div>
			</div>
			@endforeach
		</div>
	@endforeach
</div>
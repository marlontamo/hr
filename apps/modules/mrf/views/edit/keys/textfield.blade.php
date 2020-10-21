<div class="form-group">
    <label class="control-label col-md-3">{{ $key->key_label }}</label>
    <div class="col-md-5">
 
    @if( in_array($key->key_code, array('years_of_experience')) )
		<div class="number_spinner">
			<div class="input-group input-small">
				<input type="text" maxlength="3" class="spinner-input form-control" onkeypress="return isNumber(event)" 
				{{ $record['disabled'] }} value="{{ (isset($key->key_value)) ? $key->key_value : '' }} " name="key[{{ $key->key_id }}]"  >
    	
			<div class="spinner-buttons input-group-btn btn-group-vertical">
				<button {{ $record['disabled'] }}  class="btn spinner-up btn-xs blue" type="button">
				<i class="fa fa-angle-up"></i>
				</button>
				<button {{ $record['disabled'] }}  class="btn spinner-down btn-xs blue" type="button">
				<i class="fa fa-angle-down"></i>
				</button>
			</div>
				
			</div>
		</div>
	@else
    	<input type="text" {{ $record['disabled'] }} value="{{ (isset($key->key_value)) ? $key->key_value : '' }} " name="key[{{ $key->key_id }}]" class="form-control">
	@endif
	</div>
</div>
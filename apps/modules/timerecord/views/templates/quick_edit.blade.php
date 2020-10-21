@section('page_styles')
	@include('edit/page_styles')
	@show

	@section('page_content')
		<form class="form-horizontal">
            <input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
            <input type="hidden" id="date" name="date" value="{{ $date }}">
			<div class="modal-body padding-bottom-0">
			 	<div class="form-group">
                    <label class="control-label col-md-4">IN</label>
                    <div class="col-md-5">
                        <div class="input-group bootstrap-timepicker">                                       
                            <input type="text" class="form-control timepicker-default timein" value="{{ $time_in }}" id="time_in" name="time_in">
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">OUT</label>
                    <div class="col-md-5">
                        <div class="input-group bootstrap-timepicker">                                       
                            <input type="text" class="form-control timepicker-default timeout" value="{{ $time_out }}" id="time_out" name="time_out">
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer margin-top-0">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn green btn-primary" data-dismiss="modal" onclick="save_timerecord( $(this).closest('form'), '' )">Save changes</button>
			</div>
		</form>
	@show

	@section('page_plugins')
		@include('edit/page_plugins')
	@show

	@section('page_scripts')
		@include('edit/page_scripts')
        <script>
        $(document).ready(function(){

            $('.timein').timepicker({
                defaultTime: $('#time_in').val()
            });
            $('.timeout').timepicker({
                defaultTime: $('#time_out').val()
            });


        });
        </script>
	@show

	@section('view_js')
		{{ get_edit_js( $mod ) }}
	@show
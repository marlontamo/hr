@extends('layouts.master')

@section('lower-page-action')
	@parent
	<li><a href="{{ $mod->url }}/edit/{{ $record_id }}">Edit {{ $mod->short_name }}</a></li>
@stop

@section('page_content')
	@parent

	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-reorder"></i>{{ $mod->short_name }} Detail</div>
			<div class="tools">
				<a class="reload" href="javascript:;"></a>
				<a class="collapse" href="javascript:;"></a>
			</div>
		</div>
		<div class="portlet-body">
			<div class="tabbable-custom ">
            	@include('detail_tabs')
                
                <form action="#" class="form-horizontal form-bordered">
                <div class="tab-content">
                        @include('detail_fgs')

                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-3 col-md-9">
                                        <a class="btn green" href="module-manager-edit.php"><i class="fa fa-pencil"></i>  {{ lang('common.edit') }}</a>
                                        <a class="btn default" href="module-manager.php"> {{ lang('common.back') }}</a>                              
                                    </div>
                                </div>
                            </div>
                        </div>
            	</div>
                </form>        
           	</div>
		</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->

@stop
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners.other_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal">
            <div class="form-body">
                @if(in_array('height', $partners_keys))
            	<div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.height') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[height]" id="partners_personal-height" value="{{ $height }}" placeholder="Enter Height"/>
                    </div>
                </div>
                @endif
                @if(in_array('weight', $partners_keys))
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">{{ lang('partners.weight') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[weight]" id="partners_personal-weight" value="{{ $weight }}" placeholder="Enter Weight"/>
                    </div>
                </div>
                @endif
                @if(in_array('interests_hobbies', $partners_keys))
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">{{ lang('partners.hobby') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-star"></i></span>
                        <input type="text" class="form-control" name="partners_personal[interests_hobbies]" id="partners_personal-interests_hobbies" value="{{ $interests_hobbies }}" placeholder="Enter Interest and Hobbies"/>
                         </div>
                    </div>
                </div>
                @endif
                @if(in_array('language', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.languages') }}</label>
                    <div class="col-md-5">                                   
                        <input type="text" class="form-control" name="partners_personal[language]" id="partners_personal-language" value="{{ $language }}" placeholder="Enter Languange Known"/>
                    </div>
                </div>
                @endif
                @if(in_array('dialect', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.dialects') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[dialect]" id="partners_personal-dialect" value="{{ $dialect }}" placeholder="Enter Dialects"/>
                    </div>
                </div>
                @endif
                @if(in_array('dependents_count', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.no_dependents') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[dependents_count]" id="partners_personal-dependents_count" value="{{ $dependents_count }}" placeholder="Enter No. of Dependents"/>
                    </div>
                </div>
                @endif
                
            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-3 col-md-8">
                            <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )"><i class="fa fa-check"></i> {{ lang('common.save') }}</button>
                            <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
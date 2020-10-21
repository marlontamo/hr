<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="education-category">{{ lang('partners.character_ref') }}</div>
		<div class="actions">
            <a class="btn btn-default" onclick="add_form('character_references', 'reference')">
                <i class="fa fa-plus"></i>
            </a>
		</div>
	</div>
</div>

<!-- Previous Character reference : start doing the loop-->
<div id="personal_reference">
    <?php $reference_count = count($reference_tab); ?>
    <input type="hidden" name="reference_count" id="reference_count" value="{{ $reference_count }}" />
    <?php 
    $count_reference = 0;
    foreach($reference_tab as $index => $reference){ 
        $count_reference++;
?>
<div class="portlet">
	<div class="portlet-title">
		<!-- <div class="caption" id="education-category">Company Name</div> -->
		<div class="tools">
			<a class="text-muted" id="delete_reference-<?php echo $count_reference;?>" onclick="remove_form(this.id, 'reference', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
			<!-- <a class="collapse pull-right" href="javascript:;"></a> -->
		</div>
	</div>
	<div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
		<!-- START FORM -->	
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.name') }}<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[reference-name][]" id="partners_personal_history-reference-name" 
                        value="<?php echo array_key_exists('reference-name', $reference) ? $reference['reference-name'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.name') }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.occupation') }}</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[reference-occupation][]" id="partners_personal_history-reference-occupation" 
                        value="<?php echo array_key_exists('reference-occupation', $reference) ? $reference['reference-occupation'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.occupation') }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.years_known') }}<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[reference-years-known][]" id="partners_personal_history-reference-years-known" 
                        value="<?php echo array_key_exists('reference-years-known', $reference) ? $reference['reference-years-known'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.years_known') }}"/>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">{{ lang('partners.phone') }}</label>
                    <div class="col-md-6">
                         <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-phone][]" id="partners_personal_history-reference-phone" 
                        value="<?php echo array_key_exists('reference-phone', $reference) ? $reference['reference-phone'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.phone') }} {{ lang('partners.number') }}"/>
                         </div>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">{{ lang('partners.mobile') }}</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-mobile][]" id="partners_personal_history-reference-mobile" 
                        value="<?php echo array_key_exists('reference-mobile', $reference) ? $reference['reference-mobile'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.mobile') }} {{ lang('partners.number') }}"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.address') }}</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-address][]" id="partners_personal_history-reference-address" 
                        value="<?php echo array_key_exists('reference-address', $reference) ? $reference['reference-address'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.address') }}"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.city') }}</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-city][]" id="partners_personal_history-reference-city" 
                        value="<?php echo array_key_exists('reference-city', $reference) ? $reference['reference-city'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.city') }}"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.country') }}</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-country][]" id="partners_personal_history-reference-country" 
                        value="<?php echo array_key_exists('reference-country', $reference) ? $reference['reference-country'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.country') }}"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.zip') }}</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[reference-zipcode][]" id="partners_personal_history-reference-zipcode" 
                        value="<?php echo array_key_exists('reference-zipcode', $reference) ? $reference['reference-zipcode'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('partners.zip') }}"/>
                    </div>
                </div>

			</div>
		</div>
	</div>
</div>
<?php } ?>
</div>
<div class="form-actions fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-offset-3 col-md-8">
                <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )" ><i class="fa fa-check"></i> {{ lang('common.save') }}</button>
                <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>                               
            </div>
        </div>
    </div>
</div>

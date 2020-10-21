<div class="form-group">
	<button type="submit" class="btn green pull-right submit_button hidden" onclick="save_partner( $(this).parents('form') )">
	{{ lang('common.submit') }} <i class="m-icon-swapright m-icon-white"></i>
	</button>   
	<span class="btn blue pull-right nextbutton" onclick="next_back( 'next', $(this).parents('form')  )">
	{{ lang('recruitform.next') }} <i class="m-icon-swapright m-icon-white"></i>
	</span>  &nbsp;
	<span class="btn default pull-right backbutton hidden" onclick="next_back( 'back', $(this).parents('form')  )">
	{{ lang('recruitform.prev') }} <i class="m-icon-swapleft m-icon-black"></i>
	</span>             
</div>
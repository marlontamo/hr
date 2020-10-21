<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Category</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Category</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_category[category]" id="training_category-category" value="{{ $record['training_category.category'] }}" placeholder="Enter Category" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Category Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_category[category_code]" id="training_category-category_code" value="{{ $record['training_category.category_code'] }}" placeholder="Enter Category Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="training_category[description]" id="training_category-description" placeholder="Enter Description" rows="4">{{ $record['training_category.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>
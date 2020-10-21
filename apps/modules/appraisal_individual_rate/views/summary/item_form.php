<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" id="item-form">
                    <input type="hidden" name="item_id" value="{{ $item_id }}" />
                    <input type="hidden" name="parent_id" value="{{ $parent_id }}" />
                    <input type="hidden" name="planning_id" value="{{ $planning_id }}" />
                    <input type="hidden" name="user_id" value="{{ $user_id }}" />
                    <input type="hidden" name="section_column_id" value="{{ $section_column_id }}" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Item <span class="required">*</span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="item" value="{{ $item }}">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="control-label col-md-3">Sequence <span class="required">*</span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="sequence" value="{{ $sequence }}">
                            </div>
                        </div> -->
                    </div>
                </form>
                <!-- END FORM--> 
            </div>
        </div>
    </div>
</div>    
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
    <button type="button" class="btn green btn-sm" onclick="save_item()">Add</button>
</div>
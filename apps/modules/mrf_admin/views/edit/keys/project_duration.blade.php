<div class="form-group">
    <label class="control-label col-md-3">{{ $key->key_label }}</label>
    <?php $value = isset( $key->key_value ) ? $key->key_value : '';?>
    <div class="col-md-5">
        <div class="number_spinner">
            <div class="input-group input-small">
                <input type="text" maxlength="3" class="spinner-input form-control" onkeypress="return isNumber(event)" 
                name="key[{{ $key->key_id }}]" id="recruitment_request-quantity" value="<?php echo $value; ?>"{{ $record['disabled'] }} >
                <div class="spinner-buttons input-group-btn btn-group-vertical">
                    <button class="btn spinner-up btn-xs blue" type="button">
                    <i class="fa fa-angle-up"></i>
                    </button>
                    <button class="btn spinner-down btn-xs blue" type="button">
                    <i class="fa fa-angle-down"></i>
                    </button>
                </div>
            </div> 
        </div>
    </div> 
</div> 
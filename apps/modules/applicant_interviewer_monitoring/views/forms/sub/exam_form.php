<tr class="exam_assessment">
    <!--  shows the exam items -->
    <td>
        <input type="text" class="form-control" maxlength="64" name="exam_name[]" >
    </td>
    <td>
        <div class="input-group date date-picker" data-date-format="MM dd, yyyy">
            <input type="text" size="16" class="form-control" name="date_taken[]">
            <span class="input-group-btn">
            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
    </td>
    <td>
        <input type="text" class="form-control" maxlength="64" name="score[]" >
    </td> 
    <td>
        <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Passed&nbsp;&nbsp;" data-off-label="&nbsp;Failed&nbsp;">
         <input type="checkbox" value="0" checked="checked" class="dontserializeme toggle exam_status"/>
        <input type="hidden" name="status[]" value="1"/>
        </div>
    </td>
    <td>
    <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_exam_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
    </td>
</tr>

<script>
$(document).ready(function(){
    $('.exam_status').change(function(){
        if( $(this).is(':checked') ){
            $(this).parent().next().val(1);
        }
        else{
            $(this).parent().next().val(0);
        }
    });
});
</script>
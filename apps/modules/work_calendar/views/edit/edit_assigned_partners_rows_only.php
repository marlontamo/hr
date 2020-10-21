<?php for($i=0; $i < count( $partners ); $i++){ ?>
<tr rel="0">
    <td>
        <input 
            type="checkbox" 
            name="user_id[<?php echo $i; ?>]"
            id="chk_<?php echo $partners[$i]['user_id']; ?>" 
            class="checkboxes" 
            value="<?php echo $partners[$i]['user_id']; ?>" />
    </td>
    <td>
        <span class="text-success"><?php echo $partners[$i]['display_name']; ?></span>
        <br>
        <a id="date_name" href="#" class="text-muted small">
            <?php echo $partners[$i][ 'id_number']; ?>
        </a>
    </td>
    <td>
        <?php echo $partners[$i][ 'shift']; ?>
    </td>
    <td>
        <select 
            name="shift_id[<?php echo $i; ?>]" 
            id="select_<?php echo $partners[$i]['shift_id']; ?>" 
            data-select-id="<?php echo $partners[$i]['user_id']; ?>" 
            class="form-control selectM3 shiftSelect" 
            data-placeholder="Select...">

            <option value="" selected="selected">--</option>

            <?php for($j=0; $j < count( $shifts ); $j++){ ?>
            <option value="<?php echo $shifts[$j]['shift_id']; ?>">
                <?php echo $shifts[$j][ 'shift']; ?>
            </option>
            <?php } ?>
        </select>
    </td>
</tr>
<?php } ?>


<script type="text/javascript">

    /*! **************************************************
    *   THIS SCRIPT IS NEEDED TO BUT I STILL DON'T 
    *   UNDERSTAND WHY STACKED JQUERY ELEMENTS CREATED
    *   USING AJAX ON THE SECOND LEVEL DOES NOT RECOGNIZE
    *   THIS THUS THIS SCRIPT NEEDS TO BE IN HERE
    *****************************************************/

    $(document).ready(function(){

        $('.shiftSelect').on('change', function(){

            var item_id = $(this).data('select-id');

            if( $(this).val() ){
                $('#chk_' + item_id).parents(".checker").children('span').addClass('checked');
                $('#chk_' + item_id).attr('checked', true);
            }
            else{
                $('#chk_' + item_id).parents(".checker").children('span').removeClass('checked');
                $('#chk_' + item_id).attr('checked', false);
            }            
        });
    });
</script>
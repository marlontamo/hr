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
            <span class="text-success">
                <?php echo $partners[$i]['display_name']; ?>
            </span>
            
            <br>
                                       
            <a id="date_name" href="#" class="text-muted small">
                <?php echo $partners[$i]['id_number']; ?>
            </a>
        </td> 
                                    
        <td>
            <?php echo $partners[$i]['shift']; ?>
        </td>
                                    
        <td>
            <select  
                name="shift_id[<?php echo $i; ?>]" 
                id="select_<?php echo $partners[$i]['shift_id']; ?>"
                data-select-id="<?php echo $partners[$i]['user_id']; ?>"
                class="form-control shiftSelect" 
                data-placeholder="Select...">

                <option value="" selected="selected">--</option>

                <?php for($j=0; $j < count( $shifts ); $j++){ ?>
                    <option value="<?php echo $shifts[$j]['shift_id']; ?>">
                        <?php echo $shifts[$j]['shift']; ?>
                    </option>
                <?php } ?>
            </select>
        </td>
    </tr>
<?php } ?>
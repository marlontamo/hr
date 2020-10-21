<table class="table table-condensed table-striped table-hover">
    <tbody> <?php
        foreach( $signatories as $signatory ): ?>
            <tr rel="0">
                <td width="1%" class="hidden"><input type="text" class="hidden" value="<?php echo $signatory->id?>" /></td>
                <td width="40%">
                    <a id="date_name" href="#" class="text-success"><?php echo $signatory->alias?></a>
                </td>
                <td width="18%" class="hidden-xs" style="text-align: center;">
                    <?php echo $signatory->condition ?>
                </td>
                <td width="18%" class="hidden-xs" style="text-align: center;">
                    <?php echo $signatory->sequence ?>
                </td>
                <td width="24%">
                    <div class="btn-group">
                        <a class="btn btn-xs text-muted" href="javascript: edit_assign_all(<?php echo $signatory->id?>, <?php echo $signatory->class_id?>)"
                                signatory-condition="<?php echo $signatory->condition?>"
                                signatory-sequence="<?php echo $signatory->sequence?>"
                        ><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-xs text-muted" href="javascript: delete_assign_all(<?php echo $signatory->id?>)"><i class="fa fa-trash-o"></i> Delete</a>
                    </div>
                </td>
            </tr><?php
        endforeach; ?>
        <input type="hidden" id="signatories_checking" value="1">
    </tbody>
</table>

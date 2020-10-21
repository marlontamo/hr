<?php
    if ($bi && $bi->num_rows() > 0){
        $bi_header = $bi->row();
    }
?>
<div class="tab-pane active" id="tab_2-2">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Previous Work Related Information
            </div>
            <div class="tools">
                <a class="collapse" href="javascript:;"></a>
            </div>
        </div>
        <div>
            <span class="pull-left">This section manage to add conducted background investigation.</span>
            <span class="pull-right margin-bottom-15"><div class="btn btn-success btn-xs" onclick="add_prev_work_row()">+ Add Previous Work </div></span>
            <br clear="all">
        </div>
        <div class="portlet-body form">
            <!-- START FORM -->
            <form action="#" class="form-horizontal" name="bi-form" id="bi-form">
                <input type="hidden"  name="process_id" value="<?php echo $process_id?>">
                <?php
                    if ($bi && $bi->num_rows() > 0){
                        foreach ($bi->result() as $row) {
                ?>
                            <div class="bi_form_header">
                                <div class="form-bordered">
                                    <h3 class="form-group"></h3>
                                    <span class="pull-right margin-top-15 margin-bottom-15"><div class="btn btn-xs text-muted delete_sched_row"><i class="fa fa-trash-o"></i> Delete</div></span>
                                    <br clear="all">    
                                </div>
                                <div class="form-body">
                                    <div class="portlet">  
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Company</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="company[]" id="company" value="<?php echo $row->company ?>" readonly='readonly'/>
                                            </div>
                                        </div>   
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Department</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="department[]" id="department" value="<?php echo $row->department ?>" readonly='readonly'/>
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Reference Person</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="reference_person[]" id="reference_person" value="<?php echo $row->reference_person ?>"/>
                                            </div>
                                        </div>                                           
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Position</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="position[]" id="company" value="<?php echo $row->position ?>"/>
                                            </div>
                                        </div>     
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Employment Status</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="employment_status[]" id="company" value="<?php echo $row->employment_status ?>"/>
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Date Hired</label>
                                            <div class="col-md-6">
                                                <div class="input-group date date-picker" data-date-format="MM dd, yyyy">
                                                    <input type="text" size="16" class="form-control" name="date_hired[]" value="<?php echo date( 'F d, Y', strtotime($row->date_hired) ) ?>">
                                                    <span class="input-group-btn">
                                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div> 
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Date Resigned</label>
                                            <div class="col-md-6">
                                                <div class="input-group date date-picker" data-date-format="MM dd, yyyy">
                                                    <input type="text" size="16" class="form-control" name="date_resigned[]" value="<?php echo date( 'F d, Y', strtotime($row->date_resigned) ) ?>">
                                                    <span class="input-group-btn">
                                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>                                                
                                            </div>
                                        </div>     
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Reason for Leaving</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="reason_for_leaving[]" id="company" value="<?php echo $row->reason_for_leaving ?>"/>
                                            </div>
                                        </div>                                       
                                        <div class="form-group">
                                            <label class="control-label col-md-9">1. Did s/he handle cash or important matter during his/her stay in the company? </label>
                                            <div class="col-md-3">
                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                    <input type="checkbox" value="0" <?php if( $row->q1 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                    <input type="hidden" name="q1[]" value="<?php echo ( $row->q1 ) ? 1 : 0 ; ?>"/>
                                                </div>
                                            </div>
                                            <br clear="all"/>
                                            <label class="control-label col-md-6" style="padding-right:42px">If yes, was s/he able to handle it properly? </label>
                                            <br clear="all"/>
                                            <div class="col-md-11" style="padding-left:115px">
                                                <input type="text" class="form-control" name="q1_ans[]" id="company" value="<?php echo $row->q1_ans ?>"/>
                                            </div>                            
                                        </div>    
                                        <div class="form-group">
                                            <label class="control-label col-md-6">2. Was s/he involved in any disciplinary action? </label>
                                            <div class="col-md-5">
                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                    <input type="checkbox" value="0" <?php if( $row->q2 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                    <input type="hidden" name="q2[]" value="<?php echo ( $row->q2 ) ? 1 : 0 ; ?>"/>
                                                </div>
                                            </div>                           
                                        </div>  
                                        <div class="form-group">
                                            <label class="control-label col-md-5" style="padding-right:30px">3. Did s/he suffer from any illnes? </label>
                                            <div class="col-md-5">
                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                    <input type="checkbox" value="0" <?php if( $row->q3 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                    <input type="hidden" name="q3[]" value="<?php echo ( $row->q3 ) ? 1 : 0 ; ?>"/>
                                                </div>
                                            </div>                           
                                        </div> 
                                        <h3 style="padding-left:90px"><strong>ATTITUDE TOWARDS WORK</strong></h3>      
                                        <div class="form-group">
                                            <label class="control-label col-md-7" style="padding-right:33px">4. How would you describe his/her attendance record?</label>
                                            <br clear="all"/>
                                            <div class="col-md-11" style="padding-left:115px">
                                                <input type="text" class="form-control" name="q4_ans[]" id="company" value="<?php echo $row->q4_ans ?>"/>
                                            </div>                            
                                        </div>                                                                                                                   
                                        <div class="form-group">
                                            <label class="control-label col-md-9" style="padding-right:20px">5. How would you rate his/her sense of integrity, trustwothiness and honestly?</label>
                                            <div class="col-md-6" style="padding-left:140px">
                                                <div class="radio-list">
                                                    <label class="radio-inline"><input class="form-filter option" type="radio" name="q5[]" id="optionsRadios2" value="Highly" <?php if( $row->q5 == "Highly") echo 'checked="checked"'; ?>  data-form-id="8">Highly</label>
                                                    <label class="radio-inline"><input class="form-filter option" type="radio" name="q5[]" id="optionsRadios2" value="Average" <?php if( $row->q5 == "Average") echo 'checked="checked"'; ?> data-form-id="9">Average</label>
                                                    <label class="radio-inline"><input class="form-filter option" type="radio" name="q5[]" id="optionsRadios2" value="Low" <?php if( $row->q5 == "Low") echo 'checked="checked"'; ?> data-form-id="9">Low</label>
                                                </div>
                                            </div>
                                            <br clear="all"/>
                                            <label class="control-label col-md-3" style="padding-right:67px">Why? </label>
                                            <br clear="all"/>
                                            <div class="col-md-11" style="padding-left:115px">
                                                <input type="text" class="form-control" name="q5_ans[]" id="company" value="<?php echo $row->q5_ans ?>"/>
                                            </div>                               
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-12" style="padding-right:56px">6. How would you describe his/her work performance in terms of quality of output & timeliness of result?</label>
                                            <br clear="all"/>
                                            <div class="col-md-11" style="padding-left:115px">
                                                <input type="text" class="form-control" name="q6_ans[]" id="company" value="<?php echo $row->q6_ans ?>"/>
                                            </div>                            
                                        </div>                         
                                        <h3 style="padding-left:90px"><strong>ATTITUDE TOWARDS SUBORDINATES</strong></h3>      
                                        <div class="form-group">
                                            <label class="control-label col-md-10" style="padding-right:70px">7. How would you describe his/her relationship with subordinates/co-employees?</label>
                                            <br clear="all"/>
                                            <div class="col-md-11" style="padding-left:115px">
                                                <input type="text" class="form-control" name="q7_ans[]" id="company" value="<?php echo $row->q7_ans ?>"/>
                                            </div>                            
                                        </div> 
                                        <h3 style="padding-left:90px"><strong>ATTITUDE TOWARDS COMPANY</strong></h3>      
                                        <div class="form-group">
                                            <label class="control-label col-md-5" style="padding-right:50px">8. Is your company unionized? </label>
                                            <div class="col-md-5">
                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                    <input type="checkbox" value="0" <?php if( $row->q8 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                    <input type="hidden" name="q8[]" value="<?php echo ( $row->q8 ) ? 1 : 0 ; ?>"/>
                                                </div>
                                            </div>                           
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-8" style="padding-right:10px">9. What are some his/her significant contributions to your company?</label>
                                            <br clear="all"/>
                                            <div class="col-md-11" style="padding-left:115px">
                                                <input type="text" class="form-control" name="q9_ans[]" id="company" value="<?php echo $row->q9_ans ?>"/>
                                            </div>                            
                                        </div>  
                                        <div class="form-group">
                                            <label class="control-label col-md-12" style="padding-right:60px">10. To your knowledge, has this person ever been charged administratively or criminally for any offense? </label>
                                            <div class="col-md-4" style="padding-left:115px">
                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                    <input type="checkbox" value="0" <?php if( $row->q10 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                    <input type="hidden" name="q10[]" value="<?php echo ( $row->q10 ) ? 1 : 0 ; ?>"/>
                                                </div>
                                            </div>                           
                                        </div>  
                                        <div class="form-group">
                                            <label class="control-label col-md-8" style="padding-right:15px">11. Wa s/he cleared of accountability after resignation/termination? </label>
                                            <div class="col-md-4">
                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                    <input type="checkbox" value="0" <?php if( $row->q11 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                    <input type="hidden" name="q11[]" value="<?php echo ( $row->q11 ) ? 1 : 0 ; ?>"/>
                                                </div>
                                            </div>                           
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-7" style="padding-right:49px">12. Would you recommend him/her for hiring? why? </label>
                                            <div class="col-md-4">
                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                    <input type="checkbox"  value="0" <?php if( $row->q12 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                    <input type="hidden" name="q12[]" value="<?php echo ( $row->q12 ) ? 1 : 0 ; ?>"/>
                                                </div>
                                            </div>                           
                                        </div>                                                                                                                          
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    }
                ?>
            </form>
        </div>           
    </div>      
</div>

<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm" onclick="print_bi(<?php echo $process_id?>)"><?=lang('common.print_only')?></button>
    <button type="button" data-loading-text="Loading..." onclick="save_bi()" class="demo-loading-btn btn btn-success btn-sm"><?=lang('common.save')?></button>
    <button type="button" onclick="move_to_final_interview(<?php echo $process_id?>)" class="demo-loading-btn btn btn-success btn-sm"><?=lang('applicant_monitoring.move_to_final_interview')?></button>
</div>


<table style="display:none" id="bi-row">
    <tbody>
        <tr class="bi_form">
            <!--  shows the bi items -->
            <td>
                <input type="text" class="form-control" maxlength="64" name="bi_name[]" >
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
                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                 <input type="checkbox" value="0" checked="checked" name="status[temp][]" class="dontserializeme toggle bi_status"/>
                <input type="hidden" name="status[]" value="1"/>
                </div>
            </td>
            <!-- <td>
            <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_bi_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
            </td> -->
        </tr>
    </tbody>
</table>


<script type="text/javascript">
    var bi_form = $('.bi_form').length;
    if( !(bi_form > 1) ){
        $("#no_record_bi").show();
    }

    $('.q').change(function(){
        if( $(this).is(':checked') ){
            $(this).parent().next().val(1);
        }
        else{
            $(this).parent().next().val(0);
        }
    });    
</script>
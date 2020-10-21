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
                    <input type="text" class="form-control" name="company[]" id="company" value=""/>
                </div>
            </div>   
            <div class="form-group">
                <label class="control-label col-md-3">Department</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="department[]" id="department" value=""/>
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-md-3">Reference Person</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="reference_person[]" id="reference_person" value=""/>
                </div>
            </div>            
            <div class="form-group">
                <label class="control-label col-md-3">Position</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="position[]" id="company" value=""/>
                </div>
            </div>     
            <div class="form-group">
                <label class="control-label col-md-3">Employment Status</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="employment_status[]" id="company" value=""/>
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-md-3">Date Hired</label>
                <div class="col-md-6">
                    <div class="input-group date date-picker" data-date-format="MM dd, yyyy">
                        <input type="text" size="16" class="form-control" name="date_hired[]" value="">
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
                        <input type="text" size="16" class="form-control" name="date_resigned[]" value="">
                        <span class="input-group-btn">
                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div> 
                </div>
            </div>     
            <div class="form-group">
                <label class="control-label col-md-3">Reason for Leaving</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="reason_for_leaving[]" id="company" value=""/>
                </div>
            </div>                                       
            <div class="form-group">
                <label class="control-label col-md-9">1. Did s/he handle cash or important matter during his/her stay in the company </label>
                <div class="col-md-3">
                    <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                        <input type="checkbox" value="0" checked="checked" class="dontserializeme toggle q"/>
                        <input type="hidden" name="q1[]" value="1"/>
                    </div>
                </div>
                <br clear="all"/>
                <label class="control-label col-md-6" style="padding-right:42px">If yes, was s/he able to handle it properly </label>
                <br clear="all"/>
                <div class="col-md-11" style="padding-left:115px">
                    <input type="text" class="form-control" name="q1_ans[]" id="company" value=""/>
                </div>                            
            </div>    
            <div class="form-group">
                <label class="control-label col-md-6">2. Was s/he involved in any disciplinary action? </label>
                <div class="col-md-5">
                    <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                        <input type="checkbox" value="0" checked="checked" class="dontserializeme toggle q"/>
                        <input type="hidden" name="q2[]" value="1"/>
                    </div>
                </div>                           
            </div>  
            <div class="form-group">
                <label class="control-label col-md-5" style="padding-right:30px">3. Did s/he suffer from any illnes? </label>
                <div class="col-md-5">
                    <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                        <input type="checkbox" value="0" checked="checked" class="dontserializeme toggle q"/>
                        <input type="hidden" name="q3[]" value="1"/>
                    </div>
                </div>                           
            </div> 
            <h3 style="padding-left:90px"><strong>ATTITUDE TOWARDS WORK</strong></h3>      
            <div class="form-group">
                <label class="control-label col-md-7" style="padding-right:33px">4. How would you describe his/her attendance record?</label>
                <br clear="all"/>
                <div class="col-md-11" style="padding-left:115px">
                    <input type="text" class="form-control" name="q4_ans[]" id="company" value=""/>
                </div>                            
            </div>                                                                                                                   
            <div class="form-group">
                <label class="control-label col-md-9" style="padding-right:20px">5. How would you rate his/her sense of integrity, trustwothiness and honestly?</label>
                <div class="col-md-6" style="padding-left:140px">
                    <div class="radio-list">
                        <label class="radio-inline"><input class="form-filter option" type="radio" name="q5[]" id="optionsRadios2" value="Highly" data-form-id="8">Highly</label>
                        <label class="radio-inline"><input class="form-filter option" type="radio" name="q5[]" id="optionsRadios2" value="Average" data-form-id="9">Average</label>
                        <label class="radio-inline"><input class="form-filter option" type="radio" name="q5[]" id="optionsRadios2" value="Low" data-form-id="9">Low</label>
                    </div>
                </div>
                <br clear="all"/>
                <label class="control-label col-md-3" style="padding-right:67px">Why? </label>
                <br clear="all"/>
                <div class="col-md-11" style="padding-left:115px">
                    <input type="text" class="form-control" name="q5_ans[]" id="company" value=""/>
                </div>                               
            </div>
            <div class="form-group">
                <label class="control-label col-md-12" style="padding-right:56px">6. How would you describe his/her work performance in terms of quality of output & timeliness of result?</label>
                <br clear="all"/>
                <div class="col-md-11" style="padding-left:115px">
                    <input type="text" class="form-control" name="q6_ans[]" id="company" value=""/>
                </div>                            
            </div>                         
            <h3 style="padding-left:90px"><strong>ATTITUDE TOWARDS SUBORDINATES</strong></h3>      
            <div class="form-group">
                <label class="control-label col-md-10" style="padding-right:70px">7. How would you describe his/her relationship with subordinates/co-employees?</label>
                <br clear="all"/>
                <div class="col-md-11" style="padding-left:115px">
                    <input type="text" class="form-control" name="q7_ans[]" id="company" value=""/>
                </div>                            
            </div> 
            <h3 style="padding-left:90px"><strong>ATTITUDE TOWARDS COMPANY</strong></h3>      
            <div class="form-group">
                <label class="control-label col-md-5" style="padding-right:50px">8. Is your company unionized? </label>
                <div class="col-md-5">
                    <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                        <input type="checkbox" value="0" checked="checked" class="dontserializeme toggle q"/>
                        <input type="hidden" name="q8[]" value="1"/>
                    </div>
                </div>                           
            </div>
            <div class="form-group">
                <label class="control-label col-md-8" style="padding-right:10px">9. What are some his/her significant contributions to your company?</label>
                <br clear="all"/>
                <div class="col-md-11" style="padding-left:115px">
                    <input type="text" class="form-control" name="q9_ans[]" id="company" value=""/>
                </div>                            
            </div>  
            <div class="form-group">
                <label class="control-label col-md-12" style="padding-right:60px">10. To your knowledge, has this person ever been charged administratively or criminally for any offense? </label>
                <div class="col-md-4" style="padding-left:115px">
                    <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                        <input type="checkbox" value="0" checked="checked" class="dontserializeme toggle q"/>
                        <input type="hidden" name="q10[]" value="1"/>
                    </div>
                </div>                           
            </div>  
            <div class="form-group">
                <label class="control-label col-md-8" style="padding-right:15px">11. Wa s/he cleared of accountability after resignation/termination? </label>
                <div class="col-md-4">
                    <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                        <input type="checkbox" value="0" checked="checked" class="dontserializeme toggle q"/>
                        <input type="hidden" name="q11[]" value="1"/>
                    </div>
                </div>                           
            </div>
            <div class="form-group">
                <label class="control-label col-md-7" style="padding-right:49px">12. Would you recommend him/her for hiring? why? </label>
                <div class="col-md-4">
                    <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                        <input type="checkbox"  value="0" checked="checked" class="dontserializeme toggle q"/>
                        <input type="hidden" name="q12[]" value="1"/>
                    </div>
                </div>                           
            </div>                                                                                                                          
        </div>
    </div>
</div>

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
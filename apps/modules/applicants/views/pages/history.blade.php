<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-tagsinput/typeahead.js"></script>
<script src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
<link href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css" rel="stylesheet" type="text/css"/>
<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
<link href="{{ theme_path() }}plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<div class="modal fade modal-extra" tabindex="-1" aria-hidden="true"></div>

<div class="modal-body padding-bottom-0">
	<div class="">
		<ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab_schedule">{{ lang('applicant_monitoring.schedule') }}</a></li>
            <li><a data-toggle="tab" href="#tab_interview">{{ lang('applicant_monitoring.interview') }}</a></li>            
            <li><a data-toggle="tab" href="#tab_assessment">Examination</a></li>
            <li><a data-toggle="tab" href="#tab_bi">BI</a></li>
            <li><a data-toggle="tab" href="#tab_jo">{{ lang('applicant_monitoring.jo') }}</a></li>
            <!-- <li><a data-toggle="tab" href="#tab_cs">{{ lang('applicant_monitoring.cs') }}</a></li> -->
            <li><a data-toggle="tab" href="#tab_preemp">{{ lang('applicant_monitoring.preemp') }}</a></li>
        </ul>
        <div class="tab-content margin-top-20" style="min-height:300px;">
            <!-- SCHEDULE -->
        	<div id="tab_schedule" class="tab-pane active">
        		<div class="portlet">
        			<div class="portlet-title">
        				<div class="caption">{{ lang('applicant_monitoring.interview_sched') }}</div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                    </div>
                    <p>{{ lang('applicant_monitoring.note_add_interview') }}</p>
                    <div class="portlet-body form">
                        <div class="form-body">
                            <div class="portlet">
                                <div class="portlet-body" >
                                    <table class="table table-condensed table-striped table-hover" >
                                        <thead>
                                            <tr>
                                                <th width="33%" class="padding-top-bottom-10" >{{ lang('applicant_monitoring.date') }}</th>
                                                <th width="33%" class="padding-top-bottom-10 hidden-xs" >{{ lang('applicant_monitoring.interviewer') }}</th>
                                                <th width="34%" class="padding-top-bottom-10 hidden-xs" >{{ lang('applicant_monitoring.location') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="saved-scheds">
                                            @if( $saved_scheds )
                                                @foreach( $saved_scheds as $sched )
                                                    <tr>
                                                        <td>
                                                            {{ date('M d, Y - h:i a', strtotime($sched->date)) }}
                                                        </td> 
                                                        <td>
                                                            {{ $sched->full_name }}
                                                        </td>
                                                        <td>
                                                            {{ $sched->interview_location }}
                                                        </td>
                                                    </tr> 
                                                @endforeach
                                           @endif
                                         </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer margin-top-0">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">{{ lang('common.close') }}</button>
                </div>
            </div>
            <!-- SCHEDULE -->
            <!-- ASSESSMENT -->
            <div id="tab_assessment" class="tab-pane">
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">Assessment List</div>
                        <div class="tools">
                            <a class="collapse" href="javascript:;"></a>
                        </div>
                    </div>
                    <p>This section manage to add exams and show summary of results.</p>
                    <div class="portlet-body form">
                        <div class="form-body">
                            <div class="portlet">
                                <div class="portlet-body" >
                                    <!-- Table -->
                                    <table class="table table-condensed table-striped table-hover" >
                                        <thead>
                                            <tr>
                                                <th width="25%" class="padding-top-bottom-10" >Exam Name</th>
                                                <th width="25%" class="padding-top-bottom-10" >Date</th>
                                                <th width="25%" class="padding-top-bottom-10 hidden-xs" >Score</th>
                                                <th width="25%" class="padding-top-bottom-10 hidden-xs" >Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="saved-exams">
                                            @if( !empty($exams) )
                                                @foreach( $exams as $exam )
                                            <tr class="exam_assessment">
                                                <!--  shows the exam items -->
                                                <td>{{ $exam['exam_name'] }}</td>
                                                <td>{{ date( 'F d, Y', strtotime($exam['date_taken']) ) }}</td>
                                                <td>{{ $exam['score'] }}</td> 
                                                <td>{{ ( $exam['status_id'] ) ? '<span class="badge badge-success">Passed</span>' : '<span class="badge">Failed</span>'  }}</td>
                                            </tr>                                            
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                     <div id="no_record_exam" class="well" style="display:none">
                                        <p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
                                        <span><p class="small margin-bottom-0">Zero (0) was found. Click Add Exam button to add to exam assessment.</p></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ASSESSMENT -->
            <!-- INTERVIEW -->
            <div id="tab_interview" class="tab-pane">
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">{{ lang('applicant_monitoring.interview_details') }}</div>
                        <div class="tools"><a class="collapse" href="javascript:;"></a></div>
                    </div>
                    <p>{{ lang('applicant_monitoring.note_interview_result') }}</p>
                    <div class="portlet-body form">
                        <div class="form-body">
                            <div class="portlet">
                                <div class="portlet-body" >
                                    <table class="table table-condensed table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="30%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.interviewer')?></th>
                                                <th width="25%" class="padding-top-bottom-10 "><?=lang('applicant_monitoring.date')?></th>
                                                <th width="20%" class="padding-top-bottom-10 "><?=lang('applicant_monitoring.result')?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="saved-interviews">
                                            @if( $saved_scheds )
                                                @foreach( $saved_scheds as $sched )
                                                    <tr>
                                                        <td>{{ $sched->full_name }}<br>
                                                            <span class="small text-muted">{{  $sched->position }}</span>
                                                        </td> 
                                                        <td> {{ date('M-d', strtotime( $sched->date )) }}
                                                            <span class="text-muted small">{{ date('D', strtotime( $sched->date )) }}</span><br>
                                                            <span class="text-muted small">{{ date('Y', strtotime( $sched->date )) }}</span>
                                                        </td>
                                                        <td>
                                                            @if( empty( $sched->result ) )
                                                                <span class="badge badge-warning">Pending</span>
                                                            @else
                                                                <span class="badge {{ $sched->class }}">{{ $sched->result }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a class="btn btn-xs text-muted" href="javascript:view_interview_result({{ $sched->schedule_id }}, '{{ $monitoring_route }}');"><i class="fa fa-search"></i>{{ lang('common.view') }}</a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a class="btn btn-xs text-muted" href="javascript:print_interview(<?php echo $process_id ?>);"><i class="fa fa-print"></i>{{ lang('applicant_monitoring.print') }}</a>
                                                            </div>
                                                        </td>
                                                        </tr> 
                                                    @endforeach
                                                @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- INTERVIEW -->
            <!-- BI -->
            <div id="tab_bi" class="tab-pane ">
                <?php
                    if ($bi && $bi->num_rows() > 0){
                        $bi_header = $bi->row();
                    }
                    $disabled = "disabled";
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
                            <!-- <span class="pull-right margin-bottom-15"><div class="btn btn-success btn-xs" onclick="add_prev_work_row()">+ Add Previous Work </div></span> -->
                            <br clear="all">
                        </div>
                        <div class="portlet-body form">
                            <!-- START FORM -->
                            <form action="#" class="form-horizontal" name="bi-form" id="bi-form">
                                <?php
                                    if ($bi && $bi->num_rows() > 0){
                                        foreach ($bi->result() as $row) {
                                ?>
                                            <div class="bi_form_header">
                <!--                                 <div class="form-bordered">
                                                    <h3 class="form-group"></h3>
                                                    <span class="pull-right margin-top-15 margin-bottom-15"><div class="btn btn-xs text-muted delete_sched_row"><i class="fa fa-trash-o"></i> Delete</div></span>
                                                    <br clear="all">    
                                                </div> -->
                                                <div class="form-body">
                                                    <div class="portlet">  
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Company</label>
                                                            <div class="col-md-6">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="company" id="company" value="<?php echo $row->company ?>" readonly='readonly'/>
                                                            </div>
                                                        </div>   
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Department</label>
                                                            <div class="col-md-6">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="department" id="company" value="<?php echo $row->department ?>" readonly='readonly'/>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Reference Person</label>
                                                            <div class="col-md-6">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="reference_person" id="company" value="<?php echo $row->reference_person ?>"/>
                                                            </div>
                                                        </div>                                           
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Position</label>
                                                            <div class="col-md-6">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="position[]" id="company" value="<?php echo $row->position ?>"/>
                                                            </div>
                                                        </div>     
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Employment Status</label>
                                                            <div class="col-md-6">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="employment_status[]" id="company" value="<?php echo $row->employment_status ?>"/>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Date Hired</label>
                                                            <div class="col-md-6">
                                                                <div class="input-group date date-picker" data-date-format="MM dd, yyyy">
                                                                    <input <?php echo $disabled ?> type="text" size="16" class="form-control" name="date_hired[]" value="<?php echo date( 'F d, Y', strtotime($row->date_hired) ) ?>">
                                                                    <span class="input-group-btn">
                                                                    </span>
                                                                </div> 
                                                            </div>
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Date Resigned</label>
                                                            <div class="col-md-6">
                                                                <div class="input-group date date-picker" data-date-format="MM dd, yyyy">
                                                                    <input <?php echo $disabled ?> type="text" size="16" class="form-control" name="date_resigned[]" value="<?php echo date( 'F d, Y', strtotime($row->date_resigned) ) ?>">
                                                                    <span class="input-group-btn">
                                                                    </span>
                                                                </div>                                                
                                                            </div>
                                                        </div>     
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Reason for Leaving</label>
                                                            <div class="col-md-6">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="reason_for_leaving[]" id="company" value="<?php echo $row->reason_for_leaving ?>"/>
                                                            </div>
                                                        </div>                                       
                                                        <div class="form-group">
                                                            <label class="control-label col-md-9">1. Did s/he handle cash or important matter during his/her stay in the company? </label>
                                                            <div class="col-md-3">
                                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                                    <input <?php echo $disabled ?> type="checkbox" value="0" <?php if( $row->q1 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                                    <input type="hidden" name="q1[]" value="<?php echo ( $row->q1 ) ? 1 : 0 ; ?>"/>
                                                                </div>
                                                            </div>
                                                            <br clear="all"/>
                                                            <label class="control-label col-md-6" style="padding-right:42px">If yes, was s/he able to handle it properly? </label>
                                                            <br clear="all"/>
                                                            <div class="col-md-11" style="padding-left:115px">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="q1_ans[]" id="company" value="<?php echo $row->q1_ans ?>"/>
                                                            </div>                            
                                                        </div>    
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">2. Was s/he involved in any disciplinary action? </label>
                                                            <div class="col-md-5">
                                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                                    <input <?php echo $disabled ?> type="checkbox" value="0" <?php if( $row->q2 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                                    <input type="hidden" name="q2[]" value="<?php echo ( $row->q2 ) ? 1 : 0 ; ?>"/>
                                                                </div>
                                                            </div>                           
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="control-label col-md-5" style="padding-right:30px">3. Did s/he suffer from any illnes? </label>
                                                            <div class="col-md-5">
                                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                                    <input <?php echo $disabled ?> type="checkbox" value="0" <?php if( $row->q3 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                                    <input type="hidden" name="q3[]" value="<?php echo ( $row->q3 ) ? 1 : 0 ; ?>"/>
                                                                </div>
                                                            </div>                           
                                                        </div> 
                                                        <h3 style="padding-left:90px"><strong>ATTITUDE TOWARDS WORK</strong></h3>      
                                                        <div class="form-group">
                                                            <label class="control-label col-md-7" style="padding-right:33px">4. How would you describe his/her attendance record?</label>
                                                            <br clear="all"/>
                                                            <div class="col-md-11" style="padding-left:115px">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="q4_ans[]" id="company" value="<?php echo $row->q4_ans ?>"/>
                                                            </div>                            
                                                        </div>                                                                                                                   
                                                        <div class="form-group">
                                                            <label class="control-label col-md-9" style="padding-right:20px">5. How would you rate his/her sense of integrity, trustwothiness and honestly?</label>
                                                            <div class="col-md-6" style="padding-left:140px">
                                                                <div class="radio-list">
                                                                    <label class="radio-inline"><input <?php echo $disabled ?> class="form-filter option" type="radio" name="q5[]" id="optionsRadios2" value="Highly" <?php if( $row->q5 == "Highly") echo 'checked="checked"'; ?>  data-form-id="8">Highly</label>
                                                                    <label class="radio-inline"><input <?php echo $disabled ?> class="form-filter option" type="radio" name="q5[]" id="optionsRadios2" value="Average" <?php if( $row->q5 == "Average") echo 'checked="checked"'; ?> data-form-id="9">Average</label>
                                                                    <label class="radio-inline"><input <?php echo $disabled ?> class="form-filter option" type="radio" name="q5[]" id="optionsRadios2" value="Low" <?php if( $row->q5 == "Low") echo 'checked="checked"'; ?> data-form-id="9">Low</label>
                                                                </div>
                                                            </div>
                                                            <br clear="all"/>
                                                            <label class="control-label col-md-3" style="padding-right:67px">Why? </label>
                                                            <br clear="all"/>
                                                            <div class="col-md-11" style="padding-left:115px">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="q5_ans[]" id="company" value="<?php echo $row->q5_ans ?>"/>
                                                            </div>                               
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-12" style="padding-right:56px">6. How would you describe his/her work performance in terms of quality of output & timeliness of result?</label>
                                                            <br clear="all"/>
                                                            <div class="col-md-11" style="padding-left:115px">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="q6_ans[]" id="company" value="<?php echo $row->q6_ans ?>"/>
                                                            </div>                            
                                                        </div>                         
                                                        <h3 style="padding-left:90px"><strong>ATTITUDE TOWARDS SUBORDINATES</strong></h3>      
                                                        <div class="form-group">
                                                            <label class="control-label col-md-10" style="padding-right:70px">7. How would you describe his/her relationship with subordinates/co-employees?</label>
                                                            <br clear="all"/>
                                                            <div class="col-md-11" style="padding-left:115px">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="q7_ans[]" id="company" value="<?php echo $row->q7_ans ?>"/>
                                                            </div>                            
                                                        </div> 
                                                        <h3 style="padding-left:90px"><strong>ATTITUDE TOWARDS COMPANY</strong></h3>      
                                                        <div class="form-group">
                                                            <label class="control-label col-md-5" style="padding-right:50px">8. Is your company unionized? </label>
                                                            <div class="col-md-5">
                                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                                    <input <?php echo $disabled ?> type="checkbox" value="0" <?php if( $row->q8 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                                    <input type="hidden" name="q8[]" value="<?php echo ( $row->q8 ) ? 1 : 0 ; ?>"/>
                                                                </div>
                                                            </div>                           
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-8" style="padding-right:10px">9. What are some his/her significant contributions to your company?</label>
                                                            <br clear="all"/>
                                                            <div class="col-md-11" style="padding-left:115px">
                                                                <input <?php echo $disabled ?> type="text" class="form-control" name="q9_ans[]" id="company" value="<?php echo $row->q9_ans ?>"/>
                                                            </div>                            
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="control-label col-md-12" style="padding-right:60px">10. To your knowledge, has this person ever been charged administratively or criminally for any offense? </label>
                                                            <div class="col-md-4" style="padding-left:115px">
                                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                                    <input <?php echo $disabled ?> type="checkbox" value="0" <?php if( $row->q10 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                                    <input type="hidden" name="q10[]" value="<?php echo ( $row->q10 ) ? 1 : 0 ; ?>"/>
                                                                </div>
                                                            </div>                           
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="control-label col-md-8" style="padding-right:15px">11. Wa s/he cleared of accountability after resignation/termination? </label>
                                                            <div class="col-md-4">
                                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                                    <input <?php echo $disabled ?> type="checkbox" value="0" <?php if( $row->q11 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
                                                                    <input type="hidden" name="q11[]" value="<?php echo ( $row->q11 ) ? 1 : 0 ; ?>"/>
                                                                </div>
                                                            </div>                           
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-7" style="padding-right:49px">12. Would you recommend him/her for hiring? why? </label>
                                                            <div class="col-md-4">
                                                                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                                    <input <?php echo $disabled ?> type="checkbox"  value="0" <?php if( $row->q12 ) echo 'checked="checked"'; ?> class="dontserializeme toggle q"/>
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
                    <button type="button" data-dismiss="modal" class="btn btn-info btn-sm" onclick="print_bi(<?php echo $process_id?>)"><i class="fa fa-print"></i><?=lang('common.print_only')?></button>
                <!--     <button <?=$hidden?> type="button" data-loading-text="Loading..." onclick="save_bi()" class="demo-loading-btn btn btn-success btn-sm"><?=lang('common.save')?></button>
                    <button <?=$hidden?> type="button" onclick="move_to_final_interview(<?php echo $process_id?>)" class="demo-loading-btn btn btn-success btn-sm"><?=lang('applicant_monitoring.move_to_final_interview')?></button> -->
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
            </div>
            <!-- BI -->
            <!-- JOBOFFER -->
            <?php
            $disabled = "disabled";
            ?>
            <div id="tab_jo" class="tab-pane">
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">{{ lang('applicant_monitoring.jo_details') }}</div>
                        <div class="tools"><a class="collapse" href="javascript:;"></a></div>
                    </div>
                    <p>{{ lang('applicant_monitoring.note_jo_details') }}</p>
                    <div class="portlet-body form margin-top-25">
                        <form class="form-horizontal" name="jo-form" method="post"> 
                            <input type="hidden" value="<?php echo $process->process_id?>" name="process_id" id="process_id">
                            <input type="hidden" value="<?php echo $recruit->recruit_id?>" name="recruit_id" id="recruit_id">                                                       
                            <div class="row">
                                <div class="col-md-12">                        
                                    <div class="form-group">
                                        <label class="control-label col-md-4"><?=lang('applicant_monitoring.template')?>
                                        </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <?php
                                                    echo form_dropdown('jo[template_id]',$jo_template_options, $template_id, $disabled.' class="form-control select2me template_id" data-placeholder="Select..."');
                                                ?>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info" onclick="print_jo(<?php echo $process->process_id?>)"><i class="fa fa-print"></i> <?=lang('applicant_monitoring.print')?></button>
                                                </span>
                                            </div>
                                            <div class="help-block small">
                                                <?=lang('applicant_monitoring.note_print')?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label class="control-label col-md-4">&nbsp;
                                        </label>                                    
                                        <div class="col-md-8">
                                            <textarea <?php echo $disabled ?> class="wysihtml5 form-control template_val" name="jo[template_value]" placeholder="" rows="6"><?php echo (isset($template_value) ? $template_value : '') ?></textarea>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                             
                                    <div class="form-group">
                                        <label class="control-label col-md-4"><?=lang('applicant_monitoring.reports_to')?>
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <?php
                                                echo form_dropdown('jo[reports_to]',$reports_to_options, $reports_to, $disabled.' class="form-control select2me" data-placeholder="Select..."');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                            <div class="row">
                                <div class="col-md-12">                                  
                                    <div class="form-group">
                                        <label class="control-label col-md-4"><?=lang('applicant_monitoring.employee_status')?>
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <?php
                                                echo form_dropdown('jo[employment_status_id]',$employment_status_options, $employment_status_id, $disabled.' class="form-control select2me" data-placeholder="Select..." id="applicant_status"');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                               
                            <div id="nonregular">
                                <div class="row">
                                    <div class="col-md-12">                                       
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><?=lang('applicant_monitoring.month_no')?>
                                                <!-- <span class="required">*</span> -->
                                            </label>
                                            <div class="col-md-6">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" id="no_months" name="jo[no_months]" <?=$disabled?> value="<?php echo $no_months?>">
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-md-12">                                      
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><?=lang('applicant_monitoring.start_date')?>
                                                <!-- <span class="required">*</span> -->
                                            </label>
                                            <div class="col-md-6">
                                                <div class="input-group input-medium date date-picker" data-date-format="MM dd yyyy">
                                                    <input type="text" name="jo[start_date]" id="jo-start_date" class="form-control" <?=$disabled?> value="<?php echo $start_date?>" >
                                                    <span class="input-group-btn">
                                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-12">                                                                
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><?=lang('applicant_monitoring.end_date')?></label>
                                            <div class="col-md-6">
                                                <div class="input-group input-medium date date-picker" data-date-format="MM dd yyyy">
                                                    <input type="text" name="jo[end_date]" id="jo-end_date"  class="form-control" <?=$disabled?> value="<?php echo $end_date?>" >
                                                    <span class="input-group-btn">
                                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                            <div class="row">
                                <div class="col-md-12">                          
                                    <div class="form-group">
                                        <label class="control-label col-md-4"><?=lang('common.status')?></label>
                                        <div class="col-md-7">
                                            <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Accept&nbsp;&nbsp;" data-off-label="&nbsp;Decline&nbsp;">
                                                <input type="checkbox" <?=$disabled?> value="0" <?php if( $accept_offer ) echo 'checked="checked"'; ?> name="jo[accept_offer][temp]" id="jo-accept_offer-temp" class="dontserializeme toggle"/>
                                                <input type="hidden" name="jo[accept_offer]" id="jo-accept_offer" value="<?php echo ( $accept_offer ) ? 1 : 0 ; ?>"/>
                                            </div> 
                                            <small class="help-block">
                                            <?=lang('applicant_monitoring.note_status')?>
                                            </small>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                 
                                    <div class="form-group declined_blacklisted">
                                        <label class="control-label col-md-4"><?=lang('applicant_monitoring.blacklisted')?></label>
                                        <div class="col-md-7">
                                            <div class="make-switch" data-off="success" data-on="danger" data-on-label="&nbsp;Yes&nbsp;&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                                <input type="checkbox" <?=$disabled?>  value="1" <?php if( $blacklisted ) echo 'checked="checked"'; ?> name="recruitment[blacklisted][temp]" id="recruitment-blacklisted-temp" class="dontserializeme toggle"/>
                                                <input type="hidden" name="recruitment[blacklisted]" id="recruitment-blacklisted" value="<?php echo ( $blacklisted ) ? 1 : 0 ; ?>"/>
                                            </div> 
                                            <small class="help-block">
                                            <?=lang('applicant_monitoring.note_blacklist')?>
                                            </small>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                        </form>
                        
                        <br><br>
                            
                            <!--Compensation and Benefits-->
                            <div class="portlet ">
                                <div class="portlet-title">
                                    <div class="caption">{{ lang('applicant_monitoring.compben') }}</div>
                                </div>                                
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="portlet">
                                            <div class="portlet-body" >
                                                <!-- Table -->
                                                <table class="table table-condensed table-striped table-hover">
                                                    <thead>
                                                        <tr>                                                            
                                                            <th width="30%" class="padding-top-bottom-10" ><?=lang('applicant_monitoring.benefits')?></th>
                                                            <th width="25%" class="padding-top-bottom-10 hidden-xs" ><?=lang('applicant_monitoring.amount')?></th>
                                                            <th width="35%" class="padding-top-bottom-10"><?=lang('applicant_monitoring.mode')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="saved-benefits">
                                                        @foreach( $benefits->result() as $benefit )
                                                            <tr>
                                                                <td>
                                                                    <?php echo form_dropdown('compben[benefit_id]',$cbopt, $benefit->benefit_id, 'disabled class="form-control select2me" data-placeholder="Select..."')?>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" disabled name="compben[amount]" value="<?php echo number_format($benefit->amount, 2, '.', ',')?>" >
                                                                </td>
                                                                <td>
                                                                    <?php echo form_dropdown('compben[rate_id]',$rateopt, $benefit->rate_id, 'disabled class="form-control select2me" data-placeholder="Select..."')?>
                                                                </td>
                                                            </tr>
                                                        @endforeach    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                         <!-- END FORM--> 
                    </div>
                </div>
                <div class="modal-footer margin-top-0">
                    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">{{ lang('common.close') }}</button>
                </div>
            </div>
            <!-- JOBOFFER -->
            <!-- CS -->
<!--              <div id="tab_cs" class="tab-pane">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">Contract Signing</div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;"></a>
                            </div>
                        </div>
                        <p>This section manages contract signing template.</p>

                        <div class="portlet-body form margin-top-25"> -->
                            <!-- BEGIN FORM-->
<!--                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 text-right text-muted">Template : </label>
                                        <div class="col-md-7 col-sm-7"><span >{{  $template_cs }}</span>
                                            <span class="help-block small">
                                                Click button to print template.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 text-right text-muted">Status : </label>
                                        <div class="col-md-7 col-sm-7"><span >{{ ($signing_accepted)  ? '<span class="event-block label label-success">Accepted</span>' : '<span class="event-block label label-default">Decline</span>' }}</span>
                                            <span class="help-block small">The status if the applicant sign or accept the offer.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 text-right text-muted">BlackListed : </label>
                                        <div class="col-md-7 col-sm-7"><span >{{ ($blacklisted)  ? '<span class="event-block label label-danger">Yes</span>' : '<span class="event-block label label-success">No</span>' }}</span>
                                            <span class="help-block small"> Mark as block listed if applicant rejects the offer.</span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                             <!-- END FORM--> 
<!--                         </div>
                    </div>
                    <div class="modal-footer margin-top-0">
                        <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">Close</button>                       
                        <button type="button" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Print</button>                       
                    </div>
                </div> -->
            <!-- CS -->
            <!-- PRE-EMPLOYMENT -->
            <div id="tab_preemp" class="tab-pane">
                <div class="portlet">
                    <div class="portlet-body" >
                        <!-- Table -->
                        <table class="table table-condensed table-striped table-hover" >
                            <thead>
                                <tr>                                        
                                    <th width="47%" class="padding-top-bottom-10" >{{ lang('applicant_monitoring.requirements') }}</th>
                                    <th width="32%" class="padding-top-bottom-10 ">{{ lang('applicant_monitoring.completed') }}</th>
                                    
                                </tr>
                            </thead>
                            <tbody>                     
                                @foreach( $checklist->result() as $list )
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td>{{ $list->checklist  }}</td> 
                                    <td>
                                        @if($list->for_submission == 1)
                                            @if($list->submitted)  
                                             <span ><i class="fa fa-check text-success"></i> {{ lang('applicant_monitoring.done') }}</span>
                                             @else
                                             <span class="badge badge-danger" >No</span>
                                            @endif
                                        @else
                                            <span ><i class="fa fa-check text-success"></i> {{ lang('applicant_monitoring.done') }}</span>
                                        @endif

                                        <small class="help-block small">

                                        <?php if($list->submitted == 1){ 
                                                if(strtotime($list->modified_on)){
                                                    echo date('d M Y h:ia', strtotime($list->modified_on));
                                                }else if(strtotime($list->created_on)){
                                                    echo date('d M Y h:ia', strtotime($list->created_on));
                                                }
                                            }else{
                                                if(strtotime($list->modified_on)){
                                                    echo date('d M Y h:ia', strtotime($list->modified_on));
                                                }
                                            } ?>

                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer margin-top-0 pull-right">
                    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">{{ lang('common.close') }}</button>
                  
                </div>
            </div>
            <!-- PRE-EMPLOYMENT -->

        </div>
	</div>
</div>
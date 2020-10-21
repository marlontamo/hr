<div class="portlet" id="list">
   <div class="dtr-filter">
        <div class="" style="width: 600px; margin-bottom: 10px;">
        	<div class="row">
        		<div class="col-md-7">
        			<div class="input-group">
                        <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                        </span>
                        <select  
                            name="partner-filter" 
                            id="partner-filter"
                            class="form-control select2me input-large"
                            >
                            
                            <option value="">Choose a partner</option>

                            <?php for($j=0; $j < count( $partners ); $j++){ ?>
                                <option value="<?php echo $partners[$j]['partner_id']; ?>">
                                    <?php echo $partners[$j]['partner_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
        			
        		</div>
        		<div class="col-md-4">
        			
                    <div class="input-group">
                        <span class="input-group-addon">
                        <i class="fa fa-list"></i>
                        </span>
                        <select  
                            name="sub-filter" 
                            id="sub-filter"
                            class="form-control select2me input-large">
                            <option value="1">Direct</option>
                            <option value="2">All</option>
                        </select>
                    </div>
        			
        		</div>
        	</div>
        </div>
        <!-- <br>
        <span class="small text-muted margin-bottom-10">
        	Show inclusive date per calendar month
        </span> -->
    </div>
	<div class="portlet-title">
    	<div class="caption" id="date-title">&nbsp;</div>
        <div class="actions margin-bottom-10">
            <a id="previous_month" data-month="{{$prev_month}}" class="text-muted btn btn-default month-nav">
            	<i class="fa fa-chevron-left"></i>
            </a>
            <a id="next_month" data-month="{{$next_month}}" class="text-muted btn btn-default month-nav">
            	<i class="fa fa-chevron-right"></i>
            </a>
        </div>
    </div>

    <div class="portlet-body">
        <!-- Table -->

        <div id="loader" class="text-center" style="display: none;">
		    <img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> Fetching record(s)
		</div>

		<div id="no_record" class="well" style="display:none;">
		    <p class="bold"><i class="fa fa-exclamation-triangle"></i> No record/s found!</p>
		    <span><p class="small margin-bottom-0">No available Time Record/s.</p></span>
		</div>

		<div id="please_choose" class="well">
		    <p class="bold"><i class="fa fa-exclamation-triangle"></i> Select a partner.</p>
		    <span><p class="small margin-bottom-0">To start viewing partner/s DTR you must first choose a partner from the dropdown list.</p></span>
		</div>

		<div id="something_wrong" class="well" style="display:none;">
		    <p class="bold"><i class="fa fa-exclamation-triangle"></i> Oooppss! Something went wrong.</p>
		    <span><p class="small margin-bottom-0">Something has gone wrong. Please reload this page or contact your System Administrator.</p></span>
		</div>

        <table id="list-table" class="table table-condensed table-hover" style="display: none;">
            <thead>
                <tr>
                    <th width="1%" class="hidden-xs">
				        <span data-original-title="Schedules" data-content="List to remind you of your restdays and holidays" data-placement="right" data-trigger="hover" class="popovers">
				            <i class="fa fa-align-justify"></i>
				        </span></th>


                    <th width="1%" class="">
				        <span data-original-title="Reminders" data-content="List of items to remind you of needed application to file for disputes." data-placement="right" data-trigger="hover" class="popovers">
				            <i class="fa fa-bell-o"></i>
				        </span></th>

					<th width="1%" class="">&nbsp;</th>
                    <th width="10%">Date</th>
                    <th width="10%">IN</th>
                    <th width="10%">OUT</th>
                    <th width="1%" class="hidden-xs">&nbsp;</th>
                    <th width="5%">Hours<br />Worked</th>
                    <th width="5%" class="hidden-xs">Late<br /><span class="small text-muted">hr</span></th>
                    <th width="5%" class="hidden-xs">UT<br /><span class="small text-muted">hr</span></th>
                    <th width="5%" class="hidden-xs">OT<br /><span class="small text-muted">hr</span></th>
                    <th width="8%" class="hidden-xs">Actions</th>
                </tr>
            </thead>

            <tbody>
            	
            </tbody>
        </table>

        <!-- End Table -->

        <!-- MODAL -->

            <!-- /. VL: modal -->
            <?php //include "time_form_vl.php" ?>
            <!-- /.modal -->

            <!-- /. SL: modal -->
            <?php //include "time_form_sl.php" ?>
            <!-- /.modal -->

            <!-- /. LWOP: modal -->
            <?php //include "time_form_lwop.php" ?>
            <!-- /.modal -->

            <!-- /. EL: modal -->
            <?php //include "time_form_el.php" ?>
            <!-- /.modal -->

            <!-- /. BL: modal -->
            <?php //include "time_form_bl.php" ?>
            <!-- /.modal -->

            <!-- /. P: modal -->
            <?php //include "time_form_p.php" ?>
            <!-- /.modal -->

            <!-- /. M: modal -->
            <?php //include "time_form_m.php" ?>
            <!-- /.modal -->

            <!-- /. BDAY: modal -->
            <?php //include "time_form_bday.php" ?>
            <!-- /.modal -->

            <!-- /. SPLW: modal -->
            <?php //include "time_form_splw.php" ?>
            <!-- /.modal -->

            <!-- /. BT: modal -->
            <?php //include "time_form_bt.php" ?>
            <!-- /.modal -->

            <!-- /. OT: modal -->
            <?php //include "time_form_ot.php" ?>
            <!-- /.modal -->

            <!-- /. UT: modal -->
            <?php //include "time_form_ut.php" ?>
            <!-- /.modal -->

            <!-- /. DTRP: modal -->
            <?php //include "time_form_dtrp.php" ?>
            <!-- /.modal -->

            <!-- /. CWS: modal -->
            <?php //include "time_form_cws.php" ?>
            <!-- /.modal -->

        <!-- END MODAL -->
    </div>

</div>


		<div class="col-md-2" style="margin-bottom:50px">
			<ul class="ver-inline-menu tabbable">
				<li class="active">
					<a data-toggle="tab" href="#overview_tab1"><i class="fa fa-gear"></i>General</a>
					<span class="after"></span>
				</li>
				<li><a data-toggle="tab" href="#overview_tab2"><i class="fa fa-phone"></i>Contacts</a></li>
				<li><a data-toggle="tab" href="#overview_tab3"><i class="fa fa-user"></i>Personal</a></li>
			</ul>
		</div>
		<div class="tab-content col-md-10" >
			<div class="tab-pane active" id="overview_tab1">
				<!-- Basic Infomation -->
            	<div class="portlet">
					<div class="portlet-title">
						<div class="caption">Basic Information</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                    			<div class="form-group">
                            		<label class="control-label col-md-3">Last Name<span class="required">*</span></label>
									<div class="col-md-5">
	                                    <input type="text" class="form-control input-sm" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" value="<?=$lastname?>">
									</div>
								</div>										
                                <div class="form-group">
                                    <label class="control-label col-md-3">First Name<span class="required">*</span></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" value="<?=$firstname?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Middle Name</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" value="<?=$middlename?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Maiden Name <br><small class="text-muted">(if applicable)</small></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" value="<?=$maidenname?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nick Name</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" value="<?=$nickname?>">
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                        <!-- END FORM--> 
                    </div>
                </div>	
			</div>
			<div class="tab-pane" id="overview_tab2">
				<!-- Contact Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">Personal Contact</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                				<?php foreach($profile_telephones as $telephone){ ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Phone</label>
                                    <div class="col-md-5">
                                         <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" class="form-control" maxlength="16" name="defaultconfig" id="maxlength_defaultconfig" value="<?=$telephone?>">
                                         </div>
                                    </div>
                                </div>
                                <?php } ?>
                    			<?php foreach($profile_mobiles as $mobile){ ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Mobile</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                            <input type="text" class="form-control" maxlength="16" name="defaultconfig" id="maxlength_defaultconfig" value="<?=$mobile?>">
                                         </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Email Address</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            <input type="text" class="form-control" maxlength="16" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Enter Email Address">
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Address</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="fa fa-map-marker"></i>
                                             </span>
                                            <input type="text" class="form-control input-sm" maxlength="128" name="company[address]" id="maxlength_defaultconfig" placeholder="Enter Address">
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">City</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="fa fa-map-marker"></i>
                                             </span> 
                                            <input type="text" class="form-control input-sm" maxlength="32" name="company[city]" id="maxlength_defaultconfig" placeholder="Enter City">
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Country</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="fa fa-map-marker"></i>
                                             </span>
                                            <select  class="form-control select2me input-sm" data-placeholder="Select...">
                                                <option value="HK">Hong Kong</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="PH">Philippines</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Zipcode</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="16" name="company[zipcode]" id="maxlength_defaultconfig" placeholder="Enter Zipcode">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM--> 
                    </div>
                </div>                
            	<div class="portlet">
					<div class="portlet-title">
						<div class="caption">Emergency Contact</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                            	<div class="form-group">
                                    <label class="control-label col-md-3">Name</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Camille Doe ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Relationship</label>
                                    <div class="col-md-5">
                                       <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="fa fa-group"></i>
                                             </span>
                                            <select  class="form-control select2me input-sm" data-placeholder="Select...">
                                            	<option>Father</option>
                                                <option>Mother</option>
                                                <option>Sister</option>
                                                <option>Brother</option>
                                                <option>Daughter</option>
                                                <option>Son</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Phone</label>
                                    <div class="col-md-5">
                                         <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" class="form-control input-sm" maxlength="16" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Enter Telephone Number">
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Mobile</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                            <input type="text" class="form-control input-sm" maxlength="16" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Enter Mobile Number">
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Address</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="fa fa-map-marker"></i>
                                             </span>
                                            <input type="text" class="form-control input-sm" maxlength="128" name="company[address]" id="maxlength_defaultconfig" placeholder="Enter Address">
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">City</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="fa fa-map-marker"></i>
                                             </span>
                                            <input type="text" class="form-control input-sm" maxlength="32" name="company[city]" id="maxlength_defaultconfig" placeholder="Enter City">
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Country</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="fa fa-map-marker"></i>
                                             </span>
                                            <select  class="form-control select2me input-sm" data-placeholder="Select...">
                                                <option value="HK">Hong Kong</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="PH">Philippines</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Zipcode</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="16" name="company[zipcode]" id="maxlength_defaultconfig" placeholder="Enter Zipcode">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-actions fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button class="btn green btn-sm" type="button"><i class="fa fa-check"></i> Save</button>
                                            <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> Reset</button>                               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM--> 
                    </div>
                </div>
			</div>
			<div class="tab-pane" id="overview_tab3">
				<!-- Personal Information -->				
            	<div class="portlet">
					<div class="portlet-title">
						<div class="caption">Personal Info</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>

                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Gender<span class="required">*</span></label>
                                    <div class="col-md-5">
                                       <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="fa fa-user"></i>
                                             </span>
                                            <select  class="form-control select2me input-sm" data-placeholder="Select...">
                                            	<option><?php echo lang('common.female') ?></option>
                                                <option><?php echo lang('common.male') ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Birthday</label>
                                    <div class="col-md-5">
                                    	<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                            <input type="text" class="form-control" readonly>
                                            <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Place of Birth</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Quezon City ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Religion<span class="required">*</span></label>
                                    <div class="col-md-5">
                                        <select  class="form-control select2me input-sm" data-placeholder="Select...">
                                            <option>Roman Catholic</option>
                                            <option>Iglesia Ni Cristo</option>
                                            <option>Islam</option>
                                            <option>Protestant</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 input-sm">Nationality</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" maxlength="32" name="company[city]" id="maxlength_defaultconfig" placeholder="Filipino">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 input-sm">{{ lang('profile.civil_status') }}</label>
                                    <div class="col-md-5">
                                            <select  class="form-control select2me" data-placeholder="Select...">
                                                <option value="HK">Single</option>
                                                <option value="ID">Married</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                        <!-- END FORM--> 
                    </div>
                </div>
				<!-- Other Personal Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">Other Information</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                            	<div class="form-group"> 
                                    <label class="control-label col-md-3">Height</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Enter Height ">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Weight</label>
                                    <div class="col-md-5">
                                            <input type="text" class="form-control input-sm" maxlength="16" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Enter Weight">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Interest and Hobbies</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-star"></i></span>
                                            <input type="text" class="form-control input-sm" maxlength="16" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Enter Interest and Hobbies">
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Languange Known</label>
                                    <div class="col-md-5">                                                                                    
                                     <input type="text" class="form-control input-sm" maxlength="128" id="maxlength_defaultconfig" placeholder="Enter Languange Known">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Dialect Known</label>
                                    <div class="col-md-5">
                                            <input type="text" class="form-control input-sm" maxlength="32" name="company[city]" id="maxlength_defaultconfig" placeholder="Enter Dialects">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">No. of Dependents</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control input-sm" maxlength="16" name="company[zipcode]" id="maxlength_defaultconfig" placeholder="Enter No. of Dependents">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-actions fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button class="btn green btn-sm" type="button"><i class="fa fa-check"></i> Save</button>
                                            <button class="btn btn-default btn-sm" type="submit"><i class="fa fa-undo"></i> Cancel</button>                               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM--> 
                    </div>
                </div>

			</div>
		</div>



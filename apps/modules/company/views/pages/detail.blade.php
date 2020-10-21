@extends('layouts/master')

@section('page_styles')
    @parent
    @include('detail/page_styles')
@stop

@section('page_content')
    @parent

<div class="row">

    <div class="col-md-9">

    <form method="post" fg_id="1" class="form-horizontal">
        <!-- Edit -->
        <div class="portlet" id="editform" style="display: block;">

            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">{{ lang('company.company_information') }} </div>
                    <div class="tools"><a class="collapse" href="javascript:;"></a></div>
                </div>

                <div class="portlet-body form">

                    <!-- BEGIN FORM-->
                    
                        <input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.company') }}
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="64" name="users_company[company]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_company') }}" value="{{{ $record['users_company.company'] }}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.company_code') }}
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="16" name="users_company[company_code]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_company_code') }}" value="{{{ $record['users_company.company_code'] }}}">
                                    <span class="help-block small">{{ lang('company.m_company_code') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.address') }}
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                                       <i class="fa fa-thumb-tack"></i>
                                                     </span>
                                        <input type="text" disabled="disabled" class="form-control" maxlength="128" name="users_company[address]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_address') }}" value="{{ $record['users_company.address'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.city') }}
                                   <span class="required">*</span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-thumb-tack"></i>
                                        </span>
                                            <?php 
                                                $db->select('city_id,city'); 
                                                $city_options = $db->get('cities'); 
                                                $users_company_city_id_options = array(); 

                                                $users_company_city_id_options[''] = lang('company.select_city');
                                                foreach($city_options->result() as $option) { 
                                                    $users_company_city_id_options[$option->city_id] = $option->city;
                                                } 
                                            ?>

                                            {{ form_dropdown('users_company[city_id]',$users_company_city_id_options, $record['users_company.city_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.country') }}
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-thumb-tack"></i>
                                        </span>

                                            <?php 
                                                $db->select('country_id,short_name'); 
                                                //$db->where('deleted', '0'); 
                                                $options = $db->get('countries'); 
                                                $users_company_country_id_options = array(); 

                                                $users_company_country_id_options[''] = lang('company.select_country');
                                                foreach($options->result() as $option) { 
                                                    $users_company_country_id_options[$option->country_id] = $option->short_name;
                                                } 

                                            ?>

                                            {{ form_dropdown('users_company[country_id]',$users_company_country_id_options, $record['users_company.country_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.zipcode') }}
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="16" name="users_company[zipcode]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_zipcode') }}" value="{{ $record['users_company.zipcode'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.vat_registration') }}</label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="32" name="users_company[vat]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_vat_registration') }}" value="{{ $record['users_company.vat'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.rdo_code') }}</label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="32" name="users_company[rdo]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_rdo_code') }}" value="{{ $record['users_company.rdo'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.sss_number') }}</label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="32" name="users_company[sss]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_sss_number') }}" value="{{ $record['users_company.sss'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">SSS Branch Code</label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="32" name="users_company[sss_branch_code]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_sss_number') }}" value="{{ $record['users_company.sss_branch_code'] }}">
                                </div>
                            </div>             
                            <div class="form-group">
                                <label class="control-label col-md-3">SSS Branch Code Locator</label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="32" name="users_company[sss_branch_code_locator]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_sss_number') }}" value="{{ $record['users_company.sss_branch_code_locator'] }}">
                                </div>
                            </div>                                             
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.pagibig_number') }}</label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="32" name="users_company[hdmf]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_pagibig_number') }}" value="{{ $record['users_company.hdmf'] }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">PAG-IBIG Branch Code</label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="32" name="users_company[hdmf_branch_code]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_sss_number') }}" value="{{ $record['users_company.hdmf_branch_code'] }}">
                                </div>
                            </div>                              
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('company.philhealth_number') }}</label>
                                <div class="col-md-4">
                                    <input type="text" disabled="disabled" class="form-control" maxlength="32" name="users_company[phic]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_philhealth_number') }}" value="{{ $record['users_company.phic'] }}">
                                </div>
                            </div>
                    </div>
            </div>

            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">{{ lang('company.contact_numbers') }}</div>
                    <div class="tools"><a class="collapse" href="javascript:;"></a></div>
                </div>

                <div class="portlet-body form">
                            <!-- <h4 class="form-section">Contact Numbers</h4> -->

                            @if( $record_id )
                                
                                {{-- die('UPDATE') --}}

                                <?php

                                    $db->select('contacts_id, contact_type, contact_no'); 
                                    $db->where('company_id', $record_id);
                                    $db->where('deleted', '0'); 
                                    //$db->group_by('contact_type');
                                    $contacts = $db->get('ww_users_company_contact'); 
                                    $company_contacts = array(); 

                                    foreach($contacts->result() as $option) { 
                                        $company_contacts[] = $option;
                                    } 
                                ?>   


                                <!-- PHONE NUMBERS -->

                                @for($i=0; $i < count($company_contacts); $i++ )   

                                    
                                    @if($company_contacts[$i]->contact_type === 'Phone')

                                        <div id="phone-group-update-{{ $company_contacts[$i]->contacts_id }}" class="form-group hidden-sm hidden-xs">

                                            <label class="control-label col-md-3">{{ lang('company.phone') }}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    <input 
                                                        disabled="disabled"
                                                        type="text" 
                                                        class="form-control" 
                                                        maxlength="16"
                                                        name="users_company_contact[Phone][update][contact_no][{{ $company_contacts[$i]->contacts_id }}]"
                                                        id="com_cm_phone_{{ $company_contacts[$i]->contacts_id }}"
                                                        value="{{ $company_contacts[$i]->contact_no }}" 
                                                        placeholder="{{ lang('company.p_phone') }}">
                                                </div>
                                            </div>
                                            <!-- <span class="hidden-xs hidden-sm">
                                                <a  
                                                    data-target-id="phone-group-update-{{ $company_contacts[$i]->contacts_id }}" 
                                                    data-item-id="{{ $company_contacts[$i]->contacts_id }}"
                                                    class="btn btn-default btn-sm remove" 
                                                    href="#"><i class="fa fa-trash-o"></i>
                                                </a>
                                            </span> -->
                                        </div>
                                    @endif
                                @endfor  

                                    <!-- <div id="phone-group-add-nw1" class="form-group hidden-sm hidden-xs phone">
                                        <label class="control-label col-md-3">{{ lang('company.phone') }}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <input 
                                                    disabled="disabled"
                                                    type="text" 
                                                    class="form-control" 
                                                    maxlength="16"
                                                    name="users_company_contact[Phone][new][contact_no][1]" 
                                                    id="com_cm_phone_1"
                                                    placeholder="{{ lang('company.p_phone') }}">
                                            </div>
                                        </div>
                                        <!-- <span class="hidden-xs hidden-sm">
                                            <a 
                                                data-target-id="phone-group-add-nw1" 
                                                data-contact-type="Phone" 
                                                class="btn btn-default btn-sm create" 
                                                href="#"><i class="fa fa-plus"></i></a>
                                        </span> -->
                                    <!-- </div>  -->


                                <!-- MOBILE AND FAX NUMBERS TO FOLLOW -->

                                <!-- MOBILE NUMBERS --> 
                                @for($i=0; $i < count($company_contacts); $i++ )   

                                    
                                    @if($company_contacts[$i]->contact_type === 'Mobile')

                                        <div id="mobile-group-update-{{ $company_contacts[$i]->contacts_id }}" class="form-group hidden-sm hidden-xs">

                                            <label class="control-label col-md-3">{{ lang('company.mobile') }}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    <input
                                                        disabled="disabled" 
                                                        type="text" 
                                                        class="form-control" 
                                                        maxlength="16"
                                                        name="users_company_contact[Mobile][update][contact_no][{{ $company_contacts[$i]->contacts_id }}]"
                                                        id="com_cm_mobile_{{ $company_contacts[$i]->contacts_id }}"
                                                        value="{{ $company_contacts[$i]->contact_no }}" 
                                                        placeholder="{{ lang('company.p_mobile') }}">
                                                </div>
                                            </div>
                                            <!-- <span class="hidden-xs hidden-sm">
                                                <a  
                                                    data-target-id="mobile-group-update-{{ $company_contacts[$i]->contacts_id }}" 
                                                    data-item-id="{{ $company_contacts[$i]->contacts_id }}"
                                                    class="btn btn-default btn-sm remove" 
                                                    href="#"><i class="fa fa-trash-o"></i>
                                                </a>
                                            </span> -->
                                        </div>
                                    @endif
                                @endfor  

                                    <!-- <div id="mobile-group-add-nw1" class="form-group hidden-sm hidden-xs mobile">
                                        <label class="control-label col-md-3">{{ lang('company.mobile') }}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <input 
                                                    disabled="disabled"
                                                    type="text" 
                                                    class="form-control" 
                                                    maxlength="16"
                                                    name="users_company_contact[Mobile][new][contact_no][1]" 
                                                    id="com_cm_mobile_1"
                                                    placeholder="{{ lang('company.mobile') }}">
                                            </div>
                                        </div>
                                        <!-- <span class="hidden-xs hidden-sm">
                                            <a 
                                                data-target-id="mobile-group-add-nw1" 
                                                data-contact-type="mobile" 
                                                class="btn btn-default btn-sm create" 
                                                href="#"><i class="fa fa-plus"></i></a>
                                        </span> -->
                                    <!-- </div>   -->


                                <!-- FAX NUMBERS --> 
                                @for($i=0; $i < count($company_contacts); $i++ )   

                                    
                                    @if($company_contacts[$i]->contact_type === 'Fax')

                                        <div id="fax-group-update-{{ $company_contacts[$i]->contacts_id }}" class="form-group hidden-sm hidden-xs">

                                            <label class="control-label col-md-3">{{ lang('company.fax_no') }}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    <input 
                                                        disabled="disabled"
                                                        type="text" 
                                                        class="form-control" 
                                                        maxlength="16"
                                                        name="users_company_contact[Fax][update][contact_no][{{ $company_contacts[$i]->contacts_id }}]"
                                                        id="com_cm_fax_{{ $company_contacts[$i]->contacts_id }}"
                                                        value="{{ $company_contacts[$i]->contact_no }}" 
                                                        placeholder="{{ lang('company.p_fax_no') }}">
                                                </div>
                                            </div>
                                            <!-- <span class="hidden-xs hidden-sm">
                                                <a  
                                                    data-target-id="fax-group-update-{{ $company_contacts[$i]->contacts_id }}" 
                                                    data-item-id="{{ $company_contacts[$i]->contacts_id }}"
                                                    class="btn btn-default btn-sm remove" 
                                                    href="#"><i class="fa fa-trash-o"></i>
                                                </a>
                                            </span> -->
                                        </div>
                                    @endif
                                @endfor  

                                    <!-- <div id="fax-group-add-nw1" class="form-group hidden-sm hidden-xs fax">
                                        <label class="control-label col-md-3">{{ lang('company.fax_no') }}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <input 
                                                    disabled="disabled"
                                                    type="text" 
                                                    class="form-control" 
                                                    maxlength="16"
                                                    name="users_company_contact[Fax][new][contact_no][1]" 
                                                    id="com_cm_fax_1"
                                                    placeholder="{{ lang('company.p_fax_no') }}">
                                            </div>
                                        </div>
                                        <!-- <span class="hidden-xs hidden-sm">
                                            <a 
                                                data-target-id="fax-group-add-nw1" 
                                                data-contact-type="fax" 
                                                class="btn btn-default btn-sm create" 
                                                href="#"><i class="fa fa-plus"></i></a>
                                        </span> -->
                                    <!-- </div>   -->                                                                  

                            @else

                                {{-- die('NEW') --}}

                                <!--default view-->
                                    <div id="phone-group-add-nw1" class="form-group hidden-sm hidden-xs phone">
                                        <label class="control-label col-md-3">{{ lang('company.phone') }}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <input
                                                    disabled="disabled" 
                                                    type="text" 
                                                    class="form-control" 
                                                    maxlength="16"
                                                    name="users_company_contact[Phone][new][contact_no][1]" 
                                                    id="com_cm_phone_1"
                                                    placeholder="{{ lang('company.p_phone') }}">
                                            </div>
                                        </div>
                                        <!-- <span class="hidden-xs hidden-sm">
                                            <a 
                                                data-target-id="phone-group-add-nw1" 
                                                data-contact-type="Phone" 
                                                class="btn btn-default btn-sm create" 
                                                href="#"><i class="fa fa-plus"></i></a>
                                        </span> -->
                                    </div>


                                    <div id="mobile-group-add-nw1" class="form-group hidden-sm hidden-xs mobile">
                                        <label class="control-label col-md-3">{{ lang('company.mobile') }}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <input 
                                                    disabled="disabled"
                                                    type="text" 
                                                    class="form-control" 
                                                    maxlength="16"
                                                    name="users_company_contact[Mobile][new][contact_no][1]" 
                                                    id="com_cm_mobile_1"
                                                    placeholder="{{ lang('company.p_mobile') }}">
                                            </div>
                                        </div>
                                        <!-- <span class="hidden-xs hidden-sm">
                                            <a 
                                                data-target-id="mobile-group-add-nw1" 
                                                data-contact-type="mobile" 
                                                class="btn btn-default btn-sm create" 
                                                href="#"><i class="fa fa-plus"></i></a>
                                        </span> -->
                                    </div> 


                                    <div id="fax-group-add-nw1" class="form-group hidden-sm hidden-xs fax">
                                        <label class="control-label col-md-3">{{ lang('company.fax_no') }}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <input 
                                                    disabled="disabled"
                                                    type="text" 
                                                    class="form-control" 
                                                    maxlength="16"
                                                    name="users_company_contact[Fax][new][contact_no][1]" 
                                                    id="com_cm_fax_1"
                                                    placeholder="{{ lang('company.p_fax_no') }}">
                                            </div>
                                        </div>
                                        <!-- <span class="hidden-xs hidden-sm">
                                            <a 
                                                data-target-id="fax-group-add-nw1" 
                                                data-contact-type="fax" 
                                                class="btn btn-default btn-sm create" 
                                                href="#"><i class="fa fa-plus"></i></a>
                                        </span> -->
                                    </div>                                     
                                <!--end default view-->
                            @endif






                        <!--mobile view-->
                            <div class="form-group visible-sm visible-xs">
                                <label class="control-label col-md-3">{{ lang('company.phone') }}</label>
                                <div class="col-md-5">
                                    <div id="">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                        </span>
                                            <input type="text" disabled="disabled" class="form-control" maxlength="16" id="company_contacts[]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_phone') }}">
                                            <!-- <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-trash-o"></i> 
                                                </button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group visible-sm visible-xs">
                                <label class="control-label col-md-3">{{ lang('company.phone2') }}</label>
                                <div class="col-md-5">
                                    <div id="">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                        </span>
                                            <input type="text" disabled="disabled" class="form-control" maxlength="16" id="company_contacts[]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_phone') }}">
                                            <!-- <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-trash-o"></i> 
                                                </button>
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-plus"></i> 
                                                </button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group visible-sm visible-xs">
                                <label class="control-label col-md-3">{{ lang('company.mobile') }}</label>
                                <div class="col-md-5">
                                    <div id="">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                            <i class="fa fa-mobile"></i>
                                                        </span>
                                            <input type="text" disabled="disabled" class="form-control" maxlength="16" id="company_contacts[]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_mobile') }}">
                                            <!-- <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-trash-o"></i> 
                                                </button>
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-plus"></i> 
                                                </button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group visible-sm visible-xs">
                                <label class="control-label col-md-3">{{ lang('company.fax_no') }}</label>
                                <div class="col-md-5">
                                    <div id="">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                            <i class="fa fa-print"></i>
                                                        </span>
                                            <input type="text" disabled="disabled" class="form-control" maxlength="16" id="company_contacts[]" id="maxlength_defaultconfig" placeholder="{{ lang('company.p_fax_no') }}">
                                            <!-- <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-trash-o"></i> 
                                                </button>
                                                <button type="button" class="btn btn-default">
                                                    <i class="fa fa-plus"></i> 
                                                </button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!--end mobile view-->

                </div>
            </div>


            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">{{ lang('company.branding') }}</div>
                    <div class="tools"><a class="collapse" href="javascript:;"></a></div>
                </div>

                <div class="portlet-body form">
                            <!-- <h4 class="form-section">Branding</h4> -->

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('company.logo_header') }}
                                    </label>
                                    <div class="col-md-9">
                                        <div class="fileupload fileupload-new" data-provides="fileupload" id="headerlogo-photo-container">
                                            <div class="fileupload-new thumbnail" style="height: 50px;">

                                            <?php $logo = isset($record['users_company.logo']) ? $record['users_company.logo'] : 'assets/img/no-image.gif'; ?>

                                                <img id="header_logo-img-preview" style="height: 50px;" src="{{ base_url() . $logo }}" alt="Header Logo" />
                                                <input type="hidden" name="users_company[logo]" id="header_logo-image_filename" value="{{ $record['users_company.logo'] }}">
                                                <!-- <input type="hidden" name="header_logo" id="header_logo-image_filename" value=""> -->
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-height: 25px; line-height: 20px;"></div>
                                            <span class="help-block small">
                                                {{ lang('company.note_logo_header') }}
                                            </span>
                                            <!-- <div id="header_logo-photo-container">
                                                <span class="btn default btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" name="files[]" class="default file" id="config-general-header_logo" />
                                                </span>
                                                <a href="#" class="btn red fileupload-exists fileupload-delete" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                            </div> -->
                                        </div>
                                    </div>
                                    <!-- <input type="file" name="favicon" class="default file" id="config-general-favicon" /> -->
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('company.logo_email') }}
                                    </label>
                                    <div class="col-md-9">
                                        <div class="fileupload fileupload-new" data-provides="fileupload" id="printlogo-photo-container">
                                            <div class="fileupload-new thumbnail" style="height: 100px;">

                                            <?php $print_logo = isset($record['users_company.print_logo']) ? $record['users_company.print_logo'] : 'assets/img/no-image.gif'; ?>

                                                <img id="print_logo-img-preview" style="height: 100px;" src="{{ base_url() . $print_logo }}" alt="Print Logo" />
                                                <input type="hidden" name="users_company[print_logo]" id="print_logo-image_filename" value="{{ $record['users_company.print_logo'] }}">
                                                
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-height: 100px; line-height: 20px;"></div>
                                            <span class="help-block small">
                                                {{ lang('company.note_logo_email') }}
                                            </span>
                                            <!-- <div id="print_logo-photo-container">
                                                <span class="btn default btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" name="files[]" class="default file" id="config-general-print_logo" />
                                                </span>
                                                <a href="#" class="btn red fileupload-exists fileupload-delete" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                            </div> -->
                                        </div>
                                    </div>
                                    <!-- <input type="file" name="favicon" class="default file" id="config-general-favicon" /> -->
                                </div>



                </div>
            </div>

            @include('buttons/detail')

                        <!-- <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-3 col-md-9"> -->
                                        <!-- <button class="btn green btn-sm" type="button" onclick="save_fg( $(this).parents('form') )"><i class="fa fa-check"></i> Save</button> -->
                                        <!-- <button 
                                            class="btn green btn-sm" 
                                            type="button" 
                                            onclick="save_record( $(this).closest('form'), '')"><i class="fa fa-check"></i> Save
                                        </button>
                                        <button class="btn blue btn-sm" type="submit" onclick="save_record( $(this).parents('form'), 'new')">Save &amp; Add New</button>
                                        <a href="{{ $mod->url }}" class="btn default btn-sm">Back</a> 
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    <!-- </form> -->
                     <!-- END FORM -->
                <!-- </div> -->
            <!-- </div> -->
        </div>
        </form>
        <!-- End Edit -->
    </div>
    
    
    <!--RIGHT SIDE ACTION BUTTONS-->
    <!-- <div class="col-md-3 visible-lg">
    
        <div class="portlet" id="abId0.45087891281582415">
            <div class="clearfix margin-bottom-20" id="abId0.23150411853566766">
                <div class="input-icon right margin-bottom-10" id="abId0.6490198103711009">
                    <i class="fa fa-search"></i>
                    <input type="text" placeholder="Search..." class="form-control">
                </div>

                <div class="btn-group btn-group-justified">
                    <a class="btn btn-default" id="goadd"><i class="fa fa-plus"></i> Add</a>
                    <a class="btn btn-default" href="#"><i class="fa fa-times"></i> Delete</a>
                </div>
                <div class="btn-group btn-group-justified margin-bottom-10">
                    <a class="btn btn-default" id="trash"><i class="fa fa-trash-o"></i> Trash Bin</a>
                    <a class="btn btn-default" href="admin_user.php"><i class="fa fa-chevron-left"></i> Back</a>
                </div>

            </div>
        </div>
    </div> -->
    <!--END RIGHT SIDE ACTION BUTTONS-->
    
</div>

@stop


@section('page_plugins')
    @parent
    @include('detail/page_plugins')
@stop


@section('page_scripts')
    @parent

    @include('detail/page_scripts')

    <script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
@stop


@section('view_js')
    @parent

    {{ get_edit_js( $mod ) }}

@stop

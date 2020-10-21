<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Attachments <small class="text-muted">view</small></h4>
</div>
<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet" id="bl_container">
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right text-muted">Filename :</span></label>
                                    <div class="col-md-7">
                                        <?php echo array_key_exists('attachment-name', $details) ? $details['attachment-name'] : ""; ?>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right text-muted">Category :</span></label>
                                    <div class="col-md-7">
                                        <?php echo array_key_exists('attachment-category', $details) ? $details['attachment-category'] : ""; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 text-right text-muted">File :</label>
                                    <div class="col-md-7">
                                        <ul class="padding-none margin-top-11">
                                            <?php 
                                                if( array_key_exists('attachment-file', $details) ) {
                                                    $file = FCPATH . urldecode($details['attachment-file']);
                                                    if( file_exists( $file ) )
                                                    {
                                                        $f_info = get_file_info( $file );
                                                        $f_type = filetype( $file );

                                                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                                        $f_type = finfo_file($finfo, $file);
                                                        $is_image = false;
                                                        switch( $f_type )
                                                        {
                                                            case 'image/jpeg':
                                                            case 'image/jpg':
                                                            case 'image/bmp':
                                                            case 'image/png':
                                                            case 'image/gif':
                                                                $icon = 'fa-picture-o';
                                                                $is_image = true;
                                                                break;
                                                            case 'video/mp4':
                                                                $icon = 'fa-film';
                                                                break;
                                                            case 'audio/mpeg':
                                                                $icon = 'fa-volume-up';
                                                                break;
                                                            default:
                                                                $icon = 'fa-file-text-o';
                                                        }

                                                        $filepath = base_url()."partners_immediate/download_file/".$details_data_id['attachment-file'];
                                                        $file_view = base_url().$details['attachment-file'];
                                                        // $path = site_url() . 'uploads/' . $this->module_link . '/' . $file;
                                                        echo '<li class="padding-3 fileupload-delete-'.$details_data_id['attachment-file'].'" style="list-style:none;">';
                                                        if($is_image){
                                                            echo '<img src="'.$file_view.'" class="img-responsive" alt="" />';
                                                        }
                                                        echo '<a href="'.$filepath.'">
                                                            <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
                                                            <span>'. basename($f_info['name']) .'</span>
                                                            </a>
                                                        </li>'
                                                        // <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$details['attachment-file'].'" href="javascript:void(0)"></a></span>
                                                        ;
                                                    }
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                        <!-- END FORM--> 
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
</div>
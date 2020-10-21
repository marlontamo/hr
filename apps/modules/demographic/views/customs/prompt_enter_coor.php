<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4>Update Location</h4>
    <p class="clearfix text-muted small">Click on where your present address is located</p>

</div>
<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" id="update_map" name="update_map">
                    <div class="form-body">
                        
                        <div class="form-group">
                            <div id="plot_map" class="gmaps"></div>
                        </div>

                        <div id='plotted_lat'>
                            <input type="hidden" id="partners-personal_lng" name="partners-personal_lng">
                        </div>

                        <div id='plotted_lng'>
                            <input type="hidden" id="partners-personal_lat" name="partners-personal_lat">
                        </div> 

                    </div>
                </form>
                <!-- END FORM--> 
            </div>
        </div>
    </div>
</div>    
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Skip</button>
    <a type="button" class="btn green btn-sm" onclick="update_map_coor($(this).closest('form'))">Update</a>
</div>

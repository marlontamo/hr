<?php for($i=0; $i < count( $currentday_schedules ); $i++){ ?>
<a href="javascript:;" class="list-group-item small available_scheds" data-shift-id="<?php echo $currentday_schedules[$i]['form_id']; ?>">
    <?php echo $currentday_schedules[$i][ 'title']; ?>
</a>
<?php } ?>
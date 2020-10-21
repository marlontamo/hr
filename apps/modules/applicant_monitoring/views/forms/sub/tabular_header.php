<thead>
<tr>
    <?php
        if($data['other_remarks'] == 1){
    ?>
        <th colspan="2" class="text-center success"><?php echo $data['header_text'] ?></th>
        <th class="text-center success">Other Remarks</th>
    <?php       
        }else{
    ?>
        <th class="text-center success"><?php echo $data['header_text'] ?></th>
        <th class="text-center success">Remarks</th>
    <?php       
        }
    ?>
</tr>
</thead>
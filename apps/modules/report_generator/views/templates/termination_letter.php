<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>
<?php
    //prep data
    $result = $result->result_array();
    $headers = array();
    $template = ''; 

    foreach( $result as $row )
    {
    ?>

<style type="text/css">
	.main {
	  font-family:Arial,Verdana,sans-serif;
	  font-size:1.25em; 
	  color:#000;
	}

	.title {
	  font-size:1.5em; 
	  font-weight:bold;
	}

	.sub-title-bold {
	  font-size:1.25em; 
	  font-weight:bold;
	}

	.text-bold { 
	  font-weight:bold;
	}

	.border {
		border-bottom: 1px solid black;
	}

	.text-align-right{
		text-align: right;
	}

    .text-align-right-bold{
        text-align: right;
        font-weight:bold;
    }	
</style>

   <table class="main">
    	<tr>
    		<td class="title">MEMORANDUM<br/></td>
    	</tr>
    	<tr>
    		<td></td>
    	</tr>
    	<tr>
    		<td></td>
    	</tr>

    	<tr>
    		<td class="sub-title-bold">TO	   :    Mr/s. <?php echo $row['Full Name'] ?><br/></td>
    	</tr>
    	<tr>
    		<td class="sub-title-bold">FROM   :    PERSONNEL DEPARTMENT<br/></td>
    	</tr>
    	<tr>
			<td class="sub-title-bold">DATE	   :   <?php echo date("F d, Y"); ?> <br/></td>
		</tr>
		<tr>
			<td class="sub-title-bold">RE	   :   <u>NOTICE OF TERMINATION</u><br/></td>
		</tr>
		<tr>
    		<td></td>
    	</tr>
		<tr>
    		<td class="border"></td>
    	</tr>
    	<tr>
    		<td></td>
    	</tr>

    	<tr>
    		<td>This is to officially inform you that we are terminating your services as <?php echo $row['Position'] ?> for the <?php echo $row['Project'] ?> effective the close of office hour on <?php echo $row['End Date'] ?> in view of the conclusion of the specific phase of work where you are assigned.</td>
    	</tr>
    	
    	<tr>
    		<td></td>
    	</tr>

    	<tr>
    		<td><?php echo $row['Company'] ?> and its Project Management sincerely thank you for the services you have rendered in the successful completion of this project.</td>
    	</tr>
    	<tr>
    		<td></td>
    	</tr>

    	<tr>
    		<td>Please report to the personnel office once you are notified of this memo and attend to your exit clearance.</td>
    	</tr>
    	<tr>
    		<td></td>
    	</tr>
    	<tr>
    		<td>This will serve as our notice of termination of your employment.</td>
    	</tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>                        
    </table>


<?php }?>



<?php
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>
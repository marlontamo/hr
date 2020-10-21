<?php 
	//prep data
	$user_id = 'User Id';
	$lastname = 'Lastname';
	$firstname = 'Firstname';
	$middlename = 'Middlename';
	$suffix = 'Suffix';
	$project = 'Project';
	$department = 'Department';
	$company = 'Company';
	$birth_date = 'Birth Date';
	$resigned_date = 'Resigned Date';
	$location = 'Location';
	$effectivity_date = 'Effectivity Date';
	$project_name = 'Project Name';
	$position_display = 'Position Display';
	$position = 'Position';
	$birth_place = 'Birth Place';
	$civil_status = 'Civil Status';
?>
<?php foreach($result as $row){
	if( !empty( $header->template ) )
	{
		echo $this->parser->parse_string($header->template, $vars, TRUE);
	}
?>
<table cellspacing="0" cellpadding="1" border="0">
					<tr>
						<td width="100%" align="center"><hr></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td width="100%" align="center"><b>BIO-DATA</b></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width="25%">Name</td>
						<td width="5%">:</td>
						<?php 
							//
							if(!empty($row->$middlename)){
								$middleinitial = ucfirst(substr($row->$middlename,0,1));
							}else{
								$middleinitial = '';
							}
						?>
						<td width="70%"><?php echo $row->$firstname.' '.$middleinitial.' '.$row->$lastname; ?></td>
					</tr>
					<tr>
						<td>Date of Birth</td>
						<td>:</td>
						<td><?php echo $row->$birth_date; ?></td>
					</tr>
					<tr>
						<td>Place of Birth</td>
						<td>:</td>
						<td><?php echo $row->$birth_place; ?></td>
					</tr>
					<tr>
						<td>Civil Status</td>
						<td>:</td>
						<td><?php echo $row->$civil_status; ?></td>
					</tr>
					<tr>
						<td>Educational Attainment</td>
						<td>:</td>
					</tr>
					<tr>
						<td></td>
					</tr>

		<?php foreach($row->education as $education){ ?>

					<tr>
					  	<td width="5%"></td>
					  	<td width="20%"><b><?php echo $education['education-type']; ?></b></td>
					  	<td width="5%">:</td>
					  	<td width="70%"><b><?php echo $education['education-school']; ?></b></td>
					</tr>

					<?php	if(!empty($education['education-degree'])){		?>

								<tr>
									<td width="8%"></td>
									<td width="17%">Degree</td>
									<td width="5%">:</td>
									<td width="70%"><?php echo $education['education-degree']; ?></td>
								</tr>

					<?php   } ?>

					<tr>
						<td width="8%"></td>
						<td width="17%">Status</td>
						<td width="5%">:</td>
						<td width="70%"><?php echo $education['education-status']; ?></td>
					</tr>
					<tr>
						<td width="8%"></td>
						<td width="17%">Period</td>
						<td width="5%">:</td>
						<td width="70%"><?php echo $education['education-year-from']." - " .$education['education-year-to']; ?></td>
					</tr>
					<tr>
						<td></td>
					</tr>
		<?php } ?>

					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width="100%"><b><u>WORK EXPERIENCE</u></b></td>
					</tr>
					<tr>
						<td></td>
					</tr>

					<tr>
						<td width="5%"><b>1.</b></td>
					  	<td width="20%"><b>Company</b></td>
					  	<td width="5%">:</td>
						<td><b><?php echo $row->$company; ?></b></td>
					</tr>
					<tr>
						<td width="30%"></td>
						<td width="70%"><?php echo $row->$location; ?></td>
					</tr>
					<tr>
						<td width="8%"></td>
						<td width="17%">Designation</td>
						<td width="5%">:</td>
						<td width="70%"><?php echo $row->$position_display; ?></td>
					</tr>
					<tr>
						<td width="8%"></td>
						<td width="17%">Period</td>
						<td width="5%">:</td>
						<?php 
							//prepare effectivity_date and resigned_date
							if($row->$effectivity_date == "0000-00-00" || $row->$effectivity_date == ""){ 
								$effectivity = "";
							}else{
								$effectivity = date("F d, Y", strtotime($row->$effectivity_date));
							} 
							
							if($row->$resigned_date == "" || $row->$resigned_date == "0000-00-00"){
								$resign_date = "Present";
							}else{
								$resign_date = date("F d, Y", strtotime($row->$resigned_date));
							}
						?>
						<td width="70%"><?php echo $effectivity." - " .$resign_date; ?></td>
					</tr>
					<tr>
						<td></td>
					</tr>

		<?php 	

		$ctr = 2;
		foreach($row->employment as $employment){

		?>

					<tr>
						<td width="5%"><b><?php echo $ctr; ?></b></td>
					  	<td width="20%"><b>Company</b></td>
					  	<td width="5%">:</td>
					<td><b><?php echo $employment['employment-company']; ?></b></td>
					</tr>
					<tr>
						<td width="30%"></td>
						<td width="70%"><?php echo $employment['employment-location']; ?></td>
					</tr>
					<tr>
						<td width="8%"></td>
						<td width="17%">Designation</td>
						<td width="5%">:</td>
						<td width="70%"><?php echo $employment['employment-position-title']; ?></td>
					</tr>
					<tr>
						<td width="8%"></td>
						<td width="17%">Period</td>
						<td width="5%">:</td>
						<td width="70%"><?php echo $employment['employment-month-hired']. " " .$employment['employment-year-hired']. " - " .$employment['employment-month-end']. " " .$employment['employment-year-end'] ?></td>
					</tr>
					<tr>
						<td></td>
					</tr>
		<?php 

			$ctr++;
		}

		?>

					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width="100%"><b><u>TRAINING AND/OR SEMINARS ATTENDED</u></b></td>
					</tr>
					<tr>
						<td></td>
					</tr>
		<?php 
		foreach($row->training as $training){
		?>
					<tr>
						<td width="4%"></td>
					  	<td width="4%">- </td>
						<td width="92%"><?php echo $training['training-title']; ?></td>
					</tr>
		<?php 
		}
		?>

					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width="100%"><b><u>OTHERS:</u></b></td>
					</tr>
					<tr>
						<td></td>
					</tr>

		<?php 
		if(!empty($row->affiliation_tab)){
		?>
				<tr>
					<td width="5%"></td>
					<td width="95%"><b>Affiliation:</b></td>
				</tr>
		<?php 
		}
		?>

		<?php 
		foreach($row->affiliation as $affiliation){
		?>

					<tr>
						<td width="9%"></td>
					  	<td width="4%">- </td>
						<td width="87%"><?php echo $affiliation['affiliation-name']; ?></td>
					</tr>
		<?php
		}
		?>

		<?php 
		if(!empty($row->licensure)){
		?>
				<tr>
					<td width="5%"></td>
					<td width="95%"><b>Licensure:</b></td>
				</tr>
		<?php
		}
		?>

		<?php 
		foreach($row->licensure as $license){
		?>
					<tr>
						<td width="9%"></td>
					  	<td width="4%">- </td>
						<td width="87%"><?php echo $license['licensure-title']; ?></td>
					</tr>
		<?php
		}
		?>
						
		</table>
<?php 
	if( !empty( $footer->template ) )
	{
		echo $this->parser->parse_string($footer->template, $vars, TRUE);
	}
} 

?>

<?php //foreach ($qry->row() as $value) { 
	$value = $qry->row();
	$reg_company = get_registered_company();
	if(is_array($reg_company)) {
		$value->{'Company'} = (isset($reg_company['registered_company']) && !empty($reg_company['registered_company'])) ? $reg_company['registered_company'] : $value->{'Company'};
		// JULY 1 2016 AS PER RAQUEL other info will base per company
		// $value->{'Tin'} = isset($reg_company['registered_tin']) && !empty($reg_company['registered_tin']) ? $reg_company['registered_tin'] : $value->{'Tin'};
		// $value->{'Address'} = isset($reg_company['registered_address']) && !empty($reg_company['registered_address']) ? $reg_company['registered_address'] : $value->{'Address'};
		// $value->{'Rdo'} = isset($reg_company['registered_rdo']) && !empty($reg_company['registered_rdo']) ? $reg_company['registered_rdo'] : $value->{'Rdo'};
		// $value->{'Zipcode'} = isset($reg_company['registered_zipcode']) && !empty($reg_company['registered_zipcode']) ? $reg_company['registered_zipcode'] : $value->{'Zipcode'};
	}
?>
	<br><br><br>
	<br><br><br>
	<table width="100%" >
		<tr>
			<td width="100%" height="55px;" style="padding-right:10px" align="left" font-size="5">&nbsp;</td>
		</tr>
		<tr>
			<td style="padding-right:10px" align="center" width="19.5%" font-size="5">&nbsp;</td>
		<?php $mo = count($value->{'Month'}) > 1 ? $value->{'Month'} : "0".$value->{'Month'};  
			$yr_mo = array_merge(str_split($mo), str_split($value->{'Year'}));
			if( is_array($yr_mo) && !empty($yr_mo) ) { 
				foreach ($yr_mo as $ym_k => $ym) { ?>
					<td style="padding-right:10px" align="center" width="2.5%" font-size="5"><?php echo $ym; ?></td>
		<?php 	}
		  	}?>
		  	<td width="32.5%" align="center" font-size="5">X</td><!-- Ammended Return set to No -->
		</tr>
		<tr>
			<td width="100%" height="14px;" style="padding-right:10px" align="left" font-size="5">&nbsp;</td>
		</tr>
		<tr>
			<td style="padding-right:10px" align="center" width="7.5%" font-size="5">&nbsp;</td>
		<?php $value->{'Tin'} = str_split(str_pad(str_replace("-","",$value->{'Tin'}), 13, " "));
			if( is_array($value->{'Tin'}) && !empty($value->{'Tin'}) ) { 
				foreach ($value->{'Tin'} as $tin_k => $tin) { 
					if(in_array($tin_k, array(3,6,9))) {?>
						<td style="padding-right:10px" align="center" width="2.25%" font-size="5">&nbsp;</td>
					<?php }?>
					<td style="padding-right:10px" align="center" width="2.25%" font-size="5"><?php echo $tin; ?></td>
		<?php 	} ?>
		<?php }?>
		  	<td width="11%" style="padding-right:10px" align="left" font-size="5">&nbsp;</td>
		<?php 
			$value->{'Rdo'} = str_split(str_pad( $value->{'Rdo'}, 3, " ") );
			if( is_array($value->{'Rdo'}) && !empty($value->{'Rdo'}) ) { 
				foreach ($value->{'Rdo'} as $rdo_k => $rdo) { ?>
					<td style="padding-right:10px" align="center" width="2.25%" font-size="5"><?php echo $rdo; ?></td>
		<?php 	}
			}?>  
			<td width="17%">&nbsp;</td>
			<td width="21%" style="padding-right:10px" font-size="5" align="left"><?php echo !empty($value->{'Line Business'}) ? $value->{'Line Business'} : " "?></td><!-- for line of business -->
		</tr>
		<tr>
			<td width="100%" height="14px;" style="padding-right:10px" align="left" font-size="5">&nbsp;</td>
		</tr>
		<tr>
			<td width="8%" style="padding-right:10px" align="center" font-size="5">&nbsp;</td>
			<td width="74%" style="padding-right:10px" align="left" font-size="5">
				<?php echo $value->{'Company'};?>
			</td colspan>
		<?php 
			$value->{'Contact No'} = str_split(substr(str_replace("-","",$value->{'Contact No'}), 2));
			if( is_array($value->{'Contact No'}) && !empty($value->{'Contact No'}) ) { 
				foreach ($value->{'Contact No'} as $contact_k => $contact) { ?>
					<td style="padding-right:10px" align="center" width="2.2%" font-size="5"><?php echo $contact; ?></td>
		<?php 	}
			}?> 
		</tr>
		<tr>
			<td width="100%" height="14px;" style="padding-right:10px" align="left" font-size="5">&nbsp;</td>
		</tr>
		<tr>
			<td style="padding-right:10px" align="center" width="8%" font-size="5">&nbsp;</td>
			<td  width="78.7%" style="padding-right:10px" align="left" font-size="5">
				<?php echo $value->{'Address'};?>
			</td colspan>
			<?php 
				$value->{'Zipcode'} = str_split($value->{'Zipcode'});
				if( is_array($value->{'Zipcode'}) && !empty($value->{'Zipcode'}) ) { 
					foreach ($value->{'Zipcode'} as $zip_k => $zip) { ?>
						<td style="padding-right:10px" align="center" width="2.5%" font-size="5"><?php echo $zip; ?></td>
			<?php 	}
				}?> 
		</tr>
		<tr>
			<td width="60%" height="15px;" style="padding-right:10px" align="left" font-size="5">&nbsp;</td>
		</tr>
		<tr>
			<td width="8%" height="15px;">&nbsp;</td> <!-- 16 for government -->
			<td width="40%" height="15px;" style="padding-left:30px" align="left" font-size="5">X</td><!--  For private category of withholding agent -->
		</tr>
		<tr>
			<td width="60%" height="20px;" style="padding-right:10px" align="left" font-size="5">&nbsp;</td>
		</tr>
		<tr>
			<td width="35%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="27%" style="padding-right:10px" align="right" font-size="5"><?php echo number_format( $value->{'Total Compensation'} , 2, '.', ',' );?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="35%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="27%" style="padding-right:10px" align="right" font-size="5"><?php echo number_format( $value->{'Statutory Minimum'} , 2, '.', ',' );?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="35%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="27%" style="padding-right:10px" align="right" font-size="5"><?php echo number_format( $value->{'Overtime'} , 2, '.', ',' );?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="35%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="27%" style="padding-right:10px" align="right" font-size="5"><?php echo number_format( $value->{'Other Nontax Compensation'} , 2, '.', ',' );?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="35%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="27%" style="padding-right:10px" align="right" font-size="5"><?php echo number_format( $value->{'Total Compensation'} - $value->{'Statutory Minimum'} - $value->{'Overtime'} - $value->{'Other Nontax Compensation'} , 2, '.', ',' );?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 1.5x;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="65%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="28%" style="padding-right:10px" align="right" font-size="5"><?php echo number_format( $value->{'Wtax'} , 2, '.', ',' );?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 2px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="65%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="28%" style="padding-right:10px" align="right" font-size="5"><?php echo ""/*$value->{'item_19'}*/;?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 2.5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="65%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="28%" style="padding-right:10px" align="right" font-size="5"><?php echo number_format( $value->{'Wtax'} , 2, '.', ',' );?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 1.5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="35%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="27%" style="padding-right:10px" align="right" font-size="5"><?php echo ""/*$value->{'item_21a'}*/;?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 4px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="35%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="27%" style="padding-right:10px" align="right" font-size="5"><?php echo ""/*$value->{'item_21b'}*/;?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 6px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="65%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="28%" style="padding-right:10px" align="right" font-size="5"><?php echo ""/*$value->{'item_22'}*/;?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 5.5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="65%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="28%" style="padding-right:10px" align="right" font-size="5"><?php echo number_format( $value->{'Wtax'} , 2, '.', ',' );?></td>
		</tr>
		<tr>
			<td height="14px;" width="100%" style="padding-right:10px; font-size: 5.5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="8%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="12%" style="padding-right:10px" align="right" font-size="5"><?php echo ""/*$value->{'item_24a'}*/;?></td>
			<td width="22%" style="padding-right:10px" align="right" font-size="5"><?php echo ""/*$value->{'item_24b'}*/;?></td>
			<td width="20%" style="padding-right:10px" align="right" font-size="5"><?php echo ""/*$value->{'item_24c'}*/;?></td>
			<td width="31%" style="padding-right:10px" align="right" font-size="5"><?php echo ""/*$value->{'item_24d'}*/;?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 3px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="65%" style="padding-right:10px" align="right" font-size="5">&nbsp;</td>
			<td width="28%" style="padding-right:10px" align="right" font-size="5"><?php echo number_format( $value->{'Wtax'} , 2, '.', ',' );?></td>
		</tr>
		<!-- Skip item 26 -->
		<tr>
			<td height="132px;" width="100%" style="padding-right:10px; font-size: 5.5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="10%" style="padding-right:10px;" align="left">&nbsp;</td>
			<td width="35%" style="padding-right:10px; font-size: 7px;" align="center"><?php echo ""/*$value->{'item_27'}*/;?></td>
			<td width="14%" style="padding-right:10px;" align="left">&nbsp;</td>
			<td width="25%" style="padding-right:10px; font-size: 7px;" align="center"><?php echo ""/*$value->{'item_28'}*/;?></td>
		</tr>
		<tr>
			<td height="19px;" width="100%" style="padding-right:10px; font-size: 5.5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="10%" style="padding-right:10px;" align="left">&nbsp;</td>
			<td width="16%" style="padding-right:10px; font-size: 7px;" align="center"><?php echo ""/*$value->{'sign_pos27'}*/;?></td>
			<td width="8%" style="padding-right:10px;" align="left">&nbsp;</td>
			<td width="15%" style="padding-right:10px; font-size: 7px;" align="center"><?php echo ""/*$value->{'sign_tin27'}*/;?></td>
			<td width="10%" style="padding-right:10px;" align="left">&nbsp;</td>
			<td width="25%" style="padding-right:10px; font-size: 7px;" align="center"><?php echo ""/*$value->{'sign_pos28'}*/;?></td>
		</tr>
		<tr>
			<td width="100%" style="padding-right:10px; font-size: 3.5px;" align="left">&nbsp;</td>
		</tr>
		<tr>
			<td width="59%" style="padding-right:10px;" align="left">&nbsp;</td>
			<td width="25%" style="padding-right:10px; font-size: 7px;" align="center"><?php echo  ""/*$value->{'sign_tin28'}*/;?></td>
		</tr>	
	</table>

<?php //} ?>
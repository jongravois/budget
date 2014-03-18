<?php
	$curr_year = (int)'20'.$this->globals_m->current_year();
	$yrs = array($curr_year-5,$curr_year-4,$curr_year-3,$curr_year-2,$curr_year-1, $curr_year, $curr_year+1, $curr_year+2,$curr_year+3,$curr_year+4);

	$co_id = substr($budget_id,0,3);
	$de_id = ( (int)substr($budget_id,-2) == 0 ? '99' : substr($budget_id,-2));
	$totTOTALS = 0;

	if(!$this->sam_m->get_aggregate_co_total($co_id,'Amenities') ){
		$totAmenities = 0;
	} else {
		$tAmen = $this->sam_m->get_aggregate_co_total($co_id,'Amenities');
		$totAmenities = $tAmen[0]['TOTAL'];
		$totTOTALS += $totAmenities;
	} // end if

	if(!$this->sam_m->get_aggregate_co_total($co_id,'IT') ){
		$totIT = 0;
	} else {
		$tIT = $this->sam_m->get_aggregate_co_total($co_id,'IT');
		$totIT = $tIT[0]['TOTAL'];
		$totTOTALS += $totIT;
	} // end if

	if(!$this->sam_m->get_aggregate_co_total($co_id,'Leasehold') ){
		$totLeasehold = 0;
	} else {
		$tLea = $this->sam_m->get_aggregate_co_total($co_id,'Leashold');
		$totLeasehold = $tLea[0]['TOTAL'];
		$totTOTALS += $totLeasehold;
	} // end if

	if(!$this->sam_m->get_aggregate_co_total($co_id,'Office') ){
		$totOffice = 0;
	} else {
		$tOff = $this->sam_m->get_aggregate_co_total($co_id,'Office');
		$totOffice = $tOff[0]['TOTAL'];
		$totTOTALS += $totOffice;
	} // end if

	if(!$this->sam_m->get_aggregate_co_total($co_id,'Plan 21') ){
		$totPlan_21 = 0;
	} else {
		$tPlan = $this->sam_m->get_aggregate_co_total($co_id,'Plan 21');
		$totPlan_21 = $totPlan_21[0]['TOTAL'];
		$totTOTALS += $tPlan;
	} // end if

	if(!$this->sam_m->get_aggregate_co_total($co_id,'Recurring') ){
		$totRecurring = 0;
	} else {
		$tRec = $this->sam_m->get_aggregate_co_total($co_id,'Recurring');
		$totRecurring = $tRec[0]['TOTAL'];
		$totTOTALS += $totRecurring;
	} // end if
	
	if(!$this->sam_m->get_aggregate_co_total($co_id,'Structural') ){
		$totStructural = 0;
	} else {
		$tStruct = $this->sam_m->get_aggregate_co_total($co_id,'Structural');
		$totStructural = $tStruct[0]['TOTAL'];
		$totTOTALS += $totStructural;
	} // end if

	if( (int)$de_id == 99):
		if($this->sam_m->get_bed_types($co_id) == 0){
			$cntBedTypes = '-';
			$btAmenities = '-';
			$btIT = '-';
			$btLeasehold = '-';
			$btPlan_21 = '-';
			$btOffice = '-';
			$btRecurring = '-';
			$btStructural = '-';
			$btTOTALS = '-';
		} else {
			$cntBedTypes = $this->sam_m->get_bed_types($co_id);
			$btAmenities  = number_format((float)$totAmenities/(float)$cntBedTypes,2);
			$btIT         = number_format((float)$totIT/(float)$cntBedTypes,2);
			$btLeasehold  = number_format((float)$totLeasehold/(float)$cntBedTypes,2);
			$btPlan_21    = number_format((float)$totPlan_21/(float)$cntBedTypes,2);
			$btOffice     = number_format((float)$totOffice/(float)$cntBedTypes,2);
			$btRecurring  = number_format((float)$totRecurring/(float)$cntBedTypes,2);
			$btStructural = number_format((float)$totStructural/(float)$cntBedTypes,2);
			$btTOTALS = number_format((float)$totTOTALS/(float)$cntBedTypes,2);
		} // end if
	else:
		$cntBedTypes = 0;
	endif;
?>

<p style="text-align:center;">
	<table class='table table-bordered tblSubmitReport' style='width:80%; margin:0 auto;'>
		<tr>
			<td colspan="3" style="text-align:center;"><strong><?= $cntBedTypes; ?></strong> Design Beds<br><?php //print_r($tRec); ?></td>
		</tr>
		<tr>
			<th>Asset Type</th>
			<th>Annual Amount</th>
			<th>Per Bed Amount</th>
		</tr>
		<tr>
			<td>Amenities</td>
			<td><?= ($totAmenities == 0 ? '-' : number_format($totAmenities,2)); ?></td>
			<td><?= ($btAmenities == 0 ? '-' : $btAmenities); ?></td>
		</tr>
		<tr>
			<td>IT</td>
			<td><?= ($totIT == 0 ? '-' : number_format($totIT,2)); ?></td>
			<td><?= ($btIT == 0 ? '-' : $btIT); ?></td>
		</tr>
		<tr>
			<td>Leasehold</td>
			<td><?= ($totLeasehold == 0 ? '-' : number_format($totLeasehold,2)); ?></td>
			<td><?= ($btLeasehold == 0 ? '-' : $btLeasehold); ?></td>
		</tr>
		<tr>
			<td>Plan 21</td>
			<td><?= ($totPlan_21 == 0 ? '-' : number_format($totPlan_21,2)); ?></td>
			<td><?= ($btPlan_21 == 0 ? '-' : $btPlan_21); ?></td>
		</tr>
		<tr>
			<td>Office</td>
			<td><?= ($totOffice == 0 ? '-' : number_format($totOffice,2)); ?></td>
			<td><?= ($btOffice == 0 ? '-' : $btOffice); ?></td>
		</tr>
		<tr>
			<td>Recurring</td>
			<td><?= ($totRecurring == 0 ? '-' : number_format($totRecurring,2)); ?></td>
			<td><?= ($btRecurring == 0 ? '-' : $btRecurring); ?></td>
		</tr>
		<tr>
			<td>Structural</td>
			<td><?= ($totStructural == 0 ? '-' : number_format($totStructural,2)); ?></td>
			<td><?= ($btStructural == 0 ? '-' : $btStructural); ?></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td>TOTAL</td>
			<td><?= ($totTOTALS == 0 ? '-' : number_format($totTOTALS,2)); ?></td>
			<td><?= ($btTOTALS == 0 ? '-' : $btTOTALS); ?></td>
		</tr>
		<td colspan="3" style="text-align:center;">
			<button class="btn btn-medium btn-inverse btnSubSumCancel">Revise</button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-medium btn-edr btnSubSumSubmit">Submit</button>
		</td>
	</table>
</p>

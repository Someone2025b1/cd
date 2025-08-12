<?php
function poner_comas($cantidad) {
	$desglose=explode(".",$cantidad);
	$n=$desglose[0];
	if ($desglose[1] == "") {
		$d="00";
	} else {
		$d=$desglose[1];
	}
	if (strlen($n) < 4) {
		$resultado=$n;
	} else {
		switch (strlen($n)) {
			case 4 :
				$tmp_1=substr($n,0,1);
				$tmp_2=substr($n,1,3);
				$resultado=$tmp_1.",".$tmp_2;
				
			case 5:
				$tmp_1=substr($n,0,2);
				$tmp_2=substr($n,2,3);
				$resultado=$tmp_1.",".$tmp_2;
				
			case 6:
				$tmp_1=substr($n,0,3);
				$tmp_2=substr($n,3,3);
				$resultado=$tmp_1.",".$tmp_2;
				
			case 7:
				$tmp_1=substr($n,0,1);
				$tmp_2=substr($n,1,3);
				$tmp_3=substr($n,4,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				
			case 8:
				$tmp_1=substr($n,0,2);
				$tmp_2=substr($n,2,3);
				$tmp_3=substr($n,5,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				
			case 9:
				$tmp_1=substr($n,0,3);
				$tmp_2=substr($n,3,3);
				$tmp_3=substr($n,6,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				
		} // end switch
	} // end if-else
	$resultado=$resultado.".".$d;		
	return $resultado;
} 

function solo_comas($cantidad) {
	$desglose=explode(".",$cantidad);
	$n=$desglose[0];
	if ($desglose[1] == "") {
		$d="00";
	} else {
		$d=$desglose[1];
	}
	if (strlen($n) < 4) {
		$resultado=$n;
	} else {
		switch (strlen($n)) {
			case 4 :
				$tmp_1=substr($n,0,1);
				$tmp_2=substr($n,1,3);
				$resultado=$tmp_1.",".$tmp_2;
				
			case 5:
				$tmp_1=substr($n,0,2);
				$tmp_2=substr($n,2,3);
				$resultado=$tmp_1.",".$tmp_2;
				
			case 6:
				$tmp_1=substr($n,0,3);
				$tmp_2=substr($n,3,3);
				$resultado=$tmp_1.",".$tmp_2;
				
			case 7:
				$tmp_1=substr($n,0,1);
				$tmp_2=substr($n,1,3);
				$tmp_3=substr($n,4,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				
			case 8:
				$tmp_1=substr($n,0,2);
				$tmp_2=substr($n,2,3);
				$tmp_3=substr($n,5,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				
			case 9:
				$tmp_1=substr($n,0,3);
				$tmp_2=substr($n,3,3);
				$tmp_3=substr($n,6,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				
		} // end switch
	} // end if-else
	$resultado=$resultado;
	return $resultado;
}
?> 
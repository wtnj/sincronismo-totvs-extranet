<?php

	$sqlTotvsDAK010 = ociparse($totvsConexao,"SELECT DAK_FILIAL
											      , DAK_COD
												  , DAK_SEQCAR
												  , DAK_CAMINH
										          , DAK_MOTORI
												  , DAK_PESO
												  , DAK_VALOR
												  , DAK_DATA
												  , DAK_HORA
												  , DAK_DTACCA
												  , DAK_DATENT
												  , DAK_HRSTAR
												  , DAK_TRANSP
												  , R_E_C_N_O_
												  , D_E_L_E_T_
											  FROM DAK010
										      WHERE R_E_C_N_O_ = ".$rowTotvsLog["R_E_C_N_O_"]);
	ociexecute($sqlTotvsDAK010);
	$rowTotvsDAK010 = oci_fetch_array($sqlTotvsDAK010);
			
	if($rowTotvsLog["TP_LOG"] == "Insert"){
	
	    mysql_query("INSERT INTO tb_fat_carga (CO_FILIAL
					     , DT_CARGA
					     , HR_CARGA
					     , NU_CARGA
					     , NU_SEQ_CARGA
					     , CO_VEICULO
					     , CO_MOTORISTA
					     , PESO_CARGA
					     , VL_CARGA
					     , DT_ACERTO
					     , DT_ENTREGA
					     , HR_INICIO_ENTREGA
					     , CO_TRANSPORTADORA
					     , CO_RECNO)
					 VALUES('".trim($rowTotvsDAK010['DAK_FILIAL'])."' 
					     , '".trim($rowTotvsDAK010['DAK_DATA'])."' 
						 , '".trim($rowTotvsDAK010['DAK_HORA'])."' 
						 , '".trim($rowTotvsDAK010['DAK_COD'])."' 
						 , '".trim($rowTotvsDAK010['DAK_SEQCAR'])."' 
						 , '".trim($rowTotvsDAK010['DAK_CAMINH'])."' 
						 , '".trim($rowTotvsDAK010['DAK_MOTORI'])."' 
						 , '".trim($rowTotvsDAK010['DAK_PESO'])."' 
						 , '".trim($rowTotvsDAK010['DAK_VALOR'])."' 
						 , '".trim($rowTotvsDAK010['DAK_DTACCA'])."' 
						 , '".trim($rowTotvsDAK010['DAK_DATENT'])."' 
						 , '".trim($rowTotvsDAK010['DAK_HRSTAR'])."' 
						 , '".trim($rowTotvsDAK010['DAK_TRANSP'])."' 
						 , '".$rowTotvsDAK010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
											
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
	
		mysql_query("UPDATE tb_fat_carga SET
		                 CO_FILIAL           = '".trim($rowTotvsDAK010['DAK_FILIAL'])."' 
					     , DT_CARGA          = '".trim($rowTotvsDAK010['DAK_DATA'])."' 
					     , HR_CARGA          = '".trim($rowTotvsDAK010['DAK_HORA'])."' 
					     , NU_CARGA          = '".trim($rowTotvsDAK010['DAK_COD'])."' 
					     , NU_SEQ_CARGA      = '".trim($rowTotvsDAK010['DAK_SEQCAR'])."' 
					     , CO_VEICULO        = '".trim($rowTotvsDAK010['DAK_CAMINH'])."' 
					     , CO_MOTORISTA      = '".trim($rowTotvsDAK010['DAK_MOTORI'])."' 
					     , PESO_CARGA        = '".trim($rowTotvsDAK010['DAK_PESO'])."' 
					     , VL_CARGA          = '".trim($rowTotvsDAK010['DAK_VALOR'])."' 
					     , DT_ACERTO         = '".trim($rowTotvsDAK010['DAK_DTACCA'])."' 
					     , DT_ENTREGA        = '".trim($rowTotvsDAK010['DAK_DATENT'])."' 
					     , HR_INICIO_ENTREGA = '".trim($rowTotvsDAK010['DAK_HRSTAR'])."' 
					     , CO_TRANSPORTADORA = '".trim($rowTotvsDAK010['DAK_TRANSP'])."' 
					     , CO_RECNO          = '".$rowTotvsDAK010['R_E_C_N_O_']."' 
					 WHERE CO_RECNO = '".$rowTotvsDAK010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
				
	    if(trim($rowTotvsDAK010['D_E_L_E_T_']) == '*'){
			
	    	mysql_query("UPDATE tb_fat_carga SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsDAK010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
	    }else{
			
	    	mysql_query("UPDATE tb_fat_carga SET FL_DELET = null WHERE CO_RECNO = '".$rowTotvsDAK010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
	    }
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_fat_carga SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsDAK010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
	}
			
?>
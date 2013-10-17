<?php

    $sqlTotvsSG2010 = ociparse($totvsConexao,"SELECT G2_RECURSO
	                                              , G2_OPERAC
												  , G2_DESCRI
												  , G2_PRODUTO
												  , R_E_C_N_O_
    											 , D_E_L_E_T_
											  FROM SG2010
											  WHERE R_E_C_N_O_ = '".$rowTotvsLog["R_E_C_N_O_"]."'");
	ociexecute($sqlTotvsSG2010);
	$rowTotvsSG2010 = oci_fetch_array($sqlTotvsSG2010);
								
	if($rowTotvsLog["TP_LOG"] == "Insert"){
			    			
	    mysql_query("INSERT INTO tb_pcp_operacao (CO_RECURSO
					     , CO_OPERACAO
						 , DS_OPERACAO
						 , CO_PRODUTO
						 , CO_RECNO)
					 VALUES('".trim($rowTotvsSG2010['G2_RECURSO'])."' 
					     , '".trim($rowTotvsSG2010['G2_OPERAC'])."'
					     , '".trim($rowTotvsSG2010['G2_DESCRI'])."'
					     , '".trim($rowTotvsSG2010['G2_PRODUTO'])."'
					     , '".$rowTotvsSG2010['R_E_C_N_O_']."')",$conexaoExtranet);
											
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
				
	    mysql_query("UPDATE tb_pcp_operacao SET
					     CO_RECURSO    = '".trim($rowTotvsSG2010['G2_RECURSO'])."'
					     , CO_OPERACAO = '".trim($rowTotvsSG2010['G2_OPERAC'])."'
						 , DS_OPERACAO = '".trim($rowTotvsSG2010['G2_DESCRI'])."'
						 , CO_PRODUTO  = '".trim($rowTotvsSG2010['G2_PRODUTO'])."'
					 WHERE CO_RECNO = '".$rowTotvsSG2010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
				
	    if(trim($rowTotvsSG2010['D_E_L_E_T_'])=='*'){
		
	    	mysql_query("UPDATE tb_pcp_operacao SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSG2010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	    }else{
		
	    	mysql_query("UPDATE tb_pcp_operacao SET FL_DELET = null WHERE CO_RECNO = '".$rowTotvsSG2010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	    }
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_pcp_operacao SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSG2010['R_E_C_N_O_']."'",$conexaoExtranet);
				
	}
			
?>
<?php

    $sqlTotvsSH1010 = ociparse($totvsConexao,"SELECT H1_CODIGO
	                                              , H1_DESCRI
												  , R_E_C_N_O_
    											  , D_E_L_E_T_
											  FROM SH1010
											  WHERE R_E_C_N_O_ = '".$rowTotvsLog["R_E_C_N_O_"]."'");
	ociexecute($sqlTotvsSH1010);
	$rowTotvsSH1010 = oci_fetch_array($sqlTotvsSH1010);
								
	if($rowTotvsLog["TP_LOG"] == "Insert"){
			    			
	    mysql_query("INSERT INTO tb_pcp_recurso (CO_RECURSO
					     , NO_RECURSO
						 , CO_RECNO)
					 VALUES('".$rowTotvsSH1010['H1_CODIGO']."' 
					     , '".$rowTotvsSH1010['H1_DESCRI']."'
					     , '".$rowTotvsSH1010['R_E_C_N_O_']."')",$conexaoExtranet);
											
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
				
	    mysql_query("UPDATE tb_pcp_recurso SET
					     CO_RECURSO    = '".$rowTotvsSH1010['H1_CODIGO']."'
					     , NO_RECURSO = '".$rowTotvsSH1010['H1_DESCRI']."'
					 WHERE CO_RECNO = '".$rowTotvsSH1010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
				
	    if(trim($rowTotvsSH1010['D_E_L_E_T_'])=='*'){
	    	mysql_query("UPDATE tb_pcp_recurso SET FL_DELET= '*' WHERE CO_RECNO = '".$rowTotvsSH1010['R_E_C_N_O_']."'",$conexaoExtranet);
	    }else{
	    	mysql_query("UPDATE tb_pcp_recurso SET FL_DELET= null WHERE CO_RECNO = '".$rowTotvsSH1010['R_E_C_N_O_']."'",$conexaoExtranet);
	    }
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_pcp_recurso SET FL_DELET ='*' WHERE CO_RECNO = '".$rowTotvsSH1010['R_E_C_N_O_']."'",$conexaoExtranet);
				
	}
			
?>
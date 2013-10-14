<?php

    $sqlTotvsSX5010 = ociparse($totvsConexao,"SELECT X5_CHAVE
											      , X5_DESCRI
											      , X5_DESCSPA
											      , R_E_C_N_O_
    		    								  , D_E_L_E_T_
											  FROM SX5010
											  WHERE R_E_C_N_O_ = '".$rowTotvsLog["R_E_C_N_O_"]."'
											  AND X5_TABELA = 'CR'");
	ociexecute($sqlTotvsSX5010);
	$rowTotvsSX5010 = oci_fetch_array($sqlTotvsSX5010);
								
	if($rowTotvsLog["TP_LOG"] == "Insert"){
			    			
	    mysql_query("INSERT INTO tb_pcp_cor (CO_COR
				         , NO_COR
					     , DS_COR
					     , CO_RECNO)
					 VALUES('".$rowTotvsSX5010['X5_CHAVE']."'
					     , '".$rowTotvsSX5010['X5_DESCRI']."'
					     , '".$rowTotvsSX5010['X5_DESCSPA']."'
					     , '".$rowTotvsSX5010['R_E_C_N_O_']."')",$conexaoExtranet);
								
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
				
		mysql_query("UPDATE tb_pcp_cor SET
					     CO_COR     = '".$rowTotvsSX5010['X5_CHAVE']."'
					     , NO_COR   = '".$rowTotvsSX5010['X5_DESCRI']."'
					     , DS_COR   = '".$rowTotvsSX5010['X5_DESCSPA']."'
					 WHERE CO_RECNO = '".$rowTotvsSX5010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
				
	    if(trim($rowTotvsSX5010['D_E_L_E_T_'])=='*'){
	    	mysql_query("UPDATE tb_pcp_cor SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSX5010['R_E_C_N_O_']."'",$conexaoExtranet);
	    }else{
	    	mysql_query("UPDATE tb_pcp_cor SET FL_DELET = null WHERE CO_RECNO = '".$rowTotvsSX5010['R_E_C_N_O_']."'",$conexaoExtranet);
	    }
	    
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_pcp_cor SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSX5010['R_E_C_N_O_']."'",$conexaoExtranet);
				
	}
			
?>
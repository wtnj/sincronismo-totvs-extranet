<?php 
			 
    $sqlTotvsSH1010 = ociparse($totvsConexao,"SELECT H1_CODIGO
	                                              , H1_DESCRI
												  , R_E_C_N_O_
    											  , D_E_L_E_T_
											  FROM SH1010
											  ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSH1010);
	
	while($rowTotvsSH1010 = oci_fetch_array($sqlTotvsSH1010)){
		
	    $sqlPcpRecurso = mysql_query("SELECT null FROM tb_pcp_recurso WHERE CO_RECNO = '".$rowTotvsSH1010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpRecurso) == 0){
			
			if(trim($rowTotvsSH1010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("INSERT INTO tb_pcp_recurso (CO_RECURSO
					             , NO_RECURSO
						         , CO_RECNO
						         , FL_DELET)
							 VALUES('".$rowTotvsSH1010['H1_CODIGO']."' 
					             , '".trim($rowTotvsSH1010['H1_DESCRI'])."'
					             , '".$rowTotvsSH1010['R_E_C_N_O_']."'
						         , '*')",$conexaoExtranet)or die(mysql_error());
			
			}else{
				
				mysql_query("INSERT INTO tb_pcp_recurso (CO_RECURSO
					             , NO_RECURSO
						         , CO_RECNO)
							 VALUES('".$rowTotvsSH1010['H1_CODIGO']."' 
					             , '".trim($rowTotvsSH1010['H1_DESCRI'])."'
					             , '".$rowTotvsSH1010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSH1010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_pcp_recurso SET
							     CO_RECURSO   = '".$rowTotvsSH1010['H1_CODIGO']."' 
					             , NO_RECURSO = '".trim($rowTotvsSH1010['H1_DESCRI'])."'
						         , CO_RECNO   = '".$rowTotvsSH1010['R_E_C_N_O_']."'
							     , FL_DELET   = '*'
						 	 WHERE CO_RECNO = '".$rowTotvsSH1010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_pcp_recurso SET
							     CO_RECURSO   = '".$rowTotvsSH1010['H1_CODIGO']."' 
					             , NO_RECURSO = '".trim($rowTotvsSH1010['H1_DESCRI'])."'
						         , CO_RECNO   = '".$rowTotvsSH1010['R_E_C_N_O_']."'
						 	 WHERE CO_RECNO = '".$rowTotvsSH1010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
			
?>
<?php 
	
	$sqlTotvsSX5010 = ociparse($totvsConexao,"SELECT X5_CHAVE
											      , X5_DESCRI
											      , X5_DESCSPA
											      , R_E_C_N_O_
											      , D_E_L_E_T_ 
											  FROM SX5010 
											  WHERE X5_TABELA = 'CR'
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSX5010);
	
	while($rowTotvsSX5010 = oci_fetch_array($sqlTotvsSX5010)){
		
	    $sqlPcpCor = mysql_query("SELECT null FROM tb_pcp_cor WHERE CO_RECNO = '".$rowTotvsSX5010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpCor) == 0){
			
			if(trim($rowTotvsSX5010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("INSERT INTO tb_pcp_cor (CO_COR
				                 , NO_COR
					             , DS_COR
					             , CO_RECNO
								 , FL_DELET)
							 VALUES('".$rowTotvsSX5010['X5_CHAVE']."' 
					             , '".trim(addslashes($rowTotvsSX5010['X5_DESCRI']))."' 
							     , '".trim(addslashes($rowTotvsSX5010['X5_DESCSPA']))."' 
							     , '".$rowTotvsSX5010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
			
			}else{
				
				 mysql_query("INSERT INTO tb_pcp_cor (CO_COR
				                 , NO_COR
					             , DS_COR
					             , CO_RECNO)
							 VALUES('".$rowTotvsSX5010['X5_CHAVE']."' 
					             , '".trim(addslashes($rowTotvsSX5010['X5_DESCRI']))."' 
							     , '".trim(addslashes($rowTotvsSX5010['X5_DESCSPA']))."' 
							     , '".$rowTotvsSX5010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSX5010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_pcp_cor SET
							     CO_COR     = '".$rowTotvsSX5010['X5_CHAVE']."'
				                 , NO_COR   = '".trim(addslashes($rowTotvsSX5010['X5_DESCRI']))."' 
					             , DS_COR   = '".trim(addslashes($rowTotvsSX5010['X5_DESCSPA']))."'
							     , FL_DELET = '*'
						 	 WHERE CO_RECNO = '".$rowTotvsSX5010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_pcp_cor SET
							     CO_COR     = '".$rowTotvsSX5010['X5_CHAVE']."'
				                 , NO_COR   = '".trim(addslashes($rowTotvsSX5010['X5_DESCRI']))."' 
					             , DS_COR   = '".trim(addslashes($rowTotvsSX5010['X5_DESCSPA']))."'
						 	 WHERE CO_RECNO = '".$rowTotvsSX5010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
			
?>
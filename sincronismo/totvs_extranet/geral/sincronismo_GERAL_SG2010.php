﻿<?php 
	
	$sqlTotvsSG2010 = ociparse($totvsConexao,"SELECT G2_RECURSO
	                                              , G2_OPERAC
												  , G2_DESCRI
												  , G2_PRODUTO
												  , R_E_C_N_O_
    										      , D_E_L_E_T_
											  FROM SG2010
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSG2010);
	
	while($rowTotvsSG2010 = oci_fetch_array($sqlTotvsSG2010)){
		
	    $sqlPcpOperacao = mysql_query("SELECT null FROM tb_pcp_operacao WHERE CO_RECNO = '".$rowTotvsSG2010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
			
		if(mysql_num_rows($sqlPcpOperacao) == 0){
			
			if(trim($rowTotvsSG2010['D_E_L_E_T_']) == '*'){
				
				mysql_query("INSERT INTO tb_pcp_operacao (CO_RECURSO
					     	     , CO_OPERACAO
								 , DS_OPERACAO
								 , CO_PRODUTO
								 , CO_RECNO
								 , FL_DELET)
							 VALUES('".trim($rowTotvsSG2010['G2_RECURSO'])."' 
							     , '".trim($rowTotvsSG2010['G2_OPERAC'])."'
								 , '".trim($rowTotvsSG2010['G2_DESCRI'])."'
								 , '".trim($rowTotvsSG2010['G2_PRODUTO'])."'
								 , '".$rowTotvsSG2010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());	
								 						
			}else{
				
				mysql_query("INSERT INTO tb_pcp_operacao (CO_RECURSO
					     	     , CO_OPERACAO
								 , DS_OPERACAO
								 , CO_PRODUTO
								 , CO_RECNO)
							 VALUES('".trim($rowTotvsSG2010['G2_RECURSO'])."' 
							     , '".trim($rowTotvsSG2010['G2_OPERAC'])."'
								 , '".trim($rowTotvsSG2010['G2_DESCRI'])."'
								 , '".trim($rowTotvsSG2010['G2_PRODUTO'])."'
								 , '".$rowTotvsSG2010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
												 
			}
			
		}else{
			
			if(trim($rowTotvsSG2010['D_E_L_E_T_']) == '*'){
				
				mysql_query("UPDATE tb_pcp_operacao SET
					             CO_RECURSO    = '".trim($rowTotvsSG2010['G2_RECURSO'])."'
								 , CO_OPERACAO = '".trim($rowTotvsSG2010['G2_OPERAC'])."'
								 , DS_OPERACAO = '".trim($rowTotvsSG2010['G2_DESCRI'])."'
								 , CO_PRODUTO  = '".trim($rowTotvsSG2010['G2_PRODUTO'])."'
								 , FL_DELET    = '*'
					 		 WHERE CO_RECNO = '".$rowTotvsSG2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
						
			}else{
				
				mysql_query("UPDATE tb_pcp_operacao SET
					     	     CO_RECURSO    = '".trim($rowTotvsSG2010['G2_RECURSO'])."'
								 , CO_OPERACAO = '".trim($rowTotvsSG2010['G2_OPERAC'])."'
								 , DS_OPERACAO = '".trim($rowTotvsSG2010['G2_DESCRI'])."'
								 , CO_PRODUTO  = '".trim($rowTotvsSG2010['G2_PRODUTO'])."'
					 		 WHERE CO_RECNO = '".$rowTotvsSG2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
?>
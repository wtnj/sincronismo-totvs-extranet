﻿<?php 

    ini_set("max_execution_time",3600);
	ini_set("memory_limit","50M");
    set_time_limit(0);
	
	date_default_timezone_set('America/Sao_Paulo');

    $ora_user = "TOPORA"; 
	$ora_senha = "hp05br501ti504"; 

	$ora_bd = "(DESCRIPTION=
			  (ADDRESS_LIST=
				(ADDRESS=(PROTOCOL=TCP) 
				  (HOST=192.168.0.8)(PORT=1521)
				)
			  )
			  (CONNECT_DATA=(SERVICE_NAME=TOPORA))
     )"; 

    $totvsConexao = OCILogon($ora_user,$ora_senha,$ora_bd);
	
	$conexaoExtranet = mysql_connect("192.168.0.7","root","hp05br501ti504")
	or die (mysql_error());
	
	$dbExtranet = mysql_select_db("extranet")
	or die ("<script>
			     alert('[Erro] - CONFIGURAÇÃO DO BANCO DE DADOS!');
				 window.close()';
			 </script>");
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Iniciado...<br>";

	/* Convert EUC-JP to UTF-7 */
	$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");
	
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
							 VALUES('".$rowTotvsSG2010['G2_RECURSO']."' 
							     , '".$rowTotvsSG2010['G2_OPERAC']."'
								 , '".$rowTotvsSG2010['G2_DESCRI']."'
								 , '".$rowTotvsSG2010['G2_PRODUTO']."'
								 , '".$rowTotvsSG2010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());	
								 						
			}else{
				
				mysql_query("INSERT INTO tb_pcp_operacao (CO_RECURSO
					     	     , CO_OPERACAO
								 , DS_OPERACAO
								 , CO_PRODUTO
								 , CO_RECNO)
							 VALUES('".$rowTotvsSG2010['G2_RECURSO']."' 
							     , '".$rowTotvsSG2010['G2_OPERAC']."'
								 , '".$rowTotvsSG2010['G2_DESCRI']."'
								 , '".$rowTotvsSG2010['G2_PRODUTO']."'
								 , '".$rowTotvsSG2010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
												 
			}
			
		}else{
			
			if(trim($rowTotvsSG2010['D_E_L_E_T_']) == '*'){
				
				mysql_query("UPDATE tb_pcp_operacao SET
					             CO_RECURSO    = '".$rowTotvsSG2010['G2_RECURSO']."'
								 , CO_OPERACAO = '".$rowTotvsSG2010['G2_OPERAC']."'
								 , DS_OPERACAO = '".$rowTotvsSG2010['G2_DESCRI']."'
								 , CO_PRODUTO  = '".$rowTotvsSG2010['G2_PRODUTO']."'
								 , FL_DELET    = '*'
					 		 WHERE CO_RECNO = '".$rowTotvsSG2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
						
			}else{
				
				mysql_query("UPDATE tb_pcp_operacao SET
					     	     CO_RECURSO    = '".$rowTotvsSG2010['G2_RECURSO']."'
								 , CO_OPERACAO = '".$rowTotvsSG2010['G2_OPERAC']."'
								 , DS_OPERACAO = '".$rowTotvsSG2010['G2_DESCRI']."'
								 , CO_PRODUTO  = '".$rowTotvsSG2010['G2_PRODUTO']."'
					 		 WHERE CO_RECNO = '".$rowTotvsSG2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
	
?>
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
	
	$sqlTotvsSG1010 = ociparse($totvsConexao,"SELECT G1_COD
											      , G1_COMP
												  , G1_TRT
											      , G1_QUANT
											      , G1_INI
											      , G1_FIM
											      , G1_NIV
											      , R_E_C_N_O_
												  , D_E_L_E_T_
										      FROM SG1010
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSG1010);
	
	while($rowTotvsSG1010 = oci_fetch_array($sqlTotvsSG1010)){
		
	    $sqlPcpEstrutura = mysql_query("SELECT null FROM tb_pcp_estrutura WHERE CO_RECNO = '".$rowTotvsSG1010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		$qtd = (string)($rowTotvsSG1010['G1_QUANT']);
			
		if(substr($qtd,0,1) == '.' || substr($qtd,0,1) == ','){
		    $qtd = '0'.$qtd;
		}
			
		if(mysql_num_rows($sqlPcpEstrutura) == 0){
			
			if(trim($rowTotvsSG1010['D_E_L_E_T_']) == '*'){
				
				mysql_query("INSERT INTO tb_pcp_estrutura (CO_PRODUTO
						         , CO_COMPONENTE
								 , NU_SEQ_COMPONENTE
								 , QTD_COMPONENTE
								 , DT_INICIAL_COMPONENTE
								 , DT_FINAL_COMPONENTE
								 , NU_NIVEL_COMPONENTE
								 , CO_RECNO
								 , FL_DELET)
							 VALUES('".$rowTotvsSG1010['G1_COD']."' 
					             , '".$rowTotvsSG1010['G1_COMP']."'
								 , '".trim(addslashes($rowTotvsSG1010['G1_TRT']))."'
								 , '".$qtd."'
								 , '".$rowTotvsSG1010['G1_INI']."'
								 , '".$rowTotvsSG1010['G1_FIM']."'  
								 , '".$rowTotvsSG1010['G1_NIV']."' 
								 , '".$rowTotvsSG1010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
							
			}else{
				
				mysql_query("INSERT INTO tb_pcp_estrutura (CO_PRODUTO
						         , CO_COMPONENTE
								 , NU_SEQ_COMPONENTE
								 , QTD_COMPONENTE
								 , DT_INICIAL_COMPONENTE
								 , DT_FINAL_COMPONENTE
								 , NU_NIVEL_COMPONENTE
								 , CO_RECNO)
							 VALUES('".$rowTotvsSG1010['G1_COD']."' 
					             , '".$rowTotvsSG1010['G1_COMP']."'
								 , '".trim(addslashes($rowTotvsSG1010['G1_TRT']))."'
								 , '".$qtd."'
								 , '".$rowTotvsSG1010['G1_INI']."'
								 , '".$rowTotvsSG1010['G1_FIM']."'  
								 , '".$rowTotvsSG1010['G1_NIV']."' 
								 , '".$rowTotvsSG1010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
												 
			}
			
		}else{
			
			if(trim($rowTotvsSG1010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_pcp_estrutura SET
							     CO_PRODUTO              = '".$rowTotvsSG1010['G1_COD']."' 
						         , CO_COMPONENTE         = '".$rowTotvsSG1010['G1_COMP']."'
								 , NU_SEQ_COMPONENTE     = '".trim(addslashes($rowTotvsSG1010['G1_TRT']))."'
								 , QTD_COMPONENTE        = '".$qtd."'
								 , DT_INICIAL_COMPONENTE = '".$rowTotvsSG1010['G1_INI']."'
								 , DT_FINAL_COMPONENTE   = '".$rowTotvsSG1010['G1_FIM']."'  
								 , NU_NIVEL_COMPONENTE   = '".$rowTotvsSG1010['G1_NIV']."' 
							     , FL_DELET              = '*'
						 	 WHERE CO_RECNO = '".$rowTotvsSG1010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_pcp_estrutura SET
							     CO_PRODUTO              = '".$rowTotvsSG1010['G1_COD']."' 
						         , CO_COMPONENTE         = '".$rowTotvsSG1010['G1_COMP']."'
								 , NU_SEQ_COMPONENTE     = '".trim(addslashes($rowTotvsSG1010['G1_TRT']))."'
								 , QTD_COMPONENTE        = '".$qtd."'
								 , DT_INICIAL_COMPONENTE = '".$rowTotvsSG1010['G1_INI']."'
								 , DT_FINAL_COMPONENTE   = '".$rowTotvsSG1010['G1_FIM']."'  
								 , NU_NIVEL_COMPONENTE   = '".$rowTotvsSG1010['G1_NIV']."'
						 	 WHERE CO_RECNO = '".$rowTotvsSG1010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
	
?>
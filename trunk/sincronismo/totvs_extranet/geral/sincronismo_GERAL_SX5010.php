<?php 

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
	
	$sqlTotvsSX5010 = ociparse($totvsConexao,"SELECT X5_CHAVE
											  , X5_DESCRI
											  , X5_DESCSPA
											  , R_E_C_N_O_
											  , D_E_L_E_T_ from SX5010 where X5_TABELA ='CR'
										  AND D_E_L_E_T_ <> '*'
										  ORDER BY  R_E_C_N_O_");
	ociexecute($sqlTotvsSX5010);
	
	while($rowTotvsSX5010 = oci_fetch_array($sqlTotvsSX5010)){
		
	    $sqlPcpCor = mysql_query("SELECT null FROM tb_pcp_cor WHERE CO_RECNO = '".$rowTotvsSX5010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpCor) == 0){
					
			mysql_query("INSERT INTO tb_pcp_cor (CO_COR
				         , NO_COR
					     , DS_COR
					     , CO_RECNO)
					 	 VALUES('".$rowTotvsSX5010['X5_CHAVE']."' 
					         , '".$rowTotvsSX5010['X5_DESCRI']."' 
							 , '".$rowTotvsSX5010['X5_DESCSPA']."' 
							 , '".$rowTotvsSX5010['R_E_C_N_O_']."')",$conexaoExtranet);
		}
		
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
	
?>
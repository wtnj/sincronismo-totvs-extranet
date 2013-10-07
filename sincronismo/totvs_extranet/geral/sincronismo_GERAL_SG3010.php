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
	
	$conexaoExtranet = mysql_connect("192.168.0.118","root","")
	or die (mysql_error());
	
	$dbExtranet = mysql_select_db("extranet")
	or die ("<script>
			     alert('[Erro] - CONFIGURAÇÃO DO BANCO DE DADOS!');
				 window.close()';
			 </script>");
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo Iniciado...<br>";

	/* Convert EUC-JP to UTF-7 */
	$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");
	$sqlTotvsSA3010 = ociparse($totvsConexao,"SELECT 
												A3_FILIAL
												,A3_COD
												,A3_NOME
												,A3_NREDUZ
												,A3_END
												,A3_BAIRRO
												,A3_MUN
												,A3_EST
												,A3_CEP
												,A3_TEL
												,A3_TIPO
												,A3_CGC
												,A3_EMAIL
												,R_E_C_N_O_
												, D_E_L_E_T_
											   FROM SA3010  
										  WHERE D_E_L_E_T_ <> '*'
										  ORDER BY  R_E_C_N_O_");
	ociexecute($sqlTotvsSA3010);
	
	while($rowTotvsSA3010 = oci_fetch_array($sqlTotvsSA3010)){
		
	    $sqlPcpCor = mysql_query("SELECT null FROM tb_pcp_cor WHERE CO_RECNO = '".$rowTotvsSA3010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlPcpCor) == 0){
		
			$sql = "INSERT INTO tb_fat_vendedor (
						    CO_FILIAL
						 ,  CO_VENDEDOR
						 ,  NO_VENDEDOR
						 ,  NO_REDUZ_VENDEDOR
						 ,  DS_ENDERECO
						 ,  DS_BAIRRO
						 ,  DS_MUNICIPIO
						 ,  SG_UF
						 ,  NU_CEP
						 ,  NU_TEL
						 ,  TP_VENDEDOR
						 ,  CO_CGC
						 , EM_VENDEDOR 
						 , CO_RECNO)
					 	 VALUES('".$rowTotvsSA3010['A3_FILIAL']."' 
					         , '".$rowTotvsSA3010['A3_COD']."' 
							 , '". addslashes(trim(ucwords(strtolower($rowTotvsSA3010['A3_NOME']))))."' 
							 , '". addslashes(trim(ucwords(strtolower($rowTotvsSA3010['A3_NREDUZ']))))."' 						 
							 , '". addslashes(trim(ucwords(strtolower($rowTotvsSA3010['A3_END']))))."' 
							 , '". addslashes(trim(ucwords(strtolower($rowTotvsSA3010['A3_BAIRRO']))))."' 
							 , '". addslashes(trim(ucwords(strtolower($rowTotvsSA3010['A3_MUN']))))."' 
							, '".$rowTotvsSA3010['A3_EST']."' 			
							, '".$rowTotvsSA3010['A3_CEP']."' 			
							, '".trim(str_replace("-","",$rowTotvsSA3010['A3_TEL']))."'
							, '".$rowTotvsSA3010['A3_TIPO']."' 			
							, '".$rowTotvsSA3010['A3_CGC']."' 	
							, '". addslashes(trim(ucwords(strtolower($rowTotvsSA3010['A3_EMAIL']))))."'
							, '".$rowTotvsSA3010['R_E_C_N_O_']."')";

			mysql_query($sql,$conexaoExtranet);
		}
		
	}
	

	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
	
?>
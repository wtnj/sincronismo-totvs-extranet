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
	
	$sqlTotvsSA3010 = ociparse($totvsConexao,"SELECT A3_FILIAL
											      , A3_COD
											  	  , A3_NOME
											      , A3_NREDUZ
											      , A3_END
											      , A3_BAIRRO
											      , A3_MUN
											      , A3_EST
											      , A3_CEP
											      , A3_TEL
											      , A3_TIPO
											      , A3_CGC
											      , A3_EMAIL
											      , R_E_C_N_O_
											      , D_E_L_E_T_
											  FROM SA3010
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSA3010);
	
	while($rowTotvsSA3010 = oci_fetch_array($sqlTotvsSA3010)){
	
	    $sqlFatVendedor = mysql_query("SELECT null FROM tb_fat_vendedor WHERE CO_RECNO = '".$rowTotvsSA3010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlFatVendedor) == 0){
			
			if(trim($rowTotvsSA3010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("INSERT INTO tb_fat_vendedor (CO_FILIAL
				                 , CO_VENDEDOR
								 , NU_CPF_CNPJ
								 , TP_VENDEDOR
								 , NO_VENDEDOR
								 , NO_REDUZ_VENDEDOR
								 , DS_ENDERECO
								 , NO_BAIRRO
								 , NO_MUNICIPIO
								 , SG_UF
								 , NU_CEP
								 , NU_TEL
								 , EM_VENDEDOR
								 , CO_RECNO
								 , FL_DELET)
				     		 VALUES('".trim($rowTotvsSA3010['A3_FILIAL'])."'
							     , '".trim($rowTotvsSA3010['A3_COD'])."'
								 , '".trim($rowTotvsSA3010['A3_CGC'])."'
								 , '".trim($rowTotvsSA3010['A3_TIPO'])."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_NOME']))."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_NREDUZ']))."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_END']))."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_BAIRRO']))."'
								 , '".trim($rowTotvsSA3010['A3_MUN'])."'
								 , '".trim($rowTotvsSA3010['A3_EST'])."'
								 , '".trim($rowTotvsSA3010['A3_CEP'])."'
								 , '".trim($rowTotvsSA3010['A3_TEL'])."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_EMAIL']))."'
								 , '".$rowTotvsSA3010['R_E_C_N_O_']."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
			
			}else{
				
				mysql_query("INSERT INTO tb_fat_vendedor (CO_FILIAL
				                 , CO_VENDEDOR
								 , NU_CPF_CNPJ
								 , TP_VENDEDOR
								 , NO_VENDEDOR
								 , NO_REDUZ_VENDEDOR
								 , DS_ENDERECO
								 , NO_BAIRRO
								 , NO_MUNICIPIO
								 , SG_UF
								 , NU_CEP
								 , NU_TEL
								 , EM_VENDEDOR
								 , CO_RECNO)
				     		 VALUES('".trim($rowTotvsSA3010['A3_FILIAL'])."'
							     , '".trim($rowTotvsSA3010['A3_COD'])."'
								 , '".trim($rowTotvsSA3010['A3_CGC'])."'
								 , '".trim($rowTotvsSA3010['A3_TIPO'])."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_NOME']))."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_NREDUZ']))."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_END']))."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_BAIRRO']))."'
								 , '".trim($rowTotvsSA3010['A3_MUN'])."'
								 , '".trim($rowTotvsSA3010['A3_EST'])."'
								 , '".trim($rowTotvsSA3010['A3_CEP'])."'
								 , '".trim($rowTotvsSA3010['A3_TEL'])."'
								 , '".trim(addslashes($rowTotvsSA3010['A3_EMAIL']))."'
								 , '".$rowTotvsSA3010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSB1010['D_E_L_E_T_']) == '*'){
				
				mysql_query("UPDATE tb_fat_vendedor SET
							     CO_FILIAL           = '".trim($rowTotvsSA3010['A3_FILIAL'])."'
								 , CO_VENDEDOR       = '".trim($rowTotvsSA3010['A3_COD'])."'
								 , NU_CPF_CNPJ       = '".trim($rowTotvsSA3010['A3_CGC'])."'
								 , TP_VENDEDOR       = '".trim($rowTotvsSA3010['A3_TIPO'])."'
								 , NO_VENDEDOR       = '".trim(addslashes($rowTotvsSA3010['A3_NOME']))."'
								 , NO_REDUZ_VENDEDOR = '".trim(addslashes($rowTotvsSA3010['A3_NREDUZ']))."'
								 , DS_ENDERECO       = '".trim(addslashes($rowTotvsSA3010['A3_END']))."'
								 , NO_BAIRRO         = '".trim(addslashes($rowTotvsSA3010['A3_BAIRRO']))."'
								 , NO_MUNICIPIO      = '".trim($rowTotvsSA3010['A3_MUN'])."'
								 , SG_UF             = '".trim($rowTotvsSA3010['A3_EST'])."'
								 , NU_CEP            = '".trim($rowTotvsSA3010['A3_CEP'])."'
								 , NU_TEL            = '".trim($rowTotvsSA3010['A3_TEL'])."'
								 , EM_VENDEDOR       = '".trim(addslashes($rowTotvsSA3010['A3_EMAIL']))."'
								 , FL_DELET          = '*'
						 	 WHERE CO_RECNO = '".$rowTotvsSA3010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_fat_vendedor SET
							     CO_FILIAL           = '".trim($rowTotvsSA3010['A3_FILIAL'])."'
								 , CO_VENDEDOR       = '".trim($rowTotvsSA3010['A3_COD'])."'
								 , NU_CPF_CNPJ       = '".trim($rowTotvsSA3010['A3_CGC'])."'
								 , TP_VENDEDOR       = '".trim($rowTotvsSA3010['A3_TIPO'])."'
								 , NO_VENDEDOR       = '".trim(addslashes($rowTotvsSA3010['A3_NOME']))."'
								 , NO_REDUZ_VENDEDOR = '".trim(addslashes($rowTotvsSA3010['A3_NREDUZ']))."'
								 , DS_ENDERECO       = '".trim(addslashes($rowTotvsSA3010['A3_END']))."'
								 , NO_BAIRRO         = '".trim(addslashes($rowTotvsSA3010['A3_BAIRRO']))."'
								 , NO_MUNICIPIO      = '".trim($rowTotvsSA3010['A3_MUN'])."'
								 , SG_UF             = '".trim($rowTotvsSA3010['A3_EST'])."'
								 , NU_CEP            = '".trim($rowTotvsSA3010['A3_CEP'])."'
								 , NU_TEL            = '".trim($rowTotvsSA3010['A3_TEL'])."'
								 , EM_VENDEDOR       = '".trim(addslashes($rowTotvsSA3010['A3_EMAIL']))."'
						 	 WHERE CO_RECNO = '".$rowTotvsSA3010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>
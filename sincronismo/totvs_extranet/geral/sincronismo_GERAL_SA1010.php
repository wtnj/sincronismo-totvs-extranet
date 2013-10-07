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
	
	$sqlTotvsSA1010 = ociparse($totvsConexao,"SELECT A1_COD
											      , A1_LOJA
											      , A1_PESSOA
											      , A1_TIPO
											      , A1_NOME
											      , A1_NREDUZ
											      , A1_EMAIL
											      , A1_END
											      , A1_BAIRRO
											      , A1_EST
											      , A1_MUN
											      , A1_CEP
											      , A1_DDD
											      , A1_TEL
											      , A1_CGC
											      , A1_MSBLQL
											      , R_E_C_N_O_
											      , D_E_L_E_T_
											  FROM SA1010  
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSA1010);
	
	while($rowTotvsSA1010 = oci_fetch_array($sqlTotvsSA1010)){
	
	    $sqlFatCliente = mysql_query("SELECT null FROM tb_fat_cliente WHERE CO_RECNO = '".$rowTotvsSA1010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlFatCliente) == 0){
			
			if(trim($rowTotvsSA1010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("INSERT INTO tb_fat_cliente(CO_CLIENTE
				                 , CO_LOJA
								 , NU_CPF_CNPJ
								 , TP_CLIENTE
								 , FL_CLIENTE
								 , NO_CLIENTE
								 , NO_REDUZ_CLIENTE
								 , DS_ENDERECO
								 , NO_BAIRRO
								 , NO_MUNICIPIO
								 , SG_UF
								 , NU_CEP
								 , NU_DDD
								 , NU_TEL
								 , EM_CLIENTE
								 , CO_RECNO
								 , FL_BLOQUEADO
								 , FL_DELET)
							 VALUES('".trim($rowTotvsSA1010['A1_COD'])."' 
							     , '".trim($rowTotvsSA1010['A1_LOJA'])."' 
								 , '".trim($rowTotvsSA1010['A1_CGC'])."' 
								 , '".trim($rowTotvsSA1010['A1_PESSOA'])."' 
								 , '".trim($rowTotvsSA1010['A1_TIPO'])."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_NOME']))."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_NREDUZ']))."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_END']))."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_BAIRRO']))."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_MUN']))."' 
								 , '".trim($rowTotvsSA1010['A1_EST'])."' 
								 , '".trim($rowTotvsSA1010['A1_CEP'])."' 
								 , '".trim($rowTotvsSA1010['A1_DDD'])."' 
								 , '".trim($rowTotvsSA1010['A1_TEL'])."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_EMAIL']))."' 
								 , '".$rowTotvsSA1010['R_E_C_N_O_']."' 
								 , '".trim($rowTotvsSA1010['A1_MSBLQL'])."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
			
			}else{
				
				mysql_query("INSERT INTO tb_fat_cliente(CO_CLIENTE
				                 , CO_LOJA
								 , NU_CPF_CNPJ
								 , TP_CLIENTE
								 , FL_CLIENTE
								 , NO_CLIENTE
								 , NO_REDUZ_CLIENTE
								 , DS_ENDERECO
								 , NO_BAIRRO
								 , NO_MUNICIPIO
								 , SG_UF
								 , NU_CEP
								 , NU_DDD
								 , NU_TEL
								 , EM_CLIENTE
								 , CO_RECNO
								 , FL_BLOQUEADO)
							 VALUES('".trim($rowTotvsSA1010['A1_COD'])."' 
							     , '".trim($rowTotvsSA1010['A1_LOJA'])."' 
								 , '".trim($rowTotvsSA1010['A1_CGC'])."' 
								 , '".trim($rowTotvsSA1010['A1_PESSOA'])."' 
								 , '".trim($rowTotvsSA1010['A1_TIPO'])."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_NOME']))."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_NREDUZ']))."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_END']))."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_BAIRRO']))."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_MUN']))."' 
								 , '".trim($rowTotvsSA1010['A1_EST'])."' 
								 , '".trim($rowTotvsSA1010['A1_CEP'])."' 
								 , '".trim($rowTotvsSA1010['A1_DDD'])."' 
								 , '".trim($rowTotvsSA1010['A1_TEL'])."' 
								 , '".trim(addslashes($rowTotvsSA1010['A1_EMAIL']))."' 
								 , '".$rowTotvsSA1010['R_E_C_N_O_']."' 
								 , '".trim($rowTotvsSA1010['A1_MSBLQL'])."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSA1010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_fat_cliente SET
		                         CO_CLIENTE         = '".trim($rowTotvsSA1010['A1_COD'])."' 
								 , CO_LOJA          = '".trim($rowTotvsSA1010['A1_LOJA'])."' 
								 , NU_CPF_CNPJ      = '".trim($rowTotvsSA1010['A1_CGC'])."' 
								 , TP_CLIENTE       = '".trim($rowTotvsSA1010['A1_PESSOA'])."' 
								 , FL_CLIENTE       = '".trim($rowTotvsSA1010['A1_TIPO'])."' 
								 , NO_CLIENTE       = '".trim(addslashes($rowTotvsSA1010['A1_NOME']))."' 
								 , NO_REDUZ_CLIENTE = '".trim(addslashes($rowTotvsSA1010['A1_NREDUZ']))."' 
								 , DS_ENDERECO      = '".trim(addslashes($rowTotvsSA1010['A1_END']))."' 
								 , NO_BAIRRO        = '".trim(addslashes($rowTotvsSA1010['A1_BAIRRO']))."' 
								 , NO_MUNICIPIO     = '".trim(addslashes($rowTotvsSA1010['A1_MUN']))."' 
								 , SG_UF            = '".trim($rowTotvsSA1010['A1_EST'])."' 
								 , NU_CEP           = '".trim($rowTotvsSA1010['A1_CEP'])."' 
								 , NU_DDD           = '".trim($rowTotvsSA1010['A1_DDD'])."' 
								 , NU_TEL           = '".trim($rowTotvsSA1010['A1_TEL'])."' 
								 , EM_CLIENTE       = '".trim(addslashes($rowTotvsSA1010['A1_EMAIL']))."'   
								 , FL_BLOQUEADO     = '".trim($rowTotvsSA1010['A1_MSBLQL'])."'
								 , FL_DELET   	   = '*'
							 WHERE CO_RECNO = '".$rowTotvsSA1010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
					
			}else{
				
				mysql_query("UPDATE tb_fat_cliente SET
		                         CO_CLIENTE         = '".trim($rowTotvsSA1010['A1_COD'])."' 
								 , CO_LOJA          = '".trim($rowTotvsSA1010['A1_LOJA'])."' 
								 , NU_CPF_CNPJ      = '".trim($rowTotvsSA1010['A1_CGC'])."' 
								 , TP_CLIENTE       = '".trim($rowTotvsSA1010['A1_PESSOA'])."' 
								 , FL_CLIENTE       = '".trim($rowTotvsSA1010['A1_TIPO'])."' 
								 , NO_CLIENTE       = '".trim(addslashes($rowTotvsSA1010['A1_NOME']))."' 
								 , NO_REDUZ_CLIENTE = '".trim(addslashes($rowTotvsSA1010['A1_NREDUZ']))."' 
								 , DS_ENDERECO      = '".trim(addslashes($rowTotvsSA1010['A1_END']))."' 
								 , NO_BAIRRO        = '".trim(addslashes($rowTotvsSA1010['A1_BAIRRO']))."' 
								 , NO_MUNICIPIO     = '".trim(addslashes($rowTotvsSA1010['A1_MUN']))."' 
								 , SG_UF            = '".trim($rowTotvsSA1010['A1_EST'])."' 
								 , NU_CEP           = '".trim($rowTotvsSA1010['A1_CEP'])."' 
								 , NU_DDD           = '".trim($rowTotvsSA1010['A1_DDD'])."' 
								 , NU_TEL           = '".trim($rowTotvsSA1010['A1_TEL'])."' 
								 , EM_CLIENTE       = '".trim(addslashes($rowTotvsSA1010['A1_EMAIL']))."'   
								 , FL_BLOQUEADO     = '".trim($rowTotvsSA1010['A1_MSBLQL'])."'
							 WHERE CO_RECNO = '".$rowTotvsSA1010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>
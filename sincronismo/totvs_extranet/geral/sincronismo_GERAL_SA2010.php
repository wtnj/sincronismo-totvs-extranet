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
	
	$sqlTotvsSA2010 = ociparse($totvsConexao,"SELECT A2_COD
											      , A2_LOJA
												  , A2_NOME
												  , A2_NREDUZ
												  , A2_END
												  , A2_NR_END
												  , A2_BAIRRO
												  , A2_MUN
												  , A2_EST
												  , A2_CEP
												  , A2_TIPO
												  , A2_CGC
												  , A2_DDD
												  , A2_TEL
												  , A2_EMAIL
												  , A2_MSBLQL
												  , R_E_C_N_O_
											      , D_E_L_E_T_
											  FROM SA2010
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSA2010);
	
	while($rowTotvsSA2010 = oci_fetch_array($sqlTotvsSA2010)){
	
	    $sqlFatfornecedor = mysql_query("SELECT null FROM tb_fat_fornecedor WHERE CO_RECNO = '".$rowTotvsSA2010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlFatfornecedor) == 0){
			
			if(trim($rowTotvsSA2010['D_E_L_E_T_']) == '*'){
				
			    mysql_query( "INSERT INTO tb_fat_fornecedor (CO_FORNECEDOR
						          , CO_LOJA
								  , NU_CPF_CNPJ
								  , TP_FORNECEDOR
								  , NO_FORNECEDOR
								  , NO_REDUZ_FORNECEDOR
								  , DS_ENDERECO
								  , NO_BAIRRO
								  , NO_MUNICIPIO
								  , SG_UF
								  , NU_CEP
								  , NU_DDD
								  , NU_TEL
								  , EM_FORNECEDOR
								  , CO_RECNO
								  , FL_BLOQUEADO
								  , FL_DELET)
					 	 	  VALUES('".trim($rowTotvsSA2010['A2_COD'])."'
						          , '".trim($rowTotvsSA2010['A2_LOJA'])."'
								  , '".trim($rowTotvsSA2010['A2_CGC'])."'
								  , '".trim($rowTotvsSA2010['A2_TIPO'])."'
								  , '".trim(addslashes($rowTotvsSA2010['A2_NOME']))."'
								  , '".trim(addslashes($rowTotvsSA2010['A2_NREDUZ']))."'
								  , '".trim(addslashes($rowTotvsSA2010['A2_END']))."'
								  , '".trim(addslashes($rowTotvsSA2010['A2_BAIRRO']))."'
								  , '".trim(addslashes($rowTotvsSA2010['A2_MUN']))."'
								  , '".trim(addslashes($rowTotvsSA2010['A2_EST']))."'
								  , '".trim($rowTotvsSA2010['A2_CEP'])."'
								  , '".trim($rowTotvsSA2010['A2_DDD'])."'
								  , '".trim($rowTotvsSA2010['A2_TEL'])."'
								  , '".trim(addslashes($rowTotvsSA2010['A2_EMAIL']))."'
								  , '".$rowTotvsSA2010['R_E_C_N_O_']."'
								  , '".trim($rowTotvsSA2010['A2_MSBLQL'])."'
								  , '*')",$conexaoExtranet)or die(mysql_error());
			
			}else{
				
			    mysql_query("INSERT INTO tb_fat_fornecedor (CO_FORNECEDOR
						         , CO_LOJA
								 , NU_CPF_CNPJ
								 , TP_FORNECEDOR
								 , NO_FORNECEDOR
								 , NO_REDUZ_FORNECEDOR
								 , DS_ENDERECO
								 , NO_BAIRRO
								 , NO_MUNICIPIO
								 , SG_UF
								 , NU_CEP
								 , NU_DDD
								 , NU_TEL
								 , EM_FORNECEDOR
								 , CO_RECNO
								 , FL_BLOQUEADO)
					 	     VALUES('".trim($rowTotvsSA2010['A2_COD'])."'
						         , '".trim($rowTotvsSA2010['A2_LOJA'])."'
								 , '".trim($rowTotvsSA2010['A2_CGC'])."'
								 , '".trim($rowTotvsSA2010['A2_TIPO'])."'
								 , '".trim(addslashes($rowTotvsSA2010['A2_NOME']))."'
								 , '".trim(addslashes($rowTotvsSA2010['A2_NREDUZ']))."'
								 , '".trim(addslashes($rowTotvsSA2010['A2_END']))."'
								 , '".trim(addslashes($rowTotvsSA2010['A2_BAIRRO']))."'
								 , '".trim(addslashes($rowTotvsSA2010['A2_MUN']))."'
								 , '".trim(addslashes($rowTotvsSA2010['A2_EST']))."'
								 , '".trim($rowTotvsSA2010['A2_CEP'])."'
								 , '".trim($rowTotvsSA2010['A2_DDD'])."'
								 , '".trim($rowTotvsSA2010['A2_TEL'])."'
								 , '".trim(addslashes($rowTotvsSA2010['A2_EMAIL']))."'
								 , '".$rowTotvsSA2010['R_E_C_N_O_']."'
								 , '".trim($rowTotvsSA2010['A2_MSBLQL'])."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSB1010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_fat_fornecedor SET
		                         CO_FORNECEDOR         = '".trim($rowTotvsSA2010['A2_COD'])."'
								 , CO_LOJA             = '".trim($rowTotvsSA2010['A2_LOJA'])."'
								 , NU_CPF_CNPJ         = '".trim($rowTotvsSA2010['A2_CGC'])."'
								 , TP_FORNECEDOR       = '".trim($rowTotvsSA2010['A2_TIPO'])."'
								 , NO_FORNECEDOR       = '".trim(addslashes($rowTotvsSA2010['A2_NOME']))."'
								 , NO_REDUZ_FORNECEDOR = '".trim(addslashes($rowTotvsSA2010['A2_NREDUZ']))."'
								 , DS_ENDERECO         = '".trim(addslashes($rowTotvsSA2010['A2_END']))."'
								 , NO_BAIRRO           = '".trim(addslashes($rowTotvsSA2010['A2_BAIRRO']))."'
								 , NO_MUNICIPIO        = '".trim(addslashes($rowTotvsSA2010['A2_MUN']))."'
								 , SG_UF               = '".trim(addslashes($rowTotvsSA2010['A2_EST']))."'
								 , NU_CEP              = '".trim($rowTotvsSA2010['A2_CEP'])."'
								 , NU_DDD              = '".trim($rowTotvsSA2010['A2_DDD'])."'
								 , NU_TEL              = '".trim($rowTotvsSA2010['A2_TEL'])."'
								 , EM_FORNECEDOR       = '".trim(addslashes($rowTotvsSA2010['A2_EMAIL']))."'
								 , FL_BLOQUEADO        = '".trim($rowTotvsSA2010['A2_MSBLQL'])."' 
								 , FL_DELET            = '*'
					 		 WHERE CO_RECNO = '".$rowTotvsSA2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_fat_fornecedor SET
		                         CO_FORNECEDOR         = '".trim($rowTotvsSA2010['A2_COD'])."'
								 , CO_LOJA             = '".trim($rowTotvsSA2010['A2_LOJA'])."'
								 , NU_CPF_CNPJ         = '".trim($rowTotvsSA2010['A2_CGC'])."'
								 , TP_FORNECEDOR       = '".trim($rowTotvsSA2010['A2_TIPO'])."'
								 , NO_FORNECEDOR       = '".trim(addslashes($rowTotvsSA2010['A2_NOME']))."'
								 , NO_REDUZ_FORNECEDOR = '".trim(addslashes($rowTotvsSA2010['A2_NREDUZ']))."'
								 , DS_ENDERECO         = '".trim(addslashes($rowTotvsSA2010['A2_END']))."'
								 , NO_BAIRRO           = '".trim(addslashes($rowTotvsSA2010['A2_BAIRRO']))."'
								 , NO_MUNICIPIO        = '".trim(addslashes($rowTotvsSA2010['A2_MUN']))."'
								 , SG_UF               = '".trim(addslashes($rowTotvsSA2010['A2_EST']))."'
								 , NU_CEP              = '".trim($rowTotvsSA2010['A2_CEP'])."'
								 , NU_DDD              = '".trim($rowTotvsSA2010['A2_DDD'])."'
								 , NU_TEL              = '".trim($rowTotvsSA2010['A2_TEL'])."'
								 , EM_FORNECEDOR       = '".trim(addslashes($rowTotvsSA2010['A2_EMAIL']))."'
								 , FL_BLOQUEADO        = '".trim($rowTotvsSA2010['A2_MSBLQL'])."' 
					 		 WHERE CO_RECNO = '".$rowTotvsSA2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>
﻿	
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
			 
    $sqlTotvsDA4010 = ociparse($totvsConexao,"SELECT DA4_FILIAL
											      , DA4_COD
												  , DA4_NOME
											      , DA4_NREDUZ
											      , DA4_END
											      , DA4_BAIRRO
											      , DA4_MUN
											      , DA4_EST
											      , DA4_CEP
											      , DA4_CGC
											      , DA4_TEL
											      , DA4_BLQMOT
											      , DA4_TRANPO
											      , R_E_C_N_O_
											      , D_E_L_E_T_
											  FROM DA4010
										      ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsDA4010);
	
	while($rowTotvsDA4010 = oci_fetch_array($sqlTotvsDA4010)){
			
	    $sqlFatMotorista = mysql_query("SELECT null FROM tb_fat_motorista WHERE CO_RECNO = '".$rowTotvsDA4010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		if(mysql_num_rows($sqlFatMotorista) == 0){
			
			if(trim($rowTotvsDA4010['D_E_L_E_T_']) == '*'){
				
				mysql_query("INSERT INTO tb_fat_motorista (CO_FILIAL
							     , CO_MOTORISTA
								 , NU_CPF_CNPJ
								 , NO_MOTORISTA
								 , NO_REDUZ_MOTORISTA
								 , DS_ENDERECO
								 , NO_BAIRRO
								 , NO_MUNICIPIO
								 , SG_UF
								 , NU_CEP
								 , NU_TEL
								 , CO_TRANSPORTADORA
								 , FL_BLOQUEADO
								 , CO_RECNO
								 , FL_DELET)
							 VALUES('".trim($rowTotvsDA4010['DA4_FILIAL'])."' 
							     , '".trim($rowTotvsDA4010['DA4_COD'])."' 
								 , '".trim($rowTotvsDA4010['DA4_CGC'])."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_NOME']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_NREDUZ']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_END']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_BAIRRO']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_MUN']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_EST']))."' 
								 , '".trim($rowTotvsDA4010['DA4_CEP'])."' 
								 , '".trim($rowTotvsDA4010['DA4_TEL'])."' 
								 , '".trim($rowTotvsDA4010['DA4_TRANPO'])."' 
								 , '".trim($rowTotvsDA4010['DA4_BLQMOT'])."' 
								 , '".trim($rowTotvsDA4010['R_E_C_N_O_'])."'
								 , '*')",$conexaoExtranet)or die(mysql_error());
						
			}else{
			
			    mysql_query("INSERT INTO tb_fat_motorista (CO_FILIAL
							     , CO_MOTORISTA
								 , NU_CPF_CNPJ
								 , NO_MOTORISTA
								 , NO_REDUZ_MOTORISTA
								 , DS_ENDERECO
								 , NO_BAIRRO
								 , NO_MUNICIPIO
								 , SG_UF
								 , NU_CEP
								 , NU_TEL
								 , CO_TRANSPORTADORA
								 , FL_BLOQUEADO
								 , CO_RECNO)
							 VALUES('".trim($rowTotvsDA4010['DA4_FILIAL'])."' 
							     , '".trim($rowTotvsDA4010['DA4_COD'])."' 
								 , '".trim($rowTotvsDA4010['DA4_CGC'])."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_NOME']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_NREDUZ']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_END']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_BAIRRO']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_MUN']))."' 
								 , '".trim(addslashes($rowTotvsDA4010['DA4_EST']))."' 
								 , '".trim($rowTotvsDA4010['DA4_CEP'])."' 
								 , '".trim($rowTotvsDA4010['DA4_TEL'])."' 
								 , '".trim($rowTotvsDA4010['DA4_TRANPO'])."' 
								 , '".trim($rowTotvsDA4010['DA4_BLQMOT'])."' 
								 , '".trim($rowTotvsDA4010['R_E_C_N_O_'])."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsDA4010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_fat_motorista SET
							     CO_FILIAL            = '".trim($rowTotvsDA4010['DA4_FILIAL'])."' 
								 , CO_MOTORISTA       = '".trim($rowTotvsDA4010['DA4_COD'])."' 
								 , NU_CPF_CNPJ        = '".trim($rowTotvsDA4010['DA4_CGC'])."' 
								 , NO_MOTORISTA       = '".trim(addslashes($rowTotvsDA4010['DA4_NOME']))."' 
								 , NO_REDUZ_MOTORISTA = '".trim(addslashes($rowTotvsDA4010['DA4_NREDUZ']))."' 
								 , DS_ENDERECO        = '".trim(addslashes($rowTotvsDA4010['DA4_END']))."' 
								 , NO_BAIRRO          = '".trim(addslashes($rowTotvsDA4010['DA4_BAIRRO']))."' 
								 , NO_MUNICIPIO       = '".trim(addslashes($rowTotvsDA4010['DA4_MUN']))."' 
								 , SG_UF              = '".trim(addslashes($rowTotvsDA4010['DA4_EST']))."' 
								 , NU_CEP             = '".trim($rowTotvsDA4010['DA4_CEP'])."' 
								 , NU_TEL             = '".trim($rowTotvsDA4010['DA4_TEL'])."' 
								 , CO_TRANSPORTADORA  = '".trim($rowTotvsDA4010['DA4_TRANPO'])."' 
								 , FL_BLOQUEADO       = '".trim($rowTotvsDA4010['DA4_BLQMOT'])."' 
								 , FL_DELET           = '*'					 
							 WHERE CO_RECNO = '".$rowTotvsDA4010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
			    mysql_query("UPDATE tb_fat_motorista SET
		                         CO_FILIAL            = '".trim($rowTotvsDA4010['DA4_FILIAL'])."' 
								 , CO_MOTORISTA       = '".trim($rowTotvsDA4010['DA4_COD'])."' 
								 , NU_CPF_CNPJ        = '".trim($rowTotvsDA4010['DA4_CGC'])."' 
								 , NO_MOTORISTA       = '".trim(addslashes($rowTotvsDA4010['DA4_NOME']))."' 
								 , NO_REDUZ_MOTORISTA = '".trim(addslashes($rowTotvsDA4010['DA4_NREDUZ']))."' 
								 , DS_ENDERECO        = '".trim(addslashes($rowTotvsDA4010['DA4_END']))."' 
								 , NO_BAIRRO          = '".trim(addslashes($rowTotvsDA4010['DA4_BAIRRO']))."' 
								 , NO_MUNICIPIO       = '".trim(addslashes($rowTotvsDA4010['DA4_MUN']))."' 
								 , SG_UF              = '".trim(addslashes($rowTotvsDA4010['DA4_EST']))."' 
								 , NU_CEP             = '".trim($rowTotvsDA4010['DA4_CEP'])."' 
								 , NU_TEL             = '".trim($rowTotvsDA4010['DA4_TEL'])."' 
								 , CO_TRANSPORTADORA  = '".trim($rowTotvsDA4010['DA4_TRANPO'])."' 
								 , FL_BLOQUEADO       = '".trim($rowTotvsDA4010['DA4_BLQMOT'])."'
							 WHERE CO_RECNO = '".$rowTotvsDA4010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
							
			}
			
		}
	
	}
	
	oci_close($totvsConexao);
	
	echo "[ ".date("d/m/Y h:i:s")." ] Sincronismo finalizado...";
			
?>
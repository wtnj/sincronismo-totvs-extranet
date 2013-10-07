<?php

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
										      WHERE R_E_C_N_O_ = ".$rowTotvsLog["R_E_C_N_O_"]);
	ociexecute($sqlTotvsSA2010);
	$rowTotvsSA2010 = oci_fetch_array($sqlTotvsSA2010);
			
	if($rowTotvsLog["TP_LOG"] == "Insert"){
	
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
											
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
	
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
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
				
	    if(trim($rowTotvsSA2010['D_E_L_E_T_']) == '*'){
			
	    	mysql_query("UPDATE tb_fat_cliente SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSA2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
	    }else{
			
	    	mysql_query("UPDATE tb_fat_cliente SET FL_DELET = null WHERE CO_RECNO = '".$rowTotvsSA2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
	    }
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_fat_cliente SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSA2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
	}
			
?>
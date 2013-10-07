<?php

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
										      WHERE R_E_C_N_O_ = ".$rowTotvsLog["R_E_C_N_O_"]);
	ociexecute($sqlTotvsSA3010);
	$rowTotvsSA3010 = oci_fetch_array($sqlTotvsSA3010);
			
	if($rowTotvsLog["TP_LOG"] == "Insert"){
	
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
											
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
					
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
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
				
	    if(trim($rowTotvsSA3010['D_E_L_E_T_']) == '*'){
			
	    	mysql_query("UPDATE tb_fat_vendedor SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSA3010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
	    }else{
			
	    	mysql_query("UPDATE tb_fat_vendedor SET FL_DELET = null WHERE CO_RECNO = '".$rowTotvsSA3010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
	    }
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_fat_vendedor SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSA3010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
	}
			
?>
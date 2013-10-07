<?php

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
											  WHERE R_E_C_N_O_ = '".$rowTotvsLog["R_E_C_N_O_"]."'");
	ociexecute($sqlTotvsDA4010);
	$rowTotvsDA4010 = oci_fetch_array($sqlTotvsDA4010);
			
	if($rowTotvsLog["TP_LOG"] == "Insert"){
	
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
											
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
	
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
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
				
	    if(trim($rowTotvsDA4010['D_E_L_E_T_']) == '*'){
			
	    	mysql_query("UPDATE tb_fat_motorista SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsDA4010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
	    }else{
			
	    	mysql_query("UPDATE tb_fat_motorista SET FL_DELET = null WHERE CO_RECNO = '".$rowTotvsDA4010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
	    }
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_fat_motorista SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsDA4010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
	}
			
?>
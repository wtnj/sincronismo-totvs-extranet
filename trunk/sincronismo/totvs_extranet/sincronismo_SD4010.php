<?php

    $sqlTotvsSD4010 = ociparse($totvsConexao,"SELECT D4_COD
	                                              , D4_LOCAL
												  , D4_OP
												  , D4_OPORIG
												  , D4_QUANT
												  , D4_QTDEORI
												  , D4_QTSEGUM
												  , D4_DATA
												  , D_E_L_E_T_
												  , R_E_C_N_O_
										      FROM SD4010 
										      WHERE R_E_C_N_O_ = '".$rowTotvsLog["R_E_C_N_O_"]."'");
	ociexecute($sqlTotvsSD4010);
	$rowTotvsSD4010 = oci_fetch_array($sqlTotvsSD4010);
	
	$qtdAjusteEmpenho = (string)($rowTotvsSD4010['D4_QUANT']);
	if(substr($qtdAjusteEmpenho,0,1) == '.' || substr($qtdAjusteEmpenho,0,1) == ','){
		$qtdAjusteEmpenho = '0'.$qtdAjusteEmpenho;
	}
			
	$qtdOrigem = (string)($rowTotvsSD4010['D4_QTDEORI']);
	if(substr($qtdOrigem,0,1) == '.' || substr($qtdOrigem,0,1) == ','){
		$qtdOrigem = '0'.$qtdOrigem;
	}
		
	$qtdSegUM = (string)($rowTotvsSD4010['D4_QTSEGUM']);
	if(substr($qtdSegUM,0,1) == '.' || substr($qtdSegUM,0,1) == ','){
		$qtdSegUM = '0'.$qtdSegUM;
	}
	
	if($rowTotvsLog["TP_LOG"] == "Insert"){
			    			
	    mysql_query("INSERT INTO tb_pcp_ajuste_empenho (CO_PRODUTO
				         , NU_ARMAZEM
						 , NU_OP
						 , NU_OP_ORIGEM
						 , SALDO_EMPENHO
						 , QTD_ORIGEM
						 , QTD_SEG_UM
						 , DT_CADASTRO
						 , CO_RECNO)
					 VALUES('".$rowTotvsSD4010['D4_COD']."' 
					     , '".$rowTotvsSD4010['D4_LOCAL']."'
						 , '".$rowTotvsSD4010['D4_OP']."'
						 , '".$rowTotvsSD4010['D4_OPORIG']."'
						 , '".$qtdAjusteEmpenho."'
						 , '".$qtdOrigem."'
						 , '".$qtdSegUM."'
						 , '".$rowTotvsSD4010['D4_DATA']."'
						 , '".$rowTotvsSD4010['R_E_C_N_O_']."')",$conexaoExtranet);
											
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
				
	    mysql_query("UPDATE tb_pcp_ajuste_empenho SET
		                 CO_PRODUTO           = '".$rowTotvsSD4010['D4_COD']."'
				         , NU_ARMAZEM         = '".$rowTotvsSD4010['D4_LOCAL']."'
						 , NU_OP              = '".$rowTotvsSD4010['D4_OP']."'
						 , NU_OP_ORIGEM       = '".$rowTotvsSD4010['D4_OPORIG']."'
						 , SALDO_EMPENHO      = '".$qtdAjusteEmpenho."'
						 , QTD_ORIGEM         = '".$qtdOrigem."'
						 , QTD_SEG_UM         = '".$qtdSegUM."' 
				         , DT_CADASTRO        = '".$rowTotvsSD4010['D4_DATA']."'
					 WHERE CO_RECNO = '".$rowTotvsSD4010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
		
	    if(trim($rowTotvsSD4010['D_E_L_E_T_']) == '*'){
			
	    	mysql_query("UPDATE tb_pcp_ajuste_empenho SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSD4010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	    }else{
		
	    	mysql_query("UPDATE tb_pcp_ajuste_empenho SET FL_DELET = null WHERE CO_RECNO = '".$rowTotvsSD4010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	    }
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_pcp_ajuste_empenho SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSD4010['R_E_C_N_O_']."'",$conexaoExtranet);
				
	}
			
?>
<?php 
	
	$sqlPcpUltimoApontamentoEstorno = mysql_query("SELECT CO_PCP_APONTAMENTO
    										           , CO_PCP_OP
												       , NU_OP
												       , DATE_FORMAT(DT_INICIO_APONTAMENTO, '%Y%m%d') AS DT_INICIO_APONTAMENTO
												       , DATE_FORMAT(DT_FINAL_APONTAMENTO, '%Y%m%d') AS DT_FINAL_APONTAMENTO 
												       , HR_INICIO
												       , HR_FIM
												       , CO_PRODUTO
												       , CO_INT_PRODUTO
												       , CO_COR
												       , QTD_PRODUTO
												       , CO_PCP_OPERACAO
												       , CO_OPERACAO 
												       , CO_PCP_RECURSO
												       , CO_RECURSO
												       , LG_USUARIO 
											       FROM vw_pcp_produto_pi_ultimo_apontamento_estorno
											       WHERE FL_SINCRONISMO_APONTAMENTO_ESTORNO IS NULL
												   AND CO_PCP_APONTAMENTO = '35891'
											       ORDER BY CO_PCP_APONTAMENTO",$conexaoExtranet)
	or die(mysql_error());
		
	if(mysql_num_rows($sqlPcpUltimoApontamentoEstorno) > 0){
	    
		while($rowPcpUltimoApontamentoEstorno=mysql_fetch_array($sqlPcpUltimoApontamentoEstorno)){ 
			
			$sqlVerificaIntegracaoTotvsApontamentoEstorno = ociparse($totvsConexao,"SELECT COUNT(*) AS COUNT_ROWS FROM ZP0010 WHERE ZP0_XCODEX = '".$rowPcpUltimoApontamentoEstorno['CO_PCP_APONTAMENTO']."' AND ZP0_XTPINT = '1'");
	    	ociexecute($sqlVerificaIntegracaoTotvsApontamentoEstorno);	
			
			$rowVerificaIntegracaoTotvsApontamentoEstorno = oci_fetch_array($sqlVerificaIntegracaoTotvsApontamentoEstorno);
			
			if($rowVerificaIntegracaoTotvsApontamentoEstorno['COUNT_ROWS'] > 0){
				
			    //INICIO CAPTURA O CODIGO DO ULTIMO R_E_C_N_O_ DA TABELA
				$sqlIntegraçãoTotvsRecno = ociparse($totvsConexao,"SELECT MAX(R_E_C_N_O_) AS R_E_C_N_O FROM ZP0010");
				ociexecute($sqlIntegraçãoTotvsRecno);	
				
				$rowIntegraçãoTotvsRecno = oci_fetch_array($sqlIntegraçãoTotvsRecno);
				
				if($rowIntegraçãoTotvsRecno['R_E_C_N_O'] > 0){
					$recnoIntegracaoApontamentoEstorno = $rowIntegraçãoTotvsRecno['R_E_C_N_O']+1;
				}else{
					$recnoIntegracaoApontamentoEstorno = 1;
				}
				//FIM CAPTURA O CODIGO DO ULTIMO R_E_C_N_O_ DA TABELA
			
				//INICIO CAPTURA O CODIGO DA ULTIMA INTEGRACAO DA TABELA
				$sqlIntegraçãoTotvsCodigoIntegracao = ociparse($totvsConexao,"SELECT MAX(ZP0_XCOINT) AS ZP0_XCOINT FROM ZP0010");
				ociexecute($sqlIntegraçãoTotvsCodigoIntegracao);	
				
				$rowIntegraçãoTotvsCodigoIntegracao = oci_fetch_array($sqlIntegraçãoTotvsCodigoIntegracao);
				
				if($rowIntegraçãoTotvsCodigoIntegracao['ZP0_XCOINT'] > 0){
					$codigoIntegracaoApontamentoEstorno = $rowIntegraçãoTotvsCodigoIntegracao['ZP0_XCOINT']+1;
				}else{
					$codigoIntegracaoApontamentoEstorno = 1;
				}
				//FIM CAPTURA O CODIGO DA ULTIMA INTEGRACAO DA TABELA
				
				$dataCadastro    = date("Ymd");
				$horaCadastro    = date("H:i:s");
				$tipoApontamento = '2';	
				
				$sqlParametro = mysql_query("SELECT NO_PARAMETRO, VL_PARAMETRO FROM tb_parametro",$conexaoExtranet)
				or die(mysql_error());
			
				while($rowParametro=mysql_fetch_array($sqlParametro)){ 			
					
					switch($rowParametro['NO_PARAMETRO']){
						case "PARAMETRO_01":
							$armazemApontamentoEstorno = $rowParametro['VL_PARAMETRO'];
							break;
						case "PARAMETRO_02":
							$filialApontamentoEstorno  = $rowParametro['VL_PARAMETRO'];
							break;
						case "PARAMETRO_03":
							$statusApontamentoEstorno  = $rowParametro['VL_PARAMETRO'];
							break;
					}

				}	
			
				$sqlIntegracaoTotvsApontamentoEstorno = ociparse($totvsConexao,"INSERT INTO ZP0010 (ZP0_XCOINT
																					, ZP0_XDCAIN 
																				    , ZP0_HRCADI
																					, ZP0_XCODEX
																					, ZP0_XTPINT 
																					, ZP0_XSTINT 
																					, ZP0_FILIAL
																					, ZP0_DTAPON
																					, ZP0_DTPROD
																					, ZP0_DATAIN
																					, ZP0_DATAFI
																					, ZP0_HORAIN
																					, ZP0_HORAFI 
																					, ZP0_OP
																					, ZP0_PRODUT
																					, ZP0_CODINT
																					, ZP0_COR
																					, ZP0_QTDPRO
																					, ZP0_LOCAL 
																					, ZP0_OPERAC
																					, ZP0_RECURS
																					, ZP0_OPERAD
																					, R_E_C_N_O_)
																				VALUES('".$codigoIntegracaoApontamentoEstorno."'
																				    , '".$dataCadastro."'
																					, '".$horaCadastro."'
																					, '".$rowPcpUltimoApontamentoEstorno['CO_PCP_APONTAMENTO']."'
																					, '".$tipoApontamento."'
																					, '".$statusApontamentoEstorno."'
																					, '".$filialApontamentoEstorno."'
																					, '".$rowPcpUltimoApontamentoEstorno['DT_INICIO_APONTAMENTO']."'
																					, '".$rowPcpUltimoApontamentoEstorno['DT_INICIO_APONTAMENTO']."'
																					, '".$rowPcpUltimoApontamentoEstorno['DT_INICIO_APONTAMENTO']."'
																					, '".$rowPcpUltimoApontamentoEstorno['DT_INICIO_APONTAMENTO']."'
																					, '".$rowPcpUltimoApontamentoEstorno['HR_INICIO']."'
																					, '".$rowPcpUltimoApontamentoEstorno['HR_FIM']."'
																					, '".$rowPcpUltimoApontamentoEstorno['NU_OP']."'
																					, '".$rowPcpUltimoApontamentoEstorno['CO_PRODUTO']."'
																					, '".$rowPcpUltimoApontamentoEstorno['CO_INT_PRODUTO']."'
																					, '".$rowPcpUltimoApontamentoEstorno['CO_COR']."'
																					, '".$rowPcpUltimoApontamentoEstorno['QTD_PRODUTO']."'
																					, '".$armazemApontamentoEstorno."'
																					, '".$rowPcpUltimoApontamentoEstorno['CO_OPERACAO']."'
																					, '".$rowPcpUltimoApontamentoEstorno['CO_RECURSO']."'
																					, '".$rowPcpUltimoApontamentoEstorno['LG_USUARIO']."'
																					, '".$recnoIntegracaoApontamentoEstorno."')");
						
				if(ociexecute($sqlIntegracaoTotvsApontamentoEstorno)){
			    
					mysql_query("UPDATE tb_pcp_apontamento SET
									 FL_SINCRONISMO_APONTAMENTO_ESTORNO = '*'
								 WHERE CO_PCP_APONTAMENTO = '".$rowPcpUltimoApontamentoEstorno['CO_PCP_APONTAMENTO']."'",$conexaoExtranet)or die(mysql_error());
					
				}
				
			}
				
		}
		
	}
	
?>
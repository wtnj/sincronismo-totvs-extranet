<?php 
	
	$sqlPcpUltimoApontamento = mysql_query("SELECT CO_PCP_APONTAMENTO
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
											FROM vw_pcp_produto_pi_ultimo_apontamento
											WHERE FL_SINCRONISMO_APONTAMENTO IS NULL
											ORDER BY CO_PCP_APONTAMENTO",$conexaoExtranet)
	or die(mysql_error());
		
	if(mysql_num_rows($sqlPcpUltimoApontamento) > 0){
	    
		while($rowPcpUltimoApontamento=mysql_fetch_array($sqlPcpUltimoApontamento)){ 
			
			$sqlVerificaIntegracaoTotvsApontamento = ociparse($totvsConexao,"SELECT ZP0_XCODEX FROM ZP0010 WHERE ZP0_XCODEX = '".$rowPcpUltimoApontamento['CO_PCP_APONTAMENTO']."'");
	    	ociexecute($sqlVerificaIntegracaoTotvsApontamento);	
			
			if(ocirowcount($sqlVerificaIntegracaoTotvsApontamento) == null){
				
			    //INICIO CAPTURA O CODIGO DO ULTIMO R_E_C_N_O_ DA TABELA
				$sqlIntegraçãoTotvsRecno = ociparse($totvsConexao,"SELECT MAX(R_E_C_N_O_) AS R_E_C_N_O FROM ZP0010");
				ociexecute($sqlIntegraçãoTotvsRecno);	
				
				$rowIntegraçãoTotvsRecno = oci_fetch_array($sqlIntegraçãoTotvsRecno);
				
				if($rowIntegraçãoTotvsRecno['R_E_C_N_O'] > 0){
					$recnoIntegracaoApontamento = $rowIntegraçãoTotvsRecno['R_E_C_N_O']+1;
				}else{
					$recnoIntegracaoApontamento = 1;
				}
				//FIM CAPTURA O CODIGO DO ULTIMO R_E_C_N_O_ DA TABELA
			
				//INICIO CAPTURA O CODIGO Da ULTIMA INTEGRACAO DA TABELA
				$sqlIntegraçãoTotvsCodigoIntegracao = ociparse($totvsConexao,"SELECT MAX(ZP0_XCOINT) AS ZP0_XCOINT FROM ZP0010");
				ociexecute($sqlIntegraçãoTotvsCodigoIntegracao);	
				
				$rowIntegraçãoTotvsCodigoIntegracao = oci_fetch_array($sqlIntegraçãoTotvsCodigoIntegracao);
				
				if($rowIntegraçãoTotvsCodigoIntegracao['ZP0_XCOINT'] > 0){
					$codigoIntegracaoApontamento = $rowIntegraçãoTotvsCodigoIntegracao['ZP0_XCOINT']+1;
				}else{
					$codigoIntegracaoApontamento = 1;
				}
				//FIM CAPTURA O CODIGO DA ULTIMA INTEGRACAO DA TABELA
				
				$dataCadastro    = date("Ymd");
				$horaCadastro    = date("h:i:s");
				$tipoApontamento = '1';	
				
				$sqlParametro = mysql_query("SELECT NO_PARAMETRO, VL_PARAMETRO FROM tb_parametro",$conexaoExtranet)
				or die(mysql_error());
			
				while($rowParametro=mysql_fetch_array($sqlParametro)){ 			
					
					switch($rowParametro['NO_PARAMETRO']){
						case "PARAMETRO_01":
							$armazemApontamento = $rowParametro['VL_PARAMETRO'];
							break;
						case "PARAMETRO_02":
							$filialApontamento  = $rowParametro['VL_PARAMETRO'];
							break;
						case "PARAMETRO_03":
							$statusApontamento  = $rowParametro['VL_PARAMETRO'];
							break;
					}

				}	
			
				$sqlIntegracaoTotvsApontamento = ociparse($totvsConexao,"INSERT INTO ZP0010 (ZP0_XCOINT
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
																		 VALUES('".$codigoIntegracaoApontamento."'
																			 , '".$dataCadastro."'
																			 , '".$horaCadastro."'
																			 , '".$rowPcpUltimoApontamento['CO_PCP_APONTAMENTO']."'
																			 , '".$tipoApontamento."'
																			 , '".$statusApontamento."'
																			 , '".$filialApontamento."'
																			 , '".$rowPcpUltimoApontamento['DT_INICIO_APONTAMENTO']."'
																			 , '".$rowPcpUltimoApontamento['DT_INICIO_APONTAMENTO']."'
																			 , '".$rowPcpUltimoApontamento['DT_INICIO_APONTAMENTO']."'
																			 , '".$rowPcpUltimoApontamento['DT_INICIO_APONTAMENTO']."'
																			 , '".$rowPcpUltimoApontamento['HR_INICIO']."'
																			 , '".$rowPcpUltimoApontamento['HR_FIM']."'
																			 , '".$rowPcpUltimoApontamento['NU_OP']."'
																			 , '".$rowPcpUltimoApontamento['CO_PRODUTO']."'
																			 , '".$rowPcpUltimoApontamento['CO_INT_PRODUTO']."'
																			 , '".$rowPcpUltimoApontamento['CO_COR']."'
																			 , '".$rowPcpUltimoApontamento['QTD_PRODUTO']."'
																			 , '".$armazemApontamento."'
																			 , '".$rowPcpUltimoApontamento['CO_OPERACAO']."'
																			 , '".$rowPcpUltimoApontamento['CO_RECURSO']."'
																			 , '".$rowPcpUltimoApontamento['LG_USUARIO']."'
																			 , '".$recnoIntegracaoApontamento."')");
						
				if(ociexecute($sqlIntegracaoTotvsApontamento)){
			    
					mysql_query("UPDATE tb_pcp_apontamento SET
									 FL_SINCRONISMO_APONTAMENTO = '*'
								 WHERE CO_PCP_APONTAMENTO = '".$rowPcpUltimoApontamento['CO_PCP_APONTAMENTO']."'",$conexaoExtranet)or die(mysql_error());
					
				}
				
			}
				
		}
		
	}
	
?>
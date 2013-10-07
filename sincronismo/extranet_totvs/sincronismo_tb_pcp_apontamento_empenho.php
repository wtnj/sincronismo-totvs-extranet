<?php 
	
	$sqlPcpApontamentoEmpenho = mysql_query("SELECT PCP_APONTAMENTO_EMPENHO.CO_PCP_APONTAMENTO_EMPENHO
												 , DATE_FORMAT(PCP_APONTAMENTO_EMPENHO.DT_APONTAMENTO_EMPENHO, '%Y%m%d') AS DT_APONTAMENTO_EMPENHO
											     , PCP_APONTAMENTO_EMPENHO.CO_PCP_OP
											     , CONCAT(PCP_OP.CO_NUM, PCP_OP.CO_ITEM, PCP_OP.CO_SEQUENCIA) AS NU_OP
											     , PCP_APONTAMENTO_EMPENHO.NU_ARMAZEM
												 , PCP_APONTAMENTO_EMPENHO.CO_PRODUTO_ORIGEM
												 , PCP_APONTAMENTO_EMPENHO.QTD_EMPENHO_ORIGEM
												 , PCP_APONTAMENTO_EMPENHO.SALDO_EMPENHO_ORIGEM
												 , PCP_APONTAMENTO_EMPENHO.CO_PRODUTO_DESTINO
												 , CASE WHEN PCP_ESTRUTURA.NU_SEQ_COMPONENTE = ' ' THEN ' '
												        WHEN PCP_ESTRUTURA.NU_SEQ_COMPONENTE = '' THEN ' '
														WHEN PCP_ESTRUTURA.NU_SEQ_COMPONENTE IS NULL THEN ' '
														ELSE 'ERRO'
											       END AS NU_SEQ_COMPONENTE
												 , PCP_APONTAMENTO_EMPENHO.QTD_EMPENHO_DESTINO
												 , PCP_APONTAMENTO_EMPENHO.SALDO_EMPENHO_DESTINO
												 , PCP_APONTAMENTO_EMPENHO.CO_PCP_APONTAMENTO
										     FROM tb_pcp_apontamento_empenho PCP_APONTAMENTO_EMPENHO

											     INNER JOIN tb_pcp_op PCP_OP
												     ON PCP_OP.CO_PCP_OP = PCP_APONTAMENTO_EMPENHO.CO_PCP_OP
												     AND PCP_OP.FL_DELET IS NULL
												 
												 LEFT JOIN tb_pcp_estrutura PCP_ESTRUTURA
												     ON PCP_ESTRUTURA.CO_PRODUTO = PCP_OP.CO_PRODUTO
													 AND PCP_ESTRUTURA.CO_COMPONENTE = PCP_APONTAMENTO_EMPENHO.CO_PRODUTO_DESTINO

											 WHERE PCP_APONTAMENTO_EMPENHO.FL_SINCRONISMO IS NULL
											 AND PCP_APONTAMENTO_EMPENHO.FL_DELET IS NULL
										     ORDER BY PCP_APONTAMENTO_EMPENHO.CO_PCP_APONTAMENTO_EMPENHO",$conexaoExtranet)
	or die(mysql_error());
		
	if(mysql_num_rows($sqlPcpApontamentoEmpenho) > 0){
	    
		while($rowPcpApontamentoEmpenho=mysql_fetch_array($sqlPcpApontamentoEmpenho)){ 
			
			$sqlVerificaIntegracaoTotvsApontamento = ociparse($totvsConexao,"SELECT ZP1_XCODEX FROM ZP1010 WHERE ZP1_XCODEX = '".$rowPcpApontamentoEmpenho['CO_PCP_APONTAMENTO_EMPENHO']."'");
	    	ociexecute($sqlVerificaIntegracaoTotvsApontamento);	
			
			if(ocirowcount($sqlVerificaIntegracaoTotvsApontamento) == null){
				
			    //INICIO CAPTURA O CODIGO DO ULTIMO R_E_C_N_O_ DA TABELA
				$sqlIntegraçãoTotvsRecno = ociparse($totvsConexao,"SELECT MAX(R_E_C_N_O_) AS R_E_C_N_O FROM ZP1010");
				ociexecute($sqlIntegraçãoTotvsRecno);	
				
				$rowIntegraçãoTotvsRecno = oci_fetch_array($sqlIntegraçãoTotvsRecno);
				
				if($rowIntegraçãoTotvsRecno['R_E_C_N_O'] > 0){
					$recnoIntegracaoApontamento = $rowIntegraçãoTotvsRecno['R_E_C_N_O']+1;
				}else{
					$recnoIntegracaoApontamento = 1;
				}
				//FIM CAPTURA O CODIGO DO ULTIMO R_E_C_N_O_ DA TABELA
			
				//INICIO CAPTURA O CODIGO Da ULTIMA INTEGRACAO DA TABELA
				$sqlIntegraçãoTotvsCodigoIntegracao = ociparse($totvsConexao,"SELECT MAX(ZP1_XCOINT) AS ZP1_XCOINT FROM ZP1010");
				ociexecute($sqlIntegraçãoTotvsCodigoIntegracao);	
				
				$rowIntegraçãoTotvsCodigoIntegracao = oci_fetch_array($sqlIntegraçãoTotvsCodigoIntegracao);
				
				if($rowIntegraçãoTotvsCodigoIntegracao['ZP1_XCOINT'] > 0){
					$codigoIntegracaoApontamento = $rowIntegraçãoTotvsCodigoIntegracao['ZP1_XCOINT']+1;
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
						case "PARAMETRO_06":
							$filialApontamento  = $rowParametro['VL_PARAMETRO'];
							break;
						case "PARAMETRO_05":
							$statusApontamento  = $rowParametro['VL_PARAMETRO'];
							break;
					}

				}	
			
				$sqlIntegracaoTotvsApontamento = ociparse($totvsConexao,"INSERT INTO ZP1010 (ZP1_FILIAL 
																		     , ZP1_CODORI
																			 , ZP1_CODDES
																			 , ZP1_LOCAL
																			 , ZP1_OP     
																			 , ZP1_DATA   
																			 , ZP1_QTOEMP 
																			 , ZP1_QTDEMP   
																			 , ZP1_SLOEMP   
																			 , ZP1_SLDEMP    
																			 , ZP1_XDCAIN 
																			 , ZP1_XCODEX 
																			 , ZP1_XTPINT 
																			 , ZP1_XSTINT  
																			 , ZP1_XCOINT   
																			 , ZP1_HRCADI   
																			 , ZP1_TRT   
																			 , R_E_C_N_O_)
																		 VALUES('".$filialApontamento."'
																		     , '".$rowPcpApontamentoEmpenho['CO_PRODUTO_ORIGEM']."'
																			 , '".$rowPcpApontamentoEmpenho['CO_PRODUTO_DESTINO']."'
																			 , '".$rowPcpApontamentoEmpenho['NU_ARMAZEM']."'
																			 , '".$rowPcpApontamentoEmpenho['NU_OP']."'
																			 , '".$rowPcpApontamentoEmpenho['DT_APONTAMENTO_EMPENHO']."'
																			 , '".$rowPcpApontamentoEmpenho['QTD_EMPENHO_ORIGEM']."'
																			 , '".$rowPcpApontamentoEmpenho['QTD_EMPENHO_DESTINO']."'
																			 , '".$rowPcpApontamentoEmpenho['SALDO_EMPENHO_ORIGEM']."'
																			 , '".$rowPcpApontamentoEmpenho['SALDO_EMPENHO_DESTINO']."'
																			 , '".$dataCadastro."'
																			 , '".$rowPcpApontamentoEmpenho['CO_PCP_APONTAMENTO_EMPENHO']."'
																			 , '".$tipoApontamento."'
																			 , '".$statusApontamento."'
																			 , '".$codigoIntegracaoApontamento."'
																			 , '".$horaCadastro."'
																			 , '".$rowPcpApontamentoEmpenho['NU_SEQ_COMPONENTE']."'
																			 , '".$recnoIntegracaoApontamento."')");
						
				if(ociexecute($sqlIntegracaoTotvsApontamento)){
			    
					mysql_query("UPDATE tb_pcp_apontamento_empenho SET
									 FL_SINCRONISMO = '*'
								 WHERE CO_PCP_APONTAMENTO_EMPENHO = '".$rowPcpApontamentoEmpenho['CO_PCP_APONTAMENTO_EMPENHO']."'",$conexaoExtranet)or die(mysql_error());
					
				}
				
			}
				
		}
		
	}
	
?>
<?php 
		
	$sqlTotvsLog = ociparse($totvsConexao,"SELECT CO_LOG, TB_LOG, TP_LOG, R_E_C_N_O_ 
	                                       FROM TOTVS_LOG 
										   WHERE FL_LOG = 'N'
										   ORDER BY CO_LOG");
	ociexecute($sqlTotvsLog);
	
	while($rowTotvsLog = oci_fetch_array($sqlTotvsLog)){
		
		if($rowTotvsLog["TB_LOG"] == "SC2010"){
		
			//Tabela de Ordem de Producao
			require("sincronismo_SC2010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SG2010"){
			
			//Tabela de Operacao
			require("sincronismo_SG2010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SH1010"){
			
			//Tabela de Recurso
			require("sincronismo_SH1010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SB1010"){
			
			//Tabela de Produto
			require("sincronismo_SB1010.php");
						
		}elseif($rowTotvsLog["TB_LOG"] == "SB2010"){
			
			//Tabela de Produto Saldo
			require("sincronismo_SB2010.php");
						
		}elseif($rowTotvsLog["TB_LOG"] == "SX5010"){
			
			//Tabela de Cor
			require("sincronismo_SX5010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SG1010"){
			
			//Tabela de Produto Estrutura
			require("sincronismo_SG1010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SGF010"){
			
			//Tabela de Operaчуo Componente
			require("sincronismo_SGF010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SD4010"){
			
			//Tabela de Ajuste de Empenho
			require("sincronismo_SD4010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SA1010"){
			
			//Tabela de Cliente
			require("sincronismo_SA1010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SA2010"){
			
			//Tabela de Fornecedor
			require("sincronismo_SA2010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SA3010"){
			
			//Tabela de Vendedor
			require("sincronismo_SA3010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "DAK010"){
			
			//Tabela de Carga
			require("sincronismo_DAK010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "DA3010"){
			
			//Tabela de Veiculo
			require("sincronismo_DA3010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "DA4010"){
			
			//Tabela de Motorista
			require("sincronismo_DA4010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "DAI010"){
			
			//Tabela de Carga Itens
			require("sincronismo_DAI010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SC5010"){
			
			//Tabela de Pedido de Venda
			require("sincronismo_SC5010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SC6010"){
			
			//Tabela de Pedido de Venda Itens
			require("sincronismo_SC6010.php");
			
		}elseif($rowTotvsLog["TB_LOG"] == "SC9010"){
			
			//Tabela de Pedido Venda Liberado
			require("sincronismo_SC9010.php");
			
		}

		$sqlUpdateTotvsLog = ociparse($totvsConexao,"UPDATE TOTVS_LOG SET 
		                                                 FL_LOG = 'S'
                                                         , DT_SINCRONISMO	= '".date("Y-m-d H:i:s")."'													 
													 WHERE CO_LOG = '".$rowTotvsLog["CO_LOG"]."'");
	    ociexecute($sqlUpdateTotvsLog);	
		
	}
	
?>
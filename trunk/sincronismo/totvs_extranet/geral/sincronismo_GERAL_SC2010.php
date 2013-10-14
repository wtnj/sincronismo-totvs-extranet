<?php 
	
	$sqlTotvsSC2010 = ociparse($totvsConexao,"SELECT C2_NUM
											      , C2_ITEM
											      , C2_SEQUEN
											      , C2_PRODUTO
											      , C2_QUANT
											      , C2_QUJE
											      , C2_EMISSAO
											      , C2_DATRF
											      , C2_LOTBRA
											      , R_E_C_N_O_
    											  , D_E_L_E_T_
											  FROM SC2010
											  ORDER BY R_E_C_N_O_");
	ociexecute($sqlTotvsSC2010);
	
	while($rowTotvsSC2010 = oci_fetch_array($sqlTotvsSC2010)){
	    
		$sqlPcpOrdemProducao = mysql_query("SELECT null FROM tb_pcp_op WHERE CO_RECNO = '".$rowTotvsSC2010['R_E_C_N_O_']."'",$conexaoExtranet)
		or die(mysql_error());
		
		$qtdproduto = (string)($rowTotvsSC2010['C2_QUANT']);
		$qtdproduzida = (string)($rowTotvsSC2010['C2_QUJE']);
				
		if(substr($qtdproduto,0,1) == '.' || substr($qtdproduto,0,1) == ','){
			$qtdproduto = '0'.$qtdproduto;
		}
		
		if(substr($qtdproduzida,0,1) == '.' || substr($qtdproduzida,0,1) == ','){
			$qtdproduzida = '0'.$qtdproduzida;
		}	
			
		if(mysql_num_rows($sqlPcpOrdemProducao) == 0){
			
			if(trim($rowTotvsSC2010['D_E_L_E_T_']) == '*'){
				
				 mysql_query("INSERT INTO tb_pcp_op (CO_NUM
								  , CO_ITEM
								  , CO_SEQUENCIA
								  , CO_PRODUTO
								  , QTD_PRODUTO
								  , QTD_PRODUZIDA
								  , DT_EMISSAO
								  , DT_FIM
								  , NU_LOTE
								  , CO_RECNO
								  , FL_DELET)
							  VALUES('".$rowTotvsSC2010['C2_NUM']."' 
								  , '".$rowTotvsSC2010['C2_ITEM']."'
								  , '".$rowTotvsSC2010['C2_SEQUEN']."'
								  , '".$rowTotvsSC2010['C2_PRODUTO']."'
								  , '".$qtdproduto."'  
								  , '".$qtdproduzida."'  
								  , '".$rowTotvsSC2010['C2_EMISSAO']."'  
								  , '".$rowTotvsSC2010['C2_DATRF']."'  
								  , '".$rowTotvsSC2010['C2_LOTBRA']."'  
								  , '".$rowTotvsSC2010['R_E_C_N_O_']."'
								  , '*')",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("INSERT INTO tb_pcp_op (CO_NUM
								  , CO_ITEM
								  , CO_SEQUENCIA
								  , CO_PRODUTO
								  , QTD_PRODUTO
								  , QTD_PRODUZIDA
								  , DT_EMISSAO
								  , DT_FIM
								  , NU_LOTE
								  , CO_RECNO)
							  VALUES('".$rowTotvsSC2010['C2_NUM']."' 
								  , '".$rowTotvsSC2010['C2_ITEM']."'
								  , '".$rowTotvsSC2010['C2_SEQUEN']."'
								  , '".$rowTotvsSC2010['C2_PRODUTO']."'
								  , '".$qtdproduto."'  
								  , '".$qtdproduzida."'  
								  , '".$rowTotvsSC2010['C2_EMISSAO']."'  
								  , '".$rowTotvsSC2010['C2_DATRF']."'  
								  , '".$rowTotvsSC2010['C2_LOTBRA']."'  
								  , '".$rowTotvsSC2010['R_E_C_N_O_']."')",$conexaoExtranet)or die(mysql_error());
								 
			}
			
		}else{
			
			if(trim($rowTotvsSC2010['D_E_L_E_T_']) == '*'){
				
			    mysql_query("UPDATE tb_pcp_op SET
							     CO_NUM          = '".$rowTotvsSC2010['C2_NUM']."' 
								 , CO_ITEM       = '".$rowTotvsSC2010['C2_ITEM']."'
								 , CO_SEQUENCIA  = '".$rowTotvsSC2010['C2_SEQUEN']."'
								 , CO_PRODUTO    = '".$rowTotvsSC2010['C2_PRODUTO']."'
								 , QTD_PRODUTO   = '".$qtdproduto."'  
								 , QTD_PRODUZIDA = '".$qtdproduzida."'  
								 , DT_EMISSAO    = '".$rowTotvsSC2010['C2_EMISSAO']."' 
								 , DT_FIM        = '".$rowTotvsSC2010['C2_DATRF']."' 
								 , NU_LOTE       = '".$rowTotvsSC2010['C2_LOTBRA']."'  
							     , FL_DELET      = '*'
						 	 WHERE CO_RECNO = '".$rowTotvsSC2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
				
			}else{
				
				mysql_query("UPDATE tb_pcp_op SET
							     CO_NUM          = '".$rowTotvsSC2010['C2_NUM']."' 
								 , CO_ITEM       = '".$rowTotvsSC2010['C2_ITEM']."'
								 , CO_SEQUENCIA  = '".$rowTotvsSC2010['C2_SEQUEN']."'
								 , CO_PRODUTO    = '".$rowTotvsSC2010['C2_PRODUTO']."'
								 , QTD_PRODUTO   = '".$qtdproduto."'  
								 , QTD_PRODUZIDA = '".$qtdproduzida."'  
								 , DT_EMISSAO    = '".$rowTotvsSC2010['C2_EMISSAO']."' 
								 , DT_FIM        = '".$rowTotvsSC2010['C2_DATRF']."' 
								 , NU_LOTE       = '".$rowTotvsSC2010['C2_LOTBRA']."'  
						 	 WHERE CO_RECNO = '".$rowTotvsSC2010['R_E_C_N_O_']."'",$conexaoExtranet)or die(mysql_error());
			
			}
			
		}
	
	}
			
?>
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
											  WHERE R_E_C_N_O_ = '".$rowTotvsLog["R_E_C_N_O_"]."'");
	ociexecute($sqlTotvsSC2010);
	$rowTotvsSC2010 = oci_fetch_array($sqlTotvsSC2010);
	$qtdproduto = (string)($rowTotvsSC2010['C2_QUANT']);
	$qtdproduzida = (string)($rowTotvsSC2010['C2_QUJE']);
		
	if(substr($qtdproduto,0,1) == '.' || substr($qtdproduto,0,1) == ','){
		$qtdproduto = '0'.$qtdproduto;
	}

	if(substr($qtdproduzida,0,1) == '.' || substr($qtdproduzida,0,1) == ','){
		$qtdproduzida = '0'.$qtdproduzida;
	}
	
	if($rowTotvsLog["TP_LOG"] == "Insert"){
			    			
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
					     , '".$rowTotvsSC2010['R_E_C_N_O_']."')",$conexaoExtranet);
											
	}elseif($rowTotvsLog["TP_LOG"] == "Update"){
				
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
					 WHERE CO_RECNO = '".$rowTotvsSC2010['R_E_C_N_O_']."'",$conexaoExtranet);
			
	}elseif($rowTotvsLog["TP_LOG"] == "Update Campo D_E_L_E_T_"){
		
	    if(trim($rowTotvsSC2010['D_E_L_E_T_'])=='*'){
	    	mysql_query("UPDATE tb_pcp_op SET FL_DELET= '*' WHERE CO_RECNO = '".$rowTotvsSC2010['R_E_C_N_O_']."'",$conexaoExtranet);
	    }else{
	    	mysql_query("UPDATE tb_pcp_op SET FL_DELET= null WHERE CO_RECNO = '".$rowTotvsSC2010['R_E_C_N_O_']."'",$conexaoExtranet);
	    }
				
	}elseif($rowTotvsLog["TP_LOG"] == "Delete"){
				
	    mysql_query("UPDATE tb_pcp_op SET FL_DELET = '*' WHERE CO_RECNO = '".$rowTotvsSC2010['R_E_C_N_O_']."'",$conexaoExtranet);
				
	}
			
?>
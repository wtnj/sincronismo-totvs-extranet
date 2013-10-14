<?php
	
    $body = "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<meta name='author' content='Euripedes B. Silva Junior [ euripedes.junior@yahoo.com.br ]' />
<meta name='language' content='pt-br' />
<title>Sincronismo Validação Totvs com Extranet</title>
<style type='text/css'>
<!--
.BODY {
	margin-left: 0px;	
	margin-top: 20px; 
	margin-right: 0px;	
	margin-bottom: 20px; 
	background-color: #FFFFFF;
	font-family: 'Tahoma';
	font-size: 10px;
	font-weight:normal;
	color:#000000;
}

.TABLE_FULL {border: 1px solid #999999;}

FONT.FONT01 {font-family: 'Tahoma'; font-size:18px; font-weight: normal; color: #FFFFFF}
FONT.FONT02 {font-family: 'Tahoma'; font-size:12px; font-weight: normal; color: #990000}
FONT.FONT03 {font-family: 'Tahoma'; font-size:11px; font-weight: normal; color: #000000}
FONT.FONT04 {font-family: 'Tahoma'; font-size:11px; font-weight: normal; color: #FFFFFF}


A.STYLE01 {text-decoration: none; font-family:'Tahoma'; font-size:12px; font-weight: normal; color: #990000}
A.STYLE01:hover{text-decoration: underline; font-size:12px; color:#990000;}
-->
</style>
</head>
<body class='BODY'>
<table width='650' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
  <tr>
    <td><table width='650' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF' class='TABLE_FULL'>
      <tr>
        <td height='56' align='center' bgcolor='#063B6F'><table width='630' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td align='center'><font class='FONT01'>VALIDAÇÃO SINCRONISMO TOTVS COM EXTRANET</font></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align='center' valign='top'>&nbsp;</td>
      </tr>
      <tr>
        <td align='center'><table width='630' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td align='center'><font class='FONT02'><b>Esse &eacute; um e-mail autom&aacute;tico. Informamos que este e-mail n&atilde;o ser&aacute; lido nem respondido.</b></font></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height='25' align='center' bgcolor='#063B6F'><font class='FONT04'><b>INFORMA&Ccedil;&Otilde;ES DIVERGENTES ENCONTRADAS NO SINCRONISMO</b></font></td>
      </tr>
      <tr>
        <td align='center'>&nbsp;</td>
      </tr>
      <tr>
        <td align='center'><table width='630' border='0' cellspacing='2' cellpadding='5'>
          <tr>
            <td align='left' bgcolor='#EEEEEE'><font class='FONT03'><b>Data Hora Validação:</b></font></td>
            <td align='left' bgcolor='#EEEEEE'><font class='FONT03'>".$_POST['dataHoraValidacao']."</font></td>
            </tr>
          <tr>
            <td align='left' bgcolor='#EEEEEE'><font class='FONT03'><b>Tabela:</b></font></td>
            <td align='left' bgcolor='#EEEEEE'><font class='FONT03'>".$_POST['tabelaValidacao']."</font></td>
            </tr>
          <tr>
            <td width='134' align='left' bgcolor='#EEEEEE'><font class='FONT03'><b>Qtd. Oracle:</b></font></td>
            <td width='470' align='left' bgcolor='#EEEEEE'><font class='FONT03'>".$_POST['quantidadeOracle']."</font></td>
          </tr>
          <tr>
            <td align='left' bgcolor='#EEEEEE'><font class='FONT03'><b>Qtd. MySQL:</b></font></td>
            <td align='left' bgcolor='#EEEEEE'><font class='FONT03'>".$_POST['quantidadeMySQL']."</font></td>
          </tr>
          <tr>
            <td align='left' bgcolor='#EEEEEE'><font class='FONT03'><b>Diferen&ccedil;a:</b></font></td>
            <td align='left' bgcolor='#EEEEEE'><font class='FONT03'>".$_POST['quantidadeDiferenca']."</font></td>
          </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
        <td width='46%' align='left'><img src='http://www.bravomoveis.com/extranet/schedule/img/email_logo_bravo.jpg' width='97' height='70'></td>
        <td width='54%' align='right'><img src='http://www.bravomoveis.com/extranet/schedule/img/email_logo_bravo_ti.jpg' width='97' height='70'></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>"; 
	    
	$subject		  = "VALIDAÇÃO SINCRONISMO TOTVS COM EXTRANET";
	$nome_remetente	  = "Extranet Bravo Moveis";
	$email_remetente  = "ti@bravomoveis.com";
	$to               = "ejunior@bravomoveis.com";
						
	$headers = "From: $nome_remetente <$email_remetente>\n";
	$headers .= "Return-Path: $email_remetente\n";		
	$headers .= "Cc: $email_copia\n";
	$headers .= "Mime-Version:1.0\n";
	$headers .= "Content-type: text/html; charset=ISO-8859-1";
		
	mail($to,$subject,$body,$headers);
	
?>
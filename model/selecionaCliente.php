<?php
session_start();
$conexao = mysql_connect('localhost:3306','root','');
mysql_select_db('locadora',$conexao);
if(!$conexao){
	$_SESSION['resposta'] = "<font color='red'>SQL ERROR = ".mysql_error()."</font>";
} else {
	
	if(isSet($_GET['pesqCpf']) && $_GET['pesqCpf'] != ''){
		$pesqCpf = $_GET['pesqCpf'];
		$sql = "SELECT cpf,nome FROM clientes WHERE cpf = '$pesqCpf'";
		$result = mysql_query($sql);
		if($result){
			$_SESSION['cliente'] = mysql_fetch_array($result);
			if(strlen($_SESSION['cliente'][0]) == 0){
				$_SESSION['resposta'] = '<font color=red>CPF n�o � v�lido</font>';
			}
		}
				
	} else {
		$_SESSION['resposta'] = '<font color=red>O campo CPF � obrigat�ria</font>';
	}
}
mysql_close();
header('Location:../control/cadastrarLocacao.php');
?>
<html>
<STYLE type="text/css"> 
A:link {text-decoration:none;color:#ffcc33;} 
A:visited {text-decoration:none;color:#ffcc33;} 
A:active {text-decoration:none;color:#ff0000;} 
A:hover {text-decoration:underline;color:#999999;} 
</STYLE>
<script language="JavaScript">
 
 function mascara(t, mask){
	var i = t.value.length;
	var saida = mask.substring(1,0);
	var texto = mask.substring(i)
	if (texto.substring(0,1) != saida){
		t.value += texto.substring(0,1);
	}
	
	var tecla=(window.event)?event.keyCode:t.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
 }
 
 </script>
<title>Editar Cliente - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Editar Cliente - Sistema de Locadora de Filmes<h1>
	
	<div style="background-color:black">
		<h5>
			<a href="/aksjdji">In�cio</a>
			<a href="/aksjdji/view/clientes.php">Clientes</a>
			<a href="/aksjdji/view/filmes.php">Filmes</a>
			<a href="/aksjdji/view/categorias.php">Categorias</a>
			<a href="/aksjdji/view/locacoes.php">Loca��es</a>
		</h5>
	</div>
	<?php
		$conexao = mysql_connect('localhost:3306','root','');
		mysql_select_db('locadora',$conexao);
			
		$cpf = '';
		$nome = '';
		$dia = '1';
		$mes = '1';
		$ano = '2013';
		$endereco = '';
		$telefone = '';
		if(isSet($_GET['cpf'])){
			$cpf = $_GET['cpf'];
			$nome = $_GET['nome'];
			$endereco = $_GET['endereco'];
			$telefone = '';
			if(isSet($_GET['ddd'])){
				$ddd = $_GET['ddd'];
				$fone = $_GET['fone'];
				$telefone = $_GET['ddd'] . $_GET['fone'];
			} else {
				$telefone = $_GET['telefone'];
				$ddd = substr($telefone,0,2);
				$fone = substr($telefone,2);
			}
			if(isSet($_GET['data_nascimento'])){
				$dtN = $_GET['data_nascimento'];
				$dia = date('d',strtotime($dtN));
				$mes = date('m',strtotime($dtN));
				$ano = date('Y',strtotime($dtN));
			} else {
				$dia = $_GET['dia'];
				$mes = $_GET['mes'];
				$ano = $_GET['ano'];
			}
		}
		if(isSet($_GET['alterar'])){
			
			if($conexao){
				$data_nascimento = $_GET['ano'] . '-' .$_GET['mes'] . '-' .$_GET['dia'];
				
				$result = mysql_query("UPDATE clientes SET nome='$nome',data_nascimento='$data_nascimento',
					endereco='$endereco',telefone='$telefone' WHERE cpf='$cpf'");
				if($result){
					echo "<font color='lime'>CLIENTE $nome ATUALIZADO COM SUCESSO!</font> <br/><br/>";
				} else {
					echo "<font color='red'>CLIENTE $nome N�O PODE SER ATUALIZADO! ERROR = ".mysql_error()."</font><br/><br/>";
				}
			}
		}
		
		echo "
		<form action='".$_SERVER['PHP_SELF']."'>
		<table>
			<tr>
				<td>
					CPF
				</td>
				<td>
					<input type='text' name='cpf' value = '$cpf' readonly='readonly'/>
				</td>
			</tr>
			<tr>
				<td>
					Nome
				</td>
				<td>
					<input type='text' name='nome' value = '$nome' autofocus/>
				</td>
			</tr>
			<tr>
				<td>
					Data de Nascimento
				</td>
				<td>
				<select name='dia'>";
							for($i = 1;$i<=31;$i++){
								if($i == $dia){
									echo "<option value='$i' selected>$i</option>";
								} else {
									echo "<option value='$i'>$i</option>";
								}
							}
						echo '</select>';
						echo "<select name='mes'>";
							for($i = 1;$i<=12;$i++){
								if($i == $mes){
									echo "<option value='$i' selected>$i</option>";
								} else {
									echo "<option value='$i'>$i</option>";
								}
							}
						echo '</select>';	
						echo "<select name='ano'>";
							for($i = 1900;$i<=2012;$i++){
								if($i == $ano){
									echo "<option value='$i' selected>$i</option>";
								} else {
									echo "<option value='$i'>$i</option>";
								}
							}
						echo "
						<option value='2013' selected>2013</option>;
						</select>
				</td>
			</tr>
			<tr>
				<td>
					Endere�o
				</td>
				<td>
					<input type='text' name='endereco' value = '$endereco'/>
				</td>
			</tr>
			<tr>
				<td>
					Telefone
				</td>
				<td>
					<input type='text' name='ddd' value='$ddd' maxlength=2 size=2 onkeypress=\"return mascara(this,'##')\"/>
					<input type='text' name='fone' value='$fone' maxlength=8 size=11 onkeypress=\"return mascara(this,'########')\"/>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<input type='hidden' name='alterar' value='true'/>
					<button>Salvar</button>
				</td>
			</tr>
		</table>
		</form>";
		mysql_close();
	?>
</body>
</html>
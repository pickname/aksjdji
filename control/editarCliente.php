<html>
<STYLE type="text/css"> 
A:link {text-decoration:none;color:#ffcc33;} 
A:visited {text-decoration:none;color:#ffcc33;} 
A:active {text-decoration:none;color:#ff0000;} 
A:hover {text-decoration:underline;color:#999999;} 
</STYLE>

<title>Editar Cliente - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Editar Cliente - Sistema de Locadora de Filmes<h1>
	
	<div style="background-color:black">
		<h5>
			<a href="/aksjdji">Início</a>
			<a href="/aksjdji/view/clientes.php">Clientes</a>
			<a href="/aksjdji/view/filmes.php">Filmes</a>
			<a href="/aksjdji/view/categorias.php">Categorias</a>
			<a href="/aksjdji/view/locacoes.php">Locações</a>
		</h5>
	</div>
	<?php
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
			$telefone = $_GET['telefone'];
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
			$conexao = mysql_connect('localhost:3306','root','');
			mysql_select_db('locadora',$conexao);
			if($conexao){
				$data_nascimento = $_GET['ano'] . '-' .$_GET['mes'] . '-' .$_GET['dia'];
				$result = mysql_query("UPDATE clientes SET nome='$nome',data_nascimento='$data_nascimento',
					endereco='$endereco',telefone='$telefone' WHERE cpf='$cpf'");
				if($result){
					echo "<font color='lime'>CLIENTE $nome ATUALIZADO COM SUCESSO!</font> <br/><br/>";
				} else {
					echo "<font color='red'>CLIENTE $nome NÃO PODE SER ATUALIZADO! ERROR = ".mysql_error()."</font><br/><br/>";
				}
			}
		}
		
		echo "
		<form action='/aksjdji/control/editarCliente.php'>
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
					Endereço
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
					<input type='text' name='telefone' value='$telefone' maxlength=10/>
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
	?>
</body>
</html>
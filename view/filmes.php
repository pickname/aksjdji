<html>
<STYLE type="text/css"> 
	A:link {text-decoration:none;color:#ffcc33;} 
	A:visited {text-decoration:none;color:#ffcc33;} 
	A:active {text-decoration:none;color:#ff0000;} 
	A:hover {text-decoration:underline;color:#999999;} 
</STYLE>

<title>Filmes - Sistema de Locadora de Filmes</title>
<body>
	
	<h1 align="center">Filmes - Sistema de Locadora de Filmes<h1>
	
	<div style="background-color:black">
		<h5>
			<a href="/aksjdji">Início</a>
			<a href="/aksjdji/view/clientes.php">Clientes</a>
			<a href="/aksjdji/view/filmes.php">Filmes</a>
			<a href="/aksjdji/view/categorias.php">Categorias</a>
			<a href="/aksjdji/view/locacoes.php">Locações</a>
		</h5>
	</div>
	
	<div style="background-color:green">
	<form action = "/aksjdji/view/filmes.php">
		<h6>
			<b>Pesquisar por:</b>
			<?php
				$tipoPesq = '';
				$pesq = '';
				if(isSet($_GET['tipoPesq'])){
					$tipoPesq = $_GET['tipoPesq'];
				}
				if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
				}
					switch($tipoPesq){
						case 'cod':{
						echo '
							<input type="radio" name="tipoPesq" value = "nome"/>Nome
							<input type="radio" name="tipoPesq" value = "cod" checked="checked"/>Código 
							<input type="radio" name="tipoPesq" value = "qtd"/>Categoria <br/>';
							break;
						}
						case 'qtd':{
						echo '
							<input type="radio" name="tipoPesq" value = "nome"/>Nome
							<input type="radio" name="tipoPesq" value = "cod"/>Código
							<input type="radio" name="tipoPesq" value = "qtd" checked="checked"/>Categoria <br/>';	
							break;
						}
						default:{
							echo '
							<input type="radio" name="tipoPesq" value = "nome" checked="checked"/>Nome
							<input type="radio" name="tipoPesq" value = "cod"/>Código 
							<input type="radio" name="tipoPesq" value = "qtd"/>Categoria <br/>';
							break;
						}
					}
				
				
				echo "<input type='text' name='pesq' value='$pesq'/>";
				
			?>
			
			<button>Pesquisar</button>
			
		</h6>
	</form>
	</div>
	<a href="/aksjdji/control/cadastrarFilme.php"><button>Novo Filme</button></a>
	<a href="/aksjdji/control/cadastrarCategoria.php"><button>Nova Categoria</button></a>
	<hr/>
	
	<?php
		$conexao = mysql_connect('localhost:3306','root','');
		mysql_select_db('locadora',$conexao);
			
		if(isSet($_GET['cod'])){
			$cod = $_GET['cod'];
			
			$resultExcluir = mysql_query("DELETE FROM filmes WHERE cod = '$cod'");
			if($resultExcluir){
				echo "<font color='lime'>CLIENTE $cod EXCLUIDO COM SUCESSO!</font> <br/><br/>";
			} else {
				echo "FALHA NA EXCLUSÃO! " . mysql_error();
			}
		
		}
		if(isSet($_GET['pesq'])){
			$pesq = $_GET['pesq'];
			$tipoPesq = $_GET['tipoPesq'];
			
			if($conexao){
				$result;
				if($tipoPesq == 'nome'){
					$result = mysql_query("SELECT cod,nome,qtd,categoria1,categoria2,categoria3
					FROM filmes WHERE $tipoPesq like '$pesq%' ORDER BY $tipoPesq LIMIT 15");
				} else {
					$result = mysql_query("SELECT cod,nome,qtd,categoria1,categoria2,categoria3
					FROM filmes WHERE $tipoPesq = '$pesq' LIMIT 10");
				}
				if($result){
								
				echo "<table border=1>
				<tr>
					<td>
						<b>Código</b>
					</td>
					<td>
						<b>Nome</b>
					</td>
					<td>
						<b>Quantidade</b>
					</td>
					<td>
						<b>Categoria1</b>
					</td>
					<td>
						<b>Categoria2</b>
					</td>
					<td>
						<b>Categoria3</b>
					</td>
					<td>
						<b>Delete</b>
					</td>
					<td>
						<b>Editar</b>
					</td>
				</tr>";
				while($row = mysql_fetch_array($result)){
					echo "
					<tr>
						<td>
							".$row['cod']."
						</td>
						<td>
							".$row['nome']."
						</td>
						<td>
							".$row['qtd']."
						</td>
						<td>
							".$row['categoria1']."
						</td>
						<td>
							".$row['categoria2']."
						</td>
						<td>
							".$row['categoria3']."
						</td>
						<td>
							<form action='".$_SERVER['PHP_SELF']."'>
								<input type='hidden' name='cod' value = '".$row['cod']."'/>
								<input type='hidden' name='pesq' value = '".$_GET['pesq']."'/>
								<input type='hidden' name='tipoPesq' value = '".$_GET['tipoPesq']."'/>
								<button>Delete</button>
							</form>
						</td>
						<td>
							<form action='/aksjdji/control/editarCliente.php'>
								<input type='hidden' name='cod' value = '".$row['cod']."'/>
								<input type='hidden' name='nome' value = '".$row['nome']."'/>
								<input type='hidden' name='qtd' value = '".$row['qtd']."'/>
								<input type='hidden' name='categoria1' value = '".$row['categoria1']."'/>
								<input type='hidden' name='categoria2' value = '".$row['categoria2']."'/>
								<input type='hidden' name='categoria3' value = '".$row['categoria3']."'/>
								
								<button>Editar</button>
							</form>
						</td>
					</tr>";
				}
				echo '</table>';
				} else {
					echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
				}
			} else {
				echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
			}
			mysql_close();
		}
	?>
</body>
</html>
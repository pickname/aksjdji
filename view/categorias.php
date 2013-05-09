<html>
<STYLE type="text/css"> 
	A:link {text-decoration:none;color:#ffcc33;} 
	A:visited {text-decoration:none;color:#ffcc33;} 
	A:active {text-decoration:none;color:#ff0000;} 
	A:hover {text-decoration:underline;color:#999999;} 
</STYLE>

<title>Categorias - Sistema de Locadora de Filmes</title>
<body>
	
	<h1 align="center">Categorias - Sistema de Locadora de Filmes<h1>
	
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
	<form action = "/aksjdji/view/categorias.php">
		<h6>
			<b>Pesquisar:</b>
			<?php
				$pesq = '';
				
				if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
				}
				echo "<input type='text' name='pesq' value='$pesq' autofocus/>";
				
			?>
			
			<button>Pesquisar</button>
			
		</h6>
	</form>
	</div>
	
	<a href="/aksjdji/control/cadastrarCategoria.php"><button>Nova Categoria</button></a>
	
	<hr/>
	<?php
		$conexao = mysql_connect('localhost:3306','root','');
		mysql_select_db('locadora',$conexao);
			
		if($conexao){
			if(isSet($_GET['cod'])){
				$cod = $_GET['cod'];
				$nome = $_GET['nome'];
				
				$resultExcluir = mysql_query("DELETE FROM categorias WHERE cod = '$cod'");
				if($resultExcluir){
					echo "<font color='lime'>CATEGORIA $nome EXCLUIDO COM SUCESSO!</font> <br/><br/>";
				} else {
					echo "FALHA NA EXCLUSÃO! " . mysql_error();
				}
			}
			$pesq = '';
			if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
			}
				$result = mysql_query("SELECT cod,nome FROM categorias WHERE nome like '$pesq%' ORDER BY nome");
				
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
								<form action='".$_SERVER['PHP_SELF']."'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>
									<input type='hidden' name='nome' value = '".$row['nome']."'/>
									<input type='hidden' name='pesq' value = '".$pesq."'/>
									<button>Delete</button>
								</form>
							</td>
							<td>
								<form action='/aksjdji/control/editarCategoria.php'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>
									<input type='hidden' name='nome' value = '".$row['nome']."'/>
									<button>Editar</button>
								</form>
							</td>
						</tr>";
					}
					echo '</table>';
				} else {
					echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
				}
				
		}else {
			echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
		}
		mysql_close();
	?>
</body>
</html>
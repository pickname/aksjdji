<?php 
include '../style.php'; 
?>

<html>

<title>Filmes - Sistema de Locadora de Filmes</title>
<body>
	
	<h1 align="center">Filmes - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php'?>
	
	<div style="background-color:green">
	<form action = "/aksjdji/view/filmes.php">
		<h6>
			<b>Pesquisar por:</b>
			<?php
				$tipoPesq = '';
				$pesq = '';
				
				if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
					$tipoPesq = $_GET['tipoPesq'];
				}
					switch($tipoPesq){
						case 'cod':{
						echo '
							<input type="radio" name="tipoPesq" value = "nome"/>Nome
							<input type="radio" name="tipoPesq" value = "cod" checked="checked"/>C�digo 
							<input type="radio" name="tipoPesq" value = "categoria"/>Categoria <br/>';
							break;
						}
						case 'categoria':{
						echo '
							<input type="radio" name="tipoPesq" value = "nome"/>Nome
							<input type="radio" name="tipoPesq" value = "cod"/>C�digo
							<input type="radio" name="tipoPesq" value = "categoria" checked="checked"/>Categoria <br/>';	
							break;
						}
						default:{
							echo '
							<input type="radio" name="tipoPesq" value = "nome" checked="checked"/>Nome
							<input type="radio" name="tipoPesq" value = "cod"/>C�digo 
							<input type="radio" name="tipoPesq" value = "categoria"/>Categoria <br/>';
							break;
						}
					}
				
				
				echo "<input type='text' name='pesq' value='$pesq' autofocus/>";
				
			?>
			
			<button>Pesquisar</button>
			
		</h6>
	</form>
	</div>
	<a href="/aksjdji/control/cadastrarFilme.php"><button>Novo Filme</button></a>
	<hr/>
	
	<?php
		$conexao = mysql_connect('localhost:3306','root','');
		mysql_select_db('locadora',$conexao);
			
		if(isSet($_GET['cod'])){
			$cod = $_GET['cod'];
			$nome = $_GET['nome'];
			
			$resultExcluir = mysql_query("UPDATE filmes SET status = 'I' WHERE cod = '$cod'");
			if($resultExcluir){
				echo "<font color='lime'>Filme $nome deletado com sucesso!</font> <br/><br/>";
			} else {
				echo "FALHA NA EXCLUS�O! " . mysql_error();
			}
		
		}
		$pesq = '';
		$tipoPesq = '';
		$sql = "SELECT f.cod,f.nome,f.qtd,c1.nome as categoria1,c2.nome as categoria2,c3.nome as categoria3, f.categoria1 as cod_categoria1,
				f.categoria2 as cod_categoria2, f.categoria3 as cod_categoria3
				FROM filmes as f 
				INNER JOIN categorias as c1 ON f.categoria1 = c1.cod
				LEFT OUTER JOIN categorias as c2 ON f.categoria2 = c2.cod
				LEFT OUTER JOIN categorias as c3 ON f.categoria3 = c3.cod
				WHERE f.status = 'A'
				ORDER BY nome LIMIT 15";
		
		if($conexao){
				if(isSet($_GET['pesq']) && $_GET['pesq'] != ''){
					$pesq = $_GET['pesq'];
					$tipoPesq = $_GET['tipoPesq'];
					
					if($tipoPesq == 'nome'){
						$sql = "
							SELECT f.cod,f.nome,f.qtd,c1.nome as categoria1,c2.nome as categoria2,c3.nome as categoria3, f.categoria1 as cod_categoria1,
				f.categoria2 as cod_categoria2, f.categoria3 as cod_categoria3
							FROM filmes as f 
							INNER JOIN categorias as c1 ON f.categoria1 = c1.cod
							LEFT OUTER JOIN categorias as c2 ON f.categoria2 = c2.cod
							LEFT OUTER JOIN categorias as c3 ON f.categoria3 = c3.cod
							WHERE f.nome like '$pesq%' AND f.status = 'A' ORDER BY f.nome LIMIT 15";
					} elseif ($tipoPesq == 'cod') {
						$sql = "
							SELECT f.cod,f.nome,f.qtd,c1.nome as categoria1,c2.nome as categoria2,c3.nome as categoria3, f.categoria1 as cod_categoria1,
				f.categoria2 as cod_categoria2, f.categoria3 as cod_categoria3 
							FROM filmes as f 
							INNER JOIN categorias as c1 ON f.categoria1 = c1.cod
							LEFT OUTER JOIN categorias as c2 ON f.categoria2 = c2.cod
							LEFT OUTER JOIN categorias as c3 ON f.categoria3 = c3.cod
							WHERE f.cod = '$pesq' AND f.status = 'A' ORDER BY f.cod LIMIT 10";
					} elseif($tipoPesq == 'categoria') {
						$sql = "
							SELECT f.cod,f.nome,f.qtd,c1.nome as categoria1,c2.nome as categoria2,c3.nome as categoria3 , f.categoria1 as cod_categoria1,
				f.categoria2 as cod_categoria2, f.categoria3 as cod_categoria3
							FROM filmes as f 
							INNER JOIN categorias as c1 ON f.categoria1 = c1.cod
							LEFT OUTER JOIN categorias as c2 ON f.categoria2 = c2.cod
							LEFT OUTER JOIN categorias as c3 ON f.categoria3 = c3.cod
							WHERE (c1.nome like '$pesq%' or c2.nome like '$pesq%' or c3.nome like '$pesq%') AND f.status = 'A' ORDER BY f.nome LIMIT 10";
					}
				}
				$result = mysql_query($sql);
				if($result){
									
					echo "<table border=1>
					<tr>
						<td>
							<b>C�digo</b>
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
									<input type='hidden' name='nome' value = '".$row['nome']."'/>
									<input type='hidden' name='pesq' value = '".$pesq."'/>
									<input type='hidden' name='tipoPesq' value = '".$tipoPesq."'/>
									<button>Delete</button>
								</form>
							</td>
							<td>
								<form action='/aksjdji/control/editarFilme.php'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>
									<input type='hidden' name='nome' value = '".$row['nome']."'/>
									<input type='hidden' name='qtd' value = '".$row['qtd']."'/>
									<input type='hidden' name='cod_categoria1' value = '".$row['cod_categoria1']."'/>
									<input type='hidden' name='cod_categoria2' value = '".$row['cod_categoria2']."'/>
									<input type='hidden' name='cod_categoria3' value = '".$row['cod_categoria3']."'/>
									
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
	?>
</body>
</html>
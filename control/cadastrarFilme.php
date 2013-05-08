<html>
<STYLE type="text/css"> 
A:link {text-decoration:none;color:#ffcc33;} 
A:visited {text-decoration:none;color:#ffcc33;} 
A:active {text-decoration:none;color:#ff0000;} 
A:hover {text-decoration:underline;color:#999999;} 
</STYLE>
<script language="JavaScript">
 function somenteNumero(o){
	var v = o.value;
	v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    o.value = v;
 }
 
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

<title>Cadastrar Filmes - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Cadastrar Filmes - Sistema de Locadora de Filmes<h1>
	
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
		if(isSet($_GET['nome'])){
			$nome = $_GET['nome'];
			$qtd = $_GET['qtd'];
			$categoria1 = $_GET['categoria1'];
			$categoria2 = $_GET['categoria2'];
			$categoria3 = $_GET['categoria3'];
			
			if($nome != ''){
				$conexao = mysql_connect('localhost:3306','root','');
				mysql_select_db('locadora',$conexao);
				if($conexao){
					$result = mysql_query("INSERT INTO filmes (nome,qtd,categoria1,categoria2,categoria3)
						VALUES ('$nome','$qtd','$categoria1','$categoria2','$categoria3')");
					if($result){
						echo "<font color='lime'>$nome cadastro com sucesso!!!</font>";
					} else {
						echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
					}
				} else {
					echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
				}
				mysql_close();
			} else {
				echo "<font color='red'>Nome é obrigatório!!!</font>";
			}
			
		}
	?>
	</div>
	<hr/>
	<form action='/aksjdji/control/cadastrarFilme.php'>
	<table>
		<tr>
			<td>
				Nome
			</td>
			<td>
				<input type='text' name='nome' autofocus/>
			</td>
		</tr>
		<tr>
			<td>
				Quantidade
			</td>
			<td>
				<input type='text' name='qtd' onkeypress="return mascara(this, '####')" maxlength="4"/>
			</td>
		</tr>
		<?php
			$categorias = array();
			$teste;
			$conexao = mysql_connect('localhost','root','');
			mysql_select_db('locadora',$conexao);
			$result = mysql_query("SELECT cod,nome FROM categorias");
			while(list($cod,$nome) = mysql_fetch_array($result)){
				$categorias[] = $cod;
				$categorias[] = $nome;
			}
			if($conexao && $result){
			echo "
				<tr>
					<td>
						Categoria1
					</td>
					<td>
						<select name='categoria1'>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								echo "<option value=$categorias[$i]>$categorias[$j]</option>";
							}
							
						echo "</select>
					</td>
				</tr>
			";
			echo "
				<tr>
					<td>
						Categoria 2
					</td>
					<td>
						<select name='categoria2'>
							<option value=null>selecione</option>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								echo "<option value=$categorias[$i]>$categorias[$j]</option>";
							}
							
						echo "</select>
					</td>
				</tr>
			";
			echo "
				<tr>
					<td>
						Categoria 3
					</td>
					<td>
						<select name='categoria3'>
							<option value=null>selecione</option>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								echo "<option value=$categorias[$i]>$categorias[$j]</option>";
							}
							
						echo "</select>
					</td>
				</tr>
			";
			} else {
				echo "<font color='red'>SQL ERROR = ".mysql_error()."</font>";
			}
		?>
		
		<tr>
			<td>
			</td>
			<td>
				<button>Cadastrar</button>
				<button type='reset'>Limpar</button>
			</td>
		</tr>
	</table>
	</form>
	
</body>
</html>
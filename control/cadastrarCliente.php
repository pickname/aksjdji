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
    //v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    //v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
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

<title>Cadastrar Cliente - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Cadastrar Cliente - Sistema de Locadora de Filmes<h1>
	
	<div style="background-color:black">
		<h5>
			<a href="/locadora">Início</a>
			<a href="/locadora/view/clientes.php">Clientes</a>
			<a href="/locadora/view/filmes.php">Filmes</a>
			<a href="/locadora/view/locacoes.php">Locações</a>
		</h5>
	</div>
	<?php
		if(isSet($_GET['cpf'])){
			$cpf = $_GET['cpf'];
			$nome = $_GET['nome'];
			$data_nascimento = $_GET['ano'] . '-' . $_GET['mes'] . '-' . $_GET['dia'];
			$endereco = $_GET['endereco'];
			$fone = $_GET['ddd'] . "" .$_GET['telefone'];
			
			if($cpf != ''){
				$conexao = mysql_connect('localhost:3306','root','');
				mysql_select_db('locadora',$conexao);
				if($conexao){
					$result = mysql_query("INSERT INTO clientes (cpf,nome,data_nascimento,endereco,telefone)
						VALUES ('$cpf','$nome','$data_nascimento','$endereco','$fone')");
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
				echo "<font color='red'>CPF é obrigatório!!!</font>";
			}
			
		} else
	?>
	
	<form action='/locadora/control/cadastrarCliente.php'>
	<table>
		<tr>
			<td>
				CPF
			</td>
			<td>
				<input type='text' name='cpf' onkeypress="return mascara(this, '###.###.###-##')" maxlength="14" autofocus/>
			</td>
		</tr>
		<tr>
			<td>
				Nome
			</td>
			<td>
				<input type='text' name='nome'/>
			</td>
		</tr>
		<tr>
			<td>
				Data de Nascimento
			</td>
			<td>
				<?php
					echo "<select name='dia'>";
						for($i = 1;$i<=31;$i++){
							echo "<option value='$i'>$i</option>";
						}
					echo '</select>';
					echo "<select name='mes'>";
						for($i = 1;$i<=12;$i++){
							echo "<option value='$i'>$i</option>";
						}
					echo '</select>';	
					echo "<select name='ano'>";
						for($i = 1900;$i<=2012;$i++){
							echo "<option value='$i'>$i</option>";
						}
					echo "
					<option value='2013' selected>2013</option>;
					</select>";
				?>
			</td>
		</tr>
		<tr>
			<td>
				Endereço
			</td>
			<td>
				<input type='text' name='endereco'/>
			</td>
		</tr>
		<tr>
			<td>
				Telefone
			</td>
			<td>
				<input type='text' name='ddd' size="2" maxlength="2" onkeypress="return mascara(this,'##')"/>
				<input type='text' name='telefone' size="11" maxlength="8" onkeypress="return mascara(this,'########')"/>
			</td>
		</tr>
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
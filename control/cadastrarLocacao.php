<html>
<STYLE type="text/css"> 
A:link {text-decoration:non	e;color:#ffcc33;} 
A:visited {text-decoration:none;color:#ffcc33;} 
A:active {text-decoration:none;color:#ff0000;} 
A:hover {text-decoration:underline;color:#999999;} 

div#geral {
	
}

div#pesq_geral {
	margin: 0 auto;
	
}

div#divisao {
	background-color: red;
	border-right: 2px solid white;
}

div#pesquisa {
	background-color: green;
	
}
div#dados_locacao {
	background-color: pink;
	float: left;
	width: 400px; 	
	border-right: 2px solid white;
}
div#pesquisa_filmes {
	height: 250px;
	background-color: #09f; /* Azul */
}
div#filmes_locados {
	background-color: #090; /* Verde */
	border-top: 1px solid #f00;
}

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


<title>Cadastrar Locação - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Cadastrar Locação - Sistema de Locadora de Filmes<h1>
	
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
		$conexao = mysql_connect('localhost:3306','root','');
		mysql_select_db('locadora',$conexao);
		if(!$conexao){
			echo "<font color='red'>SQL ERROR = ".mysql_error()."</font>";
		}
		
		setlocale(LC_TIME, 'pt_BR', 'pt_BR iso-8859-1', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		
		$cpf_cliente = 'xxx.xxx.xxx.xx';
		$nome_cliente = 'Cliente';
		$data_locacao = date('d-m-Y H:i:s');
		$data_entrega_prevista = date('d-m-Y',strtotime($data_locacao.'+1 day'));
		$dia_entrega_prevista = date('d',strtotime($data_entrega_prevista));
		$mes_entrega_prevista = date('m',strtotime($data_entrega_prevista));
		$ano_entrega_prevista = date('Y',strtotime($data_entrega_prevista));
		$qtd_filmes = 0;
		$valor = 0;
		if(isSet($_GET['pesqCpf'])){
			$pesqCpf = $_GET['pesqCpf'];
			$sql = "SELECT cpf,nome FROM clientes WHERE cpf = '$pesqCpf'";
			$result = mysql_query($sql);
			if($result){
				$cliente = mysql_fetch_array($result);
				if($cliente['cpf'] != ''){
					$cpf_cliente = $cliente['cpf'];
					$nome_cliente = $cliente['nome']; 
				}
			} else {
				echo "ERRO ao selecionar o cliente " . mysql_error();
			}
		}
		
		if(isSet($_GET['nome'])){
			$nome = $_GET['nome'];
			
			if($nome != ''){
				if($conexao){
					$result = mysql_query("INSERT INTO categorias (nome) VALUES ('$nome')");
					if($result){
						echo "<font color='lime'>$nome cadastro com sucesso!!!</font>";
						
					} else {
						if("Duplicate entry" == substr(mysql_error(),0, strlen('Duplicate entry'))){
							echo "<font color='red'> A categoria ".$_GET['nome']." já existe</font>";
						} else {	
							echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
						}
						
					}
				} else {
					echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
				}
				
			} else {
				echo "<font color='red'>Campo nome é obrigatório!!!</font>";
			}
			
		}
		
		// verifica se o cliente já foi selecionado caso o usuário tente adicionar o filme antes de selecionar o cliente
		if(isSet($_GET['pesqFilme']) && $cpf_cliente == 'xxx.xxx.xxx.xx'){
			
				echo "<font color='red'>Selecione o cliente primeiro!</font>";
			
		}
	echo "<div id='pesquisa'>
		<table>
			<tr>
				<td>
					<form action = '".$_SERVER['PHP_SELF']."'>
							
						<b>CPF do Cliente:</b>";
							// formulario de pesquisar cpf
							$pesqCpf = '';
							if(isSet($_GET['pesqCpf'])){
								$pesqCpf = $_GET['pesqCpf'];
							}
							echo "<input type='text' name='pesqCpf' value='$pesqCpf' onkeypress=\"return mascara(this,'###.###.###-##')\" maxlength = '14' autofocus/>
							
						
						<button>Selecionar</button>
					</form>
				</td>
				<td width=36>
				</td>
				<td>
					<form action = '".$_SERVER['PHP_SELF']."'>
							<b>Pesquisar Filme por:</b>";
							// formulario de pesquisar filmes
								$tipoPesq = '';
								$pesqFilme = '';
								
								if(isSet($_GET['pesqFilme']) && $cpf_cliente != 'xxx.xxx.xxx.xx'){
									
									$pesqFilme = $_GET['pesqFilme'];
									$tipoPesq = $_GET['tipoPesq'];
								
									switch($tipoPesq){
										case 'cod':{
										echo "
										<input type='radio' name='tipoPesq' value = 'nome'/>Nome
										<input type='radio' name='tipoPesq' value = 'cod' checked='checked'/>Código 
										<input type='radio' name='tipoPesq' value = 'categoria'/>Categoria <br/>
										<input type='text' name='pesqFilme' value='$pesqFilme' autofocus/>";
											break;
										}
										case 'categoria':{
										echo "
										<input type='radio' name='tipoPesq' value = 'nome'/>Nome
										<input type='radio' name='tipoPesq' value = 'cod'/>Código 
										<input type='radio' name='tipoPesq' value = 'categoria' checked='checked'/>Categoria <br/>
										<input type='text' name='pesqFilme' value='$pesqFilme' autofocus/>";	
											break;
										}
										default:{
											echo "
										<input type='radio' name='tipoPesq' value = 'nome' checked='checked'/>Nome
										<input type='radio' name='tipoPesq' value = 'cod'/>Código 
										<input type='radio' name='tipoPesq' value = 'categoria'/>Categoria <br/>
										<input type='text' name='pesqFilme' value='$pesqFilme' autofocus/>";
											break;
										}
									}
								} else {
									echo "
										<input type='radio' name='tipoPesq' value = 'nome' checked='checked'/>Nome
										<input type='radio' name='tipoPesq' value = 'cod'/>Código 
										<input type='radio' name='tipoPesq' value = 'categoria'/>Categoria <br/>
										<input type='text' name='pesqFilme' value='$pesqFilme'/>";
								}
								
								echo "
								
							<button>Pesquisar</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
	
		<div id='dados_locacao'>";
			
				
				echo "<form action='".$_SERVER['PHP_SELF']."'>
				<table>
					<tr>
						<td>
							CPF do Cliente
						</td>
						<td>
							<b><font size=5>$cpf_cliente</font></b>
						</td>
					</tr>
					<tr>
						<td>
							Nome do Cliente
						</td>
						<td>
							<b><font size=5>$nome_cliente</font></b>
						</td>
					</tr>
					<tr>
						<td>
							Data da Locação
						</td>
						<td>
							<b><font size=5>$data_locacao</font></b>
						</td>
					</tr>
					<tr>
						<td>
							Data da Entrega
						</td>
						<td>";
							
							echo "<select name='dia_entrega'>";
								for($i = 1;$i<=31;$i++){
									if($i == $dia_entrega_prevista){
										echo "<option value='$i' selected>$i</option>";
									} else {
										echo "<option value='$i'>$i</option>";
									}
								}
							echo '</select>';
							echo "<select name='mes_entrega'>";
								for($i = 1;$i<=12;$i++){
									if($i == $mes_entrega_prevista){
										echo "<option value='$i' selected>$i</option>";
									} else {
										echo "<option value='$i'>$i</option>";
									}
								}
							echo '</select>';	
							echo "<select name='ano_entrega'>";
								for($i = date(Y);$i<=(date(Y)+1);$i++){
									echo "<option value='$i'>$i</option>";
								}
							echo "
							</select>";
						echo "</td>
					</tr>
					<tr>
						<td>
							Quantidade de Filmes
						</td>
						<td>
							<b><font size=5>$qtd_filmes</font></b>
						</td>
					</tr>
					<tr>
						<td>
							Valor R$
						</td>
						<td><b><font size=5>";
							echo number_format($valor,2,',','.');
						echo "</font></b></td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
							<button>Registrar</button>
							<button type='reset'>Limpar</button>
						</td>
					</tr>
				</table>
				</form>";
				
			
		echo "</div>
		<div id='pesquisa_filmes'>
			
						<b>Filme</b>
			
			
		<table border=1>";
		
			for($i = 0; $i < 6; $i++){
				echo "<tr><td>TESTE $i </td></tr>";
			}
		
		echo "</table>
		</div>
	</div>
	Filmes Selecionado
	<div id='filmes_locados'>
		<table border=1>";
		
			for($i = 0; $i < 20; $i++){
				echo "<tr><td>TESTE $i </td></tr>";
			}
			
			mysql_close();
		?>
		</table>
	</div>
	
</body>
</html>
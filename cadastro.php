<?php
$acao = 'incluir';
$contato = array();
if($_GET['acao']){
	$acao = $_GET['acao'];
}
$id = '';
if(isset($_GET['id']) && $_GET['id'] > 0){
	$id = $_GET['id'];

	include 'DB.php';
	$db = new DB();
	$contato = $db->getContato($id);
}

$nome = isset($contato['nome']) ? $contato['nome'] : '';
$dt_nascimento = isset($contato['dt_nascimento']) ? date("d/m/Y",strtotime(str_replace('-','/',$contato['dt_nascimento']))) : '';
$endereco = isset($contato['endereco']) ? $contato['endereco'] : '';
$numero = isset($contato['numero']) ? $contato['numero'] : '';
$cep = isset($contato['cep']) ? $contato['cep'] : '';
$bairro = isset($contato['bairro']) ? $contato['bairro'] : '';
$cidade = isset($contato['cidade']) ? $contato['cidade'] : '';
$estado = isset($contato['estado']) ? $contato['estado'] : '';
$telefone = isset($contato['telefone']) ? $contato['telefone'] : '';
$celular = isset($contato['celular']) ? $contato['celular'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Teste DealerSites</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<script src="jquery.maskedinput.js" type="text/javascript"></script>
</head>
<body>

	<div id="principal">
		<form id="formulario" action="api.php" method="post">
			<input type="hidden" name="id" id="id" value="<?=$id?>">
			<h1>Cadastro de Contato:</h1>

			<div class="tab">Dados Pessoais:
			  <p><input type="text" placeholder="Nome" name="nome" id="nome" value="<?=$nome?>"></p>
			  <p><input type="text" placeholder="Data de Nascimento" name="dt_nascimento" id="dt_nascimento" value="<?=$dt_nascimento?>"></p>
			</div>

			<div class="tab">Dados de Endere&ccedil;o:
			  <p><input type="text" placeholder="Rua" name="endereco" id="endereco" value="<?=$endereco?>"></p>
			  <p><input type="text" placeholder="N&uacute;mero" name="numero" id="numero" value="<?=$numero?>"></p>
			  <p><input type="text" placeholder="Bairro" name="bairro" id="bairro" value="<?=$bairro?>"></p>
			  <p><input type="text" placeholder="CEP" name="cep" id="cep" value="<?=$cep?>"></p>
			  <p><input type="text" placeholder="Estado" name="estado" id="estado" value="<?=$estado?>"></p>
			  <p><input type="text" placeholder="Cidade" name="cidade" id="cidade" value="<?=$cidade?>"></p>			  
			</div>

			<div class="tab">Contatos:
			  <p><input type="text" placeholder="Telefone Fixo" name="telefone" id="telefone" value="<?=$telefone?>"></p>
			  <p><input type="text" placeholder="Celular" name="celular" id="celular" value="<?=$celular?>"></p>
			</div>

			<div style="overflow:auto;">
			  <div style="float:right;">
			    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Anterior</button>
			    <button type="button" id="nextBtn" onclick="nextPrev(1)">Próximo</button>
			  </div>
			</div>

			<div style="text-align:center;margin-top:40px;">
			  <span class="step"></span>
			  <span class="step"></span>
			  <span class="step"></span>
			</div>
		</form>		
	</div>	

	<script>
		var currentTab = 0;
		showTab(currentTab);

		function showTab(n) {
			var x = document.getElementsByClassName("tab");
			x[n].style.display = "block";
			  
			if (n == 0) {
			    document.getElementById("prevBtn").style.display = "none";
			} 
			else {
			    document.getElementById("prevBtn").style.display = "inline";
			}
			
			if (n == (x.length - 1)) {
			    document.getElementById("nextBtn").innerHTML = "Salvar";			    
			} 
			else {
			    document.getElementById("nextBtn").innerHTML = "Próximo";
			}
			  
			fixStepIndicator(n)
		}

		function nextPrev(n) {
		    var x = document.getElementsByClassName("tab");
		    // Exit the function if any field in the current tab is invalid:
		    if (n == 1 && !validateForm()) return false;
		    // Hide the current tab:
		    x[currentTab].style.display = "none";
		    
		    currentTab = currentTab + n;
		  
		    if (currentTab >= x.length) {
			    salvarContato('<?=$acao?>', '<?=$id?>');
		    	return false;
		  	}
			
			showTab(currentTab);
		}

		function validateForm() {
			var valid = true;

			if(currentTab == 0){
				if(document.getElementById('nome').value == ''){
					document.getElementById('nome').className = 'invalid';
					valid = false;
				}

				/*if(document.getElementById('email').value == '' && document.getElementById('telefone').value == ''){
					document.getElementById('email').className = 'invalid';
					document.getElementById('telefone').className = 'invalid';
					valid = false;
				}*/
			}

			if(currentTab == 2){
				if(document.getElementById('telefone').value == '' && document.getElementById('celular').value == ''){
					document.getElementById('telefone').className = 'invalid';
					valid = false;
				}				
			}

			return valid;
		}

		function fixStepIndicator(n) {
		    var i, x = document.getElementsByClassName("step");
		    for (i = 0; i < x.length; i++) {
		        x[i].className = x[i].className.replace(" active", "");
		    }
		    x[n].className += " active";
		}

		function salvarContato(tipo, id){
			id = (typeof id == "undefined")?'':id;
			var statusArr = {incluir:"adicionado",alterar:"alterado",deletar:"deletado"};			

			$.ajax({
				type: 'POST',
				url: 'api.php',
				data: {
					nome: document.getElementById('nome').value,
					dt_nascimento: document.getElementById('dt_nascimento').value,
					endereco: document.getElementById('endereco').value,
					numero: document.getElementById('numero').value,
					bairro: document.getElementById('bairro').value,
					cidade: document.getElementById('cidade').value,
					estado: document.getElementById('estado').value,
					cep: document.getElementById('cep').value,
					telefone: document.getElementById('telefone').value,
					celular: document.getElementById('celular').value,
					acao: tipo,
					id: document.getElementById('id').value
				},
				success:function(msg){
					console.log(msg);
					if(msg == 'ok'){
						alert('Contato foi '+statusArr[tipo]+' com sucesso.');						
					}else{
						alert('Ocorreu algum problema ao tentar salvar o registro.');
					}
					window.location.href = 'index.php';
				}
			});
		}
		
		jQuery(function($){
		   $("#dt_nascimento").mask("99/99/9999");
		   $("#telefone").mask("(99) 9999-9999");
		   $("#celular").mask("(99) 9999-9999");
		   $("#cep").mask("99999-999");
		});
	</script>
</body>
</html>
<?php 

$conn = new mysqli("localhost", "root", "", "teste_dealersites");
if ($conn->connect_error) {
	die("Sem conexão com o banco de dados.");
} 
$res = array('error' => false);

$acao = '';

if (isset($_POST['acao'])) {
	$acao = $_POST['acao'];
}

if ($acao == 'incluir') {
	$nome = $_POST['nome'];
	$dt_nascimento = $_POST['dt_nascimento'];
	$endereco = $_POST['endereco'];
	$numero = $_POST['numero'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$cep = $_POST['cep'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$data_nasc = date("Y-m-d",strtotime(str_replace('/','-',$dt_nascimento)));
	
	$sql = "INSERT INTO contatos (nome, dt_nascimento, endereco, numero, bairro, cep, cidade, estado, telefone, celular) VALUES ('$nome', '$data_nasc', '$endereco', '$numero', '$bairro', '$cep', '$cidade', '$estado', '$telefone', '$celular') ";

	$result = $conn->query($sql);
	if ($result) {
		$conn -> close();
		echo 'ok';
		exit;
	} else{
		$conn -> close();
		echo 'err';
		//echo $s;
		exit;
	}
}

if ($acao == 'alterar') {
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$dt_nascimento = $_POST['dt_nascimento'];
	$endereco = $_POST['endereco'];
	$numero = $_POST['numero'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$cep = $_POST['cep'];
	$estado = $_POST['estado'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$data_nasc = date("Y-m-d",strtotime(str_replace('/','-',$dt_nascimento)));
	
	$sql = "UPDATE contatos SET nome = '$nome', dt_nascimento = '$data_nasc', endereco = '$endereco', numero = '$numero', bairro = '$bairro', cep = '$cep', cidade = '$cidade', estado = '$estado', telefone = '$telefone', celular = '$celular' WHERE id = '$id'";
	$result = $conn->query($sql);
	
	if ($result) {
		$conn -> close();
		echo 'ok';
		exit;
	} else{
		$conn -> close();
		echo 'err';
		exit;
	}
}

if ($acao == 'deletar') {
	$id = $_POST['id'];

	$result = $conn->query("DELETE FROM contatos WHERE id = '$id'");
	if ($result) {
		$conn -> close();
		echo 'ok';
		exit;
	} else{
		$conn -> close();
		echo 'err';
		exit;
	}
}

?>
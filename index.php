<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Teste DealerSites</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="style.css">
		<script>
			
			function deletarContato(id){
				
				$.ajax({
					type: 'POST',
					url: 'api.php',
					data: {						
						acao: 'deletar',
						id: id
					},
					success:function(msg){
						console.log(msg);
						if(msg == 'ok'){
							alert('Contato foi deletado com sucesso.');						
						}else{
							alert('Ocorreu algum problema ao tentar deletar o registro.');
						}
						window.location.href = 'index.php';
					}
				});
			}
			
			function editarContato(id){
				window.location.href='cadastro.php?acao=alterar&id='+id;
			}
			
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip(); 
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="panel panel-default users-content">
					<div class="panel-heading">Contatos <a href="javascript:void(0);" data-toggle="tooltip" title="Novo" class="glyphicon glyphicon-plus" id="addLink" onclick="location.href='cadastro.php?acao=incluir';"></a></div>

					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nome</th>
								<th>Data de Nascimento</th>
								<th>Endere&ccedil;o</th>
								<th>Telefone Fixo</th>
								<th>Celular</th>
								<th>Op&ccedil;&otilde;es</th>
							</tr>
						</thead>
						<tbody id="pessoaData">
							<?php
								include 'DB.php';
								$db = new DB();
								$contatos = $db->getRows('contatos',array('order_by'=>'id'));
								if(!empty($contatos)): $count = 0; foreach($contatos as $contato): $count++;
							?>
							<tr>
								<td><?= $contato['id']; ?></td>
								<td><?= $contato['nome']; ?></td>
								<td><?= date("d/m/Y",strtotime(str_replace('-','/',$contato['dt_nascimento']))); ?></td>
								<td><?= $contato['endereco']; ?></td>
								<td><?= $contato['telefone']; ?></td>
								<td><?= $contato['celular']; ?></td>
								<td>
									<a href="javascript:void(0);" data-toggle="tooltip" title="Editar" class="glyphicon glyphicon-edit" onclick="editarContato('<?=$contato['id']; ?>')"></a>
									<a href="javascript:void(0);" data-toggle="tooltip" title="Excluir" class="glyphicon glyphicon-trash" onclick="return confirm('Tem certeza que deseja deletar o contato?')?deletarContato('<?=$contato['id'];?>'):false;"></a>
								</td>
							</tr>
							<?php endforeach; else: ?>
							<tr><td colspan="5">Nenhum registro encontrado.</td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
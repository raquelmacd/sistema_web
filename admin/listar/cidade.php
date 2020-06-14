<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Listar Cidade</h1>
	<div class="float-right">
		<a href="cadastro/cidade" class="btn btn-success">Novo Registro</a>
		<a href="listar/cidade" class="btn btn-info">Listar Registros</a>
	</div>
	<div class="clearfix"></div>
    
    <div >
    <input class="form-control" id="myInput" type="text" placeholder="Procurar..">
    </div>
    
	<table class="table table-striped table-bordered" id="myTable">
		<thead>
			<tr>
				<td>ID</td>
				<td>Cidade</td>
                <td>Estado</td>
				<td>Opções</td>
			</tr>
		</thead>
		<tbody >
			<?php
				//buscar os servicos alfabeticamente
				$sql = "select * from cidade order by id";
				$consulta = $pdo->prepare($sql);
				$consulta->execute();

				while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
					//separar os dados
					$id 	= $dados->id;
					$cidade	= $dados->cidade;
                    $estado = $dados->estado;


					//mostrar na tela
					echo '<tr>
						<td>'.$id.'</td>
						<td>'.$cidade.'</td>
                        <td>'.$estado.'</td>
                        <td>
							<a href="cadastro/cidade/'.$id.'" class="btn btn-success btn-sm">
								<i class="fas fa-pencil-alt"></i>
							</a>
							<a class="btn btn-outline-danger btn-sm"  href="javascript:excluir('.$id.')">
								<i class="fas fa-trash"></i>
							</a>
						</td>
					</tr>';
                }?>

		</tbody>
	</table>

</div>
<script>
	function excluir(id){

		if (confirm("Deseja mesmo excluir? ")) {
			//ir para exclusao
			location.href="excluir/cidade/"+id;
		}
	};
    $(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
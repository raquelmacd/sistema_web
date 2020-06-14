<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Listar Personagens</h1>
	<div class="float-right">
		<a href="cadastro/personagem" class="btn btn-success">Novo Registro</a>
		<a href="listar/personagem" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover" id="tabela">
		<thead>
			<tr>
				<td>ID</td>
                <td>Foto</td>
				<td>Nome</td>
				<td>Nome Civil</td>
                <td>Resumo</td>
                <td>Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
				//buscar os personagens
				$sql = "SELECT * FROM personagem";
				$consulta = $pdo->prepare($sql);
				$consulta->execute();

				while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
                        //separar os dados
                        $id             = $dados->id;
                        $personagem 	= $dados->nome;
                        $nomeCivil      = $dados->nomecivil;
                        $foto           = $dados->foto;
                        $resumo         = $dados->resumo;
                    
                    $imagem = "../fotos/".$foto."p.jpg";
					//mostrar na tela
					echo '<tr>
						<td>'.$id.'</td>
                        <td><img src="'.$imagem.'" alt="'.$personagem.'" width="70px"></td>
						<td>'.$personagem.'</td>
                        <td>'.$nomeCivil.'</td>
                        <td>'.$resumo.'</td>
						<td>
							<a href="cadastro/personagem/'.$id.'" class="btn btn-success btn-sm">
								<i class="fas fa-pencil-alt"></i>
							</a>
							<a href="javascript:excluir('.$id.')" class="btn btn-outline-danger btn-sm">
								<i class="fas fa-trash"></i>
							</a>
						</td>
                    </tr>
                    
                    ';
				}
			?>
		</tbody>
	</table>

</div>
<script>
    function excluir(id){

		if (confirm("Deseja mesmo excluir? ")) {
			//ir para exclusao
			location.href="excluir/personagem/"+id;
		}
	}
    $(document).ready( function () {
    $('#tabela').DataTable({
        language: {
            "emptyTable":     "Nenhum registro",
            "info":           "Mostrando de _START_ a _END_ de _TOTAL_ registros",
            "lengthMenu":     "Mostrar _MENU_ registros",
            "loadingRecords": "Carregando...",
            "processing":     "Processando...",
            "search":         "Procurar:",
            "zeroRecords":    "Nenhum registro encontrado",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Último",
                "next":       "Próximo",
                "previous":   "Anterior"
            },
}
    });
} );
</script>
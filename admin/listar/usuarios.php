<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Listar Usuários</h1>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover" id="tabela">
		<thead>
			<tr>
				<td>ID</td>
                <td>Foto</td>
				<td>Nome</td>
				<td>E-mail</td>
			</tr>
		</thead>
		<tbody>
			<?php
				//buscar os personagens
				$sql = "SELECT * FROM usuario where ativo = 'S'";
				$consulta = $pdo->prepare($sql);
				$consulta->execute();

				while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
                        //separar os dados
                        $id             = $dados->id;
                        $nome 	= $dados->nome;
                        $email      = $dados->email;
                        $foto           = $dados->foto;
                    
                    $imagem = "../fotos/".$foto."p.jpg";
					//mostrar na tela
					echo '<tr>
						<td>'.$id.'</td>
                        <td><img src="'.$imagem.'" alt="'.$nome.'" width="70px"></td>
						<td>'.$nome.'</td>
                        <td>'.$email.'</td>
                    </tr>
                    
                    ';
				}
			?>
		</tbody>
	</table>

</div>
<script>
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
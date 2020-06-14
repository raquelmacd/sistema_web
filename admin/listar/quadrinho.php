<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Listar Quadrinhos</h1>
	<div class="float-right">
		<a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
		<a href="listar/quadrinho" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover" id="tabela">
		<thead>
			<tr>
				<td>ID</td>
                <td>Capa</td>
				<td>Título do Quadrinho / Número</td>
				<td>Data</td>
                <td>Valor</td>
                <td>Editora</td>
                <td>Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
				//buscar as editoras alfabeticamente
            //Y maiusculo traz 4 caracteres.
				$sql = "SELECT q.id, q.titulo, q.numero, date_format(q.data, '%d/%m/%Y') as data , q.valor , q.capa, e.nome FROM quadrinho AS q
                INNER JOIN tipo AS t 
                INNER JOIN editora AS e 
                WHERE q.tipo_id = t.id	AND e.id = q.editora_id order by id";
				$consulta = $pdo->prepare($sql);
				$consulta->execute();

				while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
					//separar os dados
					$id 	= $dados->id;
                    $capa   = $dados->capa;
					$titulo = $dados->titulo;
                    $data = $dados->data;
                    $valor = $dados->valor;
                    $numero = $dados->numero;
                    $editora = $dados->nome;
                    $valor = number_format($valor,2,",",".");
                    
                    $imagem = "../fotos/".$capa."p.jpg";
					//mostrar na tela
					echo '<tr>
						<td>'.$id.'</td>
                        <td><img src="'.$imagem.'" alt="'.$titulo.'" width="70px"></td>
						<td>'.$titulo.'   / '.$numero.'</td>
                        <td>'.$data.'</td>
                        <td>R$ '.$valor.'</td>
                        <td>'.$editora.'</td>
						<td>
							<a href="cadastro/quadrinho/'.$id.'" class="btn btn-success btn-sm">
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
			location.href="excluir/quadrinho/"+id;
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
<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Listar Clientes</h1>
	<div class="float-right">
		<a href="cadastro/cliente" class="btn btn-success">Novo Registro</a>
		<a href="listar/cliente" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover" id="tabela">
		<thead>
			<tr>
				<td>ID</td>
                <td>Foto</td>
                <td>Nome</td>
				<td>Email</td>
				<td>Nascimento</td>
                <td>Telefone</td>
                <td>Opções</td>
			</tr>
		</thead>
		<tbody>
            <?php
        
            $sql ="SELECT id, nome, date_format(datanascimento, '%d/%m/%Y') as datanascimento, email, foto, celular FROM cliente";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();
            
            while($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                
                $id = $dados->id;
                $nome = $dados->nome;
                $email = $dados->email;
                $foto = $dados->foto;
                $nascimento = $dados->datanascimento;
                $celular = $dados->celular;
               
                echo '<tr>
                    <td>'.$id.'</td>
                    <td><img src="../fotos/'.$foto.'p.jpg" alt="'.$nome.'" width="70px"></td>
                    <td>'.$nome.'</td>
                    <td>'.$email.'</td>
                    <td>'.$nascimento.'</td>
                    <td>'.$celular.'</td>
                    <td>
							<a href="cadastro/cliente/'.$id.'" class="btn btn-success btn-sm">
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
			location.href="excluir/cliente/"+id;
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
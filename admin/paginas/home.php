<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }

  	//selecionar os dados do banco
  	$sql = "SELECT max(id) as id FROM quadrinho";
  	$consulta = $pdo->prepare($sql);
  	$consulta->execute();
  	$dados  = $consulta->fetch(PDO::FETCH_OBJ);
    
  	//separar os dados
    $quadrinho= $dados->id;

    $pesquisar = "SELECT max(id) as vendas FROM venda";
    $verificar = $pdo->prepare($pesquisar);
  	$verificar->execute();
  	$dados  = $verificar->fetch(PDO::FETCH_OBJ);
    
  	//separar os dados
    $vendas= $dados->vendas;

    if($vendas == "") $vendas = 0;
    if($quadrinho == "") $quadrinho = 0;
?>

<div class="container">
    <h1 class="float-left">Dashboard</h1>
    <div class="clearfix"></div>
    <div class="row">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
              <div class="card-header bg-success"><h1>Vendas</h1></div>
              <div class="card-body">
                <h5 class="card-title">Quantidade de vendas </h5>
                <h2 class="card-text"><?=$vendas;?></h2>
              </div>
            </div>
            <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
              <div class="card-header bg-info"><h1>Cadastros</h1></div>
              <div class="card-body">
                <h5 class="card-title">Quantidade de quadrinhos</h5>
                <h2 class="card-text"><?=$quadrinho;?></h2>
              </div>
            </div>
    </div>
</div>
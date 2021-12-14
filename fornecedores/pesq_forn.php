<?php

session_start();
include '../conexao.php';
$tipoUsuario = $_SESSION['tipoUsuario'];
$idUsuario = $_SESSION['idUsuario'];

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchArray = array();

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " AND (razao_social LIKE :razao_social OR endereco LIKE :endereco OR bairro LIKE :bairro OR situacao LIKE :situacao OR cidade LIKE :cidade OR cep LIKE :cep OR cnpj LIKE :cnpj OR nome_fantasia LIKE :nome_fantasia ) ";
    $searchArray = array( 
        'razao_social'=>"%$searchValue%", 
        'endereco'=>"%$searchValue%",
        'bairro'=>"%$searchValue%",
        'situacao'=>"%$searchValue%",
        'cidade'=>"%$searchValue%",
        'cep'=>"%$searchValue%",
        'cnpj'=>"%$searchValue%",
        'nome_fantasia'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM fornecedores LEFT JOIN usuarios ON fornecedores.usuarios_idusuarios  = usuarios.idusuarios ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM fornecedores LEFT JOIN usuarios ON fornecedores.usuarios_idusuarios  = usuarios.idusuarios WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$stmt = $db->prepare("SELECT * FROM fornecedores LEFT JOIN usuarios ON fornecedores.usuarios_idusuarios  = usuarios.idusuarios WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

// Bind values
foreach($searchArray as $key=>$search){
    $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach($empRecords as $row){
    $data[] = array(
            "razao_social"=>$row['razao_social'],
            "endereco"=>$row['endereco'] ,
            "bairro"=>$row['bairro'],
            "cidade"=>$row['cidade'],
            "cep"=>$row['cep'],
            "uf"=>$row['uf'],
            "cnpj"=>$row['cnpj'],
            "nome_fantasia"=>$row['nome_fantasia'],
            "telefone"=>$row['telefone'],
            "nome_usuario"=>$row['nome_usuario'],
            "acoes"=> '<a href="javascript:void();" data-id="'.$row['idfornecedores'].'"  class="btn btn-info btn-sm editbtn" >Visualizar</a>  <a href="excluir-forn.php?idForn='.$row['idfornecedores'].' " data-id="'.$row['idfornecedores'].'"  class="btn btn-danger btn-sm deleteBtn" >Deletar</a>'
        );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);

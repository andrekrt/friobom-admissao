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
	$searchQuery = " AND (descricao_material LIKE :descricao_material OR nome_fantasia LIKE :nome_fantasia OR   razao_social LIKE :razao_social OR nome_usuario LIKE :nome_usuario ) ";
    $searchArray = array( 
        'descricao_material'=>"%$searchValue%", 
        'nome_fantasia'=>"%$searchValue%",
        'razao_social'=>"%$searchValue%",
        'nome_usuario'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM estoque_entradas LEFT JOIN estoque_material ON estoque_entradas.material = estoque_material.idmaterial_estoque LEFT JOIN fornecedores ON estoque_entradas.fornecedores_idfornecedores = fornecedores.idfornecedores LEFT JOIN usuarios ON estoque_entradas.usuarios_idusuarios  = usuarios.idusuarios ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM estoque_entradas LEFT JOIN estoque_material ON estoque_entradas.material = estoque_material.idmaterial_estoque LEFT JOIN fornecedores ON estoque_entradas.fornecedores_idfornecedores = fornecedores.idfornecedores LEFT JOIN usuarios ON estoque_entradas.usuarios_idusuarios  = usuarios.idusuarios WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$stmt = $db->prepare("SELECT * FROM estoque_entradas LEFT JOIN estoque_material ON estoque_entradas.material = estoque_material.idmaterial_estoque LEFT JOIN fornecedores ON estoque_entradas.fornecedores_idfornecedores = fornecedores.idfornecedores LEFT JOIN usuarios ON estoque_entradas.usuarios_idusuarios  = usuarios.idusuarios WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
            "idestoque_entradas"=>$row['idestoque_entradas'],
            "data_entrada"=>date("d/m/Y", strtotime($row['data_entrada'])),
            "nf"=>$row['nf'] ,
            "un_medida"=>$row['un_medida'],
            "descricao_material"=>$row['descricao_material'],
            "valor_unit"=>"R$ ". str_replace(".", ",",$row['valor_unit']) ,
            "qtd"=>str_replace(".", ",",$row['qtd']). " ". $row['un_medida'],
            "valor_total"=>"R$ " . str_replace(".", ",",$row['valor_total']),
            "nome_fantasia"=>$row['nome_fantasia'],
            "nome_usuario"=>$row['nome_usuario'],
            "acoes"=> '<a href="javascript:void();" data-id="'.$row['idestoque_entradas'].'"  class="btn btn-info btn-sm editbtn" >Visualizar</a>  <a href="excluir-entrada.php?idEntrada='.$row['idestoque_entradas'].' " data-id="'.$row['idestoque_entradas'].'"  class="btn btn-danger btn-sm deleteBtn" >Deletar</a>'
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

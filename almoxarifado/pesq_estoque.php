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
	$searchQuery = " AND (descricao_material LIKE :descricao_material OR un_medida LIKE :un_medida OR      grupo_material LIKE :grupo_material OR situacao LIKE :situacao OR nome_usuario LIKE :nome_usuario ) ";
    $searchArray = array( 
        'descricao_material'=>"%$searchValue%", 
        'un_medida'=>"%$searchValue%",
        'grupo_material'=>"%$searchValue%",
        'situacao'=>"%$searchValue%",
        'nome_usuario'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM estoque_material LEFT JOIN usuarios ON estoque_material.usuarios_idusuarios  = usuarios.idusuarios ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM estoque_material LEFT JOIN usuarios ON estoque_material.usuarios_idusuarios  = usuarios.idusuarios WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$stmt = $db->prepare("SELECT * FROM estoque_material LEFT JOIN usuarios ON estoque_material.usuarios_idusuarios  = usuarios.idusuarios WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
            "idmaterial_estoque"=>$row['idmaterial_estoque'],
            "descricao_material"=>$row['descricao_material'],
            "grupo_material"=>$row['grupo_material'] ,
            "un_medida"=>$row['un_medida'],
            "estoque_minimo"=>str_replace(".",",",$row['estoque_minimo']),
            "total_entrada"=>str_replace(".",",",$row['total_entrada']),
            "total_saida"=>str_replace(".",",",$row['total_saida']),
            "total_estoque"=>str_replace(".",",",$row['total_estoque']),
            "valor_comprado"=>"R$ ". str_replace(".",",",$row['valor_comprado']),
            "situacao"=>$row['situacao'],
            "data_cadastro"=>date("d/m/Y", strtotime($row['data_cadastro'])),
            "nome_usuario"=>$row['nome_usuario'],
            "acoes"=> '<a href="javascript:void();" data-id="'.$row['idmaterial_estoque'].'"  class="btn btn-info btn-sm editbtn" >Visualizar</a>  <a href="excluir-material.php?idMaterial='.$row['idmaterial_estoque'].' " data-id="'.$row['idmaterial_estoque'].'"  class="btn btn-danger btn-sm deleteBtn" >Deletar</a>'
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

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
	$searchQuery = " AND (nome_candidato LIKE :nome_candidato OR vaga LIKE :vaga OR obs LIKE :obs) ";
    $searchArray = array( 
        'nome_candidato'=>"%$searchValue%", 
        'vaga'=>"%$searchValue%",
        'obs'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM entrevistas LEFT JOIN usuarios ON entrevistas.usuario  = usuarios.idusuarios ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM entrevistas LEFT JOIN usuarios ON entrevistas.usuario  = usuarios.idusuarios WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$stmt = $db->prepare("SELECT * FROM entrevistas LEFT JOIN usuarios ON entrevistas.usuario  = usuarios.idusuarios WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
        "id"=>$row['id'],
        "nome_candidato"=>$row['nome_candidato'] ,
        "vaga"=>$row['vaga'],
        "processo"=>$row['processo'],
        "referencia"=>$row['referencia'],
        "entrevistado"=>$row['entrevistado'],
        "passou"=>$row['passou'],
        "obs"=>$row['obs'],
        "nome_usuario"=>$row['nome_usuario'],
        "acoes"=> '<a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-info btn-sm editbtn" >Visualizar</a>  <a href="excluir-entrevista.php?id='.$row['id'].' " data-id="'.$row['id'].'"  class="btn btn-danger btn-sm deleteBtn" >Deletar</a>'
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

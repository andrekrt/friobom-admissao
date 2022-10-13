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
	$searchQuery = " AND (funcionario LIKE :funcionario OR assunto LIKE :assunto OR motivo LIKE :motivo) ";
    $searchArray = array( 
        'funcionario'=>"%$searchValue%", 
        'assunto'=>"%$searchValue%",
        'motivo'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM advertencias LEFT JOIN usuarios ON advertencias.usuario = idusuarios");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];


## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM advertencias LEFT JOIN usuarios ON advertencias.usuario = idusuarios WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$stmt = $db->prepare("SELECT * FROM advertencias LEFT JOIN usuarios ON advertencias.usuario = idusuarios WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");


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
        "idadvertencia"=>$row['idadvertencia'],
        "funcionario"=>$row['funcionario'],
        "funcao"=>$row['funcao'],
        "data_ocorrencia"=>date("d/m/Y", strtotime($row['data_ocorrencia'])) ,
        "assunto"=>($row['assunto']) ,
        "usuario"=>ucfirst($row['nome_usuario']),
        "acoes"=> '<a href="form-edit.php?id='.$row['idadvertencia'].'" data-id="'.$row['idadvertencia'].'"  class="btn btn-info btn-sm editbtn" >Editar</a> <a target=_blank href="advertencia-pdf.php?id='.$row['idadvertencia'].'" data-id="'.$row['idadvertencia'].'"  class="btn btn-success btn-sm " >Imprimir</a> <a href="excluir.php?id='.$row['idadvertencia'].'" data-id="'.$row['idadvertencia'].'"  class="btn btn-danger btn-sm editbtn" >Excluir</a>'
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

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
	$searchQuery = " AND (nome_funcionario LIKE :nome_funcionario OR funcao LIKE :funcao OR nome_responsavel LIKE :nome_responsavel) ";
    $searchArray = array( 
        'nome_funcionario'=>"%$searchValue%", 
        'funcao'=>"%$searchValue%",
        'nome_responsavel'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM checklist_rescisao");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];


## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM checklist_rescisao WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$stmt = $db->prepare("SELECT * FROM checklist_rescisao WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");


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
        "idchecklist_rescisao"=>$row['idchecklist_rescisao'],
        "nome_funcionario"=>$row['nome_funcionario'],
        "funcao"=>$row['funcao'],
        "admissao"=>date("d/m/Y", strtotime($row['admissao'])) ,
        "demissao"=>date("d/m/Y", strtotime($row['demissao'])) ,
        "valor"=>"R$".str_replace(".",",",$row['valor']),
        "motivo_saida"=>ucfirst($row['motivo_saida']) ,
        "nome_responsavel"=>ucfirst($row['nome_responsavel']),
        "acoes"=> '<a href="javascript:void();" data-id="'.$row['idchecklist_rescisao'].'"  class="btn btn-info btn-sm editbtn" >Detalhes</a> <a target=_blank href="ficha.php?id='.$row['idchecklist_rescisao'].'" data-id="'.$row['idchecklist_rescisao'].'"  class="btn btn-success btn-sm " >Imprimir</a> '
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

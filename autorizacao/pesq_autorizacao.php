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
	$searchQuery = " AND (nome LIKE :nome OR funcao LIKE :funcao OR obs LIKE :obs OR nome_usuario LIKE :nome_usuario) ";
    $searchArray = array( 
        'nome'=>"%$searchValue%", 
        'funcao'=>"%$searchValue%",
        'obs'=>"%$searchValue%",
        'nome_usuario'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM autorizacoes LEFT JOIN usuarios ON autorizacoes.usuario = idusuarios");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];


## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM autorizacoes LEFT JOIN usuarios ON autorizacoes.usuario = idusuarios WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$stmt = $db->prepare("SELECT * FROM autorizacoes LEFT JOIN usuarios ON autorizacoes.usuario = idusuarios WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");


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
    $editar = "";
    $imprimir = "";
    $excluir = "";

    if($_SESSION['idUsuario']==$row['usuario']){
       $editar='<a href="javascript:void();" data-id="'.$row['idautorizacao'].'"  class="btn btn-info btn-sm editbtn" >Editar</a> ';
       $excluir = ' <a  data-id="'.$row['idautorizacao'].'"  class="btn btn-danger btn-sm" onclick=\'confirmaDelete(' . $row['idautorizacao'] . ')\' >Excluir</a> ';
    }

    if($_SESSION['tipoUsuario'] == 3 || $_SESSION['tipoUsuario']==99){
        $imprimir = ' <a target=_blank href="autorizacao-pdf.php?id='.$row['idautorizacao'].'" data-id="'.$row['idautorizacao'].'"  class="btn btn-success btn-sm " >Imprimir</a> ';
    }

    $data[] = array(
        "idautorizacao"=>$row['idautorizacao'],
        "nome"=>$row['nome'],
        "funcao"=>$row['funcao'],
        "data_atual"=>date("d/m/Y", strtotime($row['data_atual'])) ,
        "valor"=>number_format($row['valor'],2,",",".") ,
        "obs"=>$row['obs'],
        "usuario"=>ucfirst($row['nome_usuario']),
        "acoes"=> $editar . $imprimir . $excluir
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

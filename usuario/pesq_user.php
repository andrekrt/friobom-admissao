<?php
include '../conexao.php';

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
	$searchQuery = " AND (cpf LIKE :cpf OR 
        nome_usuario LIKE :nome_usuario OR 
        email LIKE :email OR nome_tipo LIKE :nome_tipo ) ";
    $searchArray = array( 
        'cpf'=>"%$searchValue%", 
        'nome_usuario'=>"%$searchValue%",
        'email'=>"%$searchValue%",
        'nome_tipo'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM usuarios LEFT JOIN tipo_usuario ON usuarios.tipo_usuario_idtipo_usuario = tipo_usuario.idtipo_usuario ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM usuarios LEFT JOIN tipo_usuario ON usuarios.tipo_usuario_idtipo_usuario = tipo_usuario.idtipo_usuario WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT * FROM usuarios LEFT JOIN tipo_usuario ON usuarios.tipo_usuario_idtipo_usuario = tipo_usuario.idtipo_usuario WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
            "idusuarios"=>$row['idusuarios'],
            "cpf"=>$row['cpf'],
            "nome_usuario"=>$row['nome_usuario'],
            "email"=>$row['email'],
            "tipo_usuario_idtipo_usuario"=>$row['nome_tipo'],
            "acoes"=> '<a href="javascript:void();" data-id="'.$row['idusuarios'].'"  class="btn btn-info btn-sm editbtn" >Nova Senha</a>  <a  data-id="'.$row['idusuarios'].'"  class="btn btn-danger btn-sm deleteBtn" onclick=\'confirmaDelete(' . $row['idusuarios'] . ')\'>Deletar</a>'
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

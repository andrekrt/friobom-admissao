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
	$searchQuery = " AND (descricao_material LIKE :descricao_material OR solicitante LIKE :solicitante OR nome_usuario LIKE :nome_usuario ) ";
    $searchArray = array( 
        'descricao_material'=>"%$searchValue%", 
        'solicitante'=>"%$searchValue%",
        'nome_usuario'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM estoque_saidas LEFT JOIN estoque_material ON estoque_saidas.material = estoque_material.idmaterial_estoque LEFT JOIN usuarios ON estoque_saidas.usuarios_idusuarios  = usuarios.idusuarios ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM estoque_saidas LEFT JOIN estoque_material ON estoque_saidas.material = estoque_material.idmaterial_estoque LEFT JOIN usuarios ON estoque_saidas.usuarios_idusuarios  = usuarios.idusuarios WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$stmt = $db->prepare("SELECT * FROM estoque_saidas LEFT JOIN estoque_material ON estoque_saidas.material = estoque_material.idmaterial_estoque LEFT JOIN usuarios ON estoque_saidas.usuarios_idusuarios  = usuarios.idusuarios WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
            "idestoque_saidas"=>$row['idestoque_saidas'],
            "data_saida"=>date("d/m/Y", strtotime($row['data_saida'])),
            "qtd"=> str_replace(".",",",$row['qtd']) . " ". $row['un_medida'] ,
            "descricao_material"=>$row['descricao_material'],
            "solicitante"=>$row['solicitante'],
            "obs"=>$row['obs'],
            "nome_usuario"=>$row['nome_usuario'],
            "acoes"=> '<a href="javascript:void();" data-id="'.$row['idestoque_saidas'].'"  class="btn btn-info btn-sm editbtn" >Visualizar</a>  <a  data-id="'.$row['idestoque_saidas'].'"  class="btn btn-danger btn-sm deleteBtn"  onclick=\'confirmaDelete(' . $row['idestoque_saidas'] . ')\'>Deletar</a>'
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

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
	$searchQuery = " AND (cnpj LIKE :cnpj OR nome LIKE :nome OR tipo_contrato LIKE :tipo_contrato OR rca LIKE :rca OR supervisor LIKE :supervisor OR nome_supervisor LIKE :nome_supervisor OR rota LIKE :rota OR nome_rota LIKE :nome_rota OR situacao LIKE :situacao) ";
    $searchArray = array( 
        'cnpj'=>"%$searchValue%", 
        'nome'=>"%$searchValue%",
        'tipo_contrato'=>"%$searchValue%",
        'rca'=>"%$searchValue%",
        'supervisor'=>"%$searchValue%", 
        'nome_supervisor'=>"%$searchValue%",
        'rota'=>"%$searchValue%",
        'nome_rota'=>"%$searchValue%",
        'situacao'=>"%$searchValue%", 
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM cores ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];


## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM cores LEFT JOIN supervisores ON cores.supervisor=supervisores.idsupervisor LEFT JOIN rotas ON cores.rota=rotas.cod_rota LEFT JOIN usuarios ON cores.usuario=usuarios.idusuarios WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];


## Fetch records
$stmt = $db->prepare("SELECT * FROM cores LEFT JOIN supervisores ON cores.supervisor=supervisores.idsupervisor LEFT JOIN rotas ON cores.rota=rotas.cod_rota LEFT JOIN usuarios ON cores.usuario=usuarios.idusuarios WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");


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
    $editar = '<a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-info btn-sm editbtn" >Editar</a> ';
    $imprimir = "";
    $excluir = '<a class="btn btn-danger btn-sm deleteBtn " onclick=\'confirmaDelete(' . $row['id'] . ')\'>Excluir</a>';
    $anexos = "Sem Anexo";

    $numAnexos = scandir("uploads/$row[id]");
    if(count($numAnexos)>2){
        $anexos = '<a href="uploads/'.$row['id'].'" target="_blank">Anexos</a>';
    }

    $diferencaDias = (strtotime($row['data_validade'])-strtotime(date('Y-m-d'))) / (60*60*24);
    if($diferencaDias>30){
        $situacao = "Dentro do Prazo";
    }elseif($diferencaDias<=30 && $diferencaDias>=0){
        $situacao = "Vencimento Próximo";
    }else{
        $situacao = "Vencida";
    }

    $data[] = array(
        "id"=>$row['id'],
        "nome"=>$row['nome'],
        "cnpj"=>$row['cnpj'],
        "rca"=>$row['rca'],
        "supervisor"=>$row['nome_supervisor'],
        "rota"=>$row['nome_rota'],
        "tipo_contrato"=>$row['tipo_contrato'],
        "data_emissao"=>date("d/m/Y", strtotime($row['data_emissao'])) ,
        "data_validade"=>date("d/m/Y", strtotime($row['data_validade'])) ,
        "situacao"=>$situacao,
        "anexos"=>$anexos,
        "nome_usuario"=>ucfirst($row['nome_usuario']),
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

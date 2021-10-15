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
	$searchQuery = " AND (nome_contratado LIKE :nome_contrado OR 
        sexo LIKE :sexo OR 
        funcao LIKE :funcao OR rota LIKE :rota OR situacao LIKE :situacao OR nome_usuario LIKE :nome_usuario ) ";
    $searchArray = array( 
        'nome_contrado'=>"%$searchValue%", 
        'sexo'=>"%$searchValue%",
        'funcao'=>"%$searchValue%",
        'rota'=>"%$searchValue%",
        'situacao'=>"%$searchValue%",
        'nome_usuario'=>"%$searchValue%"
    );
}

## Total number of records without filtering
if($tipoUsuario==1){
    $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM documentos_admissao LEFT JOIN usuarios ON documentos_admissao.usuarios_idusuarios  = usuarios.idusuarios ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];
}else{
    $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM documentos_admissao LEFT JOIN usuarios ON documentos_admissao.usuarios_idusuarios  = usuarios.idusuarios WHERE usuarios_idusuarios = :idUsuario");
    $stmt->bindValue(':idUsuario', $idUsuario);
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];
}


## Total number of records with filtering
if($tipoUsuario==1){
    $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM documentos_admissao LEFT JOIN usuarios ON documentos_admissao.usuarios_idusuarios  = usuarios.idusuarios WHERE 1 ".$searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];
}else{
    $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM documentos_admissao LEFT JOIN usuarios ON documentos_admissao.usuarios_idusuarios  = usuarios.idusuarios WHERE  1  AND usuarios_idusuarios = :idUsuario ".$searchQuery);
    $stmt->bindValue(':idUsuario', $idUsuario);
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

}

## Fetch records
if($tipoUsuario==1){
    $stmt = $db->prepare("SELECT * FROM documentos_admissao LEFT JOIN usuarios ON documentos_admissao.usuarios_idusuarios  = usuarios.idusuarios WHERE 1  ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

}else{
    $stmt = $db->prepare("SELECT * FROM documentos_admissao LEFT JOIN usuarios ON documentos_admissao.usuarios_idusuarios  = usuarios.idusuarios WHERE 1  AND usuarios_idusuarios = :idUsuario ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");
    $stmt->bindValue(':idUsuario', $idUsuario);
}

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
            "iddocumentos_admissao"=>$row['iddocumentos_admissao'],
            "data_envio"=>date("d/m/Y H:i", strtotime($row['data_envio'])) ,
            "nome_contratado"=>$row['nome_contratado'],
            "data_nascimento"=>date("d/m/Y", strtotime($row['data_nascimento'])) ,
            "sexo"=>$row['sexo'],
            "funcao"=>$row['funcao'],
            "rota"=>$row['rota'],
            "num_pis"=>$row['num_pis'],
            "tipo_conta"=>$row['tipo_conta'],
            "agencia"=>$row['agencia'],
            "conta"=>$row['conta'],
            "variacao_op"=>$row['variacao_op'],
            "documentos"=>' <a target="_blank" href="uploads/'. $row['iddocumentos_admissao'].'" >Anexos</a> ',
            "situacao"=>$row['situacao'],
            "obs"=>$row['obs'],
            "nome_usuario"=>$row['nome_usuario'],
            "acoes"=> '<a href="javascript:void();" data-id="'.$row['iddocumentos_admissao'].'"  class="btn btn-info btn-sm editbtn" >Visualizar</a>  <a href="excluir.php?idDocumento='.$row['iddocumentos_admissao'].' " data-id="'.$row['iddocumentos_admissao'].'"  class="btn btn-danger btn-sm deleteBtn" >Deletar</a>'
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

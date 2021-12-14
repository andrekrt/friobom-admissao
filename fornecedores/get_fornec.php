<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM fornecedores LEFT JOIN usuarios ON fornecedores.usuarios_idusuarios = usuarios.idusuarios WHERE idfornecedores='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>

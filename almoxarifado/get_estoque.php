<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM estoque_material LEFT JOIN usuarios ON estoque_material.usuarios_idusuarios = usuarios.idusuarios WHERE idmaterial_estoque='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>

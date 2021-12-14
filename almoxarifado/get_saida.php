<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM estoque_saidas LEFT JOIN estoque_material ON estoque_saidas.material = estoque_material.idmaterial_estoque LEFT JOIN usuarios ON estoque_saidas.usuarios_idusuarios = usuarios.idusuarios WHERE idestoque_saidas='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>

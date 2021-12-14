<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM estoque_entradas LEFT JOIN estoque_material ON estoque_entradas.material = estoque_material.idmaterial_estoque LEFT JOIN fornecedores ON estoque_entradas.fornecedores_idfornecedores = fornecedores.idfornecedores LEFT JOIN usuarios ON estoque_entradas.usuarios_idusuarios = usuarios.idusuarios WHERE idestoque_entradas='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>

<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM usuarios WHERE idusuarios='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>

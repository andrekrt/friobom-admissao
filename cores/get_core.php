<?php include('../conexao.php');
$id = $_POST['id'];
$sql = "SELECT * FROM cores LEFT JOIN supervisores ON cores.supervisor=supervisores.idsupervisor LEFT JOIN rotas ON cores.rota=rotas.cod_rota LEFT JOIN usuarios ON cores.usuario=usuarios.idusuarios WHERE id='$id' LIMIT 1";
$query = $db->query($sql);
$row = $query->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>

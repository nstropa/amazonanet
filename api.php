<?php
require('routeros_api.class.php');

$API = new RouterosAPI();
$router_ip = '192.168.88.1'; // IP da MikroTik
$username = 'admin';         // Usuário API MikroTik
$password = 'password';      // Senha API MikroTik

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($API->connect($router_ip, $username, $password)) {
        if ($action === 'create_temp_user') {
            $name = 'temp-' . rand(1000, 9999);
            $password = 'temp123';
            $duration = '15m';

            $API->comm('/ip/hotspot/user/add', [
                'name' => $name,
                'password' => $password,
                'limit-uptime' => $duration,
                'profile' => 'default'
            ]);

            echo json_encode(['success' => true, 'username' => $name, 'password' => $password]);
        } elseif ($action === 'login_user') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $users = $API->comm('/ip/hotspot/user/print', [
                '?name' => $username,
                '?password' => $password
            ]);

            if (count($users) > 0) {
                echo json_encode(['success' => true, 'message' => 'Login bem-sucedido']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Credenciais inválidas']);
            }
        }

        $API->disconnect();
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao conectar à MikroTik']);
    }
}
?>

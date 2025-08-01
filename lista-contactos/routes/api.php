<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}


require_once __DIR__ . '/../controllers/ContactoController.php';



$metodo = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/'); 

$controller = new ContactoController();



if (strpos($uri, '/lista-contactos/routes/api.php/contactos') !== false) {
    switch ($metodo) {
        case 'GET':
            $controller->obtenerContactos();
            break;

        case 'POST':
            $controller->crearContacto();
            break;

        case 'DELETE':
            
            $partes = explode('/', $uri);
            $id = end($partes);
            $controller->eliminarContacto($id);
            break;

        default:
            http_response_code(405);
            echo json_encode(["mensaje" => "Método no permitido"]);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(["mensaje" => "Ruta no encontrada"]);
}

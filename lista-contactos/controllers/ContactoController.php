<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Contacto.php';

class ContactoController {
    private $contacto;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->contacto = new Contacto($db);
    }

    
    public function obtenerContactos() {
        $stmt = $this->contacto->obtenerTodos();
        $contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($contactos);
    }

    
    public function crearContacto() {
        $data = json_decode(file_get_contents("php://input"));

        
        if (
            empty($data->nombre) ||
            !filter_var($data->email, FILTER_VALIDATE_EMAIL) ||
            !preg_match('/^[0-9\-\s\+]+$/', $data->telefono)
        ) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Datos inválidos"]);
            return;
        }

        $this->contacto->nombre = $data->nombre;
        $this->contacto->email = $data->email;
        $this->contacto->telefono = $data->telefono;

        if ($this->contacto->crear()) {
            echo json_encode(["mensaje" => "Contacto creado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al crear el contacto"]);
        }
    }

    
    public function eliminarContacto($id) {
        if ($this->contacto->eliminar($id)) {
            echo json_encode(["mensaje" => "Contacto eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["mensaje" => "Error al eliminar"]);
        }
    }
}

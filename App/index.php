<?php
namespace App;
require "../vendor/autoload.php";

use App\Model\Cliente;
use App\Model\Mega;
use App\Repository\ClienteRepository;
use App\Repository\MegaRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isValid($data)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados de entrada inválidos."]);
            break;
        }

        $cliente = new Cliente();

        $cliente->setNome($data->nome);
        $cliente->setEmail($data->email);
        $cliente->setCidade($data->cidade);
        $cliente->setEstado($data->estado);

        $repository = new ClienteRepository();
        $success = $repository->insertCliente($cliente);

        if ($success) {
            http_response_code(200);
            echo json_encode(["message" => "Dados inseridos com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Falha ao inserir dados."]);
        }
        break;
    case 'GET':
        $repository = new ClienteRepository();
        if (isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if ($id === false) {
                    http_response_code(400); 
                    echo json_encode(['error' => 'O valor do ID fornecido não é um inteiro válido.']);
                    exit;
                } else {
                    $cliente = new Cliente();
                    $repository = new ClienteRepository();
                    $cliente->setId($id);
                    $result = $repository->getById($cliente);
                }
            } else {
            $result = $repository->getAll();
        }

        if ($result) {
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Nenhum dado encontrado."]);
        }
        break;

    case "PUT":
        $data = json_decode(file_get_contents("php://input"));

        if (!isValidUpdate($data)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados de entrada inválidos."]);
            break;
        }

        $cliente = new Cliente();
        $cliente->setNome($data->nome);
        $cliente->setEmail($data->email);
        $cliente->setCidade($data->cidade);
        $cliente->setEstado($data->estado);
        $cliente->setId($data->id);

        $repository = new ClienteRepository();

        if(!$repository->getById($cliente)){
            http_response_code(404);
            echo json_encode(["error" => "Cliente não encontrado"]);
            break;
        }

        $success = $repository->updateCliente($cliente);
        if($success){
            http_response_code(200);
            echo json_encode(["success" => "Atualização realizada com sucesso"]);
        }else{
            http_response_code(400);
            echo json_encode(["erro" => "Atualizacao mal sucessedida"]);
        }


    break;
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"));

        if (!isValidDelete($data)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados de entrada inválidos."]);
            break;
        }

        $cliente = new Cliente();
        $cliente->setId($data->id);

        $repository = new ClienteRepository();

        if(!$repository->getById($cliente)){
            http_response_code(404);
            echo json_encode(["error" => "Cliente não encontrado"]);
            break;
        }

        $success = $repository->deleteCliente($cliente);
        
        if($success){
            http_response_code(200);
            echo json_encode(["success" => "Registro excluido com sucesso"]);
        }else{
            http_response_code(400);
            echo json_encode(["erro" => "Atualizacao mal sucessedida"]);
        }

    break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Método não permitido."]);
        break;
}

function isValid($data) {
    $requiredFields = ['nome', 'email', 'cidade', 'estado'];
    foreach ($requiredFields as $field) {
        if (!isset($data->$field) || empty($data->$field)) {
            return false;
        }
    }
    return true;
}


function isValidUpdate($data) {
    $requiredFields = ['nome', 'email', 'cidade', 'estado', 'id'];
    foreach ($requiredFields as $field) {
        if (!isset($data->$field) || empty($data->$field)) {
            return false;
        }
    }
    return true;
}

function isValidDelete($data) {
    $requiredFields = ["id"];
    foreach ($requiredFields as $field) {
        if (!isset($data->$field) || empty($data->$field)) {
            return false;
        }
    }
    return true;
}

<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

$db = [];

$db['host'] = 'localhost';
$db['dbname'] = 'pets';
$db['user'] = 'root';
$db['pass'] = '';

$pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// return $pdo;

return function (App $app) use ($pdo) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });


    $app->post('/save', function (Request $request, Response $response) use ($pdo) {
  
        $stmt = $pdo->prepare(
            'INSERT INTO animais (nome_animal, nome_dono, animal, raca )
                VALUES(:nome_animal, :nome_dono, :animal, :raca)'
        );
        $stmt->execute(array(
            ":nome_animal" => $_POST['nome'],
            ":nome_dono" => $_POST['nomedono'],
            ":animal" => $_POST['animal'],
            ":raca" => $_POST['raca']
        ));
      
        $result = $stmt->rowCount();
        $resultado = $result > 0 ? 'Cadastrado com sucesso' : 'falhou';
           
        // file_put_contents('debug.log', $teste);
    
        $response->getBody()->write($resultado);
        return $response;
    });


    $app->get('/lista', function (Request $request, Response $response) use ($pdo) {

        $stmt = $pdo->query(
            'SELECT * from animais order by id desc'
        );

        $result = $stmt->rowCount();
        $dados = $stmt->fetchAll();
        $resultado = $result > 0 ? 'ok' : 'falhou';

        file_put_contents('debug.log', print_r($dados, true));

        $dadosJson = json_encode($dados);
        // $dadosJson = json_encode(['nome'=> 'paulo']);

        
        $response->getBody()->write($dadosJson);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    });

};

// php -S localhost:8888 -t public public/index.php
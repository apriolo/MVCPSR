<?php

require __DIR__ . '/app/vendor/autoload.php';

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Container\ContainerInterface;

$caminho = $_SERVER["PATH_INFO"];
$rotas = require __DIR__ . '/app/config/routes.php';

if (!array_key_exists($caminho, $rotas)) {
    http_response_code(404);
}

session_start();

//Verificação de login do usuario
$isLoginRoute = stripos($caminho, "login");
if (!isset($_SESSION["logado"]) && $isLoginRoute === false) {
    session_destroy();
    header('Location:/index.php/login');
    exit();
}

// Instancio uma fabrica de requisições da PSR
$psr17Factory = new Psr17Factory();

// Crio as configuraçlões do request a fazer
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

// Utilizo as variaveis globais como request
$request = $creator->fromGlobals();

// Busco a classe da rota chamada pelo caminho
$classeControladora = $rotas[$caminho];

// Importando os containers de dependenceias (INTERFACE)
/**
 * @var ContainerInterface $container
 */
$container = require __DIR__ . '/app/config/dependences.php';


// Instanciando a classe controladora atraves de dependencias
/**
 * @var ContainerInterface $controlador
 */
$controlador = $container->get($classeControladora);


// Utilizando requests da PSR para exibir o formulario
$resposta = $controlador->handle($request);

// uma requisição pode ter N headers então pego todos enviados como resposta
// da requisição
foreach ($resposta->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

// Exibo o body da requisição
echo $resposta->getBody();

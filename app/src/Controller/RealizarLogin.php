<?php

namespace Alura\Cursos\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTrait;

// Neste formulari eu uso a interface request da PSR
// implemento ela na classe
class RealizarLogin implements RequestHandlerInterface
{
    // trait de mensagens no template
    use FlashMessageTrait;

    // private para repositorios de usuario
    private $repositorioDeUsuarios;

    // recebo o entity manager pelo construct e seto o repositorio de usuarios
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeUsuarios = $entityManager->getRepository(Usuario::class);
    }

    // Function da interface handle request
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        // get no email e filtro
        $email = filter_var($request->getParsedBody()['email'], FILTER_VALIDATE_EMAIL);

        // se email for false ou nulo defino a mensagem e retorno um redirect
        if (is_null($email) || $email === false) {
            $this->defineMensagem("danger", "Email Invalido!");
            return new Response(302, ['location' => '/index.php/login']);
        }

        // get e filter na senha
        $senha = filter_var($request->getParsedBody()['senha'], FILTER_SANITIZE_STRING);

        // Find no banco por email
        $usuario = $this->repositorioDeUsuarios->findOneBy(["email" => $email]);

        // se não encontrar email ou senha invalida retorno com mensagem de erro
        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
            $this->defineMensagem("danger", "Email ou senha Invalido!");
            return new Response(302, ['location' => '/index.php/login']);
        }

        // usuario logado
        $_SESSION["logado"] = true;

        // defino mensagem e retorno
        $this->defineMensagem("success", "Logado com sucesso");
        return new Response(302, ['location' => '/index.php/listar-cursos']);
    }
}
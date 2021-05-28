<?php

namespace Alura\Cursos\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTrait;

class Deslogar implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private $repositorioDeUsuarios;

    // Não preciso de dados do usuario, caso precise utilizo ele aqui
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeUsuarios = $entityManager->getRepository(Usuario::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Apenas destruo a sessao e redireciono
        session_destroy();
        $this->defineMensagem("success", "Usuario Deslogado");
        return new Response(302, ['location' => '/index.php/login']);
    }
}
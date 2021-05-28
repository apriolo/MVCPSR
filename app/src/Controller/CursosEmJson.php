<?php

namespace Alura\Cursos\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Curso;

class CursosEmJson implements RequestHandlerInterface
{
    private $repositorioDeCursos;

    // Preciso do repositorio de cursos
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeCursos = $entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Get em todos os cursos
        $cursos = $this->repositorioDeCursos->findAll();
        
        // Response dos cursos em json
        return new Response(302, ["Content-Type" => "application/json"], json_encode($cursos));
    }
}
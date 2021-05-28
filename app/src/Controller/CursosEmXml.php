<?php

namespace Alura\Cursos\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Curso;

class CursosEmXml implements RequestHandlerInterface
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
        // Functio de xml
        $cursosXml = new \SimpleXMLElement("<cursos/>");
        // Formatar dados
        foreach ($cursos as $curso) {
            $cursoXml = $cursosXml->addChild('curso');
            $cursoXml = $cursosXml->addChild('id', $curso->getId());
            $cursoXml = $cursosXml->addChild('descricao', $curso->getDescricao());
        }
        
        // Response dos cursos em json
        return new Response(302, ['Content-Type' => 'application/xml'], $cursosXml->asXML());
    }
}
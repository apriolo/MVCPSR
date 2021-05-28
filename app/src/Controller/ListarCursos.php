<?php

namespace Alura\Cursos\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\RenderizadorHtmlTrait;

// Neste formulari eu uso a interface request da PSR
// implemento ela na classe
class ListarCursos implements RequestHandlerInterface
{
    // Trait de render de html
    use RenderizadorHtmlTrait;

    // Private do repositorio de cursos
    private $repositorioDeCursos;

    // Recebo o entity manager e seto o curso como o repositorio a utilizar
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeCursos = $entityManager->getRepository(Curso::class);
    }

    // function de interface request handle
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        // Get em todos os cursos
        $cursos = $this->repositorioDeCursos->findAll();
        // Seto titulo da pagina
        $titulo = "Lista de Cursos";

        // salvo a pagina html com as variaveis
        $html =  $this->renderizaHtml('cursos/listar-cursos.php', [
            'titulo' => $titulo,
            'cursos' => $cursos
        ]);

        // Retorno o template com o response http
        return new Response(200, [], $html);
    }
}
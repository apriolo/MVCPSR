<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Alura\Cursos\Helper\RenderizadorHtmlTrait;

// Neste formulari eu uso a interface request da PSR
// implemento ela na classe
class FormularioInsercao implements RequestHandlerInterface
{
    use RenderizadorHtmlTrait;

    // Variavel para utilizar o entity manager do ORM
    /**
     * @var EntityManager
     */
    private $entityManager;

    // Crio o entity no construtor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Essa função é o padrão para renderizar objetos HTML
    // já existente na interface de request e response http da psr
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html =  $this->renderizaHtml('cursos/formulario.php', [
            'titulo' => $titulo,
            'cursos' => $cursos
        ]);

        return new Response(200, [], $html);
    }
}
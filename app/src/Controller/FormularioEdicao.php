<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Alura\Cursos\Helper\RenderizadorHtmlTrait;
use Alura\Cursos\Helper\FlashMessageTrait;
use Alura\Cursos\Entity\Curso;

// Neste formulari eu uso a interface request da PSR
// implemento ela na classe
class FormularioEdicao implements RequestHandlerInterface
{
    use RenderizadorHtmlTrait,FlashMessageTrait;

    // Variavel para utilizar o entity manager do ORM
    /**
     * @var EntityManager
     */
    private $entityManager;

    // Crio o entity no construtor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioCursos = $entityManager->getRepository(Curso::class);
    }

    // Essa função é o padrão da interface request handle
    // já existente na interface de request e response http da psr
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Pego o id do get
        $queryString = $request->getQueryParams();

        // Filtro ele
        $id = filter_var($queryString['id'], FILTER_VALIDATE_INT);

        // caso for nulo ou false defino a mensagem e retorno
        if (is_null($id) || $id === false) {
            $this->defineMensagem("danger", "Curso Inexistente!");
            return new Response(302, ['location' => '/index.php/listar-cursos']);
        }

        // Caso id ok, procuro ele no banco
        $curso = $this->repositorioCursos->find($id);

        // Seto o titulo da pagina
        $titulo = 'Alterar Curso:'.$curso->getDescricao();

        // Salvo o html da pagina com as variaveis atraves da trait
        $html =  $this->renderizaHtml('cursos/formulario.php', [
            'titulo' => $titulo,
            'curso' => $curso
        ]);

        // Retorno utilizando o response http
        return new Response(200, [], $html);
    }
}
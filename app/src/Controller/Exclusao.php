<?php

namespace Alura\Cursos\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;

// Neste formulari eu uso a interface request da PSR
// implemento ela na classe
class Exclusao implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private $entityManager;

    // Pego o entity manager no construtor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Handle da interface request
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Pego as variaveis get
        $queryString = $request->getQueryParams();
        // Validação
        $idEntidade = filter_var($queryString['id'], FILTER_VALIDATE_INT);
        // Get no objeto dentro do banco
        $entidade = $this->entityManager->getReference(Curso::class,$idEntidade);
        // Remove ele
        $this->entityManager->remove($entidade);
        // Atualizo o BD
        $this->entityManager->flush();

        // Defino a mensagem
        $this->defineMensagem("success", "Curso excluido com sucesso!");

        // Retorno header com redirect com o PSR RESPONSE
        return new Response(302, ['location' => '/index.php/listar-cursos']);
    }
}
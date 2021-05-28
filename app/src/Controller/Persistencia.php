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
class Persistencia implements RequestHandlerInterface
{
    // trait para exibir mensagem
    use FlashMessageTrait;

    // entity manager
    private $entityManager;

    // Entity manager pelo construtor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // function da interface request handle
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // get na descrição via post
        $descricao = filter_var($request->getParsedBody()['descricao'], FILTER_SANITIZE_STRING);

        // Crio um novo objeto curso
        $curso = new Curso();
        // Seto a descrição
        $curso->setDescricao($descricao);

        // Get no possivel id via get
        $id = filter_var($request->getQueryParams()['id'], FILTER_VALIDATE_INT);

        // Caso tenha id e for valido, é uma alteração
        if (!is_null($id) && $id !== false) {
            // Seto id no objeto do curso
            $curso->setId($id);
            // Atualizo o nome do curso
            $this->entityManager->merge($curso);
            // defino a mensagem no template atraves da trait
            $this->defineMensagem("success", "Curso atualizado com sucesso!");
        } else {
            //caso seja inserção
            //adiciono o curso no bd
            $this->entityManager->persist($curso);
            //defino a mensagem
            $this->defineMensagem("success", "Curso inserido com sucesso!");
        }
        // Atualizo o bd
        $this->entityManager->flush();

        // retorno header de redirect
        return new Response(302, ['location' => '/index.php/listar-cursos']);
    }
}
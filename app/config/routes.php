<?php

use Alura\Cursos\Controller\{
    FormularioInsercao,
    Exclusao,
    ListarCursos,
    Persistencia,
    FormularioEdicao,
    FormularioLogin,
    RealizarLogin,
    Deslogar,
    CursosEmJson,
    CursosEmXml
};

$rotas = [
    '/novo-curso' => FormularioInsercao::class,
    '/excluir-curso' => Exclusao::class,
    '/listar-cursos' => ListarCursos::class,
    '/salvar-curso' => Persistencia::class,
    '/alterar-curso' => FormularioEdicao::class,
    '/login' => FormularioLogin::class,
    '/realizar-login' => RealizarLogin::class,
    '/logout' => Deslogar::class,
    '/cursos-json' => CursosEmJson::class,
    '/cursos-xml' => CursosEmXml::class
];

return $rotas;
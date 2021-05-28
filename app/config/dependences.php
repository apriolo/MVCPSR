<?php

use Alura\Cursos\Infra\EntityManagerCreator;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManagerInterface;

// Instancio as interfaces de container de dependencias
$containerBuilder = new ContainerBuilder();

// Adiciono as dependencias dentro das classes instanciadas
// neste exemplo o container retorna o entity manager para
// usar o ORM
$containerBuilder->addDefinitions ([
    EntityManagerInterface::class => function () {
        return (new EntityManagerCreator())->getEntityManager();
    }
]);

return $containerBuilder->build();
<?php include __DIR__ . '/../inicio-html.php' ?>
<a href="/index.php/novo-curso" class="btn btn-primary mb-2"> novo curso </a>

<ul class="list-group">
    <?php foreach ($cursos as $curso): ?>
        <li class="list-group-item d-flex justify-content-between">
            <?= $curso->getDescricao(); ?>
            <span>
                <a href="/index.php/alterar-curso?id=<?= $curso->getId() ?>" class="btn btn-secondary btn-sm">editar</a>
                <a href="/index.php/excluir-curso?id=<?= $curso->getId() ?>" class="btn btn-danger btn-sm">excluir</a>
            </span>
        </li>
    <?php endforeach; ?>
</ul>
<?php include __DIR__ . '/../fim-html.php' ?>
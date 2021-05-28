<?php include __DIR__ . '/../inicio-html.php' ?>
    <form action="/index.php/realizar-login" method="POST">
        <div class="form-group">
            <label for="descricao">Email</label>
            <input type="email" id="email" name="email" class="form-control">
            <label for="descricao">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control">
        </div>
        <button class="btn btn-primary">Login</button>
    </form>
<?php include __DIR__ . '/../fim-html.php' ?>
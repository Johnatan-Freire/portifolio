<!DOCTYPE html>
<?php include('cabecalho.php') ?>

<div class="form-container">
    <h1>Login</h1>
    <form method="post" action="#">
        <div class="field">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required />
        </div>
        <div class="field">
            <label for="password">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite sua senha" required />
        </div>
        <div class="actions">
            <input type="submit" value="Entrar" class="btn-primary" />
        </div>
    </form>
</div>


<?php include('footer.php') ?>
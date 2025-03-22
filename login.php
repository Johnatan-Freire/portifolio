<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('sistema/config/conexao.php');

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if ($email && !empty($password)) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['senha'])) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_email'] = $row['email'];
                    header("Location: sistema/index.php");
                    exit();
                }
            }
        } else {
            $erro = "Erro na consulta ao banco de dados.";
        }
    } else {
        $erro = "Credenciais inválidas.";
    }
}

require_once('includes/cabecalho.php');
?>

<div class="form-container">
    <h1>Login</h1>

    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="post" action="">
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

<?php include('includes/rodape.php'); ?>

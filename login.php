<!-- portifolio/login.php -->

<!DOCTYPE html>
<?php
include('sistema/config/conexao.php'); 

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: sistema/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if ($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['senha'])) {
                session_regenerate_id(true); // Regenerate session ID
                $_SESSION['user_id'] = $row['id']; 
                $_SESSION['user_email'] = $row['email'];
                header("Location: sistema/index.php");
                exit();
            }
        }
    }
    echo "Credenciais inválidas.";
}
?>

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


<?php include('rodape.php') ?>
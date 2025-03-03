<?php
require_once 'conexao.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim(htmlspecialchars($_POST["name"] ?? ""));
    $email = filter_var(trim($_POST["email"] ?? ""), FILTER_VALIDATE_EMAIL);
    $mensagem = trim(htmlspecialchars($_POST["message"] ?? ""));

    // Verifica se os campos obrigatórios foram preenchidos corretamente
    if (!$nome || !$email || !$mensagem) {
        echo "<script>alert('Por favor, preencha todos os campos corretamente.'); window.history.back();</script>";
        exit;
    }

    // Buscar o e-mail do destinatário no banco de dados
    $result = $conn->query("SELECT email FROM contato WHERE id = 1");

    if (!$result) {
        echo "<script>alert('Erro ao consultar o banco de dados.'); window.history.back();</script>";
        exit;
    }

    $contato = $result->fetch_assoc();
    
    if (!$contato || empty($contato['email'])) {
        echo "<script>alert('Erro ao obter o e-mail do destinatário.'); window.history.back();</script>";
        exit;
    }

    $destinatario = $contato['email']; // E-mail salvo no banco
    $assunto = "E-mail de $nome via portifolio";

    // Construção do cabeçalho do e-mail
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Construção do corpo do e-mail
    $corpoEmail = "Nome: $nome\n";
    $corpoEmail .= "E-mail: $email\n";
    $corpoEmail .= "Mensagem:\n$mensagem\n";

    // Tentativa de envio do e-mail
    if (mail($destinatario, $assunto, $corpoEmail, $headers)) {
        echo "<script>alert('E-mail enviado com sucesso!'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Erro ao enviar o e-mail. Verifique a configuração do servidor.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Acesso inválido.'); window.location.href='../index.php';</script>";
}
?>

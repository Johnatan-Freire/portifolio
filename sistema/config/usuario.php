<?php
include('conexao.php'); 

$senhaCriptografada = password_hash('admin2024', PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('admin', 'admin@gmail.com', ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $senhaCriptografada);

if ($stmt->execute()) {
    echo "Usuário inserido com sucesso!";
} else {
    echo "Erro ao inserir usuário: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

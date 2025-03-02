<?php
include('conexao.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepara e executa a exclusão do projeto
    $stmt = $conn->prepare("DELETE FROM projetos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Projeto excluído com sucesso!</p>";
    } else {
        echo "<p style='color: red;'>Erro ao excluir projeto: " . $conn->error . "</p>";
    }
    
    $stmt->close();
} else {
    echo "<p style='color: red;'>ID do projeto não informado.</p>";
}

// Redireciona para a página inicial (index.php) após a exclusão
header("Location: ../index.php");
exit;
?>

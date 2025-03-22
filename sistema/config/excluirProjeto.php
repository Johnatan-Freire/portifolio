<?php
include('../config/conexao.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);


    // Verifica se o projeto existe
    $stmt = $conn->prepare("SELECT * FROM projetos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Deleta o projeto
        $stmt = $conn->prepare("DELETE FROM projetos WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: ../index.php?msg=excluido");
            exit();
        } else {
            header("Location: ../index.php?msg=erro");
            exit();
        }
    } else {
        header("Location: ../index.php?msg=nao_encontrado");
        exit();
    }
} else {
    header("Location: ../index.php?msg=sem_id_valido");
    exit();
}
?>

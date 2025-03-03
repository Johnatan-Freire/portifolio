<?php
require_once 'sistema/config/conexao.php';

$result = $conn->query("SELECT curriculo FROM contato WHERE id = 1");
$contato = $result->fetch_assoc();

if (!$contato || empty($contato['curriculo'])) {
    die("<p style='text-align:center; color:red;'>❌ Nenhum currículo encontrado.</p>");
}

$file = __DIR__ . '/sistema/' . $contato['curriculo'];

if (!file_exists($file)) {
    die("<p style='text-align:center; color:red;'>❌ Arquivo não encontrado. Caminho verificado: $file</p>");
}

// cabeçalhos para exibir PDF 
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=\"" . basename($file) . "\"");
header("Content-Length: " . filesize($file));
header("Accept-Ranges: bytes");

readfile($file);
exit;
?>

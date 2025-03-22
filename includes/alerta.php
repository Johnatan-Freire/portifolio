<?php
function exibirAlerta($mensagem, $tipo = 'erro') {
    $cor = $tipo === 'sucesso' ? '#ccffcc' : ($tipo === 'aviso' ? '#fff3cd' : '#ffcccc');
    $corTexto = $tipo === 'sucesso' ? '#060' : ($tipo === 'aviso' ? '#856404' : '#900');
    $icone = $tipo === 'sucesso' ? '✅' : ($tipo === 'aviso' ? '⚠️' : '❌');

    echo "<div style='background-color: $cor; padding: 10px; border-radius: 5px; color: $corTexto; margin-bottom: 10px;'>$icone $mensagem</div>";
}

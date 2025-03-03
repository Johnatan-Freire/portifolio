<?php
include('cabecalho.php');

// Criação tabela
$conn->query("CREATE TABLE IF NOT EXISTS projetos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    imagem VARCHAR(255) NULL,
    tecnologias VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    repositorio VARCHAR(255) NOT NULL,
    link_projeto VARCHAR(255) NOT NULL,
    privado TINYINT(1) NOT NULL DEFAULT 0
)");

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$projeto = [];

// Buscar ID no banco
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM projetos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $projeto = $result->fetch_assoc(); 
    } else {
        echo "<div style='background-color: #ffcccc; padding: 10px; border-radius: 5px; color: #900;'>❌ Projeto não encontrado.</div>";
        exit;
    }
    $stmt->close();
}

// Tratamento formulário de envio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $tecnologias = trim($_POST["tecnologias"]);
    $descricao = trim($_POST["descricao"]);
    $repositorio = trim($_POST["repositorio"]);
    $link_projeto = trim($_POST["link_projeto"]);
    $privado = isset($_POST["privado"]) ? 1 : 0; // Define se o repositório é privado ou não

    // Upload imagem do projeto
    $imagem = "";
    if (!empty($_FILES["imagem"]["name"])) {
        $target_dir = "uploads/"; // Diretório das imagens
        $imagem = $target_dir . basename($_FILES["imagem"]["name"]);

        // Move o arquivo para o diretório
        if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem)) {
            echo "<div style='background-color: #ffcccc; padding: 10px; border-radius: 5px; color: #900;'>❌ Erro ao enviar imagem.</div>";
            $imagem = "";
        }
    }

    if ($id && empty($imagem)) {
        $imagem = $projeto["imagem"];
    }

    // Validação dos campos
    if (!empty($nome) && !empty($tecnologias) && !empty($descricao) && !empty($repositorio) && !empty($link_projeto)) {
        if ($id) {
            // Atualizar projeto existente
            $stmt = $conn->prepare("UPDATE projetos SET nome = ?, imagem = ?, tecnologias = ?, descricao = ?, repositorio = ?, link_projeto = ?, privado = ? WHERE id = ?");
            $stmt->bind_param("ssssssii", $nome, $imagem, $tecnologias, $descricao, $repositorio, $link_projeto, $privado, $id);
            if ($stmt->execute()) {
                echo "<div style='background-color: #ccffcc; padding: 10px; border-radius: 5px; color: #060;'>✅ Projeto atualizado com sucesso!</div>";
            } else {
                echo "<div style='background-color: #ffcccc; padding: 10px; border-radius: 5px; color: #900;'>❌ Erro ao atualizar projeto: " . $conn->error . "</div>";
            }
            $stmt->close();
        } else {
            // Inserir novo projeto
            $stmt = $conn->prepare("INSERT INTO projetos (nome, imagem, tecnologias, descricao, repositorio, link_projeto, privado) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $nome, $imagem, $tecnologias, $descricao, $repositorio, $link_projeto, $privado);
            if ($stmt->execute()) {
                echo "<div style='background-color: #ccffcc; padding: 10px; border-radius: 5px; color: #060;'>✅ Projeto cadastrado com sucesso!</div>";
            } else {
                echo "<div style='background-color: #ffcccc; padding: 10px; border-radius: 5px; color: #900;'>❌ Erro ao cadastrar projeto: " . $conn->error . "</div>";
            }
            $stmt->close();
        }
    } else {
        echo "<div style='background-color: #ffcccc; padding: 10px; border-radius: 5px; color: #900;'>⚠️ Todos os campos são obrigatórios!</div>";
    }
}
?>

<!-- Formulário  -->
<div class="form-container">
    <h1><?php echo $id ? "Editar Projeto" : "Adicionar Projeto"; ?></h1>

    <form method="post" action="" enctype="multipart/form-data">
        <!-- Nome -->
        <div class="field">
            <label for="nome">📌 Nome do Projeto</label>
            <input type="text" name="nome" id="nome" placeholder="Digite o nome do projeto" required
                value="<?php echo isset($projeto['nome']) ? htmlspecialchars($projeto['nome']) : ''; ?>" />
        </div>

        <!-- Imagem -->
        <div class="field">
            <label for="imagem">🖼️ Imagem do Projeto</label>
            <?php if (isset($projeto['imagem']) && !empty($projeto['imagem'])): ?>
                <img src="<?php echo $projeto['imagem']; ?>" alt="Imagem do projeto" style="width:100px;"><br>
            <?php endif; ?>
            <input type="file" name="imagem" id="imagem" accept="image/*" <?php echo $id ? '' : 'required'; ?> />
            <?php if ($id): ?>
                <small>📢 Deixe em branco para manter a imagem atual.</small>
            <?php endif; ?>
        </div>

        <!-- Tecnologias -->
        <div class="field">
            <label for="tecnologias">🛠️ Tecnologias</label>
            <input type="text" name="tecnologias" id="tecnologias" placeholder="Ex.: HTML, CSS, JS" required
                value="<?php echo isset($projeto['tecnologias']) ? htmlspecialchars($projeto['tecnologias']) : ''; ?>" />
        </div>

        <!-- Descrição -->
        <div class="field">
            <label for="descricao">📝 Descrição</label>
            <textarea name="descricao" id="descricao" placeholder="Descreva o projeto em detalhes" rows="4" required><?php echo isset($projeto['descricao']) ? htmlspecialchars($projeto['descricao']) : ''; ?></textarea>
        </div>

        <!-- Repositório -->
        <div class="field">
            <label for="repositorio">📂 Repositório</label>
            <input type="url" name="repositorio" id="repositorio" placeholder="Link para o repositório" required
                value="<?php echo isset($projeto['repositorio']) ? htmlspecialchars($projeto['repositorio']) : ''; ?>" />
        </div>

        <!-- Link do projeto -->
        <div class="field">
            <label for="link_projeto">🌍 Link do Projeto</label>
            <input type="url" name="link_projeto" id="link_projeto" placeholder="Link do projeto online" required
                value="<?php echo isset($projeto['link_projeto']) ? htmlspecialchars($projeto['link_projeto']) : ''; ?>" />
        </div>

        <!-- Repositório privado -->
        <div class="field">
            <label for="privado">🔒 Repositório Privado</label>
            <input type="checkbox" name="privado" id="privado" <?php echo (isset($projeto['privado']) && $projeto['privado'] == 1) ? "checked" : ""; ?> />
        </div>

        <!-- Botão de envio -->
        <div class="actions">
            <input type="submit" value="💾 Salvar Projeto" class="btn-primary" />
        </div>
    </form>
</div>

<?php
include('rodape.php');
?>

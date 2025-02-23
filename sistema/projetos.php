<?php
include('cabecalho.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$projeto = [];

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM projetos WHERE id = ?");
    $stmt->bind_param("i", $id); // 'i' indica que o parâmetro é um inteiro
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $projeto = $result->fetch_assoc();
    } else {
        echo "<p style='color: red;'>Projeto não encontrado.</p>";
        exit;
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $tecnologias = trim($_POST["tecnologias"]);
    $descricao = trim($_POST["descricao"]);
    $repositorio = trim($_POST["repositorio"]);
    $link_projeto = trim($_POST["link_projeto"]);
    $privado = isset($_POST["privado"]) ? 1 : 0; 

    // Upload de imagem
    $imagem = "";
    if (!empty($_FILES["imagem"]["name"])) {
        $target_dir = "uploads/"; // Diretório onde as imagens serão armazenadas
        $imagem = $target_dir . basename($_FILES["imagem"]["name"]);

        // Mover arquivo temporário para o diretório de uploads
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem)) {
            echo "<p style='color: green;'>Imagem enviada com sucesso!</p>";
        } else {
            echo "<p style='color: red;'>Erro ao enviar imagem.</p>";
            $imagem = "";
        }
    }

    // Mantém a imagem atual na edição
    if ($id && empty($imagem)) {
        $imagem = $projeto["imagem"];
    }

    // Validar campos 
    if (!empty($nome) && !empty($tecnologias) && !empty($descricao) && !empty($repositorio) && !empty($link_projeto)) {
        // Atualizar registro
        if ($id) {
            $stmt = $conn->prepare("UPDATE projetos SET nome = ?, imagem = ?, tecnologias = ?, descricao = ?, repositorio = ?, link_projeto = ?, privado = ? WHERE id = ?");
            $stmt->bind_param("ssssssii", $nome, $imagem, $tecnologias, $descricao, $repositorio, $link_projeto, $privado, $id);
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Projeto atualizado com sucesso!</p>";
                $projeto["nome"] = $nome;
                $projeto["imagem"] = $imagem;
                $projeto["tecnologias"] = $tecnologias;
                $projeto["descricao"] = $descricao;
                $projeto["repositorio"] = $repositorio;
                $projeto["link_projeto"] = $link_projeto;
                $projeto["privado"] = $privado;
            } else {
                echo "<p style='color: red;'>Erro ao atualizar projeto: " . $conn->error . "</p>";
            }
            $stmt->close();
        } else {
            // Inserir novo registro 
            $stmt = $conn->prepare("INSERT INTO projetos (nome, imagem, tecnologias, descricao, repositorio, link_projeto, privado) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $nome, $imagem, $tecnologias, $descricao, $repositorio, $link_projeto, $privado);
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Projeto cadastrado com sucesso!</p>";
            } else {
                echo "<p style='color: red;'>Erro ao cadastrar projeto: " . $conn->error . "</p>";
            }
            $stmt->close();
        }
    } else {
        // Mensagem de erro campos obrigatórios
        echo "<p style='color: red;'>Todos os campos são obrigatórios!</p>";
    }
}
?>

<div class="form-container">
    <h1><?php echo $id ? "Editar Projeto" : "Adicionar Projeto"; ?></h1>

    <form method="post" action="" enctype="multipart/form-data">
        <!-- Nome do projeto -->
        <div class="field">
            <label for="nome">Nome do Projeto</label>
            <input type="text" name="nome" id="nome" placeholder="Digite o nome do projeto" required
                   value="<?php echo isset($projeto['nome']) ? htmlspecialchars($projeto['nome']) : ''; ?>" />
        </div>
        <!-- Imagem do projeto -->
        <div class="field">
            <label for="imagem">Imagem do Projeto</label>
            <?php 
            // Imagem cadastrada
            if (isset($projeto['imagem']) && !empty($projeto['imagem'])): ?>
                <img src="<?php echo $projeto['imagem']; ?>" alt="Imagem do projeto" style="width:100px;"><br>
            <?php endif; ?>
            <!-- Upload de imagem -->
            <input type="file" name="imagem" id="imagem" accept="image/*" <?php echo $id ? '' : 'required'; ?> />
            <?php if ($id): ?>
                <small>Deixe em branco para manter a imagem atual.</small>
            <?php endif; ?>
        </div>
        <!-- Tecnologias utilizadas no projeto -->
        <div class="field">
            <label for="tecnologias">Tecnologias</label>
            <input type="text" name="tecnologias" id="tecnologias" placeholder="Ex.: HTML, CSS, JS" required
                   value="<?php echo isset($projeto['tecnologias']) ? htmlspecialchars($projeto['tecnologias']) : ''; ?>" />
        </div>
        <!-- Descrição do projeto -->
        <div class="field">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" id="descricao" placeholder="Descreva o projeto em detalhes" rows="4" required><?php echo isset($projeto['descricao']) ? htmlspecialchars($projeto['descricao']) : ''; ?></textarea>
        </div>
        <!-- Link do repositório -->
        <div class="field">
            <label for="repositorio">Repositório</label>
            <input type="url" name="repositorio" id="repositorio" placeholder="Link para o repositório" required
                   value="<?php echo isset($projeto['repositorio']) ? htmlspecialchars($projeto['repositorio']) : ''; ?>" />
        </div>
        <!-- Link do projeto -->
        <div class="field">
            <label for="link_projeto">Link do Projeto</label>
            <input type="url" name="link_projeto" id="link_projeto" placeholder="Link do projeto online" required
                   value="<?php echo isset($projeto['link_projeto']) ? htmlspecialchars($projeto['link_projeto']) : ''; ?>" />
        </div>
        <!-- Indicar se o repositório é privado -->
        <div class="field">
            <label for="privado">Repositório Privado</label>
            <label class="switch">
                <input type="checkbox" name="privado" id="privado" <?php echo (isset($projeto['privado']) && $projeto['privado'] == 1) ? "checked" : ""; ?> />
                <span class="slider"></span>
            </label>
        </div>
        <div class="actions">
            <input type="submit" value="<?php echo $id ? "Atualizar Projeto" : "Salvar Projeto"; ?>" class="btn-primary" />
        </div>
    </form>
</div>

<?php 

include('rodape.php'); 
?>

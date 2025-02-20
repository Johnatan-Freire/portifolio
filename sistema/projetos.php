<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include('cabecalho.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = trim($_POST["nome"]);
        $tecnologias = trim($_POST["tecnologias"]);
        $descricao = trim($_POST["descricao"]);
        $repositorio = trim($_POST["repositorio"]);

        // Configuração para upload de imagem
        $imagem = "";
        if (!empty($_FILES["imagem"]["name"])) {
            $target_dir = "uploads/";
            $imagem = $target_dir . basename($_FILES["imagem"]["name"]);

            // Verifica e move a imagem para o diretório
            if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem)) {
                echo "<p style='color: green;'>Imagem enviada com sucesso!</p>";
            } else {
                echo "<p style='color: red;'>Erro ao enviar imagem.</p>";
                $imagem = "";
            }
        }

        if (!empty($nome) && !empty($tecnologias) && !empty($descricao) && !empty($repositorio)) {
            $stmt = $conn->prepare("INSERT INTO projetos (nome, imagem, tecnologias, descricao, repositorio) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nome, $imagem, $tecnologias, $descricao, $repositorio);

            if ($stmt->execute()) {
                echo "<p style='color: green;'>Projeto cadastrado com sucesso!</p>";
            } else {
                echo "<p style='color: red;'>Erro ao cadastrar projeto: " . $conn->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p style='color: red;'>Todos os campos são obrigatórios!</p>";
        }
    }
    ?>

    <div class="form-container">
        <h1>Adicionar Projeto</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="field">
                <label for="nome">Nome do Projeto</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome do projeto" required />
            </div>
            <div class="field">
                <label for="imagem">Imagem do Projeto</label>
                <input type="file" name="imagem" id="imagem" accept="image/*" required />
            </div>
            <div class="field">
                <label for="tecnologias">Tecnologias</label>
                <input type="text" name="tecnologias" id="tecnologias" placeholder="Ex.: HTML, CSS, JS" required />
            </div>
            <div class="field">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" placeholder="Descreva o projeto em detalhes" rows="4" required></textarea>
            </div>
            <div class="field">
                <label for="repositorio">Repositório</label>
                <input type="url" name="repositorio" id="repositorio" placeholder="Link para o repositório" required />
            </div>
            <div class="actions">
                <input type="submit" value="Salvar Projeto" class="btn-primary" />
            </div>
        </form>
    </div>


    <?php include('rodape.php') ?>

</body>

</html>
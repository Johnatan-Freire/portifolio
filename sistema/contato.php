<?php
require_once('../includes/verificaLogin.php');
require_once('includes/cabecalho.php');
require_once('../includes/alerta.php');

// Criação da tabela
$conn->query("CREATE TABLE IF NOT EXISTS contato (
    id INT PRIMARY KEY CHECK (id = 1),
    email VARCHAR(255) NOT NULL,
    celular VARCHAR(20) NOT NULL,
    linkedin VARCHAR(255) NOT NULL,
    github VARCHAR(255) NOT NULL,
    curriculo VARCHAR(255) NULL
)");

$result = $conn->query("SELECT * FROM contato WHERE id = 1");
$contato = $result->fetch_assoc() ?: [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? '');
    $celular = trim($_POST["celular"] ?? '');
    $linkedin = trim($_POST["linkedin"] ?? '');
    $github = trim($_POST["github"] ?? '');

    // Caminho fixo
    $target_dir = "uploads/";
    $curriculo = $target_dir . "curriculo.pdf"; // salvar como curriculo.pdf

    // Verifica se um arquivo foi enviado
    if (!empty($_FILES["curriculo"]["name"])) {
        $extensao = strtolower(pathinfo($_FILES["curriculo"]["name"], PATHINFO_EXTENSION));

        if ($extensao !== "pdf") {
            exibirAlerta("Apenas arquivos PDF são permitidos.", "erro");
        } else {
            if (file_exists($curriculo)) {
                unlink($curriculo);
            }

            // Salvar currículo como curriculo.pdf
            if (move_uploaded_file($_FILES["curriculo"]["tmp_name"], $curriculo)) {
                echo "<div style='background-color: #ccffcc; padding: 10px; border-radius: 5px; color: #060;'>✅ Currículo enviado com sucesso!</div>";
            } else {
                echo "<div style='background-color: #ffcccc; padding: 10px; border-radius: 5px; color: #900;'>❌ Erro ao enviar currículo.</div>";
                $curriculo = $contato["curriculo"] ?? "";
            }
        }
    } else {
        $curriculo = $contato["curriculo"] ?? "";
    }

    // Validação dos campos
    if (!empty($email) && !empty($celular) && !empty($linkedin) && !empty($github)) {
        if ($contato) {
            // Atualizar dados 
            $stmt = $conn->prepare("UPDATE contato SET email = ?, celular = ?, linkedin = ?, github = ?, curriculo = ? WHERE id = 1");
            $stmt->bind_param("sssss", $email, $celular, $linkedin, $github, $curriculo);
        } else {
            // Inserir dados
            $stmt = $conn->prepare("INSERT INTO contato (id, email, celular, linkedin, github, curriculo) VALUES (1, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $email, $celular, $linkedin, $github, $curriculo);
        }

        if ($stmt->execute()) {
            echo "<div style='background-color: #ccffcc; padding: 10px; border-radius: 5px; color: #060;'>✅ Informações salvas com sucesso!</div>";
        } else {
            echo "<div style='background-color: #ffcccc; padding: 10px; border-radius: 5px; color: #900;'>❌ Erro ao salvar informações: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div style='background-color: #ffcccc; padding: 10px; border-radius: 5px; color: #900;'>⚠️ Todos os campos são obrigatórios!</div>";
    }
}
?>

<!-- Formulário -->
<div class="form-container">
    <h1>Informações de Contato</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <!-- E-mail -->
        <div class="field">
            <label for="email">📧 E-mail</label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required
                value="<?php echo htmlspecialchars($contato['email'] ?? ''); ?>" />
        </div>

        <!-- Celular -->
        <div class="field">
            <label for="celular">📱 Celular</label>
            <input type="tel" name="celular" id="celular" onkeyup="handlePhone(event)" placeholder="Digite seu celular" required
                value="<?php echo htmlspecialchars($contato['celular'] ?? ''); ?>" />
        </div>

        <!-- LinkedIn -->
        <div class="field">
            <label for="linkedin">🔗 LinkedIn</label>
            <input type="url" name="linkedin" id="linkedin" placeholder="URL do LinkedIn" required
                value="<?php echo htmlspecialchars($contato['linkedin'] ?? ''); ?>" />
        </div>

        <!-- GitHub -->
        <div class="field">
            <label for="github">🐙 GitHub</label>
            <input type="url" name="github" id="github" placeholder="URL do GitHub" required
                value="<?php echo htmlspecialchars($contato['github'] ?? ''); ?>" />
        </div>

        <!-- Currículo -->
        <div class="field">
            <label for="curriculo">📄 Currículo (PDF)</label>
            <?php if (!empty($contato['curriculo'])): ?>
                <p><a href="curriculo.php" target="_blank">📂 Ver currículo atual</a></p>
            <?php endif; ?>
            <input type="file" name="curriculo" id="curriculo" accept="application/pdf" />
        </div>

        <!-- Botão de envio -->
        <div class="actions">
            <input type="submit" value="💾 Salvar Informações" class="btn-primary" />
        </div>
    </form>
</div>

<script>
    //Mascara Celular
    const handlePhone = (event) => {
        let input = event.target
        input.value = phoneMask(input.value)
    }

    const phoneMask = (value) => {
        if (!value) return ""
        value = value.replace(/\D/g, '')
        value = value.replace(/(\d{2})(\d)/, "($1) $2")
        value = value.replace(/(\d)(\d{4})$/, "$1-$2")
        return value
    }
</script>

<?php include('includes/rodape.php'); ?>

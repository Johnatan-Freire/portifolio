<?php
include('cabecalho.php');

// Criação de tabela 
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
    
    // Upload do currículo
    $curriculo = $contato["curriculo"] ?? "";
    if (!empty($_FILES["curriculo"]["name"])) {
        $target_dir = "uploads/";
        $extensao = strtolower(pathinfo($_FILES["curriculo"]["name"], PATHINFO_EXTENSION));
        if ($extensao !== "pdf") {
            echo "<p style='color: red;'>Apenas arquivos PDF são permitidos.</p>";
        } else {
            $curriculo = $target_dir . basename($_FILES["curriculo"]["name"]);
            if (move_uploaded_file($_FILES["curriculo"]["tmp_name"], $curriculo)) {
                echo "<p style='color: green;'>Currículo enviado com sucesso!</p>";
            } else {
                echo "<p style='color: red;'>Erro ao enviar currículo.</p>";
                $curriculo = $contato["curriculo"] ?? "";
            }
        }
    }

    if (!empty($email) && !empty($celular) && !empty($linkedin) && !empty($github)) {
        if ($contato) {
            // Atualiza o registro existente
            $stmt = $conn->prepare("UPDATE contato SET email = ?, celular = ?, linkedin = ?, github = ?, curriculo = ? WHERE id = 1");
            $stmt->bind_param("sssss", $email, $celular, $linkedin, $github, $curriculo);
        } else {
            // Insere o registro
            $stmt = $conn->prepare("INSERT INTO contato (id, email, celular, linkedin, github, curriculo) VALUES (1, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $email, $celular, $linkedin, $github, $curriculo);
        }
        
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Informações salvas com sucesso!</p>";
        } else {
            echo "<p style='color: red;'>Erro ao salvar informações: " . $conn->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Todos os campos são obrigatórios!</p>";
    }
}
?>

<div class="form-container">
    <h1>Informações de Contato</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="field">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($contato['email'] ?? ''); ?>" />
        </div>
        <div class="field">
            <label for="celular">Celular</label>
            <input type="text" name="celular" id="celular" required value="<?php echo htmlspecialchars($contato['celular'] ?? ''); ?>" />
        </div>
        <div class="field">
            <label for="linkedin">LinkedIn</label>
            <input type="url" name="linkedin" id="linkedin" required value="<?php echo htmlspecialchars($contato['linkedin'] ?? ''); ?>" />
        </div>
        <div class="field">
            <label for="github">GitHub</label>
            <input type="url" name="github" id="github" required value="<?php echo htmlspecialchars($contato['github'] ?? ''); ?>" />
        </div>
        <div class="field">
            <label for="curriculo">Currículo (PDF)</label>
            <?php if (!empty($contato['curriculo'])): ?>
                <p><a href="<?php echo $contato['curriculo']; ?>" target="_blank">Ver currículo atual</a></p>
            <?php endif; ?>
            <input type="file" name="curriculo" id="curriculo" accept="application/pdf" />
        </div>
        <div class="actions">
            <input type="submit" value="Salvar Informações" class="btn-primary" />
        </div>
    </form>
</div>

<?php include('rodape.php'); ?>

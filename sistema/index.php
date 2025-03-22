<?php
require_once('../includes/verificaLogin.php');
require_once('includes/cabecalho.php');
?>

<div class="content-wrapper">

    <h1>Projetos</h1>

    <div class="projetos">
        <table>
            <thead>
                <tr>
                    <th>Data da Criação</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date("d/m/Y", strtotime($row["data_criacao"])); ?></td>
                            <td>
                                <img src="<?php echo $row["imagem"]; ?>" alt="Imagem do projeto <?php echo $row["nome"]; ?>" style="width: 100px;">
                            </td>
                            <td><?php echo $row["nome"]; ?></td>
                            <td><?php echo $row["descricao"]; ?></td>
                            <td>
                                <div style="display: flex; gap: 10px;">
                                    <a href="projetos.php?id=<?php echo $row["id"]; ?>" class="icon solid alt fa-edit"></a>
                                    <a href="config/excluirProjeto.php?id=<?php echo $row["id"]; ?>" class="icon solid alt fa-trash"></a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum projeto encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div> 

<?php include('includes/rodape.php'); ?>

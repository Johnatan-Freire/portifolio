    <?php
    include('cabecalho.php');

    $query = "SELECT * FROM projetos ORDER BY data_criacao DESC";
    $result = $conn->query($query);
    ?>

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
                                <a href="projetos.php?id=<?php echo $row["id"]; ?>" class="icon solid alt fa-edit"></a>
                                <a href="config/excluirProjeto.php?id=<?php echo $row["id"]; ?>" class="icon solid alt fa-trash"></a>
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

    <?php

    include('rodape.php');

    ?>
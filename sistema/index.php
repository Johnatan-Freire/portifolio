    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    include('cabecalho.php');
    ?>

    <div class="projetos">
        <table>
            <thead>
                <tr>
                    <th>Data de modificação</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>31/08/2024</td>
                    <td><img src="https://via.placeholder.com/50" alt="Imagem 1"></td>
                    <td>Calculadora</td>
                    <td>Software simples de calculadora</td>
                </tr>
                <tr>
                    <td>30/08/2024</td>
                    <td><img src="https://via.placeholder.com/50" alt="Imagem 2"></td>
                    <td>Sistema escolar</td>
                    <td>Gestão escolar</td>
                </tr>
                <tr>
                    <td>29/08/2024</td>
                    <td><img src="https://via.placeholder.com/50" alt="Imagem 3"></td>
                    <td>Pagina web</td>
                    <td>Pagina web com CSS e HTML</td>
                </tr>
            </tbody>
        </table>

    </div>

    <?php

    include('rodape.php');

    ?>
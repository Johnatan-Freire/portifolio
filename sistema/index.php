    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    include('cabecalho.php');
    ?>

    <h1>Projetos visíveis para o público</h1>

    <div class="projetos">
        <table>
            <thead>
                <tr>
                    <th>Data de modificação</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>31/08/2024</td>
                    <td><img src="https://www.petz.com.br/blog/wp-content/uploads/2021/11/enxoval-para-gato-3-Copia.jpg" alt="Imagem 1"></td>
                    <td>Calculadora</td>
                    <td>Software simples de calculadora</td>
                </tr>
                <tr>
                    <td>30/08/2024</td>
                    <td><img src="https://static.nationalgeographicbrasil.com/files/styles/image_3200/public/75552.webp?w=1600&h=900" alt="Imagem 2"></td>
                    <td>Sistema escolar</td>
                    <td>Gestão escolar</td>
                </tr>
                <tr>
                    <td>29/08/2024</td>
                    <td><img src="https://www.organnact.com.br/wp-content/uploads/2022/07/bigstock-Frozen-Old-Sad-White-British-S-449433815-1.jpg" alt="Imagem 3"></td>
                    <td>Pagina web</td>
                    <td>Pagina web com CSS e HTML</td>
                </tr>
                <tr>
                    <td>29/08/2024</td>
                    <td><img src="https://blog.cobasi.com.br/wp-content/uploads/2020/06/cuidar-de-gato-capa.png" alt="Imagem 3"></td>
                    <td>Pagina web</td>
                    <td>Pagina web com CSS e HTML</td>
                </tr>
            </tbody>
        </table>

    </div>

    <?php

    include('rodape.php');

    ?>
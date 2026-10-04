<?php
include 'layouts/config.php';
include 'helpers/functions.php';
session_start();



// Verificar se a sessão é válida
if (!check_session()) {
    header('Location: login.php');
    exit;
}




try {
    // ligação
    $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    // execução da query
    $resultados = $ligacao->query("SELECT s.dataS, s.inicio, s.idSessao, c.nome, c.idCliente
        FROM cliente c
        INNER JOIN sessao s ON c.idCliente = s.idCliente")->fetchAll(PDO::FETCH_OBJ);
    
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
}

// Fechar a ligação
$ligacao = null;

include 'layouts/header.php';
?>

<style>
    body {
        background-color: rgb(0, 0, 0, 90%);
    }

    thead {
        background-color: red;
    }

    .container-fluid {
        position: absolute;
        top: 30%;
        left: 0%;
        right: 10%;
        z-index: 5;
    }

    .title {
        z-index: 4;
        font-size: xx-large;
        margin-left: 20%;
        position: absolute;
        display: inline;
        font-weight: lighter;
        border-bottom: 6px solid var(--prime);
    }

    .table {
        width: 60%;
        white-space: nowrap;
    }

    .table thead tr th {
        color: black;
    }

    .table tbody {
        background-color: rgb(0, 0, 0);
    }

    td a {
        color: whitesmoke;
        font-size: 0.8em;
        text-align: center;
        z-index: 5;
    }

    td a:hover {
        color: red;
    }

    .scbp {
        position: absolute;
        bottom: 8%;
        right: 40%;
        z-index: 5;
        background: red;
        text-decoration: none;
        padding: 5px 20px;
        border-radius: 5px;
        text-transform: capitalize;
        color: black;
        font-size: 1.2em;
    }

    .scbp:hover {
        background: whitesmoke;
        color: red;
    }

    .t_client_list {
        position: absolute;
        top: 20%;
        right: 30%;
        z-index: 5;
        background: red;
        text-decoration: none;
        padding: 5px 20px;
        border-radius: 5px;
        text-transform: capitalize;
        color: whitesmoke;
    }

    .t_client_list:hover {
        background: whitesmoke;
        color: red;
    }
</style>

<body>
    <div class="banner"></div>
    <div class="navigationbar2">
        <a class="logo" href="homepage.php"> <B>D</B>F.</a>
    </div>
    <a href="helpers/logout.php" class="logout">Logout</a>
    <div class="title">Listagem Total de Sessões de Clientes</div>

    <div class="container-fluid">
        <?php if (!empty($erro)) : ?>
            <p class="text-center text-danger"><?= htmlspecialchars($erro) ?></p>
        <?php else : ?>
            <?php if (count($resultados) == 0) : ?>
                <p class="my-5 text-center opacity-75">Não existem clientes registados.</p>
            <?php else : ?>
                <table class="table table-bordered" id="total_clients_list">
                    <thead>
                        <tr>
                            <th scope="col">id Cliente</th>
                            <th scope="col">Nome</th>
                            <th scope="col">id Sessao</th>
                            <th scope="col">Data</th>
                            <th scope="col">Hora</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $sessao) : ?>
                            <tr>
                                <td><?= $sessao->idCliente ?></td>
                                <td><?= $sessao->nome ?></td>
                                <td><?= $sessao->idSessao ?></td>
                                <td><?= $sessao->dataS ?></td>
                                <td><?= $sessao->inicio ?></td>
                                
                        
                                <td><a href="client_details.php?idCliente=<?= aes_encrypt($sessao->idCliente)?>">detalhes</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col">
                        <p class="mb-5">Total: <strong> <?= count($resultados) ?> </strong></p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#total_clients_list').DataTable({
                            pageLength: 5,
                            pagingType: "full_numbers",
                            language: {
                                decimal: "",
                                emptyTable: "Sem dados disponíveis na tabela.",
                                info: "Mostrando _START_ até _END_ de _TOTAL_ registos",
                                infoEmpty: "Mostrando 0 até 0 de 0 registos",
                                infoFiltered: "(Filtrando _MAX_ total de registos)",
                                lengthMenu: "Mostrando _MENU_ registos por página.",
                                loadingRecords: "Carregando...",
                                processing: "Processando...",
                                search: "Filtrar:",
                                zeroRecords: "Nenhum registro encontrado.",
                                paginate: {
                                    first: "Primeira",
                                    last: "Última",
                                    next: "Seguinte",
                                    previous: "Anterior"
                                },
                                aria: {
                                    sortAscending: ": ative para classificar a coluna em ordem crescente.",
                                    sortDescending: ": ative para classificar a coluna em ordem decrescente."
                                }
                            }
                        });
                    });
                </script>
</body>
<footer>
    <a href="clients_table_al.php" class="anterior">Anterior</a>
</footer>

</html>
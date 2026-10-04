<?php
include 'layouts/config.php';
include 'helpers/functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["text_username"];
    $password = $_POST["text_password"];

    if (empty($username) || empty($password)) {
        $_SESSION['server_error'] = 'Preencha todos os campos';
        header('Location: login.php');
        exit();
    }
    

    $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // execução da query do login
    $resultados = $ligacao->prepare("SELECT * FROM fisiologista WHERE AES_DECRYPT(utilizador, '" . MYSQL_AES_KEY . "') = :utilizador 
                                                                        AND AES_DECRYPT(passwrd, '" . MYSQL_AES_KEY . "') = :passwrd");
    $resultados->bindParam(':utilizador', $username);
    $resultados->bindParam(':passwrd', $password);
    $resultados->execute();
    $res = $resultados->fetchAll(PDO::FETCH_OBJ);

    if (count($res) == 0) {
        $result['status'] = 0;
    } else {
        $result['status'] = 1;
    }
    if (!$result['status']) {
        // login invalido
        $_SESSION['server_error'] = 'Login inválido';
        header('Location: login.php');
        return;
    }
    $_SESSION['user'] = $username;
} else {
    // Verificar se a sessão é válida
    if (!check_session()) {
        header('Location: login.php');
        exit;
    }
}



try {
    // ligação
    $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    // execução da query dos dados da tabela
    $resultados = $ligacao->query("SELECT s.dataS, s.inicio, s.fim, c.nome, c.idCliente
        FROM cliente c
        INNER JOIN sessao s ON c.idCliente = s.idCliente
        WHERE (s.dataS > CURDATE()) OR (s.dataS = CURDATE() and s.inicio > CURTIME())
        ORDER BY s.dataS ASC, s.inicio ASC;")->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
}

// fechar a ligação
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
    <div class="title">Listagem de Clientes [Período pós-login]</div>
    <a href="total_clients_list.php" class="t_client_list">Listagem Total De Clientes</a>
    <div class="container-fluid ">
        <hr>
        <?php if (!empty($erro)) : ?>
            <p class="text-center text-danger"><?= $erro ?></p>
        <?php else : ?>
            <?php if (count($resultados) == 0) : ?>
                <p class="my-5 text-center opacity-75">Não existem clientes registados.</p>
            <?php else : ?>
                <table class="table table-bordered " id="clients_table_al">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Nome</th>
                            <th scope="col">id Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $sessao) : ?>
                            <tr>
                                <td><?= $sessao->dataS ?></td>
                                <td><?= substr($sessao->inicio, 0, 5) ?> - <?= substr($sessao->fim, 0, 5) ?></td>
                                <td><?= $sessao->nome ?></td>
                                <td><?= $sessao->idCliente ?></td>
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
                        $('#clients_table_al').DataTable({
                            pageLength: 5,
                            pagingType: "full_numbers",
                            language: {
                                decimal: "",
                                emptyTable: "Sem dados disponíveis na tabela.",
                                info: "Mostrando _START_ até _END_ de _TOTAL_ registos",
                                infoEmpty: "Mostrando 0 até 0 de 0 registos",
                                infoFiltered: "(Filtrando _MAX_ total de registos)",
                                infoPostFix: "",
                                thousands: ",",
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
    <a href="client_selection.php" class="scbp">Selecionar clientes por período</a>
</footer>

</html>
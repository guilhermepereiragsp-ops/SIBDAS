<?php
session_start();
include 'layouts/config.php';
include 'helpers/functions.php';

// Verificar se a sessão é válida
if (!check_session()) {
    header('Location: login.php');
    exit;
}

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dataS = $_POST['dataS'];
    $inicio = $_POST['inicio'];
    // Guardar selected_clients na sessão
    $_SESSION['selected_clients'] = [
        isset($_POST['client1']) ? $_POST['client1'] : null,
        isset($_POST['client2']) ? $_POST['client2'] : null,
    ];
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $dataS = $_GET['dataS'];
    $inicio = $_GET['inicio'];
    $dataS = aes_decrypt($dataS);
    $inicio = aes_decrypt($inicio);
    // Recuperar selected_clients da sessão
    $selected_clients = isset($_SESSION['selected_clients']) ? $_SESSION['selected_clients'] : [];
} else {
    header('Location: login.php');
    exit;
}

// Recuperar os IDs dos clientes selecionados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_clients = [];
    if (isset($_POST['client1']) && !empty($_POST['client1'])) {
        $selected_clients[] = $_POST['client1'];
    }
    if (isset($_POST['client2']) && !empty($_POST['client2']) && $_POST['client2'] != 0) {
        $selected_clients[] = $_POST['client2'];
    }
}

$clientes = [];
if (!empty($selected_clients)) {
    try {
        // Ligação
        $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
        $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Execução da query
        $placeholders = str_repeat('?,', count($selected_clients) - 1) . '?';
        $resultados = $ligacao->prepare("SELECT s.dataS, s.inicio, s.fim, s.idSessao, c.idCliente, c.nome
                                         FROM cliente c
                                         INNER JOIN Sessao s ON c.idCliente = s.idCliente
                                         WHERE c.idCliente IN ($placeholders) AND s.dataS = ? AND s.inicio = ?");
        $resultados->execute(array_merge($selected_clients, [$dataS, $inicio]));
        $clientes = $resultados->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $err) {
        $erro = "Aconteceu um erro na ligação.";
    }
} else {
    $erro = "Nenhum cliente selecionado.";
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
        margin-left: 10%;
        top: 30%;
        left: 10%;
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
        text-align: center;
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
</style>

<body>
    <div class="banner"></div>
    <div class="navigationbar2">
        <a class="logo" href="homepage.php"> <b>D</b>F.</a>
    </div>
    <a href="helpers/logout.php" class="logout">Logout</a>
    <div class="title">Listagem da Seleção de Clientes por Período</div>
    <div class="container-fluid ">

        <?php if (empty($clientes)) : ?>
            <p class="my-5 text-center opacity-75">Não existem clientes selecionados.</p>
        <?php else : ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Período</th>
                        <th scope="col">idSessao</th>
                        <th scope="col">idCliente</th>
                        <th scope="col">Nome</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Agrupar os clientes pelo período de sessão
                    $selection = [];
                    foreach ($clientes as $cliente) {
                        $sessao = $cliente['dataS'] . ' ' . $cliente['inicio'] . ' - ' . $cliente['fim'];
                        if (!isset($selection[$sessao])) {
                            $selection[$sessao] = [];
                        }
                        $selection[$sessao][] = $cliente;
                    }

                    foreach ($selection as $sessao => $clientes) : ?>
                        <?php
                        $dataS = explode(' ', $sessao)[0];
                        $periodo = explode(' ', $sessao)[1];
                        $rowspan = count($clientes);
                        ?>
                        <?php foreach ($clientes as $index => $cliente) : ?>
                            <tr>
                                <?php if ($index == 0) : ?>
                                    <td rowspan="<?= $rowspan ?>"><?= $dataS ?></td>
                                    <td rowspan="<?= $rowspan ?>"><?= $periodo ?></td>
                                <?php endif; ?>
                                <td><?= $cliente['idSessao'] ?></td>
                                <td><?= $cliente['idCliente'] ?></td>
                                <td><?= $cliente['nome'] ?></td>
                                <td><a href="bs_evaluation.php?idSessao=<?= urlencode(aes_encrypt($cliente['idSessao'])) ?>&idCliente=<?= urlencode(aes_encrypt($cliente['idCliente'])) ?>&dataS=<?= urlencode(aes_encrypt($dataS)) ?>&inicio=<?= urlencode(aes_encrypt($inicio)) ?>">Iniciar Monitorização</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
<footer>
    <a href="client_selection.php" class="anterior">Anterior</a>
</footer>

</html>
<?php
include 'layouts/config.php';
include 'helpers/functions.php';
session_start();

if (!check_session()) {
    header('Location: login.php');
    exit;
}

// get form data
$user = $_SESSION['user'];
$idCliente = $_GET['idCliente'];
$idCliente = aes_decrypt($idCliente);

if (!$idCliente) {
    // id_client is invalid
    header('Location: login.php');
    exit;
}

try {
    // ligação
    $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    
    // Consulta para obter sessões do cliente
    $resultados1 = $ligacao->prepare("SELECT s.idSessao, s.dataS, s.inicio, s.fim
                                FROM sessao s
                                WHERE s.idCliente = :idCliente
                                AND (s.dataS > CURDATE() OR (s.dataS = CURDATE() AND s.inicio >= CURTIME()))
                                ORDER BY s.dataS ASC, s.inicio ASC");
                                
    $resultados1->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
    $resultados1->execute();
    $resultados = $resultados1->fetchAll(PDO::FETCH_OBJ);

    // Consulta para obter informações do cliente
    $resultados2 = $ligacao->prepare("SELECT c.nome, c.idCliente
                                FROM cliente c 
                                WHERE c.idCliente = :idCliente");
    $resultados2->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
    $resultados2->execute();
    $res = $resultados2->fetch(PDO::FETCH_OBJ);
    
    if (!$res) {
        throw new Exception("Cliente não encontrado.");
    }
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação: " . $err->getMessage();
} catch (Exception $err) {
    $erro = $err->getMessage();
}

// Fecha a conexão
$ligacao = null;

include 'layouts/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sessões do Cliente</title>
    <style>
        thead {
            background-color: red;
        }
        .container-fluid {
            position: relative;
            margin: 0 auto;
            margin-top: 10%;
            width: 50%;
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
        .subtitle {
            font-size: 1.5em;
        }
        .table {
            width: 100%;
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
    </style>
</head>
<body>
    <div class="banner"></div>
    <div class="navigationbar2">
        <a class="logo" href="homepage.php"> <B>D</B>F.</a>
    </div>
    <a href="helpers/logout.php" class="logout">Logout</a>
    <div class="title">Cliente <?= $res->idCliente ?> - <?= $res->nome ?></div>
    <div class="container-fluid ">
        <div class="subtitle">Próximas Sessões</div>
        <?php if (isset($erro)): ?>
            <p class="text-center text-danger"><?= $erro ?></p>
        <?php elseif (empty($resultados)): ?>
            <p class="text-center text-danger">Não há próximas sessões para este cliente.</p>
        <?php else: ?>
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Hora</th>
                        <th scope="col">id Sessão</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($resultados as $sessao) : ?>
                    <tr>
                        
                        <td><?= $sessao->dataS ?></td>
                        <td><?= substr($sessao->inicio, 0, 5) ?> - <?= substr($sessao->fim, 0, 5) ?></td>
                        <td><?= $sessao->idSessao ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
<footer>
    
    <a href="client_details.php?idCliente=<?= urlencode(aes_encrypt($idCliente)) ?>" class="anterior">Anterior</a>
    <a href="total_clients_list.php" class="seguinte">Seguinte</a>
</footer>
</html>

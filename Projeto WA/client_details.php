<?php
include 'layouts/config.php';
include 'helpers/functions.php';
session_start();

// get form data
$user = $_SESSION['user'];

$idClient = $_GET['idCliente'];
$idCliente = aes_decrypt($idClient);

if (!$idCliente) {
    // id_client is invalid
    header('Location: login.php');
}


try {
    // ligação
    $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    // execução da query
    $resultados = $ligacao->query("SELECT c.nome, c.idCliente
        FROM cliente c 
        where c.idCliente=$idCliente;")->fetch(PDO::FETCH_OBJ);
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
}
include 'layouts/header.php';
?>

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

        .unlink,
        .unlink:hover {
            color: black;
            text-decoration: none;
        }

        .home-option {
            background-color: red;
            width: 300px;
            border-radius: 10px;
        }

        .home-option:hover {
            background-color: lightcoral;
        }
    </style>


<body>
    <div class="banner"></div>
    <div class="navigationbar2">
        <a class="logo" href="homepage.php"> <B>D</B>F.</a>
    </div>
    <a href="helpers/logout.php" class="logout"> Logout</a>
    
    <div class="title">Cliente <?= $resultados->idCliente ?>-<?= $resultados->nome ?></div>
    
    <!-- CONTEUDO  -->
    <div class="container-fluid ">
        <div class="row ">
            <div class="d-flex flex-row flex-wrap justify-content-center">
                <!-- proximas sessoes -->
                <a href="client_sessions.php?idCliente=<?= aes_encrypt($resultados->idCliente)?>" class="unlink m-3">
                    <div class="home-option p-5 text-center">
                        <h3 class="mb-3"><i class="fa-solid fa-list-ul fa-lg"></i></h3>
                        <h5>Próximas Sessões</h5>
                    </div>
                </a>
                <!-- evolucao -->
                <a href="evolution.php?idCliente=<?= aes_encrypt($resultados->idCliente)?>" class="unlink m-3">
                    <div class="home-option p-5 text-center">
                        <h3 class="mb-3"><i class="fa-solid fa-arrow-up-right-dots fa-lg"></i></h3>
                        <h5>Evolução de Parâmetros</h5>
                    </div>
                </a>

               

                

                

            </div>

        </div>
    </div>
</body>
<footer>
    <a href="total_clients_list.php" class="anterior">Anterior</a>
    
</footer>

</html>
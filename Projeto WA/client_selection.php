<?php
session_start();

include 'layouts/config.php';
include 'helpers/functions.php';

if (!check_session()) {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: login.php');
        exit;
    }
}

$clientes = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inicio = $_POST['inicio'];
    $dataS = $_POST['dataS'];
    // Validar data e hora
    $time = strtotime($inicio);
    $minutes = date('i', $time);
    $validation_errors = [];
    if ($dataS < date('Y-m-d') || ($dataS == date('Y-m-d') && $inicio < date('H:i'))) {
        $validation_errors[] = "Erro: Data ou Horário Indisponível! Por favor, selecione uma data/hora igual ou superior à atual.";
    }
    // validar hora
    if ($inicio < "07:00" || $inicio > "21:30" || ($minutes != "00" && $minutes != "30")) {
        $validation_errors[] = "Erro: Horário Indisponível! Por favor, selecione um horário entre 07:00 e 21:30, com minutos sendo 00 ou 30.";
    }

    if (empty($validation_errors)) {
        try {
            // Ligação
            $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Execução da query
            $resultados = $ligacao->prepare("SELECT c.idCliente, c.nome 
                                       FROM cliente c
                                       INNER JOIN sessao s ON c.idCliente = s.idCliente
                                       WHERE s.dataS = :dataS AND s.inicio = :inicio");
            $resultados->bindParam(':dataS', $dataS);
            $resultados->bindParam(':inicio', $inicio);
            $resultados->execute();
            $clientes = $resultados->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $erro = "Aconteceu um erro na ligação.";
        }
        // Verifica se a seleção foi feita
        if (isset($_POST['clientes_selecionados']) && !empty($_POST['clientes_selecionados'])) {
            // Armazena os IDs selecionados na sessão
            $_SESSION['selected_clients'] = $_POST['clientes_selecionados'];
        } else {
            // Se nenhuma seleção foi feita, limpar a sessão
            $_SESSION['selected_clients'] = [];
        }
    }
}

// Fechar a ligação
$ligacao = null;

include 'layouts/header.php';
?>

<style>
    body {
        background-color: rgb(0, 0, 0, 90%);
    }

    .mb-3 input {
        color: black;
    }

    .form-select option {
        color: black;
    }
</style>



</head>

<body>
    <div class="banner"></div>
    <div class="navigationbar2">
        <a class="logo" href="homepage.php"> <b>D</b>F.</a>
    </div>
    <a href="helpers/logout.php" class="logout">Logout</a>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-8 col-10">
                <div class="card p-4 bg-dark">
                    <div class="d-flex align-items-center justify-content-center my-4">
                        <h2><strong><b>SELEÇÃO</b> DE CLIENTES</strong></h2>
                    </div>
                    <div class="row">
                        <div class="col"></div>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label>Selecione uma data:</label>
                                <input type="date" id="dataS" name="dataS" value="<?php echo isset($_POST['dataS']) ? htmlspecialchars($_POST['dataS']) : ''; ?>" required>
                                <label for="hr">Selecione um horário:</label>
                                <input type="time" id="inicio" name="inicio" value="<?php echo isset($_POST['inicio']) ? htmlspecialchars($_POST['inicio']) : ''; ?>" required>
                                <button type="submit" class="btn btn-danger px-1">Confirmar</button>
                            </div>
                            <!-- Erros -->
                            <?php if (!empty($validation_errors)) : ?>
                                <div class="alert alert-danger p-2 text-center" style="background-color: red;">
                                    <?php foreach ($validation_errors as $error) : ?>
                                        <div><?= $error ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </form>
                        <?php if (!empty($clientes)) : ?>
                            <form action="client_selection_list.php" method="POST">
                                <div class="mb-3">
                                    <label for="" class="form-label">Selecione um cliente disponível:</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Cliente 1</span>
                                        <select class="form-select" id="client1"  name="client1">
                                            <?php foreach ($clientes as $cliente) : ?>
                                                <option value="<?= $cliente['idCliente'] ?>"><?= $cliente['nome'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <?php if (count($clientes) > 1) : ?>
                                        <label for="" class="form-label">Selecione um cliente disponível:</label>
                                        <div class="input-group mb-3 ">
                                            <span class="input-group-text" id="basic-addon2">Cliente 2</span>
                                            <select class="form-select" id="client2"  name="client2">
                                                <option value="0" selected>--</option>
                                                <?php foreach ($clientes as $cliente) : ?>
                                                    <option value="<?= $cliente['idCliente'] ?>" selected><?= $cliente['nome'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <input type="hidden" name="dataS" value="<?php echo htmlspecialchars($dataS); ?>">
                                <input type="hidden" name="inicio" value="<?php echo htmlspecialchars($inicio); ?>">
                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-danger px-4">Terminar Seleção</button>
                                </div>
                            </form>
                        <?php else : ?>
                            <b>Nenhum Cliente Encontrado.</b>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <a href="clients_table_al.php" class="anterior">Anterior</a>
</footer>

</html>


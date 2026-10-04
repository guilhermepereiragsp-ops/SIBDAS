<?php
include 'layouts/config.php';
include 'helpers/functions.php';
session_start();

// Data
$user = $_SESSION['user'];

$idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : null;
$idSessao = isset($_GET['idSessao']) ? $_GET['idSessao'] : null;
$dataS = isset($_GET['dataS']) ? $_GET['dataS'] : null;
$inicio = isset($_GET['inicio']) ? $_GET['inicio'] : null;

if (!$idCliente || !$idSessao) {
    // ID Cliente ou ID Sessao nao encontrados
    header('Location: login.php');
    exit;
}
$idCliente = aes_decrypt($idCliente);
$idSessao = aes_decrypt($idSessao);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pss = $_POST['pss'];
    $psi = $_POST['psi'];
    $novoPlano = $_POST['novoPlano'];

    //validaçoes
    $validation_errors = [];
    // PSS
    if (empty($pss)) {
        $validation_errors[] = "PSS é de preenchimento obrigatório.";
    } else {
        if ($pss < 1 || $pss > 5) {
            $validation_errors[] = "PSS deve ter um valor entre 1 e 5.";
        }
    }
    // PSI
    if (empty($psi)) {
        $validation_errors[] = "PSI é de preenchimento obrigatório.";
    } else {
        if ($psi < 1 || $psi > 5) {
            $validation_errors[] = "PSI deve ter um valor entre 1 e 5.";
        }
    }
    //NovoPLano
    if (empty($novoPlano)) {
        $validation_errors[] = "É obrigatório definir a necessidade de novo plano.";
    }

    if (empty($validation_errors)) {
        try {
            // Ligação Base de Dados
            $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);

            // Atualizar Base de Dados
            $atualiza = $ligacao->prepare("UPDATE avaliacaodt d
                                       JOIN sessao s ON s.idSessao = d.idSessao
                                       SET d.pss = :pss, d.psi = :psi, s.novoPlano = :novoPlano
                                       WHERE s.idSessao = :idSessao AND s.idCliente = :idCliente");
            $atualiza->execute([
                'pss' => $pss,
                'psi' => $psi,
                'novoPlano' => $novoPlano,
                'idSessao' => $idSessao,
                'idCliente' => $idCliente
            ]);

            // Redirecionar
            header('Location: clients_table_al.php?idCliente=' . urlencode(aes_encrypt($idCliente)) . '&idSessao=' . urlencode(aes_encrypt($idSessao)));
            exit;
        } catch (PDOException $err) {
            $erro = "Aconteceu um erro na ligação: " . $err->getMessage();
        }
    }
} else {
    try {
        // Ligação Base de Dados
        $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);

        // Mostrar dados da sessao
        $resultados = $ligacao->prepare("SELECT d.pss, d.psi, s.novoPlano
                                         FROM avaliacaodt d
                                         JOIN sessao s ON s.idSessao = d.idSessao
                                         
                                         WHERE s.idSessao = :idSessao ");
        $resultados->execute(['idSessao' => $idSessao]);
        $res = $resultados->fetch(PDO::FETCH_OBJ);
        //echo($res->novoPlano);


        if (!$res) {
            throw new Exception("Sessão não encontrada.");
        }
    } catch (PDOException $err) {
        $erro = "Aconteceu um erro na ligação: " . $err->getMessage();
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }

    // Fechar Ligação
    $ligacao = null;
}

include 'layouts/header.php';
?>
<style>
    .mb-3 input {
        color: black;
    }

    .container-fluid {
        text-align: center;
    }

    
</style>




<body>
    <div class="banner"></div>
    <div class="navigationbar2">
        <a class="logo" href="homepage.php"> <B>D</B>F.</a>
    </div>
    <a href="helpers/logout.php" class="logout">Logout</a>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-8 col-10">
                <!-- BORDA À VOLTA DO FORMULÁRIO-->
                <div class="card p-4 bg-dark">
                    <div class="d-flex align-items-center justify-content-center my-4">
                        <!--TEXTO-->
                        <h2><strong><b>AVALIAÇÃO</b> DEPOIS DO TREINO</strong></h2>
                    </div>
                    <div class="row">
                        <div class="col"></div>
                        <!--  FORMULÁRIO-->
                        <form method="POST">

                            <div class="mb-3">
                                <!--seleçao das condicoes fisicas-->
                                <label for="" class="form-label">Condições Físicas antes do treino:</label>

                                <div class="input-group mb-3 justify-content-center">
                                    <span class="input-group-text" id="basic-addon1">PSS</span>
                                    <input type="number" pattern="[1-5]" name="pss" value="<?= isset($pss) ? htmlspecialchars($pss) : (isset($res->pss) ? htmlspecialchars($res->pss) : '') ?>" required class="me-3">

                                    <span class="input-group-text" id="basic-addon2">PSI</span>
                                    <input type="number" name="psi" value="<?= isset($psi) ? htmlspecialchars($psi) : (isset($res->psi) ? htmlspecialchars($res->psi) : '') ?>" required>
                                </div>
                                <!-- Comentário abaixo de PSI -->
                                <div class="form-text mx-5">PSS: Percepção Subjetiva de Satisfação</div>

                                <div class="form-text">PSI: Percepção Subjetiva de Intensidade</div>

                            </div>
                            <label for="" class="form-label">Necessidade de Novo Plano de Treino:</label>

                            <div class="d-flex justify-content-center mb-3">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="novoPlano" id="flexRadioDefault1" value="S" <?= isset($res->novoPlano) && $res->novoPlano === 'S' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="novoPlano" id="flexRadioDefault2" value="N" <?= isset($res->novoPlano) && $res->novoPlano === 'N' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Não
                                    </label>
                                </div>
                            </div>
                            <!-- Erros -->
                            <?php if (!empty($validation_errors)) : ?>
                                <div class="alert p-2 text-center" style="background-color: red;">
                                    <?php foreach ($validation_errors as $error) : ?>
                                        <div><?= $error ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($server_error)) : ?>
                                <div class="alert p-2 text-center" style="background-color: red;">
                                    <div><?= $server_error ?></div>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3 mt-5 text-center">
                                <!-- SUBMIT-->
                                <a href="monitorization.php?idCliente=<?= urlencode(aes_encrypt($idCliente)) ?>&idSessao=<?= urlencode(aes_encrypt($idSessao)) ?>&dataS=<?= $dataS ?>&inicio=<?= $inicio ?>" " class="anterior">Anterior</a>
                                <button type="submit" class="seguinte">Seguinte</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
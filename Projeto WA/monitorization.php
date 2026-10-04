<?php
include 'layouts/config.php';
include 'helpers/functions.php';
session_start();

// Get form data
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

    //validaçoes
    $validation_errors = [];
    
    foreach ($_POST['idExercicio'] as $index => $idExercicio) {
        $nseries = $_POST['nseries'][$index];
        $dur = $_POST['duracao'][$index];
        $cad1 = $_POST['cadencia1'][$index];
        $cad2 = $_POST['cadencia2'][$index];
        $carg = $_POST['carga'][$index];
        $rep = $_POST['repouso'][$index];
        $material = $_POST['pegas_material'][$index];
        $pSe = $_POST['pse'][$index];
        $eS = $_POST['es'][$index];
        $obS = $_POST['obs'][$index];

        // Nº Series
        if (empty($nseries)) {
            $validation_errors[] = "O Nº de séries é de preenchimento obrigatório.";
        } else {
            if ($nseries < 1) {
                $validation_errors[] = "O Nº de séries deve ser maior que zero.";
            }
        }
        // Duraçao
        if (empty($dur)) {
            $validation_errors[] = "A Duração é de preenchimento obrigatório.";
        } else {
            if ($dur < 1) {
                $validation_errors[] = "A Duração deve ser maior que zero.";
            }
        }
        // Cadencia
        if (empty($cad1) || empty($cad2)) {
            $validation_errors[] = "A Cadência é de preenchimento obrigatório.";
        } else {
            if (($cad1 < 1 || $cad1 > 10) || ($cad2 < 1 || $cad2 > 10)) {
                $validation_errors[] = "A Cadência deve ter os campos preenchidos com valores entre 1 e 10.";
            }
        }
        // Carga
        if (empty($carg)) {
            $validation_errors[] = "A Carga é de preenchimento obrigatório.";
        } else {
            if ($carg < 0) {
                $validation_errors[] = "A Carga deve não pode ser negativa.";
            }
        }
        // Repouso
        if (empty($rep)) {
            $validation_errors[] = "O Repouso é de preenchimento obrigatório.";
        } else {
            if ($rep < 1) {
                $validation_errors[] = "O Repouso não pode ser negativo.";
            }
        }
        // PSE
        if (empty($pSe)) {
            $validation_errors[] = "O PSE é de preenchimento obrigatório.";
        } else {
            if ($pSe < 1 || $pSe > 10) {
                $validation_errors[] = "O PSE deve ser entre 1 e 10.";
            }
        }
        // ES
        if ($eS === null || $eS === '') {
            $validation_errors[] = "O ES é de preenchimento obrigatório.";
        } else {
            if ($eS < -5 || $eS > 5) {
                $validation_errors[] = "O ES deve ser entre -5 e +5.";
            }
        }
        
    }

    if (empty($validation_errors)) {
        try {
            // Ligação
            $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Preparar a consulta de atualização
            $stmt = $ligacao->prepare("UPDATE monitorizacao SET 
            numSeries = :numSeries, 
            duracao = :duracao, 
            cadencia = :cadencia, 
            carga = :carga, 
            repouso = :repouso, 
            pega_material = :pega_material, 
            pse = :pse, 
            es = :es, 
            obs = :obs 
            WHERE idSessao = :idSessao AND idExercicio = :idExercicio");

            // Iterar sobre os dados do formulário e executar a atualização
            foreach ($_POST['idExercicio'] as $index => $idExercicio) {
                $numSeries = $_POST['nseries'][$index];
                $duracao = $_POST['duracao'][$index];
                $cadencia = $_POST['cadencia1'][$index] . ':' . $_POST['cadencia2'][$index];
                $carga = $_POST['carga'][$index];
                $repouso = $_POST['repouso'][$index];
                $pega_material = $_POST['pegas_material'][$index];
                $pse = $_POST['pse'][$index];
                $es = $_POST['es'][$index];
                $obs = $_POST['obs'][$index];

                // Executar a consulta de atualização
                $stmt->execute([
                    ':numSeries' => $numSeries,
                    ':duracao' => $duracao,
                    ':cadencia' => $cadencia,
                    ':carga' => $carga,
                    ':repouso' => $repouso,
                    ':pega_material' => $pega_material,
                    ':pse' => $pse,
                    ':es' => $es,
                    ':obs' => $obs,
                    ':idSessao' => $idSessao,
                    ':idExercicio' => $idExercicio
                ]);
            }

            // Redirecionar após a atualização
            header('Location: as_evaluation.php?idCliente=' . urlencode(aes_encrypt($idCliente)) . '&idSessao=' . urlencode(aes_encrypt($idSessao)) . '&idSessao=' . urlencode(aes_encrypt($idSessao)) . '&dataS=' . $dataS . '&inicio=' . $inicio);
            exit;
        } catch (PDOException $err) {
            $erro = "Aconteceu um erro na ligação: " . $err->getMessage();
        }
    }
}
try {
    // Ligação
    $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    // Execução da prepare
    $resultados = $ligacao->query("SELECT e.maquina, e.nome, s.idSessao, m.idExercicio, m.numSeries, m.duracao, m.cadencia, m.carga, m.repouso, m.pega_material, m.pse, m.es, m.obs  
                                        FROM monitorizacao m
                                        INNER JOIN sessao s ON s.idSessao=m.idSessao
                                        INNER JOIN exercicio e ON e.idExercicio=m.idExercicio
                                        INNER JOIN cliente c ON c.idCliente=s.idCliente
                                        WHERE m.idSessao = $idSessao")->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
}

// Fechar a ligação
$ligacao = null;

include 'layouts/header.php';
?>

<style>
    thead {
        background-color: red;
    }

    .container-fluid {
        position: relative;
        margin: 0 auto;
        margin-top: 5%;
        width: 90%;
        z-index: 5;
    }

    .title {
        z-index: 5;
        font-size: xx-large;
        margin-left: 20%;
        position: absolute;
        display: inline;
        font-weight: lighter;
        border-bottom: 6px solid var(--prime);
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
    }

    td a:hover {
        color: red;
    }

    .input-group.mb-3 input.form-control {
        width: 50px;
    }
</style>

<body>
    <div class="banner"></div>
    <div class="navigationbar2">
        <a class="logo" href="homepage.php"> <B>D</B>F.</a>
    </div>
    <a href="helpers/logout.php" class="logout">Logout</a>
    <div class="title">Monitorização</div>

    <div class="container-fluid">
        <?php if (!empty($erro)) : ?>
            <p class="text-center text-danger"><?= $erro ?></p>
        <?php elseif (!empty($success)) : ?>
            <p class="text-center text-success"><?= $success ?></p>
        <?php else : ?>
            <?php if (count($resultados) == 0) : ?>
                <p class="my-5 text-center opacity-75">Não existem resultados para esta sessão.</p>
            <?php else : ?>
                <form method="POST" action="" id="moni">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Máquina</th>
                                <th scope="col">Exercício</th>
                                <th scope="col">Nº Séries</th>
                                <th scope="col">Duração</th>
                                <th scope="col">Cadência</th>
                                <th scope="col">Carga</th>
                                <th scope="col">Repouso</th>
                                <th scope="col">Pegas/Material</th>
                                <th scope="col">PSE(1-10)*</th>
                                <th scope="col">ES(-5/+5)**</th>
                                <th scope="col">OBS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $index => $dados) : ?>
                                <tr>
                                    <td><?= $dados->maquina ?></td>
                                    <td><?= $dados->nome ?></td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" value="<?= isset($numSeries) ? htmlspecialchars($numSeries) : (isset($dados->numSeries) ? htmlspecialchars($dados->numSeries) : '') ?>" name="nseries[<?= $index ?>]" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" value="<?= isset($duracao) ? htmlspecialchars($duracao) : (isset($dados->duracao) ? htmlspecialchars($dados->duracao) : '') ?>" name="duracao[<?= $index ?>]" required>
                                            <span class="input-group-text" id="basic-addon1">s</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <?php
                                            $cadencia = explode(':', $dados->cadencia);
                                            ?>
                                            <input type="number" class="form-control" value="<?= isset($cadencia[0]) ? htmlspecialchars($cadencia[0]) : (isset($dados->cadencia[0]) ? htmlspecialchars($dados->cadencia[0]) : '') ?>" name="cadencia1[<?= $index ?>]" required>
                                            <span class="input-group-text" id="basic-addon1">:</span>
                                            <input type="number" class="form-control" value="<?= isset($cadencia[1]) ? htmlspecialchars($cadencia[1]) : (isset($dados->cadencia[1]) ? htmlspecialchars($dados->cadencia[1]) : '') ?>" name="cadencia2[<?= $index ?>]" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control"  step="0.5" value="<?= isset($carga) ? htmlspecialchars($carga) : (isset($dados->carga) ? htmlspecialchars($dados->carga) : '') ?>" name="carga[<?= $index ?>]" required>
                                            <span class="input-group-text" id="basic-addon1">kg</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" value="<?= isset($repouso) ? htmlspecialchars($repouso) : (isset($dados->repouso) ? htmlspecialchars($dados->repouso) : '') ?>" name="repouso[<?= $index ?>]" required>
                                            <span class="input-group-text" id="basic-addon1">s</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($dados->pega_material) ?>" name="pegas_material[<?= $index ?>]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" value="<?= isset($pse) ? htmlspecialchars($pse) : (isset($dados->pse) ? htmlspecialchars($dados->pse) : '') ?>" name="pse[<?= $index ?>]" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" value="<?= isset($es) ? htmlspecialchars($es) : (isset($dados->es) ? htmlspecialchars($dados->es) : '') ?>" name="es[<?= $index ?>]" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <textarea class="form-control" name="obs[<?= $index ?>]"><?= htmlspecialchars($dados->obs) ?></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <input type="hidden" name="idExercicio[<?= $index ?>]" value="<?= htmlspecialchars($dados->idExercicio) ?>">
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="form-text">*PSE: Perceção Subjetiva de Esforço</div>
                    <div class="form-text">**ES: Esforço Percetivo</div>
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

                    <input type="hidden" name="idSessao" value="<?= htmlspecialchars($idSessao) ?>">
                    <input type="hidden" name="idCliente" value="<?= htmlspecialchars($idCliente) ?>">

                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
<footer>
    <a href="bs_evaluation.php?idCliente=<?= urlencode(aes_encrypt($idCliente)) ?>&idSessao=<?= urlencode(aes_encrypt($idSessao)) ?>&dataS=<?= $dataS ?>&inicio=<?= $inicio ?>" class="anterior">Anterior</a>
    <button type="submit" class="seguinte" form="moni">Seguinte</button>
</footer>

</html>
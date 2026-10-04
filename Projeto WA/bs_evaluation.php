<?php
include 'layouts/config.php';
include 'helpers/functions.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];

$idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : null;
$idSessao = isset($_GET['idSessao']) ? $_GET['idSessao'] : null;
$dataS = isset($_GET['dataS']) ? $_GET['dataS'] : null;
$inicio = isset($_GET['inicio']) ? $_GET['inicio'] : null;

if (!$idCliente || !$idSessao) {
    // ID Cliente ou ID Sessao não encontrados
    header('Location: login.php');
    exit;
}

$idCliente = aes_decrypt($idCliente);
$idSessao = aes_decrypt($idSessao);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //declaraçao de variaveis
    $sono = $_POST['sono'];
    $fadiga = $_POST['fadiga'];
    $alimentacao = $_POST['alimentacao'];

    //validaçoes
    $validation_errors = [];
    // Sono
    if (empty($sono)) {
        $validation_errors[] = "Sono é de preenchimento obrigatório.";
    } else {
        if ($sono < 1 || $sono > 3) {
            $validation_errors[] = "O Sono deve ter um valor entre 1 e 3.";
        }
    }
    // Fadiga
    if (empty($fadiga)) {
        $validation_errors[] = "Fadiga é de preenchimento obrigatório.";
    } else {
        if ($fadiga < 1 || $fadiga > 3) {
            $validation_errors[] = "A Fadiga deve ter um valor entre 1 e 3.";
        }
    }
    // Alimentacao
    if (empty($alimentacao)) {
        $validation_errors[] = "Alimentação é de preenchimento obrigatório.";
    } else {
        if ($alimentacao < 1 || $alimentacao > 3) {
            $validation_errors[] = "A Alimentação deve ter um valor entre 1 e 3.";
        }
    }
    

    if (empty($validation_errors)) {
        try {
            // Conectar ao banco de dados
            $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);

            // Atualizar dados
            $atualiza = $ligacao->prepare("UPDATE avaliacaoat a
                                       INNER JOIN sessao s ON s.idSessao = a.idSessao
                                       SET a.sono = :sono, a.fadiga = :fadiga, a.alimentacao = :alimentacao
                                       WHERE s.idSessao = :idSessao AND s.idCliente = :idCliente");
            $atualiza->execute([
                'sono' => $sono,
                'fadiga' => $fadiga,
                'alimentacao' => $alimentacao,
                'idSessao' => $idSessao,
                'idCliente' => $idCliente
            ]);

            // Redirecionar após a atualização
            header('Location: monitorization.php?idCliente=' . urlencode(aes_encrypt($idCliente)) . '&idSessao=' . urlencode(aes_encrypt($idSessao)).'&dataS='. $dataS .'&inicio='.$inicio);
            exit;
        } catch (PDOException $err) {
            $erro = "Aconteceu um erro na ligação: " . $err->getMessage();
        }
    }
} else {
    try {
        // Conectar ao banco de dados
        $ligacao = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);

        // Buscar dados da sessão
        $resultados = $ligacao->prepare("SELECT a.sono, a.fadiga, a.alimentacao
                                         FROM avaliacaoat a
                                         JOIN sessao s ON s.idSessao = a.idSessao
                                         JOIN cliente c ON c.idCliente = s.idCliente
                                         WHERE s.idSessao = :idSessao AND c.idCliente = :idCliente");
        $resultados->execute(['idSessao' => $idSessao, 'idCliente' => $idCliente]);
        $res = $resultados->fetch(PDO::FETCH_OBJ);

        if (!$res) {
            throw new Exception("Sessão não encontrada.");
        }
    } catch (PDOException $err) {
        $erro = "Aconteceu um erro na ligação: " . $err->getMessage();
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }

    // Fechar a ligação
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
        <a class="logo" href="homepage.php"><b>D</b>F.</a>
    </div>
    <a href="helpers/logout.php" class="logout">Logout</a>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-8 col-10">
                <!-- Form border -->
                <div class="card p-4 bg-dark">
                    <div class="d-flex align-items-center justify-content-center my-4">
                        <h2><strong><b>AVALIAÇÃO</b> ANTES DO TREINO</strong></h2>
                    </div>
                    <div class="row">
                        <div class="col"></div>
                        <!-- Form -->
                        <form method="POST">
                            <div class="mb-3">
                                <label for="" class="form-label">Condições Físicas antes do treino:</label>

                                <div class="input-group mb-3 justify-content-center">
                                    <span class="input-group-text" id="basic-addon1">Sono</span>
                                    <input type="number" name="sono" value="<?= isset($sono) ? htmlspecialchars($sono) : (isset($res->sono) ? htmlspecialchars($res->sono) : '') ?>" required>
                                </div>
                                <div class="input-group mb-3 justify-content-center">
                                    <span class="input-group-text" id="basic-addon2">Fadiga</span>
                                    <input type="number" name="fadiga" value="<?= isset($fadiga) ? htmlspecialchars($fadiga) : (isset($res->fadiga) ? htmlspecialchars($res->fadiga) : '') ?>" required>
                                </div>
                                <div class="input-group mb-3 justify-content-center">
                                    <span class="input-group-text" id="basic-addon3">Alimentação</span>
                                    <input type="number" name="alimentacao"  value="<?= isset($alimentacao) ? htmlspecialchars($alimentacao) : (isset($res->alimentacao) ? htmlspecialchars($res->alimentacao) : '') ?>" required>
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
                            </div>
                            <div class="mb-3 mt-5 text-center">
                                <button type="submit" class="seguinte">Seguinte</button>
                            </div>
                        </form>
                        <div class="mb-3 mt-5 text-center">
                            <a href="client_selection_list.php?dataS=<?= $dataS ?>&inicio=<?= $inicio ?>" class="anterior">Anterior</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
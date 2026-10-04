<?php
include 'layouts/config.php';
include 'helpers/functions.php';
session_start();

if (!check_session() && $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: login.php');
    exit;
}
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

    // Consulta para obter informações do cliente
    $resultados1 = $ligacao->prepare("SELECT c.nome, c.idCliente 
                                        FROM cliente c 
                                        WHERE c.idCliente = :idCliente");
    $resultados1->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
    $resultados1->execute();
    $rescliente = $resultados1->fetch(PDO::FETCH_OBJ);

    if (!$rescliente) {
        throw new Exception("Cliente não encontrado.");
    }

    // Consulta para obter avaliacaoat do cliente
    $resultados2 = $ligacao->prepare("SELECT a.sono, a.fadiga, a.alimentacao, s.dataS
                                        FROM avaliacaoat a 
                                        INNER JOIN sessao s ON s.idSessao = a.idSessao 
                                        INNER JOIN cliente c ON c.idCliente = s.idCliente
                                        WHERE c.idCliente = :idCliente");
    $resultados2->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
    $resultados2->execute();
    $at = $resultados2->fetchAll(PDO::FETCH_OBJ);
    // Convertendo os resultados para JSON
    $atJson = json_encode($at);

    // Consulta para obter avaliacaodt do cliente
    $resultados3 = $ligacao->prepare("SELECT a.psi, a.pss, s.dataS
                                        FROM avaliacaodt a
                                        JOIN sessao s ON a.idSessao = s.idSessao
                                        JOIN cliente c ON s.idCliente = c.idCliente
                                        WHERE c.idCliente = :idCliente");
    $resultados3->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
    $resultados3->execute();
    $dt = $resultados3->fetchAll(PDO::FETCH_OBJ);
    // Convertendo os resultados para JSON
    $dtJson = json_encode($dt);
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação: " . $err->getMessage();
} catch (Exception $err) {
    $erro = $err->getMessage();
}


// Fecha a conexão
$ligacao = null;


include 'layouts/header.php';
?>

<style>
    body {
        background-color: rgb(0, 0, 0, 90%);
    }

    h2 {
        text-align: center;
        color: whitesmoke;
    }

    .graph {
        position: relative;
        width: 30%;
        margin-left: 20%;
        margin-right: 20%;
        margin-top: 5%;
        margin-bottom: 5%;
    }

    .title {
        z-index: 5;
        font-size: xx-large;
        margin-left: 20%;
        margin-top: 20%;
        position: absolute;
        display: inline;
        font-weight: lighter;
        border-bottom: 6px solid var(--prime);
    }

    .card {
        margin-top: 10%;
        margin-bottom: 10%;
    }

    footer {
        position: fixed;
        bottom: 10%;
        width: 100%;

        color: white;
        text-align: right;
        padding: 10px;
    }
</style>

<body>
    <div class="navigationbar1">
        <a class="logo" href="homepage.php"> <B>D</B>F.</a>
    </div>
    <a href="helpers/logout.php" class="logout">Logout</a>
    <div class="title">Evolução de Parâmetros</div>

    <!--Gráfico de Barras-->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-6 col-sm-8 col-10">
                <!-- BORDA À VOLTA DO FORMULÁRIO-->
                <div class="card p-4 bg-dark ">
                    <div class="d-flex align-items-center justify-content-center my-4">
                        <!--TEXTO-->

                        <h2><strong><b>DEEP</b>FITNESS</strong></h2>
                        <h3>Cliente:<?= $rescliente->nome ?></h3>
                    </div>
                    <div class="row">
                        <h2>Gráfico da Evolução das Condições de Avaliação Antes do Treino ao Longo das Sessões</h2>
                        <canvas class="graph" id="meuGraficoBarras" width="800" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Barras(javascript)-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dados obtidos do PHP
        var dadosAt = <?php echo $atJson; ?>;

        // Preparando os dados para o gráfico
        var labels = [];
        var sonoData = [];
        var fadigaData = [];
        var alimentacaoData = [];


        for (var i = 0; i < dadosAt.length; i++) {
            // Formatando a data da sessão para exibição no rótulo
            var dataSessao = new Date(dadosAt[i].dataS);
            var dataFormatada = dataSessao.toLocaleDateString('pt-PT'); // Formato dd/mm/yyyy

            labels.push('Sessão ' + (i + 1) + ' - ' + dataFormatada);
            sonoData.push(dadosAt[i].sono);
            fadigaData.push(dadosAt[i].fadiga);
            alimentacaoData.push(dadosAt[i].alimentacao);
        }

        var ctx = document.getElementById('meuGraficoBarras').getContext('2d');
        var meuGraficoBarras = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: labels, // Rótulos do eixo X
                datasets: [{
                        label: 'Sono',
                        data: sonoData, // Dados do eixo Y
                        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Cor de fundo das barras
                        borderColor: 'rgba(255, 99, 132, 1)', // Cor da borda das barras
                        borderWidth: 1 // Largura da borda
                    },
                    {
                        label: 'Fadiga',
                        data: fadigaData, // Dados do eixo Y 
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Cor de fundo das barras
                        borderColor: 'rgba(54, 162, 235, 1)', // Cor da borda das barras
                        borderWidth: 1 // Largura da borda
                    },
                    {
                        label: 'Alimentação',
                        data: alimentacaoData, // Dados do eixo Y 
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Cor de fundo das barras
                        borderColor: 'rgba(75, 192, 192, 1)', // Cor da borda das barras
                        borderWidth: 1 // Largura da borda
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Começa o eixo Y no zero
                    }
                }
            }
        });
    </script>



    <!--Gráfico de Linhas-->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-6 col-sm-8 col-10">
                <!-- BORDA À VOLTA DO FORMULÁRIO-->
                <div class="card p-4 bg-dark ">
                    <div class="d-flex align-items-center justify-content-center my-4">
                        <!--TEXTO-->
                        <h2><strong><b>DEEP</b>FITNESS</strong></h2>
                    </div>
                    <div class="row">
                        <h2>Gráfico da Evolução das Condições de Avaliação Depois do Treino ao Longo das Sessões </h2>
                        <canvas id="meuGrafico" width="800" height="300" class="graph"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Gráfico de Linhas (javascript)-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dados obtidos do PHP
        const dadosDt = <?php echo $dtJson; ?>;

        // Preparando os dados para o gráfico de linhas
        var labels = [];
        var pssData = [];
        var psiData = [];

        // Iterando sobre os dados obtidos
        for (var i = 0; i < dadosDt.length; i++) {
            var dataSessao = new Date(dadosDt[i].dataS);
            var dataFormatada = dataSessao.toLocaleDateString('pt-PT'); // Formato dd/mm/yyyy

            labels.push('Sessão ' + (i + 1) + ' - ' + dataFormatada);
            pssData.push(dadosDt[i].pss);
            psiData.push(dadosDt[i].psi);
        }

        // Configuração do gráfico de linhas
        var ctxLinhas = document.getElementById('meuGrafico').getContext('2d');
        var meuGraficoLinhas = new Chart(ctxLinhas, {
            type: 'line', // Tipo de gráfico
            data: {
                labels: labels, // Rótulos do eixo X
                datasets: [{
                        label: 'PSS',
                        data: pssData, // Dados do eixo Y para PSS
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Cor de fundo
                        borderColor: 'rgba(75, 192, 192, 1)', // Cor da borda
                        borderWidth: 1 // Largura da borda
                    },
                    {
                        label: 'PSI',
                        data: psiData, // Dados do eixo Y para PSI
                        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Cor de fundo
                        borderColor: 'rgba(255, 99, 132, 1)', // Cor da borda
                        borderWidth: 1 // Largura da borda
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Começa o eixo Y no zero
                    }
                }
            }
        });
    </script>



</body>
<footer>
    <a href="client_details.php?idCliente=<?= urlencode(aes_encrypt($idCliente)) ?>" class="anterior">Anterior</a>
    <a href="total_clients_list.php" class="seguinte">Seguinte</a>
</footer>

</html>
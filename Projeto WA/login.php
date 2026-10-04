<?php
include 'layouts/config.php';
include 'helpers/functions.php';
session_start();

include 'layouts/header.php';
?>

<style>
    body {
        background-color: rgb(0, 0, 0, 90%);
    }

    .homepage {
        position: absolute;
        top: 8%;
        right: 10%;
        z-index: 5;
        background: red;
        text-decoration: none;
        padding: 5px 20px;
        border-radius: 5px;
        text-decoration: none;
        color: whitesmoke;
    }

    .homepage:hover {
        background: whitesmoke;
        color: red;
    }

    .card {
        margin-top: 5%;
        z-index: 6;
    }

    b {
        color: red;
    }

    .btn {
        background-color: red;
        text-transform: uppercase;
    }

    .btn a {
        text-decoration: none;
        color: whitesmoke;
    }
</style>

<body>
    <div class="banner"></div>
    <div class="navigationbar2">
        <a class="logo" href="homepage.php"> <B>D</B>F.</a>
    </div>


    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-8 col-10">
                <!-- BORDA À VOLTA DO FORMULÁRIO-->
                <div class="card p-4 bg-dark ">
                    <div class="d-flex align-items-center justify-content-center my-4">
                        <!--TEXTO-->

                        <h2><strong><b>DEEP</b>FITNESS</strong></h2>
                    </div>
                    <div class="row">
                        <div class="col"></div>
                        <!--  FORMULÁRIO-->
                        <form action="clients_table_al.php" method="POST">
                            <div class="mb-3">
                                <!-- UTILIZADOR-->
                                <label for="" class="form-label">Utilizador:</label>
                                <input type="email" class="form-control" id="utilizador" name="text_username">
                            </div>
                            <div class="mb-3">
                                <!--PASSWORD-->
                                <label for="" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="text_password">
                            </div>
                            <!-- Módulo-->
                            <fieldset class="row mb-3">
                                <legend class="col-form-label col-sm-3 pt-0">Módulo:</legend>
                                <div class="col-sm-10">
                                    <div class="form-check disabled">
                                        <input class="form-check-input" type="radio" name="module" id="module1" value="option1" disabled>
                                        <label class="form-check-label" for="module1">
                                            1.RECECIONISTA
                                        </label>
                                    </div>
                                    <div class="form-check disabled">
                                        <input class="form-check-input" type="radio" name="module" id="module2" value="option2" disabled>
                                        <label class="form-check-label" for="module2">
                                            2.FISIOLOGISTA–AVALIAÇÃO
                                        </label>
                                    </div>
                                    <div class="form-check disabled">
                                        <input class="form-check-input" type="radio" name="module" id="module3" value="option3" disabled>
                                        <label class="form-check-label" for="module3">
                                            3.FISIOLOGISTA–REGISTO PLANO DE TREINO
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="module" id="module4" value="option4" checked>
                                        <label class="form-check-label" for="module4">
                                            4.FISIOLOGISTA-ACOMPANHAMENTO
                                        </label>
                                    </div>
                                    <div class="form-check disabled">
                                        <input class="form-check-input" type="radio" name="module" id="module5" value="option5" disabled>
                                        <label class="form-check-label" for="module5">
                                            5.MATERIAL-EQUIPAMENTOS
                                        </label>
                                    </div>
                                    <div class="form-check disabled">
                                        <input class="form-check-input" type="radio" name="module" id="module6" value="option6" disabled>
                                        <label class="form-check-label" for="module6">
                                            6.ADMINISTRADOR
                                        </label>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="mb-5 text-center">
                                <!-- SUBMIT-->
                                <button type="submit" class="btn btn-danger px-4">Entrar</button>
                            </div>
                            <!-- erros -->
                            <?php if (isset($_SESSION['server_error'])) : ?>
                                <div class="alert p-2 mt-4 text-center" style="background-color: red;">
                                    <div><?= htmlspecialchars($_SESSION['server_error']) ?></div>
                                </div>
                                <?php unset($_SESSION['server_error']); ?>
                            <?php endif; ?>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
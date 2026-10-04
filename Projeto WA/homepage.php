<?php
include 'layouts/header.php';
?>


<style>
    /*------------Início-------------*/
    body {
            background-color: rgb(0, 0, 0, 90%);
        }
    /*------------capa(titulos)-------------*/
    .home {
        display: flex;
        min-height: 120vh;
        align-items: center;
        justify-content: center;
    }

    .highlights {
        width: 70%;
        position: relative;
        display: inline-block;
        z-index: 11;
    }

    .highlights h3 {
        display: inline;
        font-size: 2vw;
        padding: 5px 20px;
        font-weight: lighter;
        text-transform: capitalize;
        border-left: 6px solid var(--prime);
    }

    .highlights h1 {
        font-size: 9vw;
        text-align: center;
        font-weight: normal;
    }

    .highlights b {
        color: var(--prime);
        font-weight: 800;
        font-family: sans-serif;
    }

    .highlights .tagline {
        color: #d7d7d7;
        font-size: 1.2vw;
        text-align: center;
        font-weight: normal;
    }

    .highlights .join {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-weight: 800;
        padding: 5px 20px;
        font-size: 1.5vw;
        margin-top: 1.2em;
        color: var(--prime);
        border: 2px solid var(--prime);
        border-radius: 50px;
        background: transparent;
        text-transform: uppercase;
        transition: 0.3s ease;

    }

    .highlights .join a {
        color: var(--prime);
        text-decoration: none;
    }

    .highlights .join a:hover {
        color: white;
        text-decoration: none;
    }

    .highlights .join:hover {
        color: white;
        cursor: pointer;
        letter-spacing: 1.5px;
        background: var(--prime);
    }

    /*------------todas as secçoes-------------*/
    .main {
        width: 100%;
        text-align: center;
        padding-bottom: 20px;
    }

    .main h2 {
        font-size: 2.5vw;
        position: relative;
        text-align: center;
        padding-top: 100px;
        display: inline-block;
    }

    span {
        color: var(--prime);
    }

    .main h2::before {
        position: absolute;
        background: var(--prime);
        height: 3px;
        width: 30%;
        right: -15px;
        bottom: 0;
        border-radius: 50px;
    }

    .content {
        position: relative;
        display: flex;
        width: 100%;
        padding: 0 30px;
        justify-content: center;
    }

    /*-------------acerca------------*/
    .about .content .cols {
        position: relative;
        width: 100%;
        height: 100%;
        padding: 20px 70px;
    }

    .about .content .cols p b {
        font-size: 20px;
        margin-right: 2px;
    }

    .about .content .cols a {
        position: relative;
        top: 20px;
        color: black;
        background: var(--prime);
        padding: 5px 20px;
        border-radius: 5px;
        text-decoration: none;
        text-transform: capitalize;
    }

    .about .content .cols a:hover {
        color: var(--prime);
        background: white;
    }

    .about .content .cols .box {
        position: relative;
        height: 550px;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.5);
    }

    .about .content .cols .box img {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .cols p {
        padding: 1em;
    }

    /*---------------- treino-------------*/
    .subtitle {
        font-size: xx-large;
    }

    .workout .content .cols {
        position: relative;
        width: 100%;
        height: 100%;
        padding: 20px 70px;
        text-align: center;
        font-size: large;
    }


    .workout .content .cols .box img {
        position: relative;
        top: 0;
        left: 0;
        height: 10%;
        width: 10%;
        object-fit: cover;
    }

    /*----------localizacao/contactos----------*/
    .container .col p {
        font-size: large;
    }

    .container .col .tl {
        padding: 20px;
        font-size: 1.5em;
    }

    .container .col p a:hover {
        color: red;
    }
    .navigationbar li a{
        color: whitesmoke;
    }
    
</style>


<body>
    <!-- barra de navegacao-->
    <div class="navigationbar">
        <a class="logo" href="homepage.php"> <B>D</B>F.</a>
        <ol>
            <li><a href="#home">Início</a></li>
            <li><a href="#about">Acerca</a></li>
            <li><a href="#workout">Treino</a></li>
            <li><a href="#contact">Localização</a></li>
            <li><a href="#contact">Contactos</a></li>
        </ol>
    </div>
    <!-- inicio-->
    <section id="home" class="home view">
        <div class="highlights">
            <h3>Inspire-se, Transforme-se</h3>
            <h1><b>DEEP</b>FITNESS</h1><br>
            <p class="tagline">
                Transformando Vidas Através do Fitness!
            </p>
            <button class="join"><a href="login.php">Login</a></button>
        </div>
        <div class="banner"></div>
    </section>
    <!-- acerca section-->
    <section id="about" class="about view">
        <!-- titulo-->
        <div class="main">
            <h2><span>A</span>cerca de Nós</h2>
        </div>
        <!-- texto-->
        <div class="content">
            <div class="cols">
                <p><b>B</b>em-vindo ao Ginásio DeeFitness! A nossa missão é promover saúde, bem-estar e qualidade de
                    vida para todos os nossos membros. Com uma infraestrutura moderna e um ambiente acolhedor,
                    proporcionamos um espaço ideal para que você alcance seus objetivos de fitness e se sinta motivado a
                    cada dia.</p>
                <p>Oferecemos uma ampla gama de equipamentos de última geração, projetados para atender todas as suas
                    necessidades de treino, seja você um iniciante ou um entusiasta experiente. Os nossos programas de
                    treino são variados, incluindo musculação, cardio, aulas de grupo como yoga, pilates, entre outras,
                    todas cuidadosamente planeadas para maximizar os seus resultados.</p>
                <p>Além disso, estamos comprometidos com a criação de um ambiente inclusivo, onde cada pessoa se sinta
                    valorizada e parte de uma comunidade. Acreditamos que o exercício físico é um pilar fundamental para
                    uma vida saudável e feliz, e estamos aqui para apoiar cada passo da sua jornada.</p>
                <p>No Ginásio DeepFitness, priorizamos a sua segurança e conforto. As nossas instalações são mantidas
                    com os mais altos padrões de higiene e segurança, garantindo que você possa concentrar-se apenas nos
                    seus treinos.</p>
                <p>Junte-se a nós no Ginásio DeepFitness e descubra como podemos ajudá-lo a transformar a sua vida
                    através do fitness. Estamos aqui para inspirar, motivar e celebrar as suas conquistas. Venha fazer
                    parte desta comunidade dedicada ao bem-estar e à saúde!</p>
                <a href="#">Mais</a>
            </div>
            <!------- imagem----------->
            <div class="cols">
                <div class="box">
                    <img src="assets/images/about.jpg" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- treino section-->
    <section id="workout" class="workout view">
        <!-- titulo-->
        <div class="main">
            <h2><span>T</span>reino</h2>
        </div>
        <!-- texto-->
        <div class="content">

            <div class="cols">
                <p class="subtitle">Descrição do Treino</p>
                <p><b>O</b> nosso programa de treino é projetado para atender a todos os níveis de condicionamento
                    físico, desde iniciantes até atletas avançados.
                </p>
                <p>Oferecemos uma variedade de exercícios que combinam
                    treinamento cardiovascular, força e flexibilidade, utilizando equipamentos modernos e técnicas
                    comprovadas.</p>
                <p>Cada sessão é guiada pelos nossos treinadores experientes, que personalizam os treinos
                    para maximizar os resultados e garantir a segurança.</p>
                <p>Esteja você buscando perder peso, ganhar massa
                    muscular ou simplesmente melhorar sua saúde geral, nosso treino no ginásio é a escolha ideal para
                    alcançar seus objetivos de forma eficiente e divertida.</p>
                <!-- imagem-->
                <div class="box">
                    <img src="assets/images/workout.jpg" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- localizacao/contactos section-->
    <section id="contact" class="contact view">
        <div class="main">
            <!-- titulo-->
            <h2><span>L</span>ocalização / <span>C</span>ontactos</h2>
            <!-- texto-->
            <div class="container">
                <div class="col">
                    Estamos aqui para ajudar você a atingir seus objetivos de condicionamento físico! Entre em contato
                    conosco através dos canais abaixo:
                    <p class="tl">Endereço:</p>
                    <p>Rua da Saúde, 123</p>
                    <p>Bairro Fitness</p>
                    <p>Cidade Exemplar, CEP 00000-000</p>

                    <p class="tl">Telefone:</p>
                    <p>(11) 1234-5678f</p>

                    <p class="tl">Redes Sociais:</p>
                    <p>Siga-nos nas redes sociais para ficar por dentro das novidades, dicas de treino e promoções
                        especiais!</p>
                    <p>Facebook: <a href="#">facebook.com/deepfitness</a></p>
                    <p>Instagram: <a href="#">instagram.com/deepfitness</a></p>
                    <p>Twitter: <a href="">twitter.com/deepfitness</a></p>

                </div>

            </div>

        </div>
    </section>
</body>

</html>
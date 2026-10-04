	-- Criação da Tabela Cliente
CREATE TABLE cliente (
	 idCliente NUMERIC PRIMARY KEY UNIQUE NOT NULL,
    nome VARCHAR(50) NOT NULL
);

	-- Criação da Tabela Exercicio
CREATE TABLE exercicio (
	 idExercicio NUMERIC PRIMARY KEY UNIQUE NOT NULL,
	 nome VARCHAR(50) NOT NULL,
	 maquina VARCHAR(50) NOT NULL	 
);	

	-- Criação da Tabela Fisiologista
CREATE TABLE fisiologista (
    idFisio NUMERIC PRIMARY KEY NOT NULL,
    nome VARCHAR(50) NOT NULL,
	 utilizador VARCHAR(50) NOT NULL,
	 passwrd VARCHAR(30) NOT null
);

 	-- Criação da Tabela Sessão
CREATE TABLE Sessao (
    idSessao NUMERIC(9) PRIMARY KEY UNIQUE NOT NULL,
    idCliente NUMERIC NOT NULL,
    idFisio NUMERIC NOT NULL,
    dataS DATE NOT NULL,
    inicio TIME NOT NULL CHECK (inicio BETWEEN '07:00' AND '21:30' AND MINUTE(inicio) IN (0, 30)),
    fim TIME NOT NULL CHECK (fim BETWEEN '07:30' AND '22:00' AND MINUTE(fim) IN (0, 30)),
    novoPlano CHAR(1) CHECK (novoPlano IN ('S', 'N')),
	  
	FOREIGN KEY (idCliente) REFERENCES cliente(idCliente),
	FOREIGN KEY (idFisio) REFERENCES fisiologista(idFisio)
);

	-- Criação da Tabela monitorização
CREATE TABLE monitorizacao (
    
    idExercicio NUMERIC,
    idSessao NUMERIC(9),
    numSeries INT NOT NULL,
	 duracao VARCHAR(4) NOT NULL, 
	 cadencia VARCHAR(5) NOT NULL,
	 carga VARCHAR(6) NOT NULL,
	 repouso VARCHAR(4) NOT NULL,
	 pega_material VARCHAR(50),
	 pse NUMERIC NOT NULL CHECK (pse BETWEEN 1 AND 10),
	 es NUMERIC NOT NULL	CHECK (es >= -5 AND es <= 5),
	 obs VARCHAR(200),
    
    FOREIGN KEY (idExercicio) REFERENCES exercicio(idExercicio),
    FOREIGN KEY (idsessao) REFERENCES Sessao(idSessao)
);
																
  
 	-- Criação da Tabela AvaliaçãoAntesTreino
CREATE TABLE AvaliacaoAT (
    idSessao NUMERIC(9) PRIMARY KEY UNIQUE NOT NULL,
    sono NUMERIC NOT NULL CHECK (sono IN(1,2,3)),
    alimentacao NUMERIC NOT NULL CHECK (alimentacao IN(1,2,3)),
    fadiga NUMERIC NOT NULL CHECK (fadiga IN(1,2,3)),
    
    FOREIGN KEY (idSessao) REFERENCES Sessao(idSessao)	 
);
  
                                                  
	-- Criação da Tabela AvaliaçãoDepoisTreino
CREATE TABLE AvaliacaoDT (
    idSessao NUMERIC(9) PRIMARY KEY UNIQUE NOT NULL,
    pss NUMERIC NOT NULL CHECK (pss IN(1,2,3,4,5)),
    psi NUMERIC NOT NULL CHECK (psi IN(1,2,3,4,5)),
    
	 FOREIGN KEY (idSessao) REFERENCES Sessao(idSessao)	 
);
                                                       






-- Inserts Tabela Cliente
insert into cliente (idCliente, nome) values (1, 'Bobbe Saice');
insert into cliente (idCliente, nome) values (2, 'Marcelia Hindsberg');
insert into cliente (idCliente, nome) values (3, 'Eugene Overbury');
insert into cliente (idCliente, nome) values (4, 'Marthe Sparey');
insert into cliente (idCliente, nome) values (5, 'Vanda Berkowitz');
insert into cliente (idCliente, nome) values (6, 'Griswold Edison');
insert into cliente (idCliente, nome) values (7, 'Janie Banat');
insert into cliente (idCliente, nome) values (8, 'Jo-ann Avrahm');
insert into cliente (idCliente, nome) values (9, 'Corene Tryhorn');
insert into cliente (idCliente, nome) VALUES (10, 'Doroteya Bridgement');
insert into cliente (idCliente, nome) VALUES (11, 'Meredithe Ledgard');
insert into cliente (idCliente, nome) VALUES (12, 'Angelico Secrett');
insert into cliente (idCliente, nome) VALUES (13, 'Buffy Durram');
insert into cliente (idCliente, nome) VALUES (14, 'Michel Salazar');
insert into cliente (idCliente, nome) VALUES (15, 'Lynn Stothard');
insert into cliente (idCliente, nome) VALUES (16, 'Stesha Mixture');
insert into cliente (idCliente, nome) VALUES (17, 'Lebbie Jovey');
insert into cliente (idCliente, nome) VALUES (18, 'Marylee Sephton');
insert into cliente (idCliente, nome) VALUES (19, 'Ellis Showalter');
insert into cliente (idCliente, nome) VALUES (20, 'Basile Kubasiewicz');

-- Inserts Tabela Exercicio
insert into exercicio (idExercicio, nome, maquina) values (1, 'ac nibh', 'id sapien in sapien iaculis');
insert into exercicio (idExercicio, nome, maquina) values (2, 'odio condimentum id', 'cubilia curae');
insert into exercicio (idExercicio, nome, maquina) values (3, 'eu orci mauris lacinia', 'turpis integer aliquet');
insert into exercicio (idExercicio, nome, maquina) values (4, 'rutrum nulla tellus in sagittis', 'orci luctus');
insert into exercicio (idExercicio, nome, maquina) values (5, 'sed interdum venenatis', 'ut blandit non interdum in');
insert into exercicio (idExercicio, nome, maquina) values (6, 'congue', 'risus dapibus');
insert into exercicio (idExercicio, nome, maquina) values (7, 'nam', 'blandit nam nulla');
insert into exercicio (idExercicio, nome, maquina) values (8, 'mattis nibh ligula', 'tincidunt eu');
insert into exercicio (idExercicio, nome, maquina) values (9, 'augue a suscipit', 'at');
insert into exercicio (idExercicio, nome, maquina) values (10, 'quam sapien varius', 'erat id mauris');
insert into exercicio (idExercicio, nome, maquina) values (11, 'neque libero convallis eget eleifend', 'nulla neque');
insert into exercicio (idExercicio, nome, maquina) values (12, 'proin at turpis', 'potenti');
insert into exercicio (idExercicio, nome, maquina) values (13, 'id ligula suspendisse', 'augue aliquam erat volutpat');
insert into exercicio (idExercicio, nome, maquina) values (14, 'blandit nam nulla integer', 'orci');
insert into exercicio (idExercicio, nome, maquina) values (15, 'amet sem fusce consequat', 'venenatis turpis');
insert into exercicio (idExercicio, nome, maquina) values (16, 'in eleifend quam a', 'est phasellus sit amet erat');
insert into exercicio (idExercicio, nome, maquina) values (17, 'justo sollicitudin ut suscipit a', 'dignissim');
insert into exercicio (idExercicio, nome, maquina) values (18, 'volutpat sapien arcu sed', 'non lectus aliquam sit amet');
insert into exercicio (idExercicio, nome, maquina) values (19, 'leo maecenas pulvinar', 'diam');
insert into exercicio (idExercicio, nome, maquina) values (20, 'blandit nam', 'vel pede morbi');
insert into exercicio (idExercicio, nome, maquina) values (21, 'vitae consectetuer eget rutrum', 'est');
insert into exercicio (idExercicio, nome, maquina) values (22, 'quis', 'vestibulum aliquet ultrices');
insert into exercicio (idExercicio, nome, maquina) values (23, 'lorem integer tincidunt', 'id nulla');
insert into exercicio (idExercicio, nome, maquina) values (24, 'lorem id ligula suspendisse', 'non ligula pellentesque ultrices phasellus');
insert into exercicio (idExercicio, nome, maquina) values (25, 'feugiat non pretium', 'ultrices posuere cubilia curae');
insert into exercicio (idExercicio, nome, maquina) values (26, 'nisi', 'lorem quisque ut');
insert into exercicio (idExercicio, nome, maquina) values (27, 'varius nulla facilisi', 'viverra');
insert into exercicio (idExercicio, nome, maquina) values (28, 'porttitor lacus at turpis donec', 'tellus nulla ut erat id');
insert into exercicio (idExercicio, nome, maquina) values (29, 'in', 'eget massa tempor');
insert into exercicio (idExercicio, nome, maquina) values (30, 'porttitor lorem', 'in lectus pellentesque at');
insert into exercicio (idExercicio, nome, maquina) values (31, 'in tempus sit amet', 'morbi non quam nec dui');
insert into exercicio (idExercicio, nome, maquina) values (32, 'ipsum ac tellus semper', 'faucibus orci');
insert into exercicio (idExercicio, nome, maquina) values (33, 'dapibus dolor vel', 'vel dapibus');
insert into exercicio (idExercicio, nome, maquina) values (34, 'proin interdum', 'libero nam dui');
insert into exercicio (idExercicio, nome, maquina) values (35, 'maecenas pulvinar lobortis est', 'erat quisque erat eros');
insert into exercicio (idExercicio, nome, maquina) values (36, 'hac habitasse platea', 'pellentesque eget nunc');
insert into exercicio (idExercicio, nome, maquina) values (37, 'cursus vestibulum proin eu mi', 'dui vel');
insert into exercicio (idExercicio, nome, maquina) values (38, 'sagittis dui vel', 'nulla eget eros');
insert into exercicio (idExercicio, nome, maquina) values (39, 'ipsum', 'diam neque');
insert into exercicio (idExercicio, nome, maquina) values (40, 'sed magna at nunc', 'nisl duis');
insert into exercicio (idExercicio, nome, maquina) values (41, 'ipsum', 'pellentesque eget nunc');
insert into exercicio (idExercicio, nome, maquina) values (42, 'natoque penatibus et', 'at nulla suspendisse potenti');
insert into exercicio (idExercicio, nome, maquina) values (43, 'nisi volutpat eleifend', 'elit ac');
insert into exercicio (idExercicio, nome, maquina) values (44, 'viverra pede ac diam cras', 'risus auctor sed tristique');
insert into exercicio (idExercicio, nome, maquina) values (45, 'commodo placerat', 'luctus');
insert into exercicio (idExercicio, nome, maquina) values (46, 'nulla pede ullamcorper augue a', 'integer');
insert into exercicio (idExercicio, nome, maquina) values (47, 'sapien', 'donec dapibus');
insert into exercicio (idExercicio, nome, maquina) values (48, 'ipsum ac tellus semper', 'proin leo odio porttitor id');
insert into exercicio (idExercicio, nome, maquina) values (49, 'sem praesent id massa', 'amet erat');
insert into exercicio (idExercicio, nome, maquina) values (50, 'fermentum donec', 'ultrices enim');

-- Inserts Tabela Fisiologista
SET @encryption_key = 'Vduu47qL51hLn6bkYkY6NlO1nivsmdfD';

ALTER TABLE fisiologista
MODIFY utilizador VARBINARY(255),
MODIFY passwrd VARBINARY(255);

-- Inserir dados encriptados
INSERT INTO fisiologista (idFisio, nome, utilizador, passwrd) VALUES
(1, 'Selby Muriel', AES_ENCRYPT('selby.muriel@example.com', @encryption_key), AES_ENCRYPT('password1', @encryption_key)),
(2, 'Belvia Hartop', AES_ENCRYPT('belvia.hartop@example.com', @encryption_key), AES_ENCRYPT('password2', @encryption_key)),
(3, 'Natividad Ead', AES_ENCRYPT('natividad.ead@example.com', @encryption_key), AES_ENCRYPT('password3', @encryption_key)),
(4, 'Dino Boule', AES_ENCRYPT('dino.boule@example.com', @encryption_key), AES_ENCRYPT('password4', @encryption_key)),
(5, 'Nestor Gedge', AES_ENCRYPT('nestor.gedge@example.com', @encryption_key), AES_ENCRYPT('password5', @encryption_key)),
(6, 'Stacia Wethey', AES_ENCRYPT('stacia.wethey@example.com', @encryption_key), AES_ENCRYPT('password6', @encryption_key)),
(7, 'Ignace Crame', AES_ENCRYPT('ignace.crame@example.com', @encryption_key), AES_ENCRYPT('password7', @encryption_key)),
(8, 'Chrissy Whellans', AES_ENCRYPT('chrissy.whellans@example.com', @encryption_key), AES_ENCRYPT('password8', @encryption_key)),
(9, 'Lanny Petheridge', AES_ENCRYPT('lanny.petheridge@example.com', @encryption_key), AES_ENCRYPT('password9', @encryption_key)),
(10, 'Burnard Hynes', AES_ENCRYPT('burnard.hynes@example.com', @encryption_key), AES_ENCRYPT('password10', @encryption_key));


-- Inserts Tabela Sessao
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (1, 6, 3, '2024-04-20', '21:00', '21:30', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (2, 18, 3, '2024-06-24', '07:30', '08:00', 'S');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (3, 5, 2, '2024-06-24', '07:30', '08:00', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (4, 9, 7, '2024-07-08', '21:00', '21:30', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (5, 18, 7, '2024-06-26', '09:00', '09:30', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (6, 2, 4, '2024-05-11', '09:30', '10:00', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (7, 15, 2, '2024-05-13', '10:00', '10:30', 'S');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (8, 16, 5, '2024-05-01', '13:30', '14:00', 'S');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (9, 14, 9, '2024-05-14', '11:00', '11:30', 'S');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (10, 17, 6, '2024-06-29', '11:30', '12:00', 'S');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (11, 7, 1, '2024-05-13', '21:00', '21:30', 'S');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (12, 16, 3, '2024-07-04', '12:30', '13:00', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (13, 8, 1, '2024-07-08', '21:00', '21:30', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (14, 1, 5, '2024-06-10', '13:30', '14:00', 'S');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (15, 15, 1, '2024-05-16', '14:00', '14:30', 'S');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (16, 4, 8, '2024-05-02', '14:30', '15:00', 'S');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (17, 19, 7, '2024-05-07', '15:00', '15:30', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (18, 10, 3, '2024-05-17', '15:30', '16:00', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (19, 2, 6, '2024-07-26', '16:00', '16:30', 'N');
insert into Sessao (idSessao, idCliente, idFisio, dataS, inicio, fim, novoPlano) values (20, 2, 8, '2024-08-23', '20:30', '21:00', 'S');

-- Inserts Tabela Monitorizacao
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (1, 3, 8, 80, '6:9', 45, 51, 'nascetur ridiculus', 2, 4, 'magna vestibulum aliquet ultrices');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (2, 4, 8, 44, '8:2', 55, 42, 'lorem ipsum dolor', 1, -4, 'est donec odio justo sollicitudin ut suscipit a');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (3, 5, 6, 40, '5:3', 26, 74, 'donec dapibus', 5, 5, 'amet justo morbi ut odio');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) values (4, 6, 2, 84, '9:9', 33, 60, 'dapibus duis', 10, 2, 'in quis justo maecenas');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (5, 7, 3, 67, '8:1', 65, 72, 'in quam', 6, 0, 'ac tellus semper interdum');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (6, 8, 9, 25, '0:4', 9, 54, 'aliquam', 6, 4, 'pellentesque');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (7, 9, 1, 80, '1:8', 70, 64, 'ultrices phasellus id', 4, 0, 'luctus');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (8, 10, 5, 56, '1:5', 53, 91, 'iaculis', 1, 4, 'congue vivamus metus arcu adipiscing molestie');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (9, 11, 5, 90, '7:8', 50, 20, 'eu mi', 10, 2, 'nisi vulputate nonummy maecenas tincidunt lacus at');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (10, 12, 8, 36, '6:8', 61, 85, 'quam sollicitudin', 7, -2, 'adipiscing');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (11, 13, 8, 45, '5:8', 26, 19, 'venenatis', 1, 0, 'adipiscing molestie hendrerit at vulputate');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (12, 14, 4, 46, '6:2', 37, 95, 'augue quam', 3, -2, 'primis in faucibus orci luctus et');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (13, 15, 10, 80, '4:3', 63, 87, 'varius integer', 10, 4, 'amet nunc viverra dapibus nulla suscipit ligula in lacus curabitur');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (14, 16, 9, 88, '6:7', 17, 87, 'curae donec pharetra', 7, 0, 'quis turpis eget elit sodales scelerisque mauris');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (15, 17, 4, 73, '8:9', 73, 91, 'etiam pretium iaculis', 2, 3, 'pulvinar');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (16, 18, 7, 66, '3:5', 83, 96, 'molestie', 10, 5, 'sapien cum sociis');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (17, 19, 10, 20, '9:3', 9, 69, 'nisi at', 6, 1, 'sapien iaculis congue');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (18, 20, 1, 21, '5:6', 28, 63, 'sit amet', 4, -2, 'mi sit amet lobortis sapien');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (19, 1, 8, 58, '1:6', 82, 85, 'mauris', 8, -2, 'aliquam augue quam sollicitudin vitae consectetuer eget rutrum at lorem');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (20, 2, 10, 53, '8:5', 7, 49, 'aliquam augue quam', 6, 4, 'accumsan odio curabitur convallis duis consequat dui nec');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (21, 3, 8, 80, '6:9', 45, 51, 'nascetur ridiculus', 2, 4, 'magna vestibulum aliquet ultrices');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (22, 4, 8, 44, '8:2', 55, 42, 'lorem ipsum dolor', 1, -4, 'est donec odio justo sollicitudin ut suscipit a');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (23, 5, 6, 40, '5:3', 26, 74, 'donec', 2, -2, 'turpis eget elit sodales vestibulum aliquet');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (24, 6, 2, 84, '9:9', 33, 60, 'dapibus duis', 10, 2, 'in quis justo maecenas');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (25, 7, 3, 67, '8:1', 65, 72, 'in quam', 6, 0, 'ac tellus semper interdum');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (26, 8, 9, 25, '0:4', 9, 54, 'aliquam', 6, 4, 'pellentesque');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (27, 9, 1, 80, '1:8', 70, 64, 'ultrices phasellus id', 4, 0, 'luctus');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (28, 10, 5, 56, '1:5', 53, 91, 'iaculis', 1, 4, 'congue vivamus metus arcu adipiscing molestie');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (29, 11, 5, 90, '7:8', 50, 20, 'eu mi', 10, 2, 'nisi vulputate nonummy maecenas tincidunt lacus at');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (30, 12, 8, 36, '6:8', 61, 85, 'quam sollicitudin', 7, -2, 'adipiscing');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) values (31, 13, 8, 45, '5:8', 26, 19, 'venenatis', 1, 0, 'adipiscing molestie hendrerit at vulputate');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) values (32, 14, 4, 46, '6:2', 37, 95, 'augue quam', 3, -2, 'primis in faucibus orci luctus et');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (33, 15, 10, 80, '4:3', 63, 87, 'varius integer', 10, 4, 'amet nunc viverra dapibus nulla suscipit ligula in lacus curabitur');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (34, 16, 9, 88, '6:7', 17, 87, 'curae donec pharetra', 7, 0, 'quis turpis eget elit sodales scelerisque mauris');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (35, 17, 4, 73, '8:9', 73, 91, 'etiam pretium iaculis', 2, 3, 'pulvinar');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (36, 18, 7, 66, '3:5', 83, 96, 'molestie', 10, 5, 'sapien cum sociis');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (37, 19, 10, 20, '9:3', 9, 69, 'nisi at', 6, 1, 'sapien iaculis congue');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (38, 20, 1, 21, '5:6', 28, 63, 'sit amet', 4, -2, 'mi sit amet lobortis sapien');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (39, 1, 8, 58, '1:6', 82, 85, 'mauris', 8, -2, 'aliquam augue quam sollicitudin vitae consectetuer eget rutrum at lorem');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (40, 2, 10, 53, '8:5', 7, 49, 'aliquam augue quam', 6, 4, 'accumsan odio curabitur convallis duis consequat dui nec');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (41, 3, 8, 80, '6:9', 45, 51, 'nascetur ridiculus', 2, 4, 'magna vestibulum aliquet ultrices');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (42, 4, 8, 44, '8:2', 55, 42, 'lorem ipsum dolor', 1, -4, 'est donec odio justo sollicitudin ut suscipit a');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (43, 5, 6, 40, '5:3', 26, 74, 'donec dapibus', 5, 5, 'amet justo morbi ut odio');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (44, 6, 2, 84, '9:9', 33, 60, 'dapibus duis', 10, 2, 'in quis justo maecenas');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (45, 7, 3, 67, '8:1', 65, 72, 'in quam', 6, 0, 'ac tellus semper interdum');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (46, 8, 9, 25, '0:4', 9, 54, 'aliquam', 6, 4, 'pellentes');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (47, 9, 1, 80, '1:8', 70, 64, 'ultrices phasellus id', 4, 0, 'luctus');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (48, 10, 5, 56, '1:5', 53, 91, 'iaculis', 1, 4, 'congue vivamus metus arcu adipiscing molestie');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (49, 11, 5, 90, '7:8', 50, 20, 'eu mi', 10, 2, 'nisi vulputate nonummy maecenas tincidunt lacus at');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (50, 12, 8, 36, '6:8', 61, 85, 'quam sollicitudin', 7, -2, 'adipiscing');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (1, 13, 8, 45, '5:8', 26, 19, 'venenatis', 1, 0, 'adipiscing molestie hendrerit at vulputate');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (2, 14, 4, 46, '6:2', 37, 95, 'augue quam', 3, -2, 'primis in faucibus orci luctus et');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (3, 15, 10, 80, '4:3', 63, 87, 'varius integer', 10, 4, 'amet nunc viverra dapibus nulla suscipit ligula in lacus curabitur');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (4, 16, 9, 88, '6:7', 17, 87, 'curae donec pharetra', 7, 0, 'quis turpis eget elit sodales scelerisque mauris');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (5, 17, 4, 73, '8:9', 73, 91, 'etiam pretium iaculis', 2, 3, 'pulvinar');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) values (6, 18, 7, 66, '3:5', 83, 96, 'molestie', 10, 5, 'sapien cum sociis');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (7, 19, 10, 20, '9:3', 9, 69, 'nisi at', 6, 1, 'sapien iaculis congue');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (8, 20, 1, 21, '5:6', 28, 63, 'sit amet', 4, -2, 'mi sit amet lobortis sapien');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) values (9, 12, 8, 36, '6:8', 61, 85, 'quam sollicitudin', 7, -2, 'adipiscing');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (10, 13, 8, 45, '5:8', 26, 19, 'venenatis', 1, 0, 'adipiscing molestie hendrerit at vulputate');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (11, 14, 4, 46, '6:2', 37, 95, 'augue quam', 3, -2, 'primis in faucibus orci luctus et');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (12, 15, 10, 80, '4:3', 63, 87, 'varius integer', 10, 4, 'amet nunc viverra dapibus nulla suscipit ligula in lacus curabitur');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (13, 16, 9, 88, '6:7', 17, 87, 'curae donec pharetra', 7, 0, 'quis turpis eget elit sodales scelerisque mauris');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (14, 17, 4, 73, '8:9', 73, 91, 'etiam pretium iaculis', 2, 3, 'pulvinar');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (15, 18, 7, 66, '3:5', 83, 96, 'molestie', 10, 5, 'sapien cum sociis');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (16, 19, 10, 20, '9:3', 9, 69, 'nisi at', 6, 1, 'sapien iaculis congue');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) values (17, 20, 1, 21, '5:6', 28, 63, 'sit amet', 4, -2, 'mi sit amet lobortis sapien');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (18, 1, 8, 58, '1:6', 82, 85, 'mauris', 8, -2, 'aliquam augue quam sollicitudin vitae consectetuer eget rutrum at lorem');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (19, 2, 10, 53, '8:5', 7, 49, 'aliquam augue quam', 6, 4, 'accumsan odio curabitur convallis duis consequat dui nec');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (20, 3, 8, 80, '6:9', 45, 51, 'nascetur ridiculus', 2, 4, 'magna vestibulum aliquet ultrices');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (21, 4, 8, 44, '8:2', 55, 42, 'lorem ipsum dolor', 1, -4, 'est donec odio justo sollicitudin ut suscipit a');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (22, 5, 6, 40, '5:3', 26, 74, 'donec dapibus', 5, 5, 'amet justo morbi ut odio');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (23, 6, 2, 84, '9:9', 33, 60, 'dapibus duis', 10, 2, 'in quis justo maecenas');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (24, 7, 3, 67, '8:1', 65, 72, 'in quam', 6, 0, 'ac tellus semper interdum');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (25, 8, 9, 25, '0:4', 9, 54, 'aliquam', 6, 4, 'pellentesque');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (26, 9, 1, 80, '1:8', 70, 64, 'ultrices phasellus id', 4, 0, 'luctus');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (27, 10, 5, 56, '1:5', 53, 91, 'iaculis', 1, 4, 'congue vivamus metus arcu adipiscing molestie');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (28, 11, 5, 90, '7:8', 50, 20, 'eu mi', 10, 0, 'accumsan odio curabitur convallis');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (29, 1, 8, 58, '1:6', 82, 85, 'mauris', 8, -2, 'aliquam augue quam sollicitudin vitae consectetuer eget rutrum at lorem');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (30, 2, 10, 53, '8:5', 7, 49, 'aliquam augue quam', 6, 4, 'accumsan odio curabitur convallis duis consequat dui nec');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (31, 3, 8, 80, '6:9', 45, 51, 'nascetur ridiculus', 2, 4, 'magna vestibulum aliquet ultrices');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (32, 4, 8, 44, '8:2', 55, 42, 'lorem ipsum dolor', 1, -4, 'est donec odio justo sollicitudin ut suscipit a');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (33, 5, 6, 40, '5:3', 26, 74, 'donec dapibus', 5, 5, 'amet justo morbi ut odio');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (34, 6, 2, 84, '9:9', 33, 60, 'dapibus duis', 10, 2, 'in quis justo maecenas');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (35, 7, 3, 67, '8:1', 65, 72, 'in quam', 6, 0, 'ac tellus semper interdum');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (36, 8, 9, 25, '0:4', 9, 54, 'aliquam', 6, 4, 'pellentesque');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (37, 9, 1, 80, '1:8', 70, 64, 'ultrices phasellus id', 4, 0, 'luctus');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (38, 10, 5, 56, '1:5', 53, 91, 'iaculis', 1, 4, 'congue vivamus metus arcu adipiscing molestie');
insert into monitorizacao (idExercicio, idSessao, numSeries, duracao, cadencia, carga, repouso, pega_material, pse, es, obs) VALUES (39, 11, 5, 90, '7:8', 50, 20, 'eu mi', 10, 2,'augue quam sollicitudin');



-- Inserts Tabela AvaliacaoAntesTreino
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (1, 2, 2, 1);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (2, 2, 3, 1);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (3, 1, 2, 3);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (4, 2, 2, 2);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (5, 1, 3, 2);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (6, 1, 2, 3);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (7, 2, 1, 1);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (8, 3, 2, 3);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (9, 3, 3, 1);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (10, 2, 3, 1);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (11, 3, 1, 1);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (12, 2, 2, 3);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (13, 3, 3, 3);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (14, 2, 2, 2);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (15, 2, 2, 3);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (16, 1, 2, 2);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (17, 3, 3, 1);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (18, 2, 2, 1);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (19, 3, 1, 1);
insert into AvaliacaoAT (idSessao, sono, alimentacao, fadiga) values (20, 3, 2, 1);

-- Inserts Tabela AvaliacaoDepoisTreino
insert into AvaliacaoDT (idSessao, pss, psi) values (1, 4, 5);
insert into AvaliacaoDT (idSessao, pss, psi) values (2, 5, 5);
insert into AvaliacaoDT (idSessao, pss, psi) values (3, 4, 3);
insert into AvaliacaoDT (idSessao, pss, psi) values (4, 2, 3);
insert into AvaliacaoDT (idSessao, pss, psi) values (5, 5, 3);
insert into AvaliacaoDT (idSessao, pss, psi) values (6, 1, 2);
insert into AvaliacaoDT (idSessao, pss, psi) values (7, 3, 2);
insert into AvaliacaoDT (idSessao, pss, psi) values (8, 2, 1);
insert into AvaliacaoDT (idSessao, pss, psi) values (9, 5, 1);
insert into AvaliacaoDT (idSessao, pss, psi) values (10, 1, 1);
insert into AvaliacaoDT (idSessao, pss, psi) values (11, 1, 3);
insert into AvaliacaoDT (idSessao, pss, psi) values (12, 1, 4);
insert into AvaliacaoDT (idSessao, pss, psi) values (13, 3, 4);
insert into AvaliacaoDT (idSessao, pss, psi) values (14, 4, 4);
insert into AvaliacaoDT (idSessao, pss, psi) values (15, 2, 3);
insert into AvaliacaoDT (idSessao, pss, psi) values (16, 4, 4);
insert into AvaliacaoDT (idSessao, pss, psi) values (17, 2, 4);
insert into AvaliacaoDT (idSessao, pss, psi) values (18, 1, 3);
insert into AvaliacaoDT (idSessao, pss, psi) values (19, 5, 1);
insert into AvaliacaoDT (idSessao, pss, psi) values (20, 4, 5);


   
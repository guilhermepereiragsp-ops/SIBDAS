# DeepFitness — Módulo de Fisiologista (Acompanhamento)

Web-app e base de dados de um Sistema de Gestão de Dados de um estúdio de fisiologia do exercício (módulo 4: Fisiologista, Acompanhamento). Projeto da UC de Sistemas de Informação e Base de Dados Aplicados à Saúde (SIBDAS), 2.º ano da Licenciatura em Engenharia Biomédica, ISEP, ano letivo 2023/2024.

## Conceito

O módulo apoia o fisiologista durante o acompanhamento dos clientes do ginásio: escolhe o horário e os clientes (até dois por período), regista a avaliação antes do treino, monitoriza cada exercício da sessão, avalia o cliente no fim do treino e consulta a evolução ao longo do tempo. Os dados ficam numa base de dados MySQL, ligada à aplicação web por PDO.

## Aplicação

Fluxo de navegação:

```
homepage → login → clients_table_al ─┬→ client_selection → client_selection_list
                                     │       → bs_evaluation → monitorization → as_evaluation
                                     └→ total_clients_list → client_details ─┬→ client_sessions
                                                                             └→ evolution
```

| Página | Função |
|---|---|
| `homepage` | Página de apresentação do ginásio |
| `login` | Autenticação do fisiologista e escolha do módulo |
| `clients_table_al` | Clientes com sessão no próprio dia, após a hora do login |
| `client_selection` | Escolha de uma data e horário, e de até dois clientes com sessão nesse período |
| `client_selection_list` | Lista da seleção, com ligação para iniciar a monitorização |
| `bs_evaluation` | Avaliação antes do treino: sono, fadiga e alimentação (1 a 3) |
| `monitorization` | Registo por exercício: séries, duração, cadência, carga, repouso, pegas/material, PSE (1 a 10), ES (−5 a +5) e observações |
| `as_evaluation` | Avaliação depois do treino: PSS e PSI (1 a 5) e necessidade de novo plano de treino |
| `total_clients_list` | Lista de todas as sessões de clientes, com pesquisa e paginação |
| `client_details` | Detalhe de um cliente: próximas sessões ou evolução |
| `client_sessions` | Próximas sessões do cliente |
| `evolution` | Gráficos (Chart.js) da evolução das avaliações antes e depois do treino |

As validações são feitas em PHP e JavaScript (por exemplo, horários entre as 07:00 e as 21:30, só às horas certas ou e meia), e as credenciais dos fisiologistas são guardadas encriptadas na base de dados.

## Tecnologias

PHP (PDO), MySQL, HTML, CSS, JavaScript, Bootstrap, Chart.js, Font Awesome e DataTables. Desenvolvido em Laragon, com o VS Code como editor, o Draw.io para os modelos e o Mockaroo para gerar os dados.

## Base de dados

O ficheiro `Projeto_p4.sql` cria as tabelas e insere dados fictícios (20 clientes, 10 fisiologistas e sessões, monitorizações e avaliações de exemplo).

| Tabela | Conteúdo |
|---|---|
| `cliente` | Clientes do ginásio |
| `exercicio` | Exercícios e máquinas |
| `fisiologista` | Fisiologistas (utilizador e password encriptados com AES) |
| `Sessao` | Sessões (cliente, fisiologista, data, início, fim e necessidade de novo plano) |
| `monitorizacao` | Registo de cada exercício numa sessão |
| `AvaliacaoAT` | Avaliação antes do treino |
| `AvaliacaoDT` | Avaliação depois do treino |

O esquema usa restrições `CHECK` (por exemplo, nos horários das sessões e nas escalas de avaliação), que exigem **MySQL 8.0.16 ou superior**.

## Diretórios

```
.
├── assets/        # CSS, DataTables, Flatpickr, Font Awesome, imagens e jQuery
├── helpers/
│   ├── functions.php   # Sessão, encriptação e desencriptação de atributos
│   └── logout.php      # Termina a sessão
├── layouts/
│   ├── config.php      # Constantes da ligação à base de dados
│   └── header.php      # Bibliotecas comuns a todas as páginas
├── *.php          # Páginas da aplicação (ver tabela acima)
├── Projeto_p4.sql # Base de dados (estrutura e dados)
└── Relatório_WA__SIBDAS_.pdf
```

## Como executar

Requer o [Laragon](https://laragon.org/), que traz o Apache, o PHP e o MySQL.

1. Iniciar o Apache e o MySQL no Laragon (*Start All*).
2. Colocar a pasta do projeto em `C:\laragon\www\`.
3. No HeidiSQL, criar uma base de dados e importar `Projeto_p4.sql` (o ficheiro não cria a base de dados).
4. Confirmar em `layouts/config.php` o nome da base de dados e as credenciais (por omissão no Laragon: `root`, sem password).
5. Abrir `http://localhost/<nome_da_pasta>` no navegador.

### Credenciais de teste

Na página de login, escolher o módulo **4. Fisiologista-Acompanhamento**:

```
Utilizador: selby.muriel@example.com
Password:   password1
```

Os outros nove fisiologistas seguem o mesmo padrão (`password2` a `password10`).

### Exemplo de teste

Os dados de exemplo são de 2024, por isso a página `clients_table_al` pode aparecer vazia. Em **Selecionar clientes por período**, escolher **24/06/2024** às **07:30**: há duas sessões (2 e 3) nesse horário. Seguir depois para a avaliação antes do treino, a monitorização e a avaliação depois do treino. Para ver os gráficos, abrir `total_clients_list`, escolher um cliente com várias sessões e entrar em **Evolução de Parâmetros**.

## Autor

Guilherme Pereira (1220678)  
Licenciatura em Engenharia Biomédica, Departamento de Física, ISEP, Porto, Portugal

Docentes: Pedro Guimarães, Nuno Morgado e Júlio de Souza

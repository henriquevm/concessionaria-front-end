<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concessionária - Gerenciamento de Veículos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://unpkg.com/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>
    <script src="js/cadastro.js" defer></script>
</head>
<body>
    <div class="container my-3 ">
        <div class="jumbotron mb-3">
            <h1>Logo da Concessionária</h1>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="listagem.php">Listagem</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cadastro.php">Cadastro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sobre.php">Sobre</a>
                  </li>
              </ul>
            </div>
          </nav>

        <form id="formVeiculo" method="POST" class="row" name="formulario">
            <div class="form-group col-md-6">
                <label>Marca:</label>
                <select id="marca" class="form-control custom-select" name="marca">
                    <option value="">-- Selecionar --</option>
                    <option value="Chevrolet">Chevrolet</option>
                    <option value="Ford">Ford</option>
                    <option value="Hyiundai">Hyiundai</option>
                </select>
                <div class="alert-danger w-100 p-2 d-none">Marca é obrigatório</div>
            </div> 
            <div class="form-group col-md-6">
                <label>Modelo:</label>
                <input type="text" id="modelo" class="form-control" placeholder="Insira o nome do modelo" name="modelo">
                <div class="alert-danger w-100 p-2 d-none">Modelo inválido</div>
            </div>
            <div class="form-group col-md-6">
                <label>Ano:</label>
                <input type="number" id="ano" class="form-control" value="" placeholder="Insira o ano do modelo" name="ano">
                <div class="alert-danger w-100 p-2 d-none">Ano inválido</div>
            </div>
            <div class="form-group col-md-6">
                <label>Preço:</label>
                <input type="text" id="preco" class="form-control" value="" placeholder="Insira o preço do modelo" name="preco">
                <div class="alert-danger w-100 p-2 d-none">Preço inválido</div>
            </div>
            <div class="form-group col-md-6">
                <label>Foto:</label>
                <input type="text" id="foto" class="form-control" value="" placeholder="Insira o nome da foto" name="foto">
            </div>
            <div class="form-group col-md-6">
                <label>Cor:</label>
                <select id="cor" class="form-control custom-select" name="cor">
                    <option value="">-- Selecionar --</option>
                    <option value="Preto">Preto</option>
                    <option value="Branco">Branco</option>
                    <option value="Prata">Prata</option>
                    <option value="Vermelho">Vermelho</option>
                </select>
                <div class="alert-danger w-100 p-2 d-none">Cor é obrigatório</div>
            </div>
            <div class="form-group col-md-12">
                <label>Descrição:</label>
                <textarea class="form-control" id="descricao" rows="10" placeholder="Insira a descrição do veículo"  name="descricao"></textarea>
                <div class="alert-danger w-100 p-2 d-none">Descrição é obrigatório</div>
            </div>
            <div class="form-group col-md-12 text-right">
                <button type="submit" class="btn btn-primary">
                    Cadastrar Veículo
                </button>
                <button type="reset" class="btn btn-secondary">
                    Limpar
                </button>
            </div>
        </form>

        <?php 
            // Verificar se foi enviando dados via POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $marca = (isset($_POST["marca"]) && $_POST["marca"] != null) ? $_POST["marca"] : "";
                $modelo = (isset($_POST["modelo"]) && $_POST["modelo"] != null) ? $_POST["modelo"] : "";
                $ano = (isset($_POST["ano"]) && $_POST["ano"] != null) ? $_POST["ano"] : "";
                $preco = (isset($_POST["preco"]) && $_POST["preco"] != null) ? $_POST["preco"] : NULL;
                $foto = (isset($_POST["foto"]) && $_POST["foto"] != null) ? $_POST["foto"] : NULL;
             
                try {
                    $conexao = new PDO("mysql:host=localhost; dbname=concessionaria", "root", "root");
                    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $conexao->exec("set names utf8");

                    $stmt = $conexao->prepare("INSERT INTO carros (fk_id_marca, modelo, ano, preco, foto, cor, descricao) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    
                    $stmt->bindParam(1, $marca);
                    $stmt->bindParam(2, $modelo);
                    $stmt->bindParam(3, $ano);
                    $stmt->bindParam(4, $preco);
                    $stmt->bindParam(5, $foto);

                    

                } catch (PDOException $erro) {
                    echo "Erro na conexão:" . $erro->getMessage();
                }
            }
        ?>

        <hr>
        <footer class="mb-5">
            <p>&copy; Instituto Federal do Sul de Minas Gerais – IFSULDEMINAS | Campus Poços de Caldas, MG.</p>
        </footer>
    </div>
    
</body>
</html>
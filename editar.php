<?php
    require_once('conexao.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
        isset($_POST["id_marca"]) && isset($_POST["modelo"]) && isset($_POST["ano"]) &&
        isset($_POST["preco"]) && isset($_POST["foto"]) && isset($_POST["id_cor"]) &&
        isset($_POST["descricao"]) && isset($_GET["id"])) {

        $sql = "UPDATE veiculo SET fk_id_marca = ?,
            modelo = ?, ano = ?, preco = ?, foto = ?, fk_id_cor = ?, descricao = ?
            WHERE id_veiculo = ?";
            
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$_POST["id_marca"], $_POST["modelo"], $_POST["ano"], $_POST["preco"],
            $_POST["foto"], $_POST["id_cor"], $_POST["descricao"], $_GET["id"]]);
    }

    $marcas = [];
    $cores = [];
    $veiculo = null;

    try {   
        $consulta = $conexao->query("SELECT id_marca, descricao FROM marca");
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            array_push($marcas, $linha);
        }

        $consulta = $conexao->query("SELECT id_cor, descricao FROM cor");
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            array_push($cores, $linha);
        }

        $consulta = $conexao->query("SELECT marca.id_marca, marca.descricao as marca, veiculo.modelo, veiculo.ano, veiculo.preco, veiculo.foto, cor.id_cor, cor.descricao as cor, veiculo.descricao FROM veiculo INNER JOIN marca ON marca.id_marca = veiculo.fk_id_marca INNER JOIN cor ON cor.id_cor = veiculo.fk_id_cor WHERE id_veiculo = " . $_GET['id']);
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $veiculo = $linha;
        }

    } catch (PDOException $erro) {
        echo "Erro na conexão:" . $erro->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concessionária - Gerenciamento de Veículos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://unpkg.com/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>
    <script src="js/editar.js"></script>
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

        <form id="formVeiculo" method="POST" action="#" class="row">
            <div class="form-group col-md-6">
                <label>Marca:</label>
                <select id="marca" name="id_marca" class="form-control custom-select">
                    <option value="" disabled>-- Selecionar --</option>
                    <?php
                        for ($i = 0; $i < count($marcas); $i++) {
                            echo "<option value=\"".$marcas[$i]['id_marca']."\"".
                                ($marcas[$i]['id_marca'] == $veiculo['id_marca'] ? "selected" : "").">".
                                $marcas[$i]['descricao']."</option>";
                        }
                    ?>
                </select>
                <div class="alert-danger w-100 p-2 d-none">Marca é obrigatório</div>
            </div>
            <div class="form-group col-md-6">
                <label>Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo $veiculo['modelo'] ?>" placeholder="Insira o nome do modelo">
                <div class="alert-danger w-100 p-2 d-none">Modelo inválido</div>
            </div>
            <div class="form-group col-md-6">
                <label>Ano:</label>
                <input type="number" id="ano" name="ano" class="form-control" value="<?php echo $veiculo['ano'] ?>" placeholder="Insira o ano do modelo">
                <div class="alert-danger w-100 p-2 d-none">Ano inválido</div>
            </div>
            <div class="form-group col-md-6">
                <label>Preço:</label>
                <input type="text" id="preco" name="preco" class="form-control" value="<?php echo $veiculo['preco'] ?>" placeholder="Insira o preço do modelo">
                <div class="alert-danger w-100 p-2 d-none">Preço inválido</div>
            </div>
            <div class="form-group col-md-6">
                <label>Foto:</label>
                <input type="text" id="foto" name="foto" class="form-control" value="<?php echo $veiculo['foto'] ?>" placeholder="Insira o nome da foto">
            </div>
            <div class="form-group col-md-6">
                <label>Cor:</label>
                <select id="cor" name="id_cor" class="form-control custom-select">
                    <option value="" disabled>-- Selecionar --</option>
                    <?php
                        for ($i = 0; $i < count($cores); $i++) {
                            echo "<option value=\"".$cores[$i]['id_cor']."\"".
                                ($cores[$i]['id_cor'] == $veiculo['id_cor'] ? "selected" : "").">".
                                $cores[$i]['descricao']."</option>";
                        }
                    ?>
                </select>
                <div class="alert-danger w-100 p-2 d-none">Cor é obrigatório</div>
            </div>
            <div class="form-group col-md-12">
                <label>Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="10" placeholder="Insira a descrição do veículo"><?php echo $veiculo['descricao'] ?></textarea>
                <div class="alert-danger w-100 p-2 d-none">Descrição é obrigatório</div>
            </div>
            <div class="form-group col-md-12 text-right">
                <button type="submit" class="btn btn-primary">
                    Salvar Veículo
                </button>
                <button type="reset" class="btn btn-secondary">
                    Limpar
                </button>
            </div>
        </form>
        <hr>
        <footer class="mb-5">
            <p>&copy; Instituto Federal do Sul de Minas Gerais – IFSULDEMINAS | Campus Poços de Caldas, MG.</p>
        </footer>
    </div>
    
</body>
</html>
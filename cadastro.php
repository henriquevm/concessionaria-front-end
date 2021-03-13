<?php
require_once('conexao.php');

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
                    <option value="" disabled selected>-- Selecionar --</option>
                    <?php
                    for ($i = 0; $i < count($marcas); $i++) {
                        echo "<option  value=\"" . $marcas[$i]['id_marca'] . "\">" .
                            $marcas[$i]['descricao'] . "</option>";
                    }
                    ?>
                </select>
                <div class="alert-danger w-100 p-2 d-none">Marca é obrigatório</div>
            </div>
            <div class="form-group col-md-6">
                <label>Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Insira o nome do modelo">
                <div class="alert-danger w-100 p-2 d-none">Modelo inválido</div>
            </div>
            <div class="form-group col-md-6">
                <label>Ano:</label>
                <input type="number" id="ano" name="ano" class="form-control" placeholder="Insira o ano do modelo">
                <div class="alert-danger w-100 p-2 d-none">Ano inválido</div>
            </div>
            <div class="form-group col-md-6">
                <label>Preço:</label>
                <input type="text" id="preco" name="preco" class="form-control" placeholder="Insira o preço do modelo">
                <div class="alert-danger w-100 p-2 d-none">Preço inválido</div>
            </div>
            <div class="form-group col-md-6">
                <label>Foto:</label>
                <input type="text" id="foto" name="foto" class="form-control" placeholder="Insira o nome da foto">
            </div>
            <div class="form-group col-md-6">
                <label>Cor:</label>
                <select id="cor" name="id_cor" class="form-control custom-select">
                    <option value="" disabled selected>-- Selecionar --</option>
                    <?php
                    for ($i = 0; $i < count($cores); $i++) {
                        echo "<option value=\"" . $cores[$i]['id_cor'] . "\">" .
                            $cores[$i]['descricao'] . "</option>";
                    }
                    ?>
                </select>
                <div class="alert-danger w-100 p-2 d-none">Cor é obrigatório</div>
            </div>
            <div class="form-group col-md-12">
                <label>Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="10" placeholder="Insira a descrição do veículo"></textarea>
                <div class="alert-danger w-100 p-2 d-none">Descrição é obrigatório</div>
            </div>
            <div class="form-group col-md-12 text-right">
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modalConfirmacao">
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

    <?php
    require_once('conexao.php');

    if (
        $_SERVER['REQUEST_METHOD'] == 'POST' &&
        isset($_POST["id_marca"]) && isset($_POST["modelo"]) && isset($_POST["ano"]) &&
        isset($_POST["preco"]) && isset($_POST["foto"]) && isset($_POST["id_cor"]) &&
        isset($_POST["descricao"])
    ) {
        $id_marca = (isset($_POST["id_marca"]) && $_POST["id_marca"] != null) ? $_POST["id_marca"] : "";
        $modelo = (isset($_POST["modelo"]) && $_POST["modelo"] != null) ? $_POST["modelo"] : "";
        $ano = (isset($_POST["ano"]) && $_POST["ano"] != null) ? $_POST["ano"] : "";
        $preco = (isset($_POST["preco"]) && $_POST["preco"] != null) ? $_POST["preco"] : "";
        $foto = (isset($_POST["foto"]) && $_POST["foto"] != null) ? $_POST["foto"] : "";
        $id_cor = (isset($_POST["id_cor"]) && $_POST["id_cor"] != null) ? $_POST["id_cor"] : "";
        $descricao = (isset($_POST["descricao"]) && $_POST["descricao"] != null) ? $_POST["descricao"] : "";

        try {
            $stmt = $conexao->prepare("INSERT INTO veiculo (fk_id_marca, modelo, ano, preco, foto, fk_id_cor, descricao) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $id_marca);
            $stmt->bindParam(2, $modelo);
            $stmt->bindParam(3, $ano);
            $stmt->bindParam(4, $preco);
            $stmt->bindParam(5, $foto);
            $stmt->bindParam(6, $id_cor);
            $stmt->bindParam(7, $descricao);

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // echo "Dados cadastrados com sucesso!";

                    /*echo '<script language="javascript">';
                    echo 'alert("Veiculo cadastrado com Sucesso!")';
                    echo '</script>';*/

                    echo "<script>$('#modalConfirmacao').modal('show');</script>";

                    $id_marca = null;
                    $modelo = null;
                    $ano = null;
                    $preco = null;
                    $foto = null;
                    $id_cor = null;
                    $descricao = null;
                } else {
                    echo "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }
    ?>

    <div class="modal" tabindex="-1" role="dialog" id="modalConfirmacao">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sucesso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Veiculo Cadastrado com sucesso!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery e JS do Bootstrap, utilizados no modal de confirmação da cadastro de um veículo -->
    <scscriptript src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></scscriptript>
    <scscriptript src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></scscriptript>

</body>

</html>
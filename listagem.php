<?php
    require_once('conexao.php');

    if (isset($_POST["id_excluir"])) {

        try {  
            $sql = "DELETE FROM veiculo WHERE id_veiculo = ?";

            $stmt = $conexao->prepare($sql);
            $stmt->execute([$_POST["id_excluir"]]);
        } catch (PDOException $erro) {
            echo "Erro na conexão:" . $erro->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concessionária - Gerenciamento de Veículos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .btn-excluir {
            height: 38px;
            margin-left: 5px;
        }
    </style>
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

        <section>
            <header class="card-header p-3 mb-3">
                <h2>Veja os nossos veículos</h2>
            </header>
            <?php 

                require_once('conexao.php');

                try {
                    $stmt = $conexao->prepare("SELECT veiculo.id_veiculo as id, veiculo.foto, veiculo.modelo, marca.descricao as marca, veiculo.preco, cor.descricao as cor, veiculo.descricao FROM veiculo INNER JOIN marca ON veiculo.fk_id_marca = marca.id_marca INNER JOIN cor ON cor.id_cor = veiculo.fk_id_cor");
                
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {  
                                echo "<div class='card p-2 my-3'>";
                                    echo "<div class='row'>";
                                        echo "<div class='col-md-3'>";
                                            echo "<img src='img/".$rs->foto."' class='img-thumbnail img-fluid'>";
                                        echo "</div>";
                                        echo "<div class='col-md-9 p-3'>";
                                            echo "<h3>".$rs->modelo."</h3>";
                                            echo "<p>";
                                                echo "<strong>"."Marca: "."</strong>".$rs->marca."<br>";
                                                echo "<strong>"."Preço: "."</strong>".$rs->preco."<br>";
                                                echo "<strong>"."Cor: "."</strong>".$rs->cor;
                                            echo "</p>";
                                            echo "<p>";
                                             echo $rs->descricao;
                                             echo "</p>";
                                             echo "<p class='text-right'>";
                                                echo "<a href='editar.php?id=".$rs->id."' class='btn btn-primary'>"."Editar"."</a>";
                                                echo "<button type='button' data-toggle='modal' data-target='#modalConfirmacao' onclick=\"$('#id_excluir').val(".$rs->id.")\" class='btn btn-danger btn-excluir'>Excluir</a>";
                                            echo "</p>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "Erro: Não foi possível recuperar os dados do banco de dados";
                        }

                } catch (PDOException $erro) {
                    echo "Erro na conexão:" . $erro->getMessage();
                }

            ?>

            

            
            
        </section>

        <hr>
        <footer class="mb-5">
            <p>&copy; Instituto Federal do Sul de Minas Gerais – IFSULDEMINAS | Campus Poços de Caldas, MG.</p>
        </footer>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modalConfirmacao">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir este veículo?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="#">
                        <input type="hidden" id="id_excluir" name="id_excluir">
                        <button type="submit" class="btn btn-primary">Excluir</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- jQuery e JS do Bootstrap, utilizados no modal de confirmação da exclusão de um veículo -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
</body>
</html>
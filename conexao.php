<?php
    $host="localhost:3306";
    $dbName="concessionaria";
    $dbUser="root";
    $dbPassword="root";

    try {
        $conexao = new PDO("mysql:host=".$host."; dbname=".$dbName, $dbUser, $dbPassword);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexao->exec("set names utf8");
    } catch (PDOException $erro) {
        echo "Erro na conexão:" . $erro->getMessage();
    }
?>
<?php

require_once('conexaoMySql.php');

$statusResposta = (bool) false;

function selectAllValores()
{
    $conexao = conexaoMySql();

    $sql = "select * from estacionamento order by id";

    $result = mysqli_query($conexao, $sql);

    if ($result) {
        $cont = 0;

        while ($vlDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "id"                    => $vlDados['id'],
                "total_vagas"           => $vlDados['total_vagas'],
                "valor_primeira_hora"   => $vlDados['valor_primeira_hora'],
                "valor_demais_horas"    => $vlDados['valor_demais_horas']
            );

            $cont++;
        }


        fecharConexaoMySql($conexao);

        if (isset($arrayDados)) {
            return $arrayDados;
        } else {
            return false;
        }
    }
}

function insertValores($dadosValores)
{
    $statusResposta = (bool) false;

    $conexao = conexaoMySql();

    $sql = "insert into estacionamento
                            (total_vagas,
                             valor_primeira_hora,
                             valor_demais_horas
                             )
                    values
                        ('" . $dadosValores['total_vagas'] . "',
                        '" . $dadosValores['valor_primeira_hora'] . "',
                        '" . $dadosValores['valor_demais_horas'] . "'
                    );";

    if (mysqli_query($conexao, $sql)) {
        if (mysqli_affected_rows($conexao)) {
            $statusResposta = true;
        }
    } else {
        fecharConexaoMySql($conexao);
    }
    return $statusResposta;
}

function updateValores($dadosValores)
{
    $conexao = conexaoMySql();

    $sql = "update estacionamento set
                        total_vagas = '" . $dadosValores['nome'] . "',
                        valor_primeira_hora = '" . $dadosValores['placa'] . "',
                        valor_demais_horas = '" . $dadosValores['veiculo'] . "',
                        where id =" . $dadosValores['id'];

    if (mysqli_query($conexao, $sql)) {
        if (mysqli_affected_rows($conexao)) {
            $statusResposta = true;
        }
    } else {
        fecharConexaoMySql($conexao);
    }
}

function deleteValores($id)
{
    $conexao = conexaoMySql();

    $sql = "delete from estacionamento where id = " . $id;

    if (mysqli_query($conexao, $sql)) {
        if (mysqli_affected_rows($conexao)) {
            $statusResposta = true;
        }
    }

    fecharConexaoMySql($conexao);

    return $statusResposta;
}

function selectByIdEstacionamento($id)
{
    $conexao = conexaoMySql();

    $sql = "select * from estacionamento where id = " . $id;

    $result = mysqli_query($conexao, $sql);

    if ($result) {
        if ($vlDados = mysqli_fetch_assoc($result)) {
            $arrayDados = array(
                "id"                    => $vlDados['id'],
                "total_vagas"           => $vlDados['total_vagas'],
                "valor_primeira_hora"   => $vlDados['valor_primeira_hora'],
                "valor_demais_horas"    => $vlDados['valor_demais_horas']

            );
        }
    }

    fecharConexaoMySql($conexao);

    if (isset($arrayDados)) {
        return $arrayDados;
    } else {
        return false;
    }
}

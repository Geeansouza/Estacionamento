<?php
    
    require_once(SRC.'modulo/config.php');

    function listarValores()
    {
        require_once(SRC.'model/bd/valores.php');

        $dados = selectAllValores();

        if (!empty($dados))
        {
            return $dados;

        } else {
            return false;
        }
    }

    function inserirValores($dadosValores)
    {
        if (!empty($dadosValores))
        {
            if (!empty($dadosValores[0]['total_vagas']) && !empty($dadosValores[0]['valor_primeira_hora']) && !empty($dadosValores[0]['valor_demais_horas']))
            {
                $arrayDados = array(
                    "total_vagas"      => $dadosValores[0]['total_vagas'],
                    "valor_primeira_hora"     => $dadosValores[0]['valor_primeira_hora'],
                    "valor_demais_horas"    => $dadosValores[0]['valor_demais_horas'],
                    
                );
                
                require_once(SRC.'model/bd/valores.php');

                if (insertValores($arrayDados))
                    {
                    return true;
                } else 
                {
                    return array ('idErro' => 1, 'message' =>'Não foi possível inserir os dados');
                }

            }   else 
            {
                return array ('idErro' => 2, 'message' => 'Existem campos obrigatórios que não foram preenchidos');
            }
        }
    }

    function buscarValores($id)
    {
        if ($id != 0 && !empty($id) && is_numeric($id))
        {
            require_once(SRC.'model/bd/valores.php');


            $dados = selectByIdEstacionamento($id);

           
            if (!empty($dados))
            {
                return $dados;
            } else 
            {
                return false;
            }
        } else 
        {
            return array ('idErro' => 4, 'message' => 'Não é possível buscar um Valores sem informar um Id válido');
        }
    }

    function atualizarValores($dadosValores, $arrayDados)
    {
        $id = $arrayDados['id'];

        if (!empty($dadosValores))
        {
            if (!empty($dadosValores['total_vagas']) && !empty($dadosValores['valor_primeira_hora']) && !empty($dadosValores['valor_demais_horas']))
            {
                if (is_numeric($id) && $id != 0 )
                {
                    $arrayDados = array (
                        "id"        => $id,
                        "total_vagas"      => $dadosValores['total_vagas'],
                        "valor_primeira_hora"   => $dadosValores['valor_primeira_hora'],
                        "valor_demais_horas"     => $dadosValores['valor_demais_horas']
                    );

                    require_once(SRC.'model/bd/valores.php');

                    if (updateValores($arrayDados))
                    {
                        return true;
                    } else
                    {
                        return array ('idErro' => 1, '');
                    }
                } else
                {
                    return array ('idErro' => 1, 'message' => 'Não é possível editar um Valores sem informar um Id válido');
                }
            } else
            {
                return array ('idErro' => 2, 'message' => 'Existem campos obrigatórios que não foram preenchidos');
            }
        }
    }

    function excluirValores($arrayDados)
    {
        $id = $arrayDados['id'];

        if ($id != 0 && is_numeric($id))
        {
            require_once(SRC.'model/bd/valores.php');

            if (deleteValores($id))
            {
                return true;

            } else
            {
                return array ('idErro' => 3, 'message' => 'O banco de dados não pode excluit o Valores.');
            }
        } else
        {
            return array( 'idErro' => 3, 'message' => 'Não é possível excluir um Valores sem informar um Id válido');
        }
    }
    ?>
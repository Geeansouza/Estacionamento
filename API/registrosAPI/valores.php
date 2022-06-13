<?php

require_once('vendor/autoload.php');

$app = new \Slim\app();

// Endpoint para LISTAR todos os valores
$app->get('/valores', function($request, $response, $args)
{

    
    require_once('../modulo/config.php');
    require_once('../controller/valoresController.php');
    
    
    if ($dados = listarValores())
    {
        if ($dadosJSON = createJSON($dados))
        {
            return $response    -> withStatus(200)
                                -> withHeader('Content-Type', 'application/json')
                                -> write($dadosJSON);
        }
        
    } else
    {
        var_dump($dados);
        die; 
        return $response    -> withStatus(404)
                            -> withHeader('Content-Type', 'application/json')
                            -> write('{"message" : "Item não encontrado"}');

                            
        
    }
});


// Endpoint para listar apenas um registro
$app -> get('/valores/{id}', function($request, $response, $args)
{
    $id = $args['id'];

    require_once('../modulo/config.php');
    require_once('../controller/valoresController.php');

    if ($dados = buscarValores($id))
    {
        if (!isset($dados['idErro']))
        {
            if ($dadosJSON = createJSON($dados))
            {
                return $response    -> withStatus(200)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write($dadosJSON);
            }
        } else
        {
            $dadosJSON = createJSON($dados);
            
            return $response    -> withStatus(404) 
                                -> withHeader('Content-Type', 'application/json')
                                -> write('{"message" : "Dados Inválidos", "Erro" : '.$dadosJSON.'}');

        } 
    } else
        {
            return $response    -> withStatus(404)
                                -> withHeader('Content-Type', 'application/json')
                                -> write('{"message" : "Item não encontrado"}');
        }
});

// Endpoint para inserir um valor
$app -> post('/valores', function($request, $response, $args)
{
    $contentTypeHeader = $request -> getHeaderLine('Content-Type');

    $contentType = explode(";", $contentTypeHeader);

    switch ($contentType[0])
    {

        case 'multipart/form-data' :

            $dadosBody = $request -> getParsedBody();

            $arrayDados = array ($dadosBody);

            require_once('../modulo/config.php');
            require_once('../controller/valoresController.php');

            
            $resposta = inserirValores($arrayDados);
            
            
            if (is_bool($resposta) && $resposta == true)
            {
                return $response -> withStatus(201)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write('{"message" : "Registro inserido com sucesso"}');


            } elseif (is_array($resposta) && $resposta['idErro'])
            {
                $dadosJSON = createJSON($resposta);

                return $response    -> withStatus(404)
                                    -> withHeader('Content-Type', 'application/josn')
                                    -> write('{"message" : "Houve um problema no processo de inserção", "Erro" : '.$dadosJSON.'}');
            }

            break;

        case 'application/json' :
            
            return $response    -> withStatus(200)
                                -> withHeader('Content-Type', 'application/json')
                                -> write('{"message" : "Formato selecionado foi JSON"}');

            break;
            
        default :
            return $response    -> withStatus(400)
                                -> withHeader('Content-Type', 'application/json')
                                -> write('{"message" : "Formato selecionado inválido"}');

            break;                        


    }
});

//  Endpoint para deletar registro
$app -> delete('/valores/{id}', function($request, $response, $args)
{
    if (is_numeric($args['id']))
    {
        $id = $args['id'];

        require_once('../modulo/config.php');
        require_once('../controller/valoresController.php');

        
        if ($dados = buscarValores($id))
        {
           
            $arrayDados = array("id" => $id);

            $resposta = excluirValores($arrayDados);

         

            if (is_bool($resposta) && $resposta == true)
            {
                return $response    -> withStatus(200)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write('{"message" : "Registro excluído com sucesso"}');

            } else 
            {
                return $response    -> withStatus(404)
                                    -> withHeader('Content-Type', 'application/json')
                                    -> write('{"message" : "O Id informado não foi encontrado"}');
            }
        }
    }
});

$app->run();

?>
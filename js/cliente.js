'use strict'

const url = 'http://localhost/gean/Estacionamento/api/registros'

const lerClientes = async () => {
    const response = await fetch(`${url}`)
    return await response.json()
}

const novoCliente = async (cliente) =>{

    const opcoes = {
        'method' : 'POST',
        'body' : JSON.stringify(cliente),
        'headers': {
            'content-type':'application/json'
        }
    }

    const response = await fetch(url, opcoes)
    console.log(response.ok)
}
const deletarRegistro = async (posicao) => {
    const opcoes = {
        'method':'DELETE'
    }

    const response = await fetch(`${url}/${posicao}`, opcoes)
    console.log(response.ok)
}

const atualizarRegistro = async (clientes) =>{
    const opcoes = {
        'method': 'PUT',
        'body': JSON.stringify(cliente),
        headers: {
            'content-type': 'application/json'
        }
    }
    const response = await fetch(`${url}/${cliente.id}`, opcoes)
    console.log('ATUALIZAR', response.ok)
}



export{
    lerClientes,
    novoCliente,
    deletarRegistro,
    atualizarRegistro
}
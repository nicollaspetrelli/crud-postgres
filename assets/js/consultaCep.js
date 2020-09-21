// Script para Consultar Endreços via CEP
// DesignPattern Observer

// Ao Pressionar Enter - Não funciona por conta do Form
// var input = document.getElementById("CEP");

// input.addEventListener("keyup", function(event) {

// if (event.keyCode === 13) {
//     // Cancel the default action, if needed
//     event.preventDefault();
//     // Trigger the button element with a click
//     validaDados(input.value)
// }
// });

// Ao mudar a checkbox
var checkbox = document.querySelector("input[name=edit]");

checkbox.addEventListener( 'change', function() {
    if(this.checked) {
        // Checkbox is checked..
        document.getElementById("endereco").readOnly = false;
        document.getElementById("bairro").readOnly = false;
        document.getElementById("cidade").readOnly = false;
        document.getElementById("estado").readOnly = false;

    } else {
        // Checkbox is not checked..
        document.getElementById("endereco").readOnly = true;
        document.getElementById("bairro").readOnly = true;
        document.getElementById("cidade").readOnly = true;
        document.getElementById("estado").readOnly = true;
    }
});


// Functions
function validaDados(dados){

    if (dados == '') {
        alert('Seu campo está vazio')
        return false
    } else {
        cep = dados
        getDadosCEP(cep)
    }
}

function getDadosCEP(cep){
    let url = 'https://viacep.com.br/ws/'+cep+'/json/' // API de CEP

    let xmlHttp = new XMLHttpRequest()
    xmlHttp.open('GET', url)

    console.log(xmlHttp)

    xmlHttp.onreadystatechange = () => {
        //Recebe uma função que é executada a cada mudança de estado
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            let response = xmlHttp.responseText
            let dadosJSON = JSON.parse(response) // Retorna o Objeto JSON com os dados

            if (dadosJSON['erro']) {
                alert('o CEP digitado não é valido ou não foi localizado!')
                document.getElementById('CEP').value = ''
                document.getElementById('endereco').value = ''
                document.getElementById('bairro').value = ''
                document.getElementById('cidade').value = ''
                document.getElementById('estado').value = ''
            } else {
                document.getElementById('endereco').value = dadosJSON.logradouro
                document.getElementById('bairro').value = dadosJSON.bairro
                document.getElementById('cidade').value = dadosJSON.localidade
                document.getElementById('estado').value = dadosJSON.uf
            }
        }
    }
    xmlHttp.send()
}
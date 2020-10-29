



$(document).ready(function () {

    $('#label').hide()
    $('#btnSubmit').prop('disabled', true)


    //. ESCONDER LABEL DE USUARIO CADASTRADO
    $('#inscreverseForm').on('click', function () {
        $('#labelUsuarioExistente').hide()
    })


    //. REGRAS DE VALIDAÇÃO FORMULÁRIO COM JQUERY VALIDATE
    $('#inscreverseForm').validate({

        rules: {
            nome: {
                required: true,
                minWords: 2,
                nmrMinimoDePalavrasPorNome: true
            },
            email: {
                required: true,
                email: true
            },
            senha: {

                required: true,
                minlength: 5
            }
        }

    })


    //. REGRAS DE VALIDAÇÃO FORMULÁRIO COM JQUERY VALIDATE
    $('#inscreverseForm input').bind('keyup blur click', function () {

        if ($('#inscreverseForm').validate().checkForm()) {
            $('#btnSubmit').prop('disabled', false)

        } else {
            $('#btnSubmit').prop('disabled', true)

        }

    })


})



//; FUNÇÃO QUE ENVIA PARA A VARIAVEL GLOBAL POST DA ROTA /getEmail O EMAIL DIGITADO PELO USUARIO 
function getEmail(sthis) {


    $(document).ready(function () {

        $('#inscreverseForm input').on('focus load blur click', function () {

            let emailDigitadoPeloUsuario = $(sthis).val()

            //# MÉTODO AJAX QUE VERFICA SE O EMAIL FOI CADASTRADO, SE JA FOI DAR UM FEEDBACK PARA O USUÁRIO SEM LOADING 
            $.ajax({
                type: "POST",/*tipo*/
                url: "/getEmail",/*url*/
                data: 'emailDigitado=' + emailDigitadoPeloUsuario.toString(),/*data*/
                dataType: "",
                success: function (response) {
                    //*RESPOSTA DA REQUISIÇÃO COM A ROTA    
                    console.log(response)

                    //# A REQUISIÇÃO RETORNA 'Encontrado' ou NÃO
                    if (response == 'Encontrado') {
                        $('#btnSubmit').prop('disabled', true)
                        $('#label').show()
                        $('#email').addClass('bordaVermelha')

                    } else {
                        if ($('#email').hasClass('bordaVermelha')) {
                            $('#email').removeClass('bordaVermelha')
                        }
                        $('#label').hide()
                    }
                },
                error: function (e) {
                    console.log('deu error ' + e)
                }
            });

        })

    })

}



//; CRIAÇÃO DE METODO JQUERY VALIDATE 
jQuery.validator.addMethod("nmrMinimoDePalavrasPorNome", function (value, element) {

    function splitString(string, separador) {

        let arrayDeStrings = string.split(separador)

        return arrayDeStrings
    }

    let space = ' '
    let array = splitString(value, space)

    if (array[0].length < 2) {
        return false
    } else {
        return true
    }

}, "O nome dever ter pelo menos 2 letras")



//. PUBLICAR MENSAGEM SEM LOADING 
$('#formTweet').submit(function (e) {
    e.preventDefault()
    let dados = $('#formTweet').serialize()
    $.ajax({
        type: "post",
        url: "/tweet",
        data: dados,
        dataType: "json",
        success: function (valor) {
            let nome = null
            let data = null
            let tweet = null
            valor.forEach((valor, indice, array) => {
                nome = valor.nome
                data = valor.data
                tweet = valor.tweet
            });


            let divRow = document.createElement('div')
            divRow.className = 'row tweet'

            let divCol = document.createElement('div')
            divCol.className = 'col'

            let pNomeEdata = document.createElement('p')

            let strong = document.createElement('strong')
            strong.innerHTML = nome

            let small = document.createElement('small')

            let span = document.createElement('span')
            span.className = 'text text-muted'
            span.innerHTML = ' - ' + data

            let pConteudo = document.createElement('p')
            pConteudo.innerHTML = tweet

            let br = document.createElement('br')

            let form = document.createElement('form')

            let divButton = document.createElement('div')
            divButton.className = 'col d-flex justify-content-end'

            let button = document.createElement('button')
            button.type = 'submit'
            button.className = 'btn btn-danger'

            let smallButton = document.createElement('small')
            smallButton.innerHTML = 'Remover'

            divRow.appendChild(divCol)
            divCol.appendChild(pNomeEdata)
            pNomeEdata.appendChild(strong)
            pNomeEdata.appendChild(small)
            small.appendChild(span)
            divCol.appendChild(pConteudo)
            divCol.appendChild(br)
            divCol.appendChild(form)
            form.appendChild(divButton)
            divButton.appendChild(button)
            button.appendChild(smallButton)

            $('.after').after(divRow)



        }
    });
    $('#formTweet')[0].reset();
})


$(document).ready(() => {
    
    $('.btn_procurar').on('click', (e) => {

        $(".remove").remove()
        e.preventDefault()
        let pesquisarPor = $('form').serialize()
        console.log(pesquisarPor)
        $.ajax({
            type: "GET",
            url: "/quem_seguir",
            data: pesquisarPor,
            success: (dados) => {
                let html1 = $(dados).find("#xerebebeu")
                html = html1.html()
                console.log(html)                
                $('#procurar').after(html)

                




            },
            error: error => { console.log(error) }
        })
    })

    
    // $('.seguir').on('click', (e)=>{
    //     e.preventDefault()

    //     let seguir = 'seguir'
    //     let dados = {
    //         acao: seguir
    //         id:
    //     }
    // })

})


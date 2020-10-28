



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



//. PESQUISAR POR USUARIOS SEM LOADING 
$('#procurar').submit(function(e){
    $('.divRow').remove()

    e.preventDefault()
    let dados = $('#procurar').serialize()
    $.ajax({
        type: "post",
        url: "/pesquisar_usuarios",
        data: dados,
        dataType: "json",
        success: function (response) {
            console.log(response)
            let nome = null

            response.forEach((valor, indice, array) => {
                nome = valor.nome
            
                let divRow = document.createElement('div')
                divRow.className = 'row mb-2 divRow'

                let divCol = document.createElement('div')
                divCol.className = 'col'

                let divCard = document.createElement('div')
                divCard.className = 'card'

                let cardBody = document.createElement('div')
                cardBody.className = 'card-body'
                
                let divRow2 = document.createElement('div')
                divRow2.className = 'row'
                
                let divCol21 = document.createElement('div')
                divCol21.className = 'col-md-6'
                divCol21.innerHTML = nome

                let divCol22 = document.createElement('div')
                divCol22.className = 'col-md-6 d-flex justify-content-end'

                let divPura = document.createElement('div')

                let linkSeguir = document.createElement('a')
                linkSeguir.href = '#'
                linkSeguir.className = 'btn btn-success'
                linkSeguir.innerHTML = 'Seguir'

                let linkDeixar = document.createElement('a')
                linkDeixar.href = '#'
                linkDeixar.className = 'btn btn-danger mr'
                linkDeixar.innerHTML = 'Deixar de seguir'                
                
                divRow.appendChild(divCol)
                divCol.appendChild(divCard)
                divCard.appendChild(cardBody)
                cardBody.appendChild(divRow2)
                divRow2.appendChild(divCol21)
                divRow2.appendChild(divCol22)
                divCol22.appendChild(divPura)
                divPura.appendChild(linkSeguir)
                divPura.appendChild(linkDeixar)

                $('.procurarPorUsuarios').after(divRow)
                
            });
        },
        error: function(e){
            console.log('erro')
        }
    });
} )
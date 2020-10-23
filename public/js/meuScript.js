
// class TratarEmail{

//     constructor(email){
//         this.email = email
//     }

    

// } 
$(document).ready(function(){
    $('#label').hide()
    $('button').prop('disabled' , true)

})

//; FUNÇÃO QUE ENVIA PARA A VARIAVEL GLOBAL POST DA ROTA /getEmail O EMAIL DIGITADO PELO USUARIO 
function getEmail(sthis){

    
    $(document).ready(function(){

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
                    if(response == 'Encontrado'){
                        $('button').prop('disabled' , true)
                        $('#label').show()
                        $('#email').addClass('bordaVermelha')                        

                    }else{
                        if($('#email').hasClass('bordaVermelha')){
                            $('#email').removeClass('bordaVermelha')
                        }
                        $('#label').hide()                        
                    }
                },
                error: function (e){
                    console.log('deu error ' + e)
                }
            });

        })

    })    

}

//. ESCONDER LABEL DE USUARIO CADASTRADO
$(document).ready(function(){
    
    $('#inscreverseForm').on('click', function() {
        $('#labelUsuarioExistente').hide()
    })

})


//; CRIAÇÃO DE METODO JQUERY VALIDATE 
jQuery.validator.addMethod("nmrMinimoDePalavrasPorNome", function(value, element) {    

    function splitString(string, separador){

        let arrayDeStrings = string.split(separador)

        return arrayDeStrings
    }

    let space = ' '
    let array = splitString(value, space)
    
    if(array[0].length < 2){
        return false
    }else{
        return true
    }

}, "O nome dever ter pelo menos 2 letras")


//. REGRAS DE VALIDAÇÃO FORMULÁRIO COM JQUERY VALIDATE
$(document).ready(function () {
    
    $('#inscreverseForm').validate({

        rules:{
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
    
    
    
    $('#inscreverseForm input').bind('keyup blur click', function () 
    {        

        if($('#inscreverseForm').validate().checkForm()){                        
            $('#btnSubmit').prop('disabled', false)
            
        }else{
            $('button').prop('disabled' , true)

        }              
        
    })
 
});






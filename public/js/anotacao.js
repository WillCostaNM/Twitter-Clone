let divRow = document.createElement('div')
                    divRow.className = 'row tweet'

                    let divCol = document.createElement('div')
                    divCol.className = 'col'

                    let pNomeEdata = document.createElement('p')                    

                    let strong = document.createElement('strong')
                    strong.innerHTML = valor.nome

                    let small = document.createElement('small')

                    let span = document.createElement('span')
                    span.className = 'text text-muted'
                    span.innerHTML = '- ' + valor.data

                    let pConteudo = document.createElement('p')
                    pConteudo.innerHTML = valor.tweet

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

                    console.log(divRow)

                    $('#areaTweet').after(divRow)



                    


                    
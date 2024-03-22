let url = "http://localhost:8000/App/index.php";


fetch(url).then(async function(response){
    let resposta = await response.json()
    resposta.forEach(dados => {
        let nome = document.createElement("td")
        let id = document.createElement("td")
        let email = document.createElement("td")
        let cidade = document.createElement("td")
        let estado = document.createElement("td")
        let funcoes = document.createElement("td")
        let excluir = document.createElement("button")
        let atualizar = document.createElement("button")

        excluir.classList.value ="ui red basic button"
        excluir.classList.add("excluir")
        excluir.innerHTML = "Excluir"
        excluir.setAttribute("id", dados.id)

        atualizar.classList.value ="ui primary basic button"
        atualizar.classList.add("atualizar")
        atualizar.innerHTML = "atualizar"

        funcoes.append(excluir)
        funcoes.append(atualizar)

        let linhas = document.createElement("tr")

        nome.innerHTML = dados.nome
        email.innerHTML = dados.email
        cidade.innerHTML = dados.cidade
        estado.innerHTML = dados.estado
        id.innerHTML = dados.id

        linhas.append(id)
        linhas.append(nome)
        linhas.append(email)
        linhas.append(cidade)
        linhas.append(estado)
        linhas.append(funcoes)

        let corpo = document.getElementById("linhas")
        corpo.append(linhas)
        document.querySelectorAll(".excluir").forEach(element => {
            element.addEventListener("click", function(evento){
                
                let data = {"id": evento.target.getAttribute("id")}

                fetch(url,{
                    method: "DELETE",
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                }).then(async function(response){
                    if(response.ok){
                        alert("Registro inserido com sucesso")
                        location.href="/"
                    }else{
                        alert("Erro ao excluir cliente")
                    }
                })
            })
        });

        document.querySelectorAll(".atualizar").forEach(element => {
            element.addEventListener("click", function(){
                location.href = "/atualizar.html"
            })
        })

    });
    
}).catch(function (error){
    console.log(error)
})


let url = "http://localhost:8000/App/index.php";

function cadastrar() {
    let data = {
        "nome": document.getElementById("nome").value,
        "email": document.getElementById("email").value,
        "cidade": document.getElementById("cidade").value,
        "estado": document.getElementById("estado").value
    }
    fetch(url, {
        method: "POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }).then(function (resposta) {
        if(resposta.ok){
             location.href="/"
        }else{
            document.getElementById("erro").innerHTML = "Formato dos dados incorreto"
        }
    }).catch(function (error) {
        document.getElementById("erro").innerHTML = "Erro ao enviar formulario"
    })
}

document.getElementById("enviar").addEventListener("click", function () {
    cadastrar()
})
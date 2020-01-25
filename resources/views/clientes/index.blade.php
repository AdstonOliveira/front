<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{isset($title) ? $title : 'Cliente Index'}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="row w-100 justify-content-center">
                <h1>Clientes Ativos</h1>
            </div>
            <div class="row w-100 justify-content-center">
                <span id="msg"></span>
            </div>
        </div>
        <div class="row justify-content-around">
            <div class="col-md-4">
                <a href="{{route('cliente.novo')}}" class="btn btn-outline-success">Novo Cliente</a>
            </div>
            <div class="col-md-5 pb-2">
                <div class="row form-inline justify-content-between">
                    <input type="text" class="form-control col-md-9" name="busca" id="busca" placeholder="Pesquisa Nome - Somente ativos">
                    <button type="button" class="btn btn-outline-info" id="buscar">Buscar</button>
                </div>
            </div>
        </div>

        <div class="row">
            <table class="table table-striped text-center" id="tabela">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Endereco</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Idade</th>
                        <th scope="col">Filhos</th>
                        <th scope="col">Opção</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="row justify-content-center">
            <h1>Clientes Inativos</h1>
        </div>
        <div class="row">
            <div class="col-md-5 pb-2">
                <div class="row form-inline justify-content-between">
                    <input type="text" class="form-control col-md-9" name="buscaInativo" id="buscaInativo" placeholder="Pesquisa Nome - Somente inativos">
                    <button type="button" class="btn btn-outline-info" id="buscarInativo">Buscar</button>
                </div>
            </div>
        </div>

        <div class="row">
            <table class="table table-striped text-center" id="apagados">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Endereco</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Idade</th>
                        <th scope="col">Filhos</th>
                        <th scope="col">Opção</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        preencheTabela();
        preencheApagados();

        $("#buscar").click(function(){
            buscar();
        })
        $("#buscarInativo").click(function(){
            buscarInativo();
        })

    });

    function preencheTabela(){
            $.getJSON('http://localhost:5500/api/v1/clientes/', function(data){
                $.each(data, function(i, value){
                    let newRow = $('<tr id="'+value["id"]+'">');
                    let cols = "";

                    cols += '<td>'+ value["id"] + '</td>'
                    cols += '<td>'+ value["nome"] + '</td>'
                    cols += '<td>'+ value["endereco"] + '</td>'
                    cols += '<td>'+ value["telefone"] + '</td>'
                    cols += '<td>'+ value["idade"] + '</td>'
                    cols += '<td>'+ value["filho"] + '</td>'
                    cols += '<td><div class="row justify-content-around"><a href = "/cliente/'+value["id"]+'" class="btn btn-warning">Editar </a> <button type="button" class="btn btn-danger" value = '+value["id"]+' id="excluir" onclick="deletar('+value["id"]+')"> Excluir </button></div></td>'

                    newRow.append(cols);

                    $("#tabela tbody").append(newRow);
                })
            })
    }

    function preencheApagados(){

            $.getJSON('http://localhost:5500/api/v1/clientes/apagados', function(data){
                $.each(data, function(i, value){
                    let newRow = $('<tr id="'+value["id"]+'">');
                    let cols = "";

                    cols += '<td>'+ value["id"] + '</td>'
                    cols += '<td>'+ value["nome"] + '</td>'
                    cols += '<td>'+ value["endereco"] + '</td>'
                    cols += '<td>'+ value["telefone"] + '</td>'
                    cols += '<td>'+ value["idade"] + '</td>'
                    cols += '<td>'+ value["filho"] + '</td>'
                    cols += '<td><div class="row justify-content-around"><button type="button" class="btn btn-success" value = '+value["id"]+' id="excluir" onclick="restaurar('+value["id"]+')"> Restaurar </button></div></td>'

                    newRow.append(cols);

                    $("#apagados tbody").append(newRow);
                })
            })
    }

        function deletar(id){
            $.ajax({
                 url: 'http://localhost:5500/api/v1/clientes/'+id,
                 method: 'DELETE',

            }).done(function(result) {
                    $("#msg").addClass("alert-success")
                    $("#msg").text("Apagado com sucesso")
                    $("#msg").fadeIn("slow").delay(4500).fadeOut("slow")
                    $('#'+id).fadeOut();

                    $("#apagados tbody").empty();
                    preencheApagados();

            }).fail(function(result){
                    console.log(result["responseJSON"]["message"])
                    $("#msg").addClass("alert-danger")
                    $("#msg").text(result["responseJSON"]["message"])
                    $("#msg").fadeIn("slow").delay(4500).fadeOut("slow")
                })

        }

        function restaurar(id){
            $.ajax({
                 url: 'http://localhost:5500/api/v1/clientes/'+id,
                 method: 'DELETE',

            }).done(function(result) {
                    $("#msg").addClass("alert-success")
                    $("#msg").text("Restaurado com sucesso")
                    $("#msg").fadeIn("slow").delay(4500).fadeOut("slow")
                    $('#'+id).fadeOut();

                    $("#tabela tbody").empty();
                    preencheTabela();

            }).fail(function(result){
                    console.log(result["responseJSON"]["message"])
                    $("#msg").addClass("alert-danger")
                    $("#msg").text(result["responseJSON"]["message"])
                    $("#msg").fadeIn("slow").delay(4500).fadeOut("slow")
                })

        }

        function buscar(){
            let nome = $("#busca").val()
            $("#tabela tbody").empty();

            if(nome.trim() === ""){
                preencheTabela()
            }else
                $.getJSON('http://localhost:5500/api/v1/clientes/ativos/nome/'+nome, function(data){

                    $.each(data, function(i, value){
                        let newRow = $('<tr id="'+value["id"]+'">');
                        let cols = "";

                        cols += '<td>'+ value["id"] + '</td>'
                        cols += '<td>'+ value["nome"] + '</td>'
                        cols += '<td>'+ value["endereco"] + '</td>'
                        cols += '<td>'+ value["telefone"] + '</td>'
                        cols += '<td>'+ value["idade"] + '</td>'
                        cols += '<td>'+ value["filho"] + '</td>'
                        cols += '<td><div class="row justify-content-around"><a href = "/cliente/'+value["id"]+'" class="btn btn-warning">Editar </a> <button type="button" class="btn btn-danger" value = '+value["id"]+' id="excluir" onclick="deletar('+value["id"]+')"> Excluir </button></div></td>'

                        newRow.append(cols);

                        $("#tabela tbody").append(newRow);

                    })
                })
        }

        function buscarInativo(){

            let nome = $("#buscaInativo").val()
            $("#apagados tbody").empty();

            if(nome.trim() === ""){
                preencheApagados()
            }else
                $.getJSON('http://localhost:5500/api/v1/clientes/inativos/nome/'+nome, function(data){

                    $.each(data, function(i, value){
                        let newRow = $('<tr id="'+value["id"]+'">');
                        let cols = "";

                        cols += '<td>'+ value["id"] + '</td>'
                        cols += '<td>'+ value["nome"] + '</td>'
                        cols += '<td>'+ value["endereco"] + '</td>'
                        cols += '<td>'+ value["telefone"] + '</td>'
                        cols += '<td>'+ value["idade"] + '</td>'
                        cols += '<td>'+ value["filho"] + '</td>'
                        cols += '<td><div class="row justify-content-around"><button type="button" class="btn btn-success" value = '+value["id"]+' id="excluir" onclick="restaurar('+value["id"]+')"> Restaurar </button></div></td>'

                        newRow.append(cols);

                        $("#apagados tbody").append(newRow);
                    })
                })
        }


</script>
</html>

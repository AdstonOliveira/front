<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dados Produto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript"></script>
</head>

<body>
    <div class="container align-items-center" style="min-height: 100vh">
        <div class="row justify-content-center" style="min-height: 100vh">

            <div class="col-md-8 col-sm-10 pt-5">
                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <span>Dados do Produto</span>
                        </div>
                        <div class="row" id="divmsg">
                            <span id="msg" class=""></span>
                        </div>

                        @if($errors)
                        <div class="row">
                            @foreach ($errors->all() as $item)
                                <div class="row">
                                     <span class="alert alert-danger">{{$item}}</span>
                                 </div>
                            @endforeach
                        </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ !isset($produto) ? route('produto.salvar') : ''}}">
                            @csrf
                            @if(isset($produto))
                                <input type="hidden" name="id" value="{{isset($produto) ? $produto->id : ''}}">
                            @endif

                            <div class="row justify-content-center">

                                <div class="col-md-6">
                                    <label for="nome">Nome:</label>
                                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome"
                                        value="{{isset($produto) ? $produto->nome : old('nome') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fornecedor">Fornecedor</label>
                                    <input type="text" name="fornecedor" id="fornecedor" class="form-control"
                                        placeholder="Fornecedor" value="{{isset($produto) ? $produto->fornecedor : old('fornecedor') }}" required>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <label for="UN">UN</label>
                                    <input type="text" name="UN" id="UN" class="form-control"
                                        placeholder="UN" value="{{isset($produto) ? $produto->UN : old('un') }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="idade">Preço</label>
                                    <input type="number" name="preco" id="preco" class="form-control" step="0.01"
                                        placeholder="R$" value="{{isset($produto) ? $produto->preco : old('preco') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="qtde">Qtd</label>
                                    <input type="number" name="qtde" id="qtde" class="form-control"
                                        placeholder="Qtde" value="{{isset($produto) ? $produto->qtde : old('qtde') }}" required>
                                </div>

                            </div>

                            <div class="row pt-3 justify-content-around">
                                <button value={{isset($produto) ? $produto->id : ''}} id="{{isset($produto) ? 'update' : 'save'}}" type="submit" class="btn {{isset($produto) ? 'btn-outline-warning' : 'btn-outline-success' }} col-md-4">{{isset($produto) ? 'Atualizar' : 'Salvar'}}</button>
                                <a href="/produto" class="btn btn-outline-dark col-md-3 col-sm-12">Voltar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
</body>
<script>
    // $(document).ready(function(){

    // });

        $("#update").click(function(e){
            e.preventDefault();
            let id = $(this).val()
            $.ajax({
                 url: 'http://localhost:5500/api/v1/produtos/'+id,
                 method: 'PUT',
                 data: {
                     'nome': $("#nome").val(),
                     'fornecedor': $("#fornecedor").val(),
                     'UN': $("#UN").val(),
                     'preco'   : $("#preco").val(),
                     'qtde'   :$("#qtde").val()
                 },}).
                 done(function(result) {
                    $("#msg").addClass("alert alert-success")
                    $("#msg").text("Atualizado com sucesso")
                    $("#msg").fadeIn("slow").delay(4500).fadeOut("slow")
                    // $("#msg").removeClass("alert-success")

                }).fail(function(result){
                    console.log(result["responseJSON"]["message"])
                    $("#msg").addClass("alert alert-danger")
                    $("#msg").text(result["responseJSON"]["message"])
                    $("#msg").fadeIn("slow").delay(4500).fadeOut("slow")
                    // $("#msg").removeClass("alert-danger")
                })
            });
        // });



</script>

</html>

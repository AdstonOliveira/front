<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dados Cliente</title>
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
                            <span>Dados do cliente</span>
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
                        <form method="POST" action="{{ !isset($cliente) ? route('cliente.salvar') : ''}}">
                            @csrf
                            @if(isset($cliente))
                                <input type="hidden" name="id" value="{{isset($cliente) ? $cliente->id : ''}}">
                            @endif

                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <label for="nome">Nome:</label>
                                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome"
                                        value="{{isset($cliente) ? $cliente->nome : old('nome') }}" required>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <label for="endereco">Endereço</label>
                                    <input type="text" name="endereco" id="endereco" class="form-control"
                                        placeholder="Endereco" value="{{isset($cliente) ? $cliente->endereco : old('endereco') }}" required>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" name="telefone" id="telefone" class="form-control"
                                        placeholder="Telefone" value="{{isset($cliente) ? $cliente->telefone : old('telefone') }}" required>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <label for="idade">Idade</label>
                                    <input type="number" name="idade" id="idade" class="form-control"
                                        placeholder="Idade" value="{{isset($cliente) ? $cliente->idade : old('telefone') }}" required>
                                </div>
                                <div class="col-md-5">
                                    <label for="filho">Qtd Filhos</label>
                                    <input type="number" name="filho" id="filho" class="form-control"
                                        placeholder="Qtde Filhos" value="{{isset($cliente) ? $cliente->filho : old('telefone') }}" required>
                                </div>
                            </div>

                            <div class="row pt-3 justify-content-around">
                                <button value={{isset($cliente) ? $cliente->id : ''}} id="{{isset($cliente) ? 'update' : 'save'}}" type="submit" class="btn {{isset($cliente) ? 'btn-outline-warning' : 'btn-outline-success' }} col-md-4">{{isset($cliente) ? 'Atualizar' : 'Salvar'}}</button>
                                <a href="/cliente" class="btn btn-outline-dark col-md-3 col-sm-12">Voltar</a>
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
    $(document).ready(function(){


            formatTel();



            function formatTel(){

                var SPMaskBehavior = function (val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                }, spOptions = {
                        onKeyPress: function(val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                };

                $('#telefone').mask(SPMaskBehavior, spOptions);
            }
        });

        $("#update").click(function(e){
            e.preventDefault();
            let id = $(this).val()
            $.ajax({
                 url: 'http://localhost:5500/api/v1/clientes/'+id,
                 method: 'PUT',
                 data: {
                     'nome': $("#nome").val(),
                     'endereco': $("#endereco").val(),
                     'telefone': $("#telefone").val(),
                     'idade'   : $("#idade").val(),
                     'filho'   :$("#filho").val()
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

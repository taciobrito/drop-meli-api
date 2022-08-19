@extends('layout')

@section('content')
    <h2>Autorizado com sucesso!</h2>

    <p>
        Usuário de teste:
    </p>

    <pre>
        <code>
            <?php print_r($dataUser); ?>
        </code>
    </pre>

    <p>
        <a href="/">Clique aqui</a> para ir para a lista de produtos.
    </p>
@endsection

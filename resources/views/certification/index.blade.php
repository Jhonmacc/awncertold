<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de Certificado</title>
    <!-- Inclua aqui links para CSS externo ou interno, se necessário -->
</head>
<body>
    <div class="container">
        <!-- Exibe mensagens de erro -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Exibe mensagem de sucesso -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/certification/validate') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="certificate">Certificado A1 (.pfx, .p12):</label>
                <input type="file" id="certificate" name="certificate" accept=".pfx,.p12" required>
            </div>
            <div>
                <label for="password">Senha do Certificado:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>

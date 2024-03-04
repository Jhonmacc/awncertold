@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalhes do Certificado</h2>
    <div>Nome: {{ $certInfo['name'] }}</div>
    <div>Validade: {{ date('d/m/Y', $certInfo['validTo_time_t']) }}</div>
    <div>Razão Social e CNPJ/CPF: {{ $certInfo['subject']['CN'] }}</div>
    <!-- Adicione mais detalhes conforme necessário -->

    <h3>Chave Pública</h3>
    <pre>{{ $publicKey }}</pre>

    <h3>Chave Privada</h3>
    <pre>{{ $privateKey }}</pre>
</div>
@endsection

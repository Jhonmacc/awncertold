@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Certificados</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Exibir mensagens de erro de validação -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário para upload do certificado -->
    <form action="{{ route('certification.validate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="certificate" class="form-label">Certificado (.pfx)</label>
            <input type="file" class="form-control" id="certificate" name="certificate" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha do Certificado</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    <hr>
    <div class="text-center mb-4">
        <h4>Legenda das Cores</h4>
        <div class="d-flex justify-content-center">
            <div class="px-3">
                <span class="badge bg-success">No Prazo</span>
            </div>
            <div class="px-3">
                <span class="badge bg-warning text-dark">Perto de Vencer</span>
            </div>
            <div class="px-3">
                <span class="badge bg-danger">Vencido</span>
            </div>
        </div>
    </div>
    <hr>
    <table id="certificates-table" class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Data</th>
                <th>Razão Social e CNPJ/CPF</th>
                <th>Dias para Vencimento</th>
            </tr>
        </thead>
        <tbody>

            @if (isset($certificates))
                @foreach ($certificates as $certificate)
                @php
                    $validTo = strtotime($certificate->validTo_time_t);
                    $daysUntilExpiry = ceil(($validTo - time()) / (60 * 60 * 24));
                    $bgColor = $daysUntilExpiry <= 0 ? 'red' : ($daysUntilExpiry <= 10 ? 'yellow' : 'green');
                    $fontColor = $daysUntilExpiry <= 0 || $daysUntilExpiry > 10 ? 'white' : 'black'; // Branco para vermelho e verde, preto para amarelo

                    // Tratamento do nome
                    preg_match('/CN=(.*?):\d+/', $certificate->name, $matches);
                    $cleanName = $matches[1] ?? 'Nome Indisponível';
                @endphp
                <tr>
                    <td>{{ $cleanName }}</td>
                    <td style="background-color: {{ $bgColor }}; color: {{ $fontColor }};">{{ date('d/m/Y', strtotime($certificate->validTo_time_t)) }}</td>
                    <td>{{ $certificate->cnpj_cpf }}</td>
                    <td>{{ $daysUntilExpiry }}</td>
                </tr>

            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#certificates-table').DataTable();
        });
    </script>
@endsection

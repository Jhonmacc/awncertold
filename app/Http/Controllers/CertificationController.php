<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CertificationController extends Controller
{

    public function index()
    {

        return view('certification.index');
    }

    public function validateCertification(Request $request)
    {
        $request->validate([
            'certificate' => 'required|file',
            'password' => 'required|string',
        ]);

        // Captura o arquivo e a senha do certificado do request
        $certificateFile = $request->file('certificate');
        $certPassword = $request->input('password');

        // Lê o conteúdo do arquivo do certificado
        $pfxContent = file_get_contents($certificateFile->getPathName());

        if (!openssl_pkcs12_read($pfxContent, $x509certdata, $certPassword)) {
            // Se não for possível ler o certificado com a senha fornecida, retorna um erro
            return back()->withErrors('O certificado não pode ser lido ou a senha está incorreta!');
        } else {
            // Descriptografa e processa o certificado
            $certInfo = openssl_x509_parse(openssl_x509_read($x509certdata['cert']));
            $publicKey = openssl_pkey_get_details(openssl_pkey_get_public($x509certdata['cert']))['key'];
            $privateKey = $x509certdata['pkey'];

            // Aqui você poderia armazenar o certificado no banco de dados,
            // ou fazer o que precisar com as informações descriptografadas

            // Para este exemplo, vamos apenas retornar os detalhes do certificado como uma view
            return view('certification.details', compact('certInfo', 'publicKey', 'privateKey'));
        }
    }
}

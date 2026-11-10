<?php

namespace App\Http\Controllers\Soap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibrarySoapController extends Controller
{
    public function wsdl()
    {
        $wsdl = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<definitions
    name="SIPUSLibraryService"
    targetNamespace="http://sipus-del.test/soap"
    xmlns="http://schemas.xmlsoap.org/wsdl/"
    xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
    xmlns:tns="http://sipus-del.test/soap"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema">

    <message name="CheckClearanceStatusRequest">
        <part name="nim_peminjam" type="xsd:string"/>
    </message>

    <message name="CheckClearanceStatusResponse">
        <part name="active_loans" type="xsd:int"/>
        <part name="is_cleared" type="xsd:boolean"/>
    </message>

    <portType name="LibrarySoapPortType">
        <operation name="CheckClearanceStatus">
            <input message="tns:CheckClearanceStatusRequest"/>
            <output message="tns:CheckClearanceStatusResponse"/>
        </operation>
    </portType>

    <binding name="LibrarySoapBinding" type="tns:LibrarySoapPortType">
        <soap:binding
            style="document"
            transport="http://schemas.xmlsoap.org/soap/http"/>
        <operation name="CheckClearanceStatus">
            <soap:operation soapAction="CheckClearanceStatus"/>
            <input>
                <soap:body use="literal"/>
            </input>
            <output>
                <soap:body use="literal"/>
            </output>
        </operation>
    </binding>

    <service name="SIPUSLibraryService">
        <port name="LibrarySoapPort" binding="tns:LibrarySoapBinding">
            <soap:address location="http://localhost:8000/soap/sipus"/>
        </port>
    </service>
</definitions>
XML;

        return response($wsdl, 200)
            ->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    
public function checkClearance(Request $request)
{
    libxml_use_internal_errors(true);

    $xml = simplexml_load_string($request->getContent());

    if ($xml === false) {
        return $this->soapFault('Client', 'XML tidak valid.');
    }

    $soapNamespace = 'http://schemas.xmlsoap.org/soap/envelope/';
    $serviceNamespace = 'http://sipus-del.test/soap';

    $envelope = $xml->children($soapNamespace);

    if (!isset($envelope->Body)) {
        return $this->soapFault('Client', 'SOAP Body tidak ditemukan.');
    }

    $body = $envelope->Body->children($serviceNamespace);

    if (!isset($body->CheckClearanceStatus)) {
        return $this->soapFault(
            'Client',
            'Operasi CheckClearanceStatus tidak ditemukan.'
        );
    }

    $operation = $body->CheckClearanceStatus;
    $parameters = $operation->children($serviceNamespace);

    $nim = trim((string) $parameters->nim_peminjam);

    if ($nim === '') {
        return $this->soapFault('Client', 'NIM peminjam wajib diisi.');
    }

    $activeLoans = DB::table('peminjamans')
        ->where('nim_peminjam', $nim)
        ->where('status', 'dipinjam')
        ->count();

    $isCleared = $activeLoans === 0 ? 'true' : 'false';

    $responseXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope
    xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:tns="http://sipus-del.test/soap">
    <soap:Body>
        <tns:CheckClearanceStatusResponse>
            <tns:active_loans>{$activeLoans}</tns:active_loans>
            <tns:is_cleared>{$isCleared}</tns:is_cleared>
        </tns:CheckClearanceStatusResponse>
    </soap:Body>
</soap:Envelope>
XML;

    return response($responseXml, 200)
        ->header('Content-Type', 'text/xml; charset=UTF-8');
}


    private function soapFault(string $code, string $message)
    {
        $safeMessage = htmlspecialchars(
            $message,
            ENT_XML1 | ENT_QUOTES,
            'UTF-8'
        );

        $faultXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope
    xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <soap:Fault>
            <faultcode>soap:{$code}</faultcode>
            <faultstring>{$safeMessage}</faultstring>
        </soap:Fault>
    </soap:Body>
</soap:Envelope>
XML;

        return response($faultXml, 400)
            ->header('Content-Type', 'text/xml; charset=UTF-8');
    }
}

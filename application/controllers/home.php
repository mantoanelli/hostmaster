<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_GenericController {

    public function __construct() {
        parent::__construct();

        //redirect('admin');


        require(DIR_UPLOADS . '../application/libraries/whm.php');

        /* $WHM = new WHM(true, '46.4.25.208', 'root', 'n3Yf4ZBD');
          $domain = 'rogeriomasterphp.com.br';
          $username = 'rogerphprogerio';
          $password = 'rogerio5362?';
          $email = 'rogeriofotovibe@gmail.com';
          $package = '';

          //$create = $WHM->create_account($domain , $username , $password , $email , $package);

          debug($WHM->list_packages());
          debug($WHM->show_load_avg());
          debug($WHM->list_accounts());
          //debug($WHM->change_password_account('rogerm','rogerio5362'));
          debug($WHM->get_host_name(),1); */
    }

    public function index() {
        debug('Home', 1);
    }

    public function gerarCobrancas() {
        debug($_SERVER['HTTP_USER_AGENT']);
        $objDominio = new UsuarioDominio();
        $dominios = $objDominio->getAll();
        $hoje = strtotime(now());
        foreach ($dominios['rows'] as $k => $v) {

            $ultimaCobranca = $v->getUltimaCobranca();
            $ultimaCobrancaLimiteTime = strtotime("{$v->getUltimaCobranca()} 00:00:00 +{$v->getPeriodoCobranca()} months");
            $dataHoje = date('d/m/Y');
            if ($hoje >= $ultimaCobrancaLimiteTime) {
                $user = new Usuario($v->getUsuarioId());
                $valor = $v->getValor() * $v->getPeriodoCobranca();
                $desconto = round(($valor * ($v->getDesconto() / 100)), 2);

                $dataVencimento = proximoDiaUtil(date('Y-m-d', strtotime(now(1) . ' 00:00:00 +2 days')));
                $vencimento = dataBr($dataVencimento);

                $descricao = 'Serviço de host - plano ' . $v->getPlano() . ' referente a ' . date('m/Y') . ' por ' . $v->getPeriodoCobranca() . ' mes(es)';

                //$urlBoleto = $this->geraBoleto($valor, $desconto, $vencimento, $user->getNome(), $descricao);
                $urlBoleto = "https://contagerencianet.com.br/fatura/leitura.php?lote=27782_20_LODRA2&chave=A4XB-27782-14873346-PALO4";

                $v->setUltimaCobranca($dataHoje);
                $v->save();

                $usuDomCob = new UsuarioDominioCobranca();
                $usuDomCob->setUsuarioDominioId($v->getId());
                $usuDomCob->setValor($valor - $desconto);
                $usuDomCob->setUrlBoleto($urlBoleto);
                $usuDomCob->setDataVencimento(dataDB($vencimento));
                $usuDomCob->save();

                debug($usuDomCob->_fields);
            }
        }
    }

    private function geraBoleto($valor, $desconto, $vencimento, $sacado, $descricao) {
        $ch = curl_init();

        $estruturaEnvio = 'xml';
        $estruturaResposta = 'xml';
        $metodo = 'boleto';
        $submetodo = 'emite';
        $url = 'https://v3.contagerencianet.com.br/rest/' . $estruturaEnvio . '/' . $metodo . '/' . $submetodo . '/' . $estruturaResposta;

        $xml = '
        <?xml version="1.0" encoding="utf-8"?>
        <boleto>
            <token>341b2dc488fd7de770766506027a6445</token>
            <clientes>
                <cliente>
                    <nomeRazaoSocial>' . $sacado .'</nomeRazaoSocial>
                </cliente>
            </clientes>
            <itens>
                <item>
                    <descricao>' . $descricao . '</descricao>
                    <valor>' . toNumber(currencyFormatAll($valor)) . '</valor>
                    <desconto>' . toNumber(currencyFormatAll($desconto)) . '</desconto>
                    <qtde>1</qtde>
                </item>
            </itens>
            <vencimento>' . $vencimento . '</vencimento>
        </boleto>';
        //debug(htmlentities($xml));
        $xml = str_replace("\n", '', $xml); //o xml não poderá conter quebras de linha
        $xml = str_replace("\r", '', $xml);
        $xml = str_replace("\t", '', $xml);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);

        $data = array('xml' => $xml);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'seu agente');

        $resposta = curl_exec($ch);
        curl_close($ch);
        
        $xmlResposta  = simplexml_load_string($resposta);
        if((string)$xmlResposta->statusCod == '2'){
            $linkBoleto = ($xmlResposta->resposta->cobrancasGeradas->cliente->cobranca->link);
        }else{
            $linkBoleto = ($xmlResposta->resposta->erros->errosGerais->erro->entrada->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->link);
        }
        return (string)$linkBoleto;
    }

}
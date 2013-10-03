<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Robo extends CI_GenericController {

    public function __construct() {
        parent::__construct();

    }

    public function index() {
        debug('Home', 1);
    }

   /* public function testeemail() {
        $this->load->library('myemail');
        $subject = 'Teste';
        $corpo = 'Teste de email';
        $emailDestino = 'rogerio@awdigital.com.br';
        $this->myemail->enviarAuth('mail@rogeriomaster.com', 'HostMaster', $subject, $corpo, $emailDestino, array('rogeriofotovibe@gmail.com'));
        debug('Home', 1);
    }*/

    public function gerarCobrancas() {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($agent, 'Wget') === FALSE) {
            //debug('Não le nada!',1);
        }
        $objDominio = new UsuarioDominio();
        $dominios = $objDominio->getAll();
        $hoje = strtotime(now());
        foreach ($dominios['rows'] as $k => $v) {

            $ultimaCobrancaLimiteTime = strtotime("{$v->getProximaCobranca()} 00:00:00");
            
            $dataHoje = date('d/m/Y');
            if ($hoje >= $ultimaCobrancaLimiteTime) {
                $user = $v->getUsuario();
                $valor = $v->getValor() * $v->getPeriodoCobranca();
                $desconto = round(($valor * ($v->getDesconto() / 100)), 2);
                $dataVencimento = proximoDiaUtil(date('Y-m-d', strtotime(now(1) . ' 00:00:00 +2 days')));
                $vencimento = dataBr($dataVencimento);
                $descricao = 'Serviço de host - plano ' . $v->getPlano() . ' referente a ' . date('m/Y') . ' por ' . $v->getPeriodoCobranca() . ' mes(es)';
                $urlBoleto = $this->geraBoleto($valor, $desconto, $vencimento, $user->getNome(), $descricao);
                $subject = 'Cobrança Host Master';
                $conteudoEmail = '
                    Segue abaixo o link para geração do boleto referente ao serviço: <ul><li>' . $descricao . ' - R$ ' . currencyFormatAll($valor - $desconto) . ' - Vencimento: ' . $vencimento . '</li></ul><hr>
                    Clique <a href="' . $urlBoleto . '">aqui</a> para gerar o boleto ou copie a url abaixo e cole em seu navegador.
                    <br><br>' . $urlBoleto;

                $tpl = file_get_contents(DIR_UPLOADS . '../application/views/templateEmail/padrao.php');
                $tpl = str_replace("{ASSUNTO}", $subject, $tpl);
                $tpl = str_replace("{CONTEUDO}", $conteudoEmail, $tpl);

                $this->load->library('myemail');
                $corpo = $tpl;
                $emailDestino = $user->getEmail();
                
                $this->myemail->enviarAuth('mail@rogeriomaster.com', 'Host Master', $subject, $corpo, $emailDestino, array('rogeriofotovibe@gmail.com'));
                
                $v->setProximaCobranca(date('Y-m-d',strtotime("{$v->getProximaCobranca()} 00:00:00 +{$v->getPeriodoCobranca()} months")));
                $v->setUltimaCobranca(dataDB($dataHoje));
                $v->save();

                $usuDomCob = new UsuarioDominioCobranca();
                $usuDomCob->setUsuarioDominioId($v->getId());
                $usuDomCob->setValor($valor - $desconto);
                $usuDomCob->setUrlBoleto($urlBoleto);
                $usuDomCob->setDataVencimento(dataDB($vencimento));
                $usuDomCob->save();
            }
            
        }
    }

    public function confirmaPagamentos($dataConsulta = null) {
        $processaOntem = false;
        if (!$dataConsulta) {
            $processaOntem = true;
            $dataConsulta = now(1);
        }
        debug($dataConsulta);
        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <faturasConfirmadasNoDia>
        <token>341b2dc488fd7de770766506027a6445</token>
        <data>' . $dataConsulta . '</data>
        </faturasConfirmadasNoDia>';
        $ch = curl_init();
        $xml = str_replace(array("\t", "\n", "\r"), "", $xml); //o xml não poderá conter quebras de linha
        $url = "https://v3.contagerencianet.com.br/rest/faturasConfirmadasNoDia";
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

        $xmlResposta = simplexml_load_string($resposta);
        $chaves = $xmlResposta->resposta->chaves;

        if (is_array($chaves)) {
            foreach ($chaves as $k => $v) {
                $urlBoleto = (string) $v->chave->url;
                $udc = new UsuarioDominioCobranca();
                $cobranca = $udc->getOne("url_boleto='$urlBoleto' AND status='pendente'");
                if ($cobranca) {
                    $cobranca->setStatus('pago');
                    $cobranca->setDataPagamento(now());
                    $cobranca->save();
                }
            }
        } else {
            $urlBoleto = (string) $chaves->chave->url;
            $udc = new UsuarioDominioCobranca();
            $cobranca = $udc->getOne("url_boleto='$urlBoleto'");
            if ($cobranca) {
                $cobranca->setStatus('pago');
                $cobranca->setDataPagamento(now());
                $cobranca->save();
            }
        }
        
        if($processaOntem){
            $dataConsulta = date('Y-m-d',  strtotime($dataConsulta. ' -1 days'));
            $this->confirmaPagamentos($dataConsulta);
        }
        exit;
    }

    public function inativaVencidos(){
        $udc = new UsuarioDominioCobranca();
        $dataHoje = now(1);
        $dataHojeTime = strtotime($dataHoje.' 00:00:00');
        
        $cobrancas = $udc->getAll("status='pendente' AND bloqueia_conta='1' AND data_vencimento < '{$dataHoje}'");
        foreach($cobrancas['rows'] as $k => $v){
            $dataVencimento = $v->getDataVencimento() . ' 00:00:00';
            $dataVencimentoTime = strtotime($dataVencimento);
            $dataSuspensao = proximoDiaUtil(date('Y-m-d',strtotime($dataVencimento.' +2 days'))) . ' 00:00:00';
            $dataSuspensaoTime = strtotime(proximoDiaUtil(date('Y-m-d',strtotime($dataVencimento.' +2 days'))));
            if($dataHojeTime > $dataSuspensaoTime){
                if($v->getUsuarioDominio()->getAccountCpanel()->suspended < 1)
                    $v->getUsuarioDominio()->suspend_account();
            }
        }
        exit;
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
                    <nomeRazaoSocial>' . $sacado . '</nomeRazaoSocial>
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

        $xmlResposta = simplexml_load_string($resposta);
        if ((string) $xmlResposta->statusCod == '2') {
            $linkBoleto = ($xmlResposta->resposta->cobrancasGeradas->cliente->cobranca->link);
        } else {
            $linkBoleto = ($xmlResposta->resposta->erros->errosGerais->erro->entrada->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->link);
        }
        return (string) $linkBoleto;
    }

}
<?php
function whmLogin(){
    require_once(DIR_UPLOADS . '../application/libraries/whm.php');
    return new WHM(true, '46.4.25.208', 'root', 'n3Yf4ZBD');
}
function setSubTituloForm($str) {

    $str = '<div class="head"><h5 class="iList">' . $str . '</h5></div>';
    return $str;
}

function getEstados() {
//$CI =& get_instance();
    $estado = new Estado();
    $estado = $estado->getAll(null, 'uf ASC');
    return array_to_select($estado['rows'], 'uf', 'uf');
}

function getPaises($first = false) {
    if ($first)
        $first = array('' => $first);

    $r = array(
        'África do Sul' => 'África do Sul',
        'Albânia' => 'Albânia',
        'Alemanha' => 'Alemanha',
        'Andorra' => 'Andorra',
        'Angola' => 'Angola',
        'Anguilla' => 'Anguilla',
        'Antigua' => 'Antigua',
        'Arábia Saudita' => 'Arábia Saudita',
        'Argentina' => 'Argentina',
        'Armênia' => 'Armênia',
        'Aruba' => 'Aruba',
        'Austrália' => 'Austrália',
        'Áustria' => 'Áustria',
        'Azerbaijão' => 'Azerbaijão',
        'Bahamas' => 'Bahamas',
        'Bahrein' => 'Bahrein',
        'Bangladesh' => 'Bangladesh',
        'Barbados' => 'Barbados',
        'Bélgica' => 'Bélgica',
        'Benin' => 'Benin',
        'Bermudas' => 'Bermudas',
        'Botsuana' => 'Botsuana',
        'Brasil' => 'Brasil',
        'Brunei' => 'Brunei',
        'Bulgária' => 'Bulgária',
        'Burkina Fasso' => 'Burkina Fasso',
        'botão' => 'botão',
        'Cabo Verde' => 'Cabo Verde',
        'Camarões' => 'Camarões',
        'Camboja' => 'Camboja',
        'Canadá' => 'Canadá',
        'Cazaquistão' => 'Cazaquistão',
        'Chade' => 'Chade',
        'Chile' => 'Chile',
        'China' => 'China',
        'Cidade do Vaticano' => 'Cidade do Vaticano',
        'Colômbia' => 'Colômbia',
        'Congo' => 'Congo',
        'Coréia do Sul' => 'Coréia do Sul',
        'Costa do Marfim' => 'Costa do Marfim',
        'Costa Rica' => 'Costa Rica',
        'Croácia' => 'Croácia',
        'Dinamarca' => 'Dinamarca',
        'Djibuti' => 'Djibuti',
        'Dominica' => 'Dominica',
        'EUA' => 'EUA',
        'Egito' => 'Egito',
        'El Salvador' => 'El Salvador',
        'Emirados Árabes' => 'Emirados Árabes',
        'Equador' => 'Equador',
        'Eritréia' => 'Eritréia',
        'Escócia' => 'Escócia',
        'Eslováquia' => 'Eslováquia',
        'Eslovênia' => 'Eslovênia',
        'Espanha' => 'Espanha',
        'Estônia' => 'Estônia',
        'Etiópia' => 'Etiópia',
        'Fiji' => 'Fiji',
        'Filipinas' => 'Filipinas',
        'Finlândia' => 'Finlândia',
        'França' => 'França',
        'Gabão' => 'Gabão',
        'Gâmbia' => 'Gâmbia',
        'Gana' => 'Gana',
        'Geórgia' => 'Geórgia',
        'Gibraltar' => 'Gibraltar',
        'Granada' => 'Granada',
        'Grécia' => 'Grécia',
        'Guadalupe' => 'Guadalupe',
        'Guam' => 'Guam',
        'Guatemala' => 'Guatemala',
        'Guiana' => 'Guiana',
        'Guiana Francesa' => 'Guiana Francesa',
        'Guiné-bissau' => 'Guiné-bissau',
        'Haiti' => 'Haiti',
        'Holanda' => 'Holanda',
        'Honduras' => 'Honduras',
        'Hong Kong' => 'Hong Kong',
        'Hungria' => 'Hungria',
        'Iêmen' => 'Iêmen',
        'Ilhas Cayman' => 'Ilhas Cayman',
        'Ilhas Cook' => 'Ilhas Cook',
        'Ilhas Curaçao' => 'Ilhas Curaçao',
        'Ilhas Marshall' => 'Ilhas Marshall',
        'Ilhas Turks & Caicos' => 'Ilhas Turks & Caicos',
        'Ilhas Virgens (brit.)' => 'Ilhas Virgens (brit.)',
        'Ilhas Virgens(amer.)' => 'Ilhas Virgens(amer.)',
        'Ilhas Wallis e Futuna' => 'Ilhas Wallis e Futuna',
        'Índia' => 'Índia',
        'Indonésia' => 'Indonésia',
        'Inglaterra' => 'Inglaterra',
        'Irlanda' => 'Irlanda',
        'Islândia' => 'Islândia',
        'Israel' => 'Israel',
        'Itália' => 'Itália',
        'Jamaica' => 'Jamaica',
        'Japão' => 'Japão',
        'Jordânia' => 'Jordânia',
        'Kuwait' => 'Kuwait',
        'Latvia' => 'Latvia',
        'Líbano' => 'Líbano',
        'Liechtenstein' => 'Liechtenstein',
        'Lituânia' => 'Lituânia',
        'Luxemburgo' => 'Luxemburgo',
        'Macau' => 'Macau',
        'Macedônia' => 'Macedônia',
        'Madagascar' => 'Madagascar',
        'Malásia' => 'Malásia',
        'Malaui' => 'Malaui',
        'Mali' => 'Mali',
        'Malta' => 'Malta',
        'Marrocos' => 'Marrocos',
        'Martinica' => 'Martinica',
        'Mauritânia' => 'Mauritânia',
        'Mauritius' => 'Mauritius',
        'México' => 'México',
        'Moldova' => 'Moldova',
        'Mônaco' => 'Mônaco',
        'Montserrat' => 'Montserrat',
        'Nepal' => 'Nepal',
        'Nicarágua' => 'Nicarágua',
        'Niger' => 'Niger',
        'Nigéria' => 'Nigéria',
        'Noruega' => 'Noruega',
        'Nova Caledônia' => 'Nova Caledônia',
        'Nova Zelândia' => 'Nova Zelândia',
        'Omã' => 'Omã',
        'Palau' => 'Palau',
        'Panamá' => 'Panamá',
        'Papua-nova Guiné' => 'Papua-nova Guiné',
        'Paquistão' => 'Paquistão',
        'Paraguai' => 'Paraguai',
        'Peru' => 'Peru',
        'Polinésia Francesa' => 'Polinésia Francesa',
        'Polônia' => 'Polônia',
        'Porto Rico' => 'Porto Rico',
        'Portugal' => 'Portugal',
        'Qatar' => 'Qatar',
        'Quênia' => 'Quênia',
        'Rep. Dominicana' => 'Rep. Dominicana',
        'Rep. Tcheca' => 'Rep. Tcheca',
        'Reunion' => 'Reunion',
        'Romênia' => 'Romênia',
        'Ruanda' => 'Ruanda',
        'Rússia' => 'Rússia',
        'Saipan' => 'Saipan',
        'Samoa Americana' => 'Samoa Americana',
        'Senegal' => 'Senegal',
        'Serra Leone' => 'Serra Leone',
        'Seychelles' => 'Seychelles',
        'Singapura' => 'Singapura',
        'Síria' => 'Síria',
        'Sri Lanka' => 'Sri Lanka',
        'St. Kitts & Nevis' => 'St. Kitts & Nevis',
        'St. Lúcia' => 'St. Lúcia',
        'St. Vincent' => 'St. Vincent',
        'Sudão' => 'Sudão',
        'Suécia' => 'Suécia',
        'Suiça' => 'Suiça',
        'Suriname' => 'Suriname',
        'Tailândia' => 'Tailândia',
        'Taiwan' => 'Taiwan',
        'Tanzânia' => 'Tanzânia',
        'Togo' => 'Togo',
        'Trinidad & Tobago' => 'Trinidad & Tobago',
        'Tunísia' => 'Tunísia',
        'Turquia' => 'Turquia',
        'Ucrânia' => 'Ucrânia',
        'Uganda' => 'Uganda',
        'Uruguai' => 'Uruguai',
        'Venezuela' => 'Venezuela',
        'Vietnã' => 'Vietnã',
        'Zaire' => 'Zaire',
        'Zâmbia' => 'Zâmbia',
        'Zimbábue' => 'Zimbábue',
    );
    if ($first)
        $r = array_merge($first, $r);
    return $r;
}

function getImgExtensao($ext) {

    $exts = array(
        'pdf' => 'pdf.png',
        'doc' => 'word.png',
        'docx' => 'word.png',
        'xls' => 'excel.png',
        'xlsx' => 'excel.png',
        'pptx' => 'ppt.png',
        'zip' => 'zip.png',
        'rar' => 'zip.png',
        'mov' => 'mov.png',
        'wav' => 'audio.png',
        'mp3' => 'audio.png',
        'txt' => 'text.png',
    );

    return $exts[strtolower($ext)];
}

function __autoload($class_name) {
    $CI = & get_instance();
    $class_name = str_replace("_", "", $class_name);
    $pathClass = dirname(__FILE__) . '/../models/' . $class_name . 'Model.php';
    if (file_exists($pathClass)) {
        include_once $pathClass;
    }
}

function formataNomeCampo($campo) {
    $retorno = '';
    $campoArr = explode('_', $campo);
    foreach ($campoArr as $v) {
        $retorno .= ucfirst($v);
    }
    return $retorno;
}

function curl_redirect_exec($ch, &$redirects = 1, $curlopt_header = false) {
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    $data = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code == 301 || $http_code == 302) {

        list($header) = explode("\r\n\r\n", $data, 2);
        $matches = array();
//this part has been changes from the original
        preg_match("/(Location:|URI:)[^(\n)]*/", $header, $matches);
        $url = trim(str_replace($matches[1], "", $matches[0]));
//end changes
        $url_parsed = parse_url($url);
        if (isset($url_parsed)) {
            curl_setopt($ch, CURLOPT_URL, $url);
            $redirects++;
            return curl_redirect_exec($ch, $redirects);
        }
    }
    if ($curlopt_header)
        return $data;
    else {
        list(, $body) = explode("\r\n\r\n", $data, 2);
        return $body;
    }
}

function curl_exec_follow(/* resource */ $ch, /* int */ &$maxredirect = null) {
    $mr = $maxredirect === null ? 5 : intval($maxredirect);
    if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);
        curl_setopt($ch, CURLOPT_MAXREDIRS, $mr);
    } else {
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        if ($mr > 0) {
            $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

            $rch = curl_copy_handle($ch);
            curl_setopt($rch, CURLOPT_HEADER, true);
            curl_setopt($rch, CURLOPT_NOBODY, true);
            curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
            curl_setopt($rch, CURLOPT_RETURNTRANSFER, true);
            do {
                curl_setopt($rch, CURLOPT_URL, $newurl);
                $header = curl_exec($rch);
                if (curl_errno($rch)) {
                    $code = 0;
                } else {
                    $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                    if ($code == 301 || $code == 302) {
                        preg_match('/Location:(.*?)\n/', $header, $matches);
                        $newurl = trim(array_pop($matches));
                    } else {
                        $code = 0;
                    }
                }
            } while ($code && --$mr);
            curl_close($rch);
            if (!$mr) {
                if ($maxredirect === null) {
                    trigger_error('Too many redirects. When following redirects, libcurl hit the maximum amount.', E_USER_WARNING);
                } else {
                    $maxredirect = 0;
                }
                return false;
            }
            curl_setopt($ch, CURLOPT_URL, $newurl);
        }
    }
    return curl_exec($ch);
}

function rmdirr($diretorio) {
    $folder = opendir($diretorio);

    while ($item = readdir($folder)) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (is_dir("{$diretorio}/{$item}")) {
            rmdirr("{$diretorio}/{$item}");
        } else {
            unlink("{$diretorio}/{$item}");
        }
        @rmdir("$diretorio/$item");
    }
    @rmdir("$diretorio");
}

function copiar_diretorio($diretorio, $destino, $ver_acao = false) {
    if ($destino{strlen($destino) - 1} == '/') {
        $destino = substr($destino, 0, -1);
    }
    if (!is_dir($destino)) {
        if ($ver_acao) {
            echo "Criando diretorio {$destino}\n";
        }
        mkdir($destino);
        chmod($destino, 0777);
    }

    $folder = opendir($diretorio);

    while ($item = readdir($folder)) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (is_dir("{$diretorio}/{$item}")) {
            copiar_diretorio("{$diretorio}/{$item}", "{$destino}/{$item}", $ver_acao);
        } else {
            if ($ver_acao) {
                echo "Copiando {$item} para {$destino}" . "\n";
            }
            copy("{$diretorio}/{$item}", "{$destino}/{$item}");
            chmod("{$destino}/{$item}", 0777);
        }
    }
}

function cleanDB() {
    $CI = & get_instance();
    $sql = "SHOW PROCESSLIST";
    $query = $CI->db->query($sql);
    foreach ($query->result() as $row) {
        if ($row->Time > 100 && $row->db == $CI->db->database) {
//debug($row);
            $CI->db->query("KILL {$row->Id}");
        }
    }
}

function RemoveCookieLive($name) {
    unset($_COOKIE[$name]);
    return setcookie($name, NULL, -1);
}

function getPaginationGrid($per_page = 10, $total_rows = 100, $configAlt = '') {
    $CI = & get_instance();
    $CI->load->library('pagination');
    $directory = $CI->router->fetch_directory();
    $controller = $CI->router->fetch_class();
    $method = $CI->router->fetch_method();
    $querystring = ($_SERVER['QUERY_STRING']) ? "?{$_SERVER['QUERY_STRING']}" : "";

    $config['base_url'] = str_replace($CI->config->item('url_suffix'), '', site_url("$directory/$controller/$method"));
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['suffix'] = "/{$CI->_data['limitPerPage']}/{$CI->_data['orderField']}/{$CI->_data['order']}{$CI->config->item('url_suffix')}{$querystring}";
    $config['num_links'] = 3;
    $config['uri_segment'] = 4;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="currentPage"><span>';
    $config['cur_tag_close'] = '</span></li>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['first_link'] = '<<';
    $config['last_link'] = '>>';
    $config['first_url'] = $config['base_url'] . $querystring;

    if (!empty($configAlt)) {
        $config = array_merge($config, $configAlt);
    }

    $CI->pagination->initialize($config);
    return $CI->pagination->create_links();
}

function statusMailing($str) {
    $sts = array(
        '0' => 'cross.png',
        '1' => 'accept.png',
        '2' => 'alert.png'
    );

    return '<img src="' . base_url() . 'images/admin/' . $sts[$str] . '" align="absmiddle" />';
}

function isFileExist($path, $qtd = '1') {
    $file = end(explode('/', $path));
    $ext = end(explode('.', $file));
    $name = current(explode('.', $file));

    $pathNew = str_replace($file, "", $path);
    if (file_exists($path)) {
        $qtdAnt = $qtd - 1;
        $name = str_replace("[{$qtdAnt}]", "", $name);
        return isFileExist($pathNew . $name . '[' . $qtd . '].' . $ext, $qtd + 1);
    } else {
        return $path;
    }
}

function limpaPost($post) {
//debug($post);
    foreach ($post as $k => $v):
        if (is_array($v)) {
//debug($v);
            $post[$k] = limpaPost($v);
        } else {
            $post[$k] = addslashes($v);
        }
    endforeach;
    return $post;
}

function moeda2float($n) {
    if (strpos($n, ',') === FALSE) {
        return $n;
    }
    $n = str_replace(".", "", $n);
    $n = str_replace(",", ".", $n);
    return $n;
}

function SimNaoOptions() {

    $arr[1] = 'Sim';
    $arr[0] = 'Não';
    return $arr;
}

function SimNaoRadio($name, $value = '', $extra = '') {
    $html = form_radio($name, 1, ($value == '1' ? TRUE : FALSE), $extra) . '<font>Sim</font>';
    $html .= form_radio($name, 0, ($value == '0' ? TRUE : FALSE), $extra) . '<font>Não</font>';
    return $html;
}

function my_date_diff($start, $end = "NOW", $return = 'days') {
    if ($end == null)
        $end = "NOW +2 seconds";
    $sdate = strtotime($start);
    $edate = strtotime($end);
    $time = $edate - $sdate;
    $pday = ($time) / 86400;
    $pmonth = ($time) / 86400 / 30;


    if ($return == 'days')
        $r = explode('.', $pday);
    elseif ($return == 'months')
        $r = explode('.', $pmonth);
    elseif ($return == 'mktime')
        $r[0] = $time;

    return $r[0];
}

function timeToNumber($time, $return = 'hours') {
    if ($time) {
        $arr = explode(":", $time);

        if ($return == 'hours') {
            $horas = ceil($arr[0]);
            $minutos = ($arr[1] / 60);
            $segundos = ($arr[2] / 3600);
            $time = $horas + $minutos + $segundos;
        } elseif ($return == 'minutes') {
            $horas = ($arr[0] * 60);
            $minutos = ($arr[1]);
            $segundos = ($arr[2] / 60);
            $time = $horas + $minutos + $segundos;
        }
    }
    return $time;
}

function decimalToTime($n, $r = 'h') {
    $minutos = floor(('0.' . end(explode('.', $n))) * 60);
    $horas = current(explode('.', $n));
    $time = array('h' => $horas, 'm' => $minutos);

    return $time[$r];
}

function decimalToFloat($n) {
    $r = str_replace(".", "", $n);
    $r = str_replace(",", ".", $r);

    return $r;
}

function timeToDecimal($time) {
    $decimais = end(explode(".", (end(explode(':', $time)) / 60)));
    $inteiros = current(explode(':', $time));
    return $inteiros . "." . $decimais;
}

function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function close_db() {
    $CI = & get_instance();
    $CI->db->close();
}

function getValueParamByData($nome, $data, $exact = false) {
    $CI = & get_instance();

    $op = ($exact) ? '=' : '>=';

    $sql = "
	SELECT
	  psv.psv_valor as value
	FROM
	  parametros_sistema ps
	  INNER JOIN parametros_sistema_valores psv ON (ps.par_id = psv.psv_par_id)
	WHERE
	  ps.par_nome_sistema = '{$nome}' AND
	  '{$data}' {$op} psv.psv_data_inicio AND
	  psv.psv_delete = 1
	  ORDER BY psv.`psv_data_inicio` DESC
	  LIMIT 1
			";
    $query = $CI->db->query($sql);

    if ($query->num_rows() > 0) {
        $row = $query->result();
        return $row[0]->value;
    } else {
        return '0';
    }
}

function validaEmail($mail) {
    if (preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/", $mail)) {
        return true;
    } else {
        return false;
    }
}

function getValueParamByDataOp($nome, $data, $op = '>=') {
    $CI = & get_instance();

    $sql = "
	SELECT
	  psv.psv_valor as value
	FROM
	  parametros_sistema ps
	  INNER JOIN parametros_sistema_valores psv ON (ps.par_id = psv.psv_par_id)
	WHERE
	  ps.par_nome_sistema = '{$nome}' AND
	  psv.psv_data_inicio  {$op} '{$data}'  AND
	  psv.psv_delete = 1
	  ORDER BY psv.`psv_data_inicio` DESC
	  LIMIT 1
			";
    $query = $CI->db->query($sql);

    if ($query->num_rows() > 0) {
        $row = $query->result();
        return $row[0]->value;
    } else {
        return '0';
    }
}

function getNomeMes($n) {
    $mes[1] = 'Janeiro';
    $mes[2] = 'Fevereiro';
    $mes[3] = 'Março';
    $mes[4] = 'Abril';
    $mes[5] = 'Maio';
    $mes[6] = 'Junho';
    $mes[7] = 'Julho';
    $mes[8] = 'Agosto';
    $mes[9] = 'Setembro';
    $mes[10] = 'Outubro';
    $mes[11] = 'Novembro';
    $mes[12] = 'Dezembro';

    return $mes[$n];
}

function getValue($strChave, $array) {
    foreach (explode('.', $strChave) as $chave) {
        if (isset($array[$chave]) && is_array($array[$chave]))
            $array = $array[$chave];
        else
            return $array[$chave];
    }

    return null;
}

function isFieldArray($arr, $field) {


    if (is_array($field)) {

        foreach ($field as $v) {

            if (strpos($v, ".") !== FALSE) {
                $campo = str_replace(".", "_", $v);
                $campo = explode("_", $campo);
                $qtd = count($campo);
                if ($qtd == 4) {
                    $valor[] = $arr[$campo[0]][$campo[1]][$campo[2]][$campo[3]];
                } elseif ($qtd == 3) {
                    $valor[] = $arr[$campo[0]][$campo[1]][$campo[2]];
                } elseif ($qtd == 2) {
                    $valor[] = $arr[$campo[0]][$campo[1]];
                }
            } else {
                $valor[] = $arr[$v];
            }
        }
        $valor = implode(' - ', $valor);
    } else {
        if (strpos($field, ".") !== FALSE) {
            $campo = str_replace(".", "_", $field);
            $campo = explode("_", $campo);
            $qtd = count($campo);
            if ($qtd == 4) {
                $valor = $arr[$campo[0]][$campo[1]][$campo[2]][$campo[3]];
            } elseif ($qtd == 3) {
                $valor = $arr[$campo[0]][$campo[1]][$campo[2]];
            } elseif ($qtd == 2) {
                $valor = $arr[$campo[0]][$campo[1]];
//debug($campo);
            }
        } else {
            $valor = $arr[$field];
        }
    }
// debug($valor);
//debug("&nbsp;");
    return $valor;
}

function _rmdirr($dir) {
    if (!file_exists($dir))
        return false;

    if (is_file($dir) || is_link($dir))
        return unlink($dir);

    $dir = dir($dir);
    while (false !== $entry = $dir->read()) {
        if ($entry == '.' || $entry == '..')
            continue;

        rmdirr($dir . DIRECTORY_SEPARATOR . $entry);
    }

    $dir->close();
    return rmdir($dir);
}

function trataValorNegativo($valor) {
    if (!$valor) {
        return '0.00';
    } else {
        $valor2 = str_replace("-", "", $valor);
        $valor2 = str_replace(".", "", $valor2);
        $valor2 = str_replace(",", ".", $valor2);
        if (strpos($valor, "-") !== false) {

            $valor2 = number_format($valor2, 2, '.', '');
            $valor2 = "-" . $valor2;
            return $valor2;
        } else {
            return $valor2;
        }
    }
}

function trataValorDecimal($valor) {

    return trataValorNegativo($valor);
}

function convertClassName($str) {
    $r = "";
    $str = str_replace("_id", "", $str);
    $str = explode("_", $str);
    foreach ($str as $v) {
        $r .= ucfirst($v);
    }
    return $r;
}

function getAllByClass($className, $where = null, $order = null) {
    $pathClass = dirname(__FILE__) . '/../models/' . $className . 'Model.php';
    if (file_exists($pathClass)) {
        $obj = new $className();
        $regs = $obj->getAll($where, $order);
        return $regs['rows'];
    } else {
        return false;
    }
}

function array_to_select($rows, $value, $label, $first = null) {
    $retorno = array();

    if ($first) {
        $retorno[""] = $first;
    }
    foreach ($rows as $k => $v) {
        $namevalue = "get" . $value;
        $namelabel = "get" . $label;
        $retorno[$v->$namevalue()] = $v->$namelabel();
    }

    return $retorno;
}
function array_to_select_model($model, $value, $label, $first=null,$whr=''){
    $obj = new $model();
    $rows = $obj->getAll($whr);
    return array_to_select($rows['rows'], $value, $label, $first);
}
function array_to_radios($name, $arr, $selected = false, $extra = '') {
    $r = '';

    foreach ($arr as $k => $v) {
        $r .= "<lable><input type='radio' name='{$name}' value='{$k}' " . (($selected == $k) ? "checked='checked'" : "") . " {$extra}>{$v} </label> &nbsp; &nbsp; ";
    }

    return $r;
}

function formatCompetencia($data) {
    $data = explode("-", $data);

    return translateMouth($data[1]) . '/' . $data[0];
}

function array_compare($array1, $array2) {
    $diff = false;
// Left-to-right
    if (is_array($array1) && count($array1) > 0 && is_array($array2) && count($array2) > 0) {
        foreach ($array1 as $key => $value) {
            if (!array_key_exists($key, $array2)) {
                $diff[0][$key] = $value;
            } elseif (is_array($value)) {
                if (!is_array($array2[$key])) {
                    $diff[0][$key] = $value;
                    $diff[1][$key] = $array2[$key];
                } else {
                    $new = array_compare($value, $array2[$key]);
                    if ($new !== false) {
                        if (isset($new[0]))
                            $diff[0][$key] = $new[0];
                        if (isset($new[1]))
                            $diff[1][$key] = $new[1];
                    };
                };
            } elseif ($array2[$key] !== $value) {
                $diff[0][$key] = $value;
                $diff[1][$key] = $array2[$key];
            };
        };
// Right-to-left
        foreach ($array2 as $key => $value) {
            if (!array_key_exists($key, $array1)) {
                $diff[1][$key] = $value;
            };
        };
    }
    return $diff;
}

function now($notime = null) {
    if ($notime)
        return date('Y-m-d');
    else
        return date('Y-m-d H:i:s');
}

function arrayKeysEqualValues($arr) {
    $newArr = array();
    foreach ($arr as $v) {
        $newArr[$v] = $v;
    }
    return $newArr;
}

function show_enum_values($table, $field, $first = null, $not = null) {
    $CI = & get_instance();
    $query = $CI->db->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'");
    $row = $query->result();
    $enum = str_replace("enum(", "", $row[0]->Type);
    $enum = str_replace("'", "", $enum);
    $enum = substr($enum, 0, strlen($enum) - 1);
    $enum = explode(",", $enum);
    if ($not) {
        foreach ($enum as $chave => $campo) {
            foreach ($not as $tirar) {
                if ($campo == $tirar) {
                    unset($enum[$chave]);
                }
            }
        }
    }
    $r = array();
    if ($first) {
        $r[''] = $first;
    }
    foreach ($enum as $chave => $campo) {
        $campo = trim($campo);
        $r[$campo] = $campo;
    }
    return $r;
}

function getController() {
    $CI = & get_instance();
    return $CI->router->fetch_class();
}

function linkTitle($text, $title, $after = '', $last = '') {
    $CI = & get_instance();

//exit(substr($CI->router->fetch_directory(), strlen($CI->router->fetch_directory())));

    $url = $CI->router->fetch_directory() . $CI->router->fetch_class() . '/' . $CI->router->fetch_method() . '/';

    $url.= $after;
    if (isset($CI->data)) {
        $url.= ( isset($CI->data['page']) ? $CI->data['page'] . '/' : '') . (isset($CI->data['limitPerPage']) ? $CI->data['limitPerPage'] . '/' : '') . $title['field'] . '/' . $title['order'];
    }
    $url.= $last;

    if ($title['orderBy']) {
        $value = '<b>' . $text . '</b>';
        $classStyle = 'class="lista_' . ($title['order'] == 'asc' ? 'asc' : 'desc') . '" ';
    } else {
        $value = $text;
        $classStyle = '';
    }

    return anchor($url, $value, $classStyle, $_SERVER['QUERY_STRING'] == '' ? '' : '?' . $_SERVER['QUERY_STRING']);
}

function getLinkOrder($orderBy, $order) {
    $CI = & get_instance();

    if (isset($CI->data)) {
        $uri = $CI->router->fetch_directory() . $CI->router->fetch_class() . '/' . $CI->router->fetch_method();


        $query_string = $_SERVER['QUERY_STRING'] == '' ? '' : '?' . $_SERVER['QUERY_STRING'];

        $extra = '/' . (($CI->data['limitPerPage']) ? $CI->data['limitPerPage'] : 10) . '/' . $orderBy . '/' . $order;
        $link = $uri . "/1" . $extra . $query_string;
        return site_url() . $link;
    }
}

function pagination() {

    $CI = & get_instance();
    $order = $CI->data['orderBy'];

    $uri = $CI->router->fetch_directory() . $CI->router->fetch_class() . '/' . $CI->router->fetch_method();
    $extra = '/' . $CI->data['limitPerPage'] . '/' . $CI->data['orderBy'] . '/' . $CI->data['order'];
    $queryString = $_SERVER['QUERY_STRING'] == '' ? '' : '?' . $_SERVER['QUERY_STRING'];

    echo "<div class=\"div2\" style=\"margin: 0 auto; padding-top: 2px\">";
    if (isset($CI->data) && $CI->data['nPages'] > 1) {
        if ($CI->data['page'] == 1)
            echo '<span style="margin-left: 2px; padding: 1px 5px;"> << primeiro </span>';
        else {
            $classes = array('class' => 'lk_prev');
            echo anchor($uri . '/1' . $extra, ' << primeiro', $classes, $queryString) . ' ';
        }

        if ($CI->data['page'] == 1)
            echo '<span style="margin-left: 2px; padding: 1px 5px;"> < anterior </span>';
        else {
            $classes = array('class' => 'lk_prev');
            echo anchor($uri . '/' . ($CI->data['page'] - 1) . $extra, ' < anterior', $classes, $queryString) . ' ';
        }

        $inicio = $CI->data['page'] + 2 >= $CI->data['nPages'] ? ($CI->data['nPages'] - 4 <= 0 ? 1 : $CI->data['nPages'] - 4) : ($CI->data['page'] - 2 <= 1 ? 1 : $CI->data['page'] - 2);

        if ($inicio != 1)
            echo ' ... ';

        for ($i = $inicio; $i < $inicio + 5 && $i <= $CI->data['nPages']; $i++)
            if ($CI->data['page'] == $i) {
                echo '<a class="selected" href="javascript:;">' . $i . '</a> ';
            } else {
                echo anchor($uri . '/' . $i . $extra, $i, '', $queryString) . ' ';
            }

        if ($inicio + 4 < $CI->data['nPages'])
            echo ' ... ';

        if ($CI->data['page'] == $CI->data['nPages'])
            echo '<span style="margin-left: 2px; padding: 1px 5px;"> próximo > </span>';
        else {
            $classes = array('class' => 'lk_next');
            echo anchor($uri . '/' . ($CI->data['page'] + 1) . $extra, 'próximo > ', $classes, $queryString) . ' ';
        }

        if ($CI->data['page'] == $CI->data['nPages'])
            echo '<span style="margin-left: 2px; padding: 1px 5px;"> &uacute;ltimo >> </span>';
        else {
            $classes = array('class' => 'lk_next');
            echo anchor($uri . '/' . $CI->data['nPages'] . $extra, '&uacute;ltimo >> ', $classes, $queryString) . ' ';
        }
    }

    if ($CI->data['limitPerPage'] == 999999999) {
        echo '<span style="margin-left: 2px; padding: 1px 5px;">Total de <strong>' . $CI->data['listagem']['total'] . '</strong> registros</span>';
//debug($CI->data['listagem']);
    }
    $selectLimit = array(30 => 30, 60 => 60, 90 => 90, 120 => 120, 200 => 200, 500 => 500, 999999999 => 'todos');
//$selectLimit[$CI->data['limitPerPage']] = " selected=\"selected\" ";
    $optionsPaginacao = "<div class=\"div4\" style=\"float:right\">Registros por p&aacute;gina: &nbsp;<select class=\"selectLimitPagination\">";
    foreach ($selectLimit as $k => $v) {
        $optionsPaginacao .= "<option " . (($CI->data['limitPerPage'] == $k) ? " selected=\"selected\" " : "") . " value=\"{$k}\" href=\"" . site_url($uri . '/1/' . $k . '/' . $CI->data['orderBy'] . '/' . $CI->data['order']) . $queryString . "\">{$v}</option>";
    }
    $optionsPaginacao .= "</select></div>";
    echo $optionsPaginacao;
    echo "</div>";
}

function trace($data) {
    ob_start();
    echo '<script type="text/javascript">';
    echo 'if (console != null) console.log("' . str_replace("\n", '\\n', addslashes(var_export($data, TRUE))) . '");';
    echo '</script>';
}

function redirectAlert($msg, $url) {
    echo '<script>alert("' . $msg . '");document.location.href="' . $url . '"</script>';
    exit();
}

function debug($data, $exit = null) {
    ob_start();
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($exit)
        exit;
}

function search_url() {
    $CI = & get_instance();

    return site_url($CI->router->fetch_directory() . $CI->router->fetch_class() . '/' . $CI->router->fetch_method() . '/' .
            $CI->data['page'] . '/' . $CI->data['limitPerPage'] . '/' . $CI->data['orderBy'] . '/' . $CI->data['order']);
}

function secToHour($sec, $saida = 'time') {
//debug($sec);
    if ($sec > 0) {
        $hour = $sec / 60 / 60;
        if ($saida == 'decimal') {
            $hour = number_format($hour, 2, ',', '');
        } elseif ($saida == 'float') {
            $hour = number_format($hour, 2, '.', '');
        } elseif ($saida == 'time') {
            $hour = formata_hora($sec);
        }
    } else {
        $hour = 0;
    }
    return $hour;
}

function formata_hora($tempo, $label = false) {
    $hora = (strpos($tempo, "-") !== FALSE) ? ceil($tempo / 3600) : floor($tempo / 3600);
    $minuto = floor(($tempo % 3600) / 60);

//$hora = ($hora < 10)?"0".$hora:$hora;
//$minuto = ($minuto < 10)?"0".$minuto:$minuto;
    if ($minuto == 0) {
//$minuto="00";
    }

    if ($label == true) {
        if (strpos($tempo, "-") !== FALSE) {
#$ret = str_replace("-","",$hora.":".$minuto);
            $ret = $hora . ":" . $minuto;
            if ($minuto == 0) {
                $minuto = "00";
            }
            return "<span style='color:red;'>" . $hora . ":" . str_replace("-", "", $minuto) . "</span>";
        }
    }

    $minuto = str_replace("-", "", $minuto);
    $sinal = "";
    if (strpos($hora, '-') !== FALSE) {
        $sinal = "-";
    }

    $minuto = str_replace("-", "", $minuto);
    $hora = str_replace("-", "", $hora);

    $hora = ($hora < 10) ? "0" . $hora : $hora;
    $minuto = ($minuto < 10) ? "0" . $minuto : $minuto;

    return $sinal . $hora . ":" . $minuto;
}

function escreveMesAno($date) {
    $date = explode(' ', $date);
    $date = explode('-', $date[0]);
    return translateMouth($date[1]) . '/' . $date[0];
}

function translateMouth($a, $abrev = false) {

    switch ($a) {
        case '01':
            $mes = 'janeiro';
            break;
        case '02':
            $mes = 'fevereiro';
            break;
        case '03':
            $mes = 'marco';
            break;
        case '04':
            $mes = 'abril';
            break;
        case '05':
            $mes = 'maio';
            break;
        case '06':
            $mes = 'junho';
            break;
        case '07':
            $mes = 'julho';
            break;
        case '08':
            $mes = 'agosto';
            break;
        case '09':
            $mes = 'setembro';
            break;
        case '10':
            $mes = 'outubro';
            break;
        case '11':
            $mes = 'novembro';
            break;
        case '12':
            $mes = 'dezembro';
            break;
    }
    return ($abrev) ? substr($mes, 0, 3) : $mes;
}

function format_date_to_form($str, $saida = "d/m/Y") {
    if (preg_match('/[a-z]/i', $str)) {
        return $str;
    } else {
        if (!empty($str) and $str != "0000-00-00 00:00:00") {
            return date($saida, strtotime($str));
        } else {
            if (!empty($saida)) {
                return;
            } else {
                return "--";
            }
        }
    }
}

function printAvaliacaoPost($nota) {
    $total = 5;
    $r = '';
    $cheia = floor($nota / 2);
    $meia = ($nota % 2);
    $vazia = $total - ($cheia + $meia);
    $r .= str_repeat('<div class="estrela cheia"></div>', $cheia);
    $r .= str_repeat('<div class="estrela meia"></div>', $meia);
    $r .= str_repeat('<div class="estrela vazia"></div>', $vazia);
    return $r;
}

function dataBr($str, $saida = 'd/m/Y') {
    return format_date_to_form($str, $saida);
}

function dataDB($str) {
    return format_date_to_db($str, 1);
}

function dataHoraDB($str) {
    $str = explode(' ', $str);
    $data = dataDB($str[0]);
    $hora = $str[1];
    return $data . " " . $hora;
}

function dataHoraBr($str, $saida = 'd/m/Y H:i:s') {
    return format_date_to_form($str, $saida);
}

function getTrimestre($arrDate) {
    $month = $arrDate[1];
    $day = $arrDate[0];
    $year = $arrDate[2];
    $dataEmissao = mktime(0, 0, 0, $month, $day, $year);

    $trimestres = array(
        '1' => array(mktime(0, 0, 0, 1, 1, $year), mktime(0, 0, 0, 3, 31, $year)),
        '2' => array(mktime(0, 0, 0, 4, 1, $year), mktime(0, 0, 0, 6, 30, $year)),
        '3' => array(mktime(0, 0, 0, 7, 1, $year), mktime(0, 0, 0, 9, 30, $year)),
        '4' => array(mktime(0, 0, 0, 10, 1, $year), mktime(0, 0, 0, 12, 31, $year)),
    );

    foreach ($trimestres as $k => $v) {
        if ($dataEmissao >= $v[0] && $dataEmissao <= $v[1]) {
            return $k . '/' . $year;
            $dateStart = date('d/m/Y', $v[0]);
            $dateEnd = date('d/m/Y', $v[1]);
            $dataFim = explode("/", $dateEnd);
            $dataVencimento = date('d/m/Y', strtotime(getUltimoDiaUtil(date('Y-m-d', mktime(0, 0, 0, $dataFim[1] + 1, 1, $dataFim[2])))));
//$dataVencimento = date('d/m/Y',mktime(0, 0, 0, $dataFim[1]+1, 30, $dataFim[2]));
        }
    }
}

function getTrimestreRange($n, $year) {
    $trimestres = array(
        '1' => array(mktime(0, 0, 0, 1, 1, $year), mktime(0, 0, 0, 3, 31, $year)),
        '2' => array(mktime(0, 0, 0, 4, 1, $year), mktime(0, 0, 0, 6, 30, $year)),
        '3' => array(mktime(0, 0, 0, 7, 1, $year), mktime(0, 0, 0, 9, 30, $year)),
        '4' => array(mktime(0, 0, 0, 10, 1, $year), mktime(0, 0, 0, 12, 31, $year)),
    );
    return $trimestres[$n];
}

function format_date_to_form_full($str, $saida = "d/m/Y H:i:s") {
    if (preg_match('/[a-z]/i', $str)) {
        return $str;
    } else {
        if (!empty($str) and $str != "0000-00-00 00:00:00") {
            return date($saida, strtotime($str));
        } else {
            if (!empty($saida)) {
                return;
            } else {
                return "--";
            }
        }
    }
}

function clear_str($StrAux) {
    $StrAux = trim(str_ireplace("'", "", $StrAux));
    $StrAux = str_ireplace("'", "''", $StrAux);
    $StrAux = str_ireplace("#", "''", $StrAux);
    $StrAux = str_ireplace("$", "''", $StrAux);
    $StrAux = str_ireplace("%", "''", $StrAux);
    $StrAux = str_ireplace('"', '´´', $StrAux);
    $StrAux = str_ireplace("ï¿½", "''", $StrAux);
    $StrAux = str_ireplace("'or'1'='1'", "''", $StrAux);
    $StrAux = str_ireplace("--", "''", $StrAux);
    $StrAux = str_ireplace("insert", "''", $StrAux);
    $StrAux = str_ireplace("drop", "''", $StrAux);
    $StrAux = str_ireplace("delet", "''", $StrAux);
    $StrAux = str_ireplace("xp_", "''", $StrAux);
    $StrAux = str_ireplace("select", "''", $StrAux);
    $StrAux = str_ireplace("*", "''", $StrAux);
    return $StrAux;
}

function format_date_to_db($str, $tipo = "") {

    if (!empty($str) && $str != '' && $str != "--") {
        clear_str($str);

        if (strpos($str, "/")) {
            $x = explode("/", $str);
            $dia = $x[0];
            $mes = $x[1];
            $ano = $x[2];

            /* if(!in_array($dia,inteiros())) {
              return null;
              }

              if(!in_array($mes,inteiros())) {
              return null;
              } */

            if ($tipo == 1) {
                return $ano . "-" . $mes . "-" . $dia;
            }
            if ($tipo == 2) {
                return $ano . "-" . $mes . "-" . $dia . " 00:00:00";
            }
            if ($tipo == 3) {
                return $ano . "-" . $mes . "-" . $dia . " 23:59:59";
            }
            return $ano . "-" . $mes . "-" . $dia . " " . date("H:i:s");
        }
    } else {
        return null;
    }
}

function get_icon_ext($str) {
    $ext['image.png'] = array("jpg", "gif", "png", "bmp");
    $ext['doc.png'] = array("doc", 'docx');
    $ext['xls.png'] = array("xls", 'xlsx');
    $ext['pdf.png'] = array("pdf");

    foreach ($ext as $k => $v) {
        if (in_array($str, $v)) {
            $ico = $k;
            return $ico;
        }
    }
    return 'file.png';
}

function SimNao($n) {
    if ($n != null)
        return ($n == 1) ? "Sim" : "Não";
    else
        return null;
}

function string_number($string, $decimal = null) {
    if (isset($decimal))
        return str_replace('.', ',', number_format($string, 2, '.', ''));
    else
        return str_replace('.', ',', $string);
}

function currencyFormat($number) {
    return $number > 0 ? number_format($number, 2, ',', '.') : '';
}

function currencyFormatAll($number = null, $zeraNegativo = false) {
    $sinal = "";
    $number = moeda2float($number);
//$number = str_replace(",", ".", $number);

    if (!is_numeric($number)) {
        return '&nbsp;';
    }

    if (strpos($number, '-')) {
        $sinal = "-";
        $number = str_replace("-", "", $number);
    }

    if ($zeraNegativo) {
        $number = ($number < 0) ? 0 : $number;
    }

    return number_format($sinal . $number, 2, ',', '.');
}

function array_in_array($arr, $arrComp) {
    foreach ($arr as $k => $v) {
        if (in_array($v, $arrComp)) {
            return true;
        }
    }
    return false;
}

function cortatexto($texto, $tamanho, $bold = "") {
    $str = substr($texto, 0, $tamanho);

    if ($bold != "") {
        $str = "<b>" . $str . "</b>";
    }

    if (strlen($texto) < $tamanho) {
        return $str;
    }

    return $str . "...";
}

function toNumber($str) {
    $str = preg_replace("/[^0-9]/", "", $str);
    return $str;
}

function formatCnpj($str) {
    $str = toNumber($str);
//09.218.727/0001-14
    $r = substr($str, 0, 2) . "." . substr($str, 2, 3) . "." . substr($str, 5, 3) . "/" . substr($str, 8, 4) . "-" . substr($str, 12, 2);
    return $r;
}

function formatCpf($str) {
    $str = toNumber($str);
//000.000.000-55
    $r = substr($str, 0, 3) . "." . substr($str, 3, 3) . "." . substr($str, 6, 3) . "-" . substr($str, 9, 2);
    return $r;
}

function toFloat($str) {
    $str = trataValorNegativo(preg_replace("/[^0-9,.]/", "", $str));
    return $str;
}

function removeAcentos($string, $slug = false) {
//Setamos o localidade
    setlocale(LC_ALL, 'pt_BR');

//Verificamos se a string é UTF-8
    if (is_utf8($string))
        $string = utf8_decode($string);

//Se a flag 'slug' for verdadeira, transformamos o texto para lowercase
    if ($slug)
        $string = strtolower($string);

// Código ASCII das vogais
    $ascii['a'] = range(224, 230);
    $ascii['e'] = range(232, 235);
    $ascii['i'] = range(236, 239);
    $ascii['o'] = array_merge(range(242, 246), array(240, 248));
    $ascii['u'] = range(249, 252);

// Código ASCII dos outros caracteres
    $ascii['b'] = array(223);
    $ascii['c'] = array(231);
    $ascii['d'] = array(208);
    $ascii['n'] = array(241);
    $ascii['y'] = array(253, 255);

//Fazemos um loop para criar as regras de troca dos caracteres acentuados
    foreach ($ascii as $key => $item) {
        $acentos = '';
        foreach ($item AS $codigo)
            $acentos .= chr($codigo);
        $troca[$key] = '/[' . $acentos . ']/i';
    }

//Aplicamos o replace com expressao regular
    $string = preg_replace(array_values($troca), array_keys($troca), $string);

// /Se a flag 'slug' for verdadeira...
    if ($slug) {
// Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
// Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
    }

    return trim($string);
}

function dirRange($n) {
    $qtdDigitos = 7; //004820
    $qtdRange = 500;
    $result = floor($n / $qtdRange);
    $de = preencherZeros(($result * $qtdRange) + 1, $qtdDigitos);
    $ate = preencherZeros(($result * $qtdRange) + $qtdRange, $qtdDigitos);
    $string = "{$de}-{$ate}";
    return $string . '/' . $n . '/';
}

function preencherZeros($n, $qtd) {
    $r = str_repeat("0", $qtd - strlen($n)) . $n;
    return $r;
}

function numeroEscrito($n) {

    $numeros[1][0] = '';
    $numeros[1][1] = 'um';
    $numeros[1][2] = 'dois';
    $numeros[1][3] = 'três';
    $numeros[1][4] = 'quatro';
    $numeros[1][5] = 'cinco';
    $numeros[1][6] = 'seis';
    $numeros[1][7] = 'sete';
    $numeros[1][8] = 'oito';
    $numeros[1][9] = 'nove';

    $numeros[2][0] = '';
    $numeros[2][10] = 'dez';
    $numeros[2][11] = 'onze';
    $numeros[2][12] = 'doze';
    $numeros[2][13] = 'treze';
    $numeros[2][14] = 'quatorze';
    $numeros[2][15] = 'quinze';
    $numeros[2][16] = 'dezesseis';
    $numeros[2][17] = 'dezesete';
    $numeros[2][18] = 'dezoito';
    $numeros[2][19] = 'dezenove';

    $numeros[2][2] = 'vinte';
    $numeros[2][3] = 'trinta';
    $numeros[2][4] = 'quarenta';
    $numeros[2][5] = 'cinquenta';
    $numeros[2][6] = 'sessenta';
    $numeros[2][7] = 'setenta';
    $numeros[2][8] = 'oitenta';
    $numeros[2][9] = 'noventa';

    $numeros[3][0] = '';
    $numeros[3][1] = 'cem';
    $numeros[3][2] = 'duzentos';
    $numeros[3][3] = 'trezentos';
    $numeros[3][4] = 'quatrocentos';
    $numeros[3][5] = 'quinhentos';
    $numeros[3][6] = 'seiscentos';
    $numeros[3][7] = 'setecentos';
    $numeros[3][8] = 'oitocentos';
    $numeros[3][9] = 'novecentos';

//$n = 30019;
    $n = number_format($n, 2, '', '');
    $n = substr($n, 0, strlen($n) - 2);

    $qtd = strlen($n);

    $compl[0] = ' mil ';
    $compl[1] = ' millhão ';
    $compl[2] = ' millhões ';

    $numero = "";
    $casa = $qtd;
    $pulaum = false;

    $x = 0;
    for ($y = 0; $y < $qtd; $y++) {

        if ($casa == 5) {
            if ($n[$x] == '1') {
                $indice = '1' . $n[$x + 1];
                $pulaum = true;
            } else {
                $indice = $n[$x];
            }
            if ($n[$x] != '0') {
                if (isset($n[$x - 1])) {
                    $numero .= ' e ';
                }
                $numero .= $numeros[2][$indice];
                if ($pulaum) {
                    $numero .= ' ' . $compl[0];
                }
            }
        }

        if ($casa == 4) {
            if (!$pulaum) {
                if ($n[$x] != '0') {
                    if (isset($n[$x - 1])) {
                        $numero .= ' e ';
                    }
                }
            }
            $numero .= $numeros[1][$n[$x]] . ' ' . $compl[0];
        }
        if ($casa == 3) {
            if ($n[$x] == '1' && $n[$x + 1] != '0') {
                $numero .= 'cento ';
            } else {
                if ($n[$x] != '0') {
                    if (isset($n[$x - 1])) {
                        $numero .= ' e ';
                    }
                    $numero .= $numeros[3][$n[$x]];
                }
            }
        }
        if ($casa == 2) {
            if ($n[$x] == '1') {
                $indice = '1' . $n[$x + 1];
                $casa = 0;
            } else {
                $indice = $n[$x];
            }
            if ($n[$x] != '0') {
                if (isset($n[$x - 1])) {
                    $numero .= ' e ';
                }
                $numero .= $numeros[2][$indice];
            }
        }
        if ($casa == 1) {
            if ($n[$x] != '0') {
                $numero .= ' e ' . $numeros[1][$n[$x]];
            } else {
                $numero .= '';
            }
        }
        if ($pulaum) {
            $casa--;
            $x++;
            $pulaum = false;
        }
        $casa--;
        $x++;
    }
    return ucfirst($numero . ' reais e centavos acima');
}

function getMemoryStatus() {
    return '<div align="right" style="padding:4px 10px;margin:0;;background:#5f7d77;z-index:999;color:#FFF">' .
            'Limite: ' . ini_get('memory_limit') . ' | ' .
            'Usados: ' . round(memory_get_peak_usage() / 1024 / 1024, 2) . 'MB</div>';
}

function isAppleMobile() {
    return preg_match("/iPad|iPhone/i", $_SERVER['HTTP_USER_AGENT']);
}

function printRoute() {
    $CI = & get_instance();
    $route = array();
    if ($CI->router->fetch_directory() != '')
        $route[] = $CI->router->fetch_directory();

    if ($CI->router->fetch_class() != '')
        $route[] = $CI->router->fetch_class();

    if ($CI->router->fetch_method() != '')
        $route[] = $CI->router->fetch_method();

    debug($route);
}

function getRoute() {
    $CI = & get_instance();
    $route = array();
    if ($CI->router->fetch_directory() != '')
        $route[] = $CI->router->fetch_directory();

    if ($CI->router->fetch_class() != '')
        $route[] = $CI->router->fetch_class();

    if ($CI->router->fetch_method() != '')
        $route[] = $CI->router->fetch_method();

    return($route);
}

/**
 * Cria diretórios de forma recursiva
 * 
 * @param string $path - Path fisico onde vão ser criados os novos diretórios
 * @param string $pathAdd  - Nome dos diretórios que serão criados separados por "/" EX: (produtos/categoria/informatica)
 * @example mkDirR("/var/www/aplicacaoTeste/uploads/","produtos/categoria/informatica")
 * @return void
 */
function mkDirR($path, $pathAdd) {

//Verificamos se já existe o diretório que queremos criar
    if (!file_exists($path . $pathAdd)) {

//Transformamos a variável em um array
        $pathAdd = explode("/", $pathAdd);

//Criamos uma varíavel para guardar os que já foram criados
        $pastasCriadas = "";

//Iniciamos um loop que fará a criação recursiva
        foreach ($pathAdd as $pasta) {

//Se não existe ainda...
            if (!file_exists($path . $pastasCriadas . $pasta)) {

//Criamos e...
                mkdir($path . $pastasCriadas . $pasta);

//Damos permissão de leitura e escrita para qualquer grupo/usuario
                chmod($path . $pastasCriadas . $pasta, 0777);
            }

//Concatenamos o nome do diretório criado na varíavel
            $pastasCriadas .= $pasta . '/';
        }
    }
}

function getThumb($path, $conf) {
    $file = end(explode('/', $path));
    $ext = end(explode('.', $file));
    $pathSave = str_replace($file, "", $path);
    $tmb = "tmb_" . $file;
    if (!file_exists($pathSave . $tmb)) {
        $myImage = imagecreatefromjpeg($path);
        list($width_orig, $height_orig) = getimagesize($path);

        $thumbnail_width = $conf['w'];
        $thumbnail_height = $conf['h'];

        $ratio_orig = $width_orig / $height_orig;

        if ($thumbnail_width / $thumbnail_height > $ratio_orig) {
            $new_height = $thumbnail_width / $ratio_orig;
            $new_width = $thumbnail_width;
        } else {
            $new_width = $thumbnail_height * $ratio_orig;
            $new_height = $thumbnail_height;
        }

        $x_mid = $new_width / 2;  //horizontal middle
        $y_mid = $new_height / 2; //vertical middle

        $process = imagecreatetruecolor(round($new_width), round($new_height));

        imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
        $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresampled($thumb, $process, 0, 0, ($x_mid - ($thumbnail_width / 2)), ($y_mid - ($thumbnail_height / 2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
        imagejpeg($thumb, $pathSave . $tmb, $conf['q']);
        chmod($pathSave . $tmb, 0777);
        imagedestroy($process);
        imagedestroy($myImage);
    }
    return $tmb;
//return $thumb;
}

function isModuloAtivo($arr) {
    $CI = & get_instance();
    if ($CI->router->fetch_class() == $arr['controller']) {
        return $arr['label'];
    }
    if (isset($arr['sub'])) {
        foreach ($arr['sub'] as $k => $v) {
            if ($CI->router->fetch_class() == $v['controller'])
                return $arr['label'] . ' <span style="font-size:10px">>></span> ' . $v['label'];
        }
    }else {
        return false;
    }
}

function getTituloController($menu) {
    foreach ($menu as $k => $v) {
        if (isModuloAtivo($v)) {
            return isModuloAtivo($v);
        }
    }
}

function hasPermission($perm, $c = null) {
    $CI = & get_instance();
    $controller = (!$c) ? $CI->router->fetch_class() : $c;
    foreach ($CI->perms as $k => $v) {
        foreach ($v['funcionalidades'] as $kf => $vf) {
            if ($vf['controller'] == $controller) {
                foreach ($vf['perms'] as $kp => $vp) {
                    if ($perm == $kp && $vp == 1)
                        return true;
                }
            }
        }
    }
    return false;
}

function hasPermissionGroup($permid, $funcId, $grupoid) {
    $CI = & get_instance();
    $sql = "SELECT * FROM funcionalidade_permissao WHERE deleted = 0";
    $res = $CI->db->query($sql);
    foreach ($res->result_array() as $k => $v) {
        if ($v['funcionalidade_id'] == $funcId && $v['permissao_id'] == $permid && $v['grupo_id'] == $grupoid) {
            return true;
        }
    }
    return false;
}

function _hasPermissionGroup($permid, $funcId, $grupoid) {
    $funcPerm = new FuncionalidadePermissao();
    $funcPerm = $funcPerm->getAll();
    foreach ($funcPerm['rows'] as $k => $v) {
        if ($v->getFuncionalidadeId() == $funcId && $v->getPermissaoId() == $permid && $v->getGrupoId() == $grupoid) {
            return true;
        }
    }
    return false;
}

function imageResize($file, $w = 500, $h = 500, $crop = false, $q = 90) {
    if ($crop) {
        $myImage = imagecreatefromjpeg($file);
        list($width_orig, $height_orig) = getimagesize($file);

        $thumbnail_width = $w;
        $thumbnail_height = $h;

        $ratio_orig = $width_orig / $height_orig;

        if ($thumbnail_width / $thumbnail_height > $ratio_orig) {
            $new_height = $thumbnail_width / $ratio_orig;
            $new_width = $thumbnail_width;
        } else {
            $new_width = $thumbnail_height * $ratio_orig;
            $new_height = $thumbnail_height;
        }

        $x_mid = $new_width / 2;  //horizontal middle
        $y_mid = $new_height / 2; //vertical middle

        $process = imagecreatetruecolor(round($new_width), round($new_height));

        imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
        $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresampled($thumb, $process, 0, 0, ($x_mid - ($thumbnail_width / 2)), ($y_mid - ($thumbnail_height / 2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
        imagejpeg($thumb, $file, $q);
        chmod($file, 0777);
        imagedestroy($process);
        imagedestroy($myImage);
    } else {
        $pic = imagecreatefromjpeg($file);
        $width = imagesx($pic);
        $height = imagesy($pic);
        $maxW = $w;
        $maxH = $h;

        if ($width > $maxW || $height > $maxH) {
            if ($width > $height) {
                $newWidth = $maxW;
                $newHeight = $newWidth * $height / $width;
            } else {
                $newHeight = $maxH;
                $newWidth = $newHeight * $width / $height;
            }
        } else {
            $newHeight = $height;
            $newWidth = $width;
        }
        $out = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($out, $pic, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($out, $file, $q);
        imagedestroy($pic);
        imagedestroy($out);
    }
}

function getSlugPost($obj) {
    $categoria = removeAcentos($obj->getPostCategoria()->getNome(), '-');
    $titulo = removeAcentos($obj->getTitulo(), '-');
    $slug = "{$obj->getId()}/{$categoria}/{$titulo}";
    return $slug;
}

function getSlugPostSiteMap($obj) {
    $categoria = removeAcentos($obj->getPostCategoria()->getNome(), '-');
    $titulo = removeAcentos($obj->getTitulo(), '-');
    $slug = "%d/{$categoria}/{$titulo}";
    return $slug;
}

function getPagination($per_page = 10, $total_rows = 100, $configAlt = '') {
    $CI = & get_instance();
    $CI->load->library('pagination');
    $controller = $CI->router->fetch_class();
    $method = $CI->router->fetch_method();
    $config['base_url'] = str_replace($CI->config->item('url_suffix'), '', site_url("$controller/$method"));
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['suffix'] = $CI->config->item('url_suffix');
    $config['num_links'] = 3;
    $config['uri_segment'] = 3;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="currentPage"><span>';
    $config['cur_tag_close'] = '</span></li>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['first_link'] = '<<';
    $config['last_link'] = '>>';

    if (!empty($configAlt)) {
        $config = array_merge($config, $configAlt);
    }

    $CI->pagination->initialize($config);
    return $CI->pagination->create_links();
}

function formatCode($string) {
    $padroes = array(
        '[code]' => '<div class="codigoFonte">',
        '[/code]' => '</div>',
            #'&lt;?php' => '&lt;?php <blockquote>',
#'?&gt;' => '</blockquote>?&gt;',
#' {' => '{<blockquote>',
#' }' => '</blockquote>}',
    );

//Aplica os padrões
    foreach ($padroes as $k => $v) {
        $string = str_replace($k, $v, $string);
    }

//Aplica as quebras de linha
//$string = nl2br($string);
    return $string;
}

/**
 * Returns true if $string is valid UTF-8 and false otherwise.
 *
 * @since        1.14
 * @param [mixed] $string     string to be tested
 * @subpackage
 */
function is_utf8($string) {

// From http://w3.org/International/questions/qa-forms-utf-8.html
    return preg_match('%^(?:
		  [\x09\x0A\x0D\x20-\x7E]            # ASCII
		| [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
		|  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
		| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
		|  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
		|  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
		| [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
		|  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
	)*$%xs', $string);
}

function formatNameModel($str) {
    $partCampo = array();
    $campo = explode('_', $str);
    foreach ($campo as $value) {
        $partCampo[] = ucfirst($value);
    }
    $name = implode('', $partCampo);
    return $name;
}

function isDiaUtil($data) {

    $fds = array('6', '0');
    $diaSemana = date('w', strtotime($data));
    if (in_array($diaSemana, $fds)) {
        return false;
    } else {
        return true;
    }
}

function proximoDiaUtil($data) {
    //debug($data);
    if(isDiaUtil($data)){
        return $data;
    }else{
        $data = date('Y-m-d',  strtotime($data.' +1 days'));
        return proximoDiaUtil($data);
    }
    
}
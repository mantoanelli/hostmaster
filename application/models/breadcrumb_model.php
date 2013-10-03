<?php 

/**
 * Define migalhas a partir do arquivo sitemap.xml
 * 
 * Para usar:
 * Arquivo sitemap.xml na raiz da pasta view 
 * 
 * Ex.:  
 * <?xml version="1.0" encoding="utf-8" ?>
 * <siteMap xmlns="http://schemas.microsoft.com/AspNet/SiteMap-File-1.0" >
 * 	<siteMapNode url="welcome" title="Home" description="Home">
 * 		<siteMapNode url="consultor" title="Consultor" description="Consultor">
 * 			<siteMapNode url="consultor/cadastro" title="Cadastro" description="Cadastro" />
 * 			<siteMapNode url="consultor/venda" title="Venda" description="Venda" >
 *                 <siteMapNode url="consultor/venda_editar/%d" title="Edição" description="Edição" />
 *             </siteMapNode>
 * 		</siteMapNode>
 * 	</siteMapNode>
 * </siteMap>
 * 
 * <code>
 * //Na controller:
 * $this->load->model('Breadcrumb_model');
 * 
 * //Na view
 * <?php echo $this->Breadcrumb_model->get_breadcrumb(); ?> 
 * </code>
 * 
 * 
 */
class Breadcrumb_model extends CI_Model{

    private $sitemap;
    private $separator;
    private $str_breadcrumb = '';
    
	function __construct(){
        parent::__construct();
		$this->separator = '»';
        
        //Caminho padrão do sitemap
        $sitemap_path = FCPATH . APPPATH . 'views/sitemap.xml';
        $this->set_sitemap_path($sitemap_path);
	}
    
    /**
     * Caso o arquivo esteja em outra pasta ele pode ser definido pelo metódo abaixo
     * @param string $sitemap_path 
     */
    public function set_sitemap_path($sitemap_path)
    {
        if (file_exists($sitemap_path)) {
            $this->sitemap = simplexml_load_file($sitemap_path);          
        //} else {
            //show_error('Erro ao tentar abrir o arquivo: ' . $sitemap_path);
        }
    }
    
    
    /**
     * Obtem a string com o caminho
     * @return string 
     */
    public function get_breadcrumb(){
        $this->set_breadcrumb($this->uri->uri_string());
        return $this->str_breadcrumb;
    }
    
    
    /**
     * Função interna para percorrer o arquivo xml
     * @param string $s Link a ser procurado
     * @param object $siteMapNode Nó a ser percorrido
     * @param array $siteMapArr Caminho atual
     */
    private function set_breadcrumb($s, $siteMapNode = null, $siteMapArr = array()){     
        
        if(!isset($siteMapNode)) $siteMapNode = $this->sitemap->siteMapNode;
        
        
        //Se localizou o link informado, armazena na variavel abaixo
        if($siteMapNode['url'] == $this->get_fmt_url($s)){
            
            //Define o nó atual
            $siteMapArr[] = $siteMapNode['title'];

            $this->str_breadcrumb = implode(" {$this->separator} ", $siteMapArr);
            
        //Caso não tenha localizado, continua a percorrer os nós    
        } else {
            
            //Define o nó atual
            $siteMapArr[] = anchor($siteMapNode['url'], $siteMapNode['title'], "title=\"{$siteMapNode['description']}\"");
                        
            //se tiver filhos
            if(isset($siteMapNode->siteMapNode)){
                //Caso não possua nós filhos
                if(count($siteMapNode->siteMapNode)==1){
                    $this->set_breadcrumb($s, $siteMapNode->siteMapNode, $siteMapArr);    
                //Caso possua percorre eles    
                } elseif(count($siteMapNode->siteMapNode)>1){
                    foreach ($siteMapNode->siteMapNode as $node) {
                        $this->set_breadcrumb($s, $node, $siteMapArr);
                    }
                }
            }
        }
        
    }
    
    function get_fmt_url($url){
        $aUrlOrig = explode('/', $url);
        $aUrlNov = '';
        foreach ($aUrlOrig as $s) {
            if(is_numeric($s)){
                $s = '%d';
            }
            $aUrlNov[] = $s;
        }
        $r = implode('/', $aUrlNov);
        //debug($aUrlNov);
        return $r;
    }
    
    
}

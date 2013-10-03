<? $this->load->view('ROOT/head'); ?>
<body>
    <? 
    $this->load->view('ROOT/header');
    $this->load->view('ROOT/indique');
    $this->load->view($CI->getView(((isset($contentView) && $contentView != '') ? $contentView : 'content')), $CI->_data);
    $this->load->view('ROOT/footer'); 
    ?>
</body>
</html>
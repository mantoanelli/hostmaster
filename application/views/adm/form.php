<? $this->load->view('adm/msgAdmin'); ?> 
<? $this->load->view('adm/acoesListagem'); ?>
<?= form_open($this->router->fetch_directory() . $this->router->fetch_class() . '/save/' . $idRegistro, 'id="' . $idForm . '" class="validate mainForm" enctype="multipart/form-data"') ?>
<? $this->load->view($CI->getView('form_content')); ?>
<?= form_close(); ?>
                
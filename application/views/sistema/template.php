<?php $this->load->view('sistema/header') ?>
<?= $this->load->view('menus/'.$this->session->userdata('acceso')); ?>
<?php $this->load->view($main_content) ?>
<?php $this->load->view('sistema/footer') ?>
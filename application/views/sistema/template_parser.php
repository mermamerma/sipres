<?php $this->load->view('sistema/header') ?>
<?= $this->load->view('menus/'.$this->session->userdata('acceso')); ?>
<?= $main_content ?>
<?php $this->load->view('sistema/footer') ?>
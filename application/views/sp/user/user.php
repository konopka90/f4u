<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('sp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Partnera</a></li>
    <li class="active"><span class="label label-primary">Klienci</span></li>
</ol>

<div class="row">
    <div class="col-md-12">
        
        <a href="<?=base_url()?>sp/user/create" class="btn btn-primary pull-right btn-xs"><i class="glyphicon glyphicon-plus"></i> Dodaj nowego klienta</a>
        
		<h3 class="margin_0 margin_b_20"><i class="glyphicon glyphicon-user"></i>&nbsp; Lista moich klientów</h3>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
        
		<?=$this->load->view('sp/user/user_table', array(), true)?>
        
        <div id="div_user_message"></div>
        
    </div>
</div>


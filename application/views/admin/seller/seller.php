<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
    <li class="active"><span class="label label-primary">Sprzedawcy</span></li>
</ol>

<div class="row margin_b_20">
    <div class="col-md-12">
        
        <a href="<?=base_url()?>admin/seller/create" class="btn btn-primary pull-right btn-xs"><i class="glyphicon glyphicon-plus"></i> Dodaj nowego sprzedawcę</a>
        
		<h3 class="margin_0 margin_b_20"><i class="glyphicon glyphicon-user"></i>&nbsp; Lista sprzedawców</h3>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
        
        <?=$this->load->view('admin/seller/seller_table', array(), true)?>
        
        <div id="div_user_message"></div>
        
    </div>
</div>


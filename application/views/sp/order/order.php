<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('sp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Partnera</a></li>
    <li class="active"><span class="label label-primary">Zamówienia</span></li>
</ol>

<div class="row">
    <div class="col-md-12">
        
        <a href="<?=base_url()?>sp/order/create" class="btn btn-primary pull-right btn-xs"><i class="glyphicon glyphicon-plus"></i> Dodaj nowe zamówienie</a>
        
		<h3 class="margin_0 margin_b_20"><i class="glyphicon glyphicon-cutlery"></i>&nbsp; Zamówienia cateringu</h3>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>  

    </div>
</div>

<?=$this->load->view('admin/order/order_table', array('all_orders' => $all_orders, 'access' => 'seller'), true)?>

<div class="row margin_b_20 margin_t_30">

    <div class="col-md-8">
    
    	<h3 class="margin_0 margin_b_0 border_b_3 padding_b_10"><i class="glyphicon glyphicon-usd muted"></i>&nbsp; Ostatnie wypłaty</h3>
        
		<?=$this->load->view('sp/order/payout_table', array('payouts' => $payouts, 'access' => 'seller', 'limit' => 2), true)?>
        
    </div>

    <div class="col-md-4">
        <?=$this->load->view('sp/_elements/saldo_box', array(), true)?>
  	</div>
    
</div>

<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('sp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Partnera</a></li>
    <li class="active"><span class="label label-primary">Prowizje</span></li>
</ol>

<div class="row margin_b_20">

    <div class="col-md-8">
    
    	<h3 class="margin_0 margin_b_0 border_b_3 padding_b_10"><i class="glyphicon glyphicon-usd muted"></i>&nbsp; Historia wypłat</h3>
        
		<?=$this->load->view('sp/order/payout_table', array('payouts' => $payouts, 'access' => 'seller'), true)?>
        
    </div>

    <div class="col-md-4">
		
        <h3 class="margin_0 margin_b_35 border_b_3 padding_b_10"><i class="glyphicon glyphicon-usd muted"></i>&nbsp; Twoje środki</h3>
        
        <?=$this->load->view('sp/_elements/saldo_box', array(), true)?>
        
  	</div>
    
</div>

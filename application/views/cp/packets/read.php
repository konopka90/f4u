<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('cp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>cp">Panel Klienta</a></li>
    <li><a href="<?=base_url()?>cp/packets">Zamówienia i płatności</a></li>
    <li class="active">Szczegóły zamówienia <?=$order->order_number?></li>
</ol>      

<h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon-th-list muted"></i>&nbsp; Szczegóły zamówienia <?=$order->order_number?></h3>

<table class="table">
    <tr>
        <td class="border_t_0">Data zamówienia</td>
        <td class="border_t_0"><?=$order->date?></td>
    </tr>
    <tr>
        <td>Numer zamówienia</td>
        <td><?=$order->order_number?></td>
    </tr>
    <tr>
        <td>Kwota</td>
        <td><?=$order->price?> PLN</td>
    </tr>
    <tr>
        <td>Dane do fakturowania</td>
        <td>
			<strong><?=$order->name_surname?></strong><br>
            
            <em>Adres:</em> <strong><?=$order->address?></strong><br>
            <?=$order->postcode?> <?=$order->city?>
            
            <? if($order->nip) {?>
            	<em>NIP:</em> <strong><?=$order->nip?></strong><br>
            <? } ?>
        </td>
    </tr>
    <tr>
        <td>Powiadomienia email na adres</td>
        <td><?=$order->email?></td>
    </tr>
</table>

<div class="row margin_b_20">
    <div class="col-md-8">
 
        <h4>Kupione usługi</h4>
        
		<?=$this->data['template'] = $this->load->view('cp/packets/_elements/invoice_products_payment', array('order' => $order), true);?>
        
        
 
        <div class="btn-group btn-group-justified margin_t_20">
            <a href="<?=base_url()?>cp/order/<?=$order->order_id?>/save" class="btn btn-default"><i class="glyphicon glyphicon-save"></i> &nbsp; Pobierz fakturę</a>
        </div>

 
	</div>
    <div class="col-md-4">
    
    	<h4>Płatność</h4>
        
        <? 
		$dotpay_values = dotpay_values($order->payment);
		$dotpay_channels_values = dotpay_channels_values();
		?>

        
            
        <table class="table">
           
            <tr>
                <td>Status płatności</td>
                <td><h3 class="margin_0"><span class="label <?=$dotpay_values[1]?>"><?=$dotpay_values[0]?></span></h3></td>
            </tr>
      
            <? if($order->payment == 2) { ?>
				<? if($order->payment_channel) { ?>
                    <tr>
                        <td>Kanał płatności</td>
                        <td><?=$dotpay_channels_values[$order->payment_channel]?></td>
                    </tr>
                <? } ?>
                <? if($order->payment_date) { ?>
                    <tr>
                        <td>Data płatności</td>
                        <td><?=$order->payment_date?></td>
                    </tr>
                <? } ?>
                <? if($order->invoice_number && $order->invoice_date && $order->invoice_date != '0000-00-00') { ?>
                    <tr>
                        <td>Faktura</td>
                        <td>
                            <a href="<?=base_url()?>cp/order/<?=$order->order_id?>/save">
                                <i class="glyphicon glyphicon-save tooltipa" data-original-title="Pobierz fakturę"></i> &nbsp; Pobierz 
                            </a>
                        </td>
                    </tr>
                <? } ?>
            <? } ?>
        </table>
        
        <? if($order->payment != 2) { ?>
            <div class="btn-group btn-group-justified">
            	<a href="<?=$this->order->create_dotpay_url($order)?>" class="btn btn-danger"><i class="glyphicon glyphicon-usd"></i> &nbsp; ZAPŁAĆ ZA ZAMÓWIENIE</a>
            </div>
        <? } ?>

        
    </div>
</div>

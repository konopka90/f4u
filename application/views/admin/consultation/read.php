<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Admina</a></li>
    <li><a href="<?=base_url()?>admin/consultation">Konsultacje</a></li>
    <li class="active">Szczegóły konsultacji <?=$consultation->order_number?></li>
</ol>      

<h3 class="margin_0 margin_b_30">Szczegóły konsultacji <?=$consultation->order_number?> <a href="<?=base_url()?>admin/order/update/<?=$consultation->order_id?>" class="btn btn-primary btn-xs">Edytuj zamówienie</a></h3>



<div class="row margin_b_20">

	<div class="col-md-6">
    
    	<h4>Szczegóły konsultacji</h4>
    
        <table class="table">
            <tr>
                <td style="width: 40%">Numer zamówienia</td>
                <td><?=$consultation->order_number?></td>
            </tr>
            <tr>
                <td>Data zamówienia</td>
                <td><?=$consultation->date?></td>
            </tr>
            <tr>
                <td>Wartość zamówienia</td>
                <td><?=$consultation->price?> PLN</td>
            </tr>
            <tr>
                <td>Dane do fakturowania</td>
                <td>
                    <strong><?=$consultation->name_surname?></strong><br>
                    
                    <em>Adres:</em> <strong><?=$consultation->address?></strong><br>
                    <?=$consultation->postcode?> <?=$consultation->city?>
                    
                    <? if($consultation->nip) {?>
                        <em>NIP:</em> <strong><?=$consultation->nip?></strong><br>
                    <? } ?>
                </td>
            </tr>
            <tr class="active">
                <td>Elementy zamówienia</td>
                <td>
                                
                    <ul class="list-group margin_0">
						<? foreach($consultation->products as $product) { ?>
                            <li class="list-group-item"><i class="glyphicon glyphicon-ok"></i>&nbsp; <?=$product->name?></li>
                        <? } ?>
                    </ul>

                </td>
            </tr>
            <tr class="active">
                <td>Adres email</td>
                <td><?=$consultation->email?></td>
            </tr>
            <tr class="active">
                <td>Telefon</td>
                <td><?=$consultation->phone?></td>
            </tr>
            <? if($consultation->skype) { ?>
                <tr class="active">
                    <td>Skype</td>
                    <td><a href="skype:<?=$consultation->skype?>?call"><?=$consultation->skype?></a></td>
                </tr>
            <? } ?>
        </table>
        
    	<h4>Płatność <a class="btn btn-primary btn-xs btn_modal" data-id="<?=$consultation->order_id?>" data-cont="order" data-func="payment">Edytuj płatność</a></h4>
        
        <div id="div_order_payment"></div>
        
        <? 
		$dotpay_values = dotpay_values($consultation->payment);
		$dotpay_channels_values = dotpay_channels_values();
		?>
        
        <table class="table">
           
            <tr>
                <td>Status płatności</td>
                <td><h3 class="margin_0"><span class="label <?=$dotpay_values[1]?>"><?=$dotpay_values[0]?></span></h3></td>
            </tr>
      
            <? if($consultation->payment == 2) { ?>
				<? if($consultation->payment_channel) { ?>
                    <tr>
                        <td>Kanał płatności</td>
                        <td><?=$dotpay_channels_values[$consultation->payment_channel]?></td>
                    </tr>
                <? } ?>
                <? if($consultation->payment_date && $consultation->payment_date != '0000-00-00 00:00:00') { ?>
                    <tr>
                        <td>Data płatności</td>
                        <td><?=$consultation->payment_date?></td>
                    </tr>
                <? } ?>
            <? } ?>
        </table>

		<h4>Faktura <a href="<?=base_url()?>admin/order/invoice/<?=$consultation->order_id?>" class="btn btn-primary btn-xs">Edytuj fakturę</a></h4>
        
        <table class="table">
            <tr>
                <td>Faktura</td>
                <td>
                    <a href="<?=base_url()?>cp/order/<?=$consultation->order_id?>/save">
                        <i class="glyphicon glyphicon-save tooltipa" data-original-title="Pobierz fakturę"></i> &nbsp; Pobierz 
                    </a>
                </td>
            </tr>
            <? if($consultation->invoice_number) { ?>
                <tr>
                    <td>Numer faktury</td>
                    <td><?=($consultation->invoice_number)?$consultation->invoice_number:'-'?></td>
                </tr>
    		<? } ?>
           	<? if($consultation->invoice_date) { ?>
                <tr>
                    <td>Data wystawienia</td>
                    <td><?=($consultation->invoice_date && $consultation->invoice_date != '0000-00-00')?$consultation->invoice_date:'-'?></td>
                </tr>
         	<? } ?>
			<? if($consultation->invoice_payment_method) { ?>
                <tr>
                    <td>Metoda płatności</td>
                    <td><?=($consultation->invoice_payment_method)?reset(payment_method_values($consultation->invoice_payment_method)):'-'?></td>
                </tr>
            <? } ?>
			<? if($consultation->invoice_payment_deadline && $consultation->invoice_payment_deadline != '0000-00-00') { ?>
                <tr>
                    <td>Termin płatności</td>
                    <td><?=$consultation->invoice_payment_deadline?></td>
                </tr>
           <? } ?>
           
        </table>
            
    </div>
    
    <div class="col-md-6">
    
    	<h4>Wyślij emaila do użytkownika</h4>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
      
        <form role="form" action="<?=current_url()?>" method="post">
        
            <div class="form-group">
                <label>Adres email</label>
                <input type="email" class="form-control" name="email" value="<?=$consultation->email?>" placeholder="Adres email">
            </div>
            
            <div class="form-group">
                <label>Treść</label>
                <textarea name="text" id="text" class="ckeditor"></textarea>
            </div>
            
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="copy" value="1"> Wyslij kopię też do mnie (<?=$user->email?>)
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary" name="send_email" value="1">Wyślij</button>
            
        </form>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
    	<? if($access == 'seller') { ?>
        	<?=$this->load->view('sp/_elements/menu', array(), true)?>
        <? } else { ?>
        	<?=$this->load->view('admin/_elements/menu', array(), true)?>
        <? } ?>
    </div>
</div>

<ol class="breadcrumb">

	<? if($access == 'seller') { ?>

        <li><a href="<?=base_url()?>sp">Panel Sprzedawcy</a></li>
        <li><a href="<?=base_url()?>sp/order" class="label label-primary">Zamówienia</a></li>
        <li class="active">Szczegóły zamówienia <?=$order->order_number?></li>
    
    <? } else { ?>
    
        <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
        <li><a href="<?=base_url()?>admin/order" class="label label-primary">Catering</a></li>
        <li class="active">Szczegóły zamówienia <?=$order->order_number?></li>
    
    <? } ?>



</ol>      

<h3 class="margin_0 margin_b_30">Szczegóły zamówienia <?=$order->order_number?> <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/order/update/<?=$order->order_id?>" class="btn btn-primary btn-xs">Edytuj zamówienie</a></h3>

<table class="table">
    <tr>
        <td width="50%">Numer zamówienia</td>
        <td><?=$order->order_number?></td>
    </tr>
    <tr>
        <td>Data zamówienia</td>
        <td><?=$order->date?></td>
    </tr>
    <tr>
        <td>Wartość zamówienia</td>
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
    <tr>
        <td width="50%">Pierwsza dostawa</td>
        <td><?=reset($all_deliveries)->date?></td>
    </tr>
    <tr>
        <td width="50%">Ostatnia dostawa</td>
        <td><?=end($all_deliveries)->date?></td>
    </tr>
    <tr>
        <td width="50%"><strong>Catering</strong></td>
        <td>

            <?=reset($order->products)->name?> <span class="font_gray"><?=(is_array(unserialize($order->meals_selected)))?'('.implode(", ", unserialize($order->meals_selected)).')':''?></span><br />
            
            <?=($order->days)?$order->days:0?> <span class="font_gray">dni, od</span> <?=reset($all_deliveries)->date?> <span class="font_gray">do</span> <?=end($all_deliveries)->date?>
            

        </td>
    </tr>
</table>

<div class="row margin_b_20">
    <div class="col-md-8">
 
        <h4>Kupione usługi</h4>
        
		<?=$this->data['template'] = $this->load->view('cp/packets/_elements/invoice_products_payment', array('order' => $order), true);?>
 
	</div>
    <div class="col-md-4">

    	<h4>
        	Płatność 
        	<? if($access != 'seller') { ?>
        		<a class="btn btn-primary btn-xs btn_modal" data-id="<?=$order->order_id?>" data-cont="order" data-func="payment">Edytuj płatność</a>
        	<? } ?>
        </h4>
        
        <div id="div_order_payment"></div>
        
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
                <? if($order->payment_date && $order->payment_date != '0000-00-00 00:00:00') { ?>
                    <tr>
                        <td>Data płatności</td>
                        <td><?=$order->payment_date?></td>
                    </tr>
                <? } ?>
            <? } ?>
        </table>

		<h4>
        	Faktura 
            <? if($access != 'seller') { ?>
            	<a href="<?=base_url()?>admin/order/invoice/<?=$order->order_id?>" class="btn btn-primary btn-xs">Edytuj fakturę</a>
            <? } ?>
        </h4>
        
        <table class="table">
            <tr>
                <td>Faktura</td>
                <td>
                    <a href="<?=base_url()?>cp/order/<?=$order->order_id?>/save">
                        <i class="glyphicon glyphicon-save tooltipa" data-original-title="Pobierz fakturę"></i> &nbsp; Pobierz 
                    </a>
                </td>
            </tr>
            
            <? if($order->invoice_number) { ?>
                <tr>
                    <td>Numer faktury</td>
                    <td><?=($order->invoice_number)?$order->invoice_number:'-'?></td>
                </tr>
            <? } ?>
            
            <? if($order->invoice_date) { ?>
                <tr>
                    <td>Data wystawienia</td>
                    <td><?=($order->invoice_date && $order->invoice_date != '0000-00-00')?$order->invoice_date:'-'?></td>
                </tr>
            <? } ?>
            
            <? if($order->invoice_payment_method) { ?>
                <tr>
                    <td>Metoda płatności</td>
                    <td><?=($order->invoice_payment_method)?reset(payment_method_values($order->invoice_payment_method)):'-'?></td>
                </tr>
            <? } ?>

            <? if($order->invoice_payment_deadline && $order->invoice_payment_deadline != '0000-00-00') { ?>
                <tr>
                    <td>Termin płatności</td>
                    <td><?=$order->invoice_payment_deadline?></td>
                </tr>
           <? } ?>
           
        </table>
        
    </div>
</div>

<div class="row margin_b_20">
    <div class="col-md-12">
    	
        <h4>Dostawy i gramatura <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/order/grammage/<?=$order->order_id?>" class="btn btn-primary btn-xs">Edytuj gramaturę</a> <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/order/delivery/<?=$order->order_id?>" class="btn btn-primary btn-xs margin_l_10">Edytuj dostawy</a></h4>
    	
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                
                    <th width="60px">Dostawa</th>
                    <th>Adres dostawy</th>
                    <th>Gramatura</th>
                    <th width="150px">Uwagi klienta</th>
                    <th width="150px">Uwagi do gramatury</th>
                    <th width="150px">Uwagi do dostawy</th>
                    <?php /*?><th class="text-right">Opcje</th><?php */?>
                </tr>
            </thead>
			<?
                $active_days = 0;
                $stopped_days = 0;
            ?>
			<? foreach($all_deliveries as $d) { ?>
                <tr class="<?=(date("Y-m-d") == $d->date)?'success':''?>">
                    <td>
                        <?=$this->load->view('_elements/calendar_card', array('d' => $d), true)?>
                    </td>
                    <td>
            
                        <div class="clearfix">

                            <span>
                                <?=$d->name_surname?><br /><?=$d->address?>, <?=$d->postcode?> <?=$d->city?><br /><em>tel.</em> <?=$d->phone?><br />
                                
                            </span>
                            
                            <? if($order->payment != 2) { ?>
                                <span class="font_orange font_12">
                                    <i class="glyphicon glyphicon-exclamation-sign"></i> Dostawa jest nieaktywna, ponieważ pakiet niezostał opłacony.
                                </span>
                            <? } else { ?>
                            
                                <? if($order->stopped == 1) { ?>
                                    <span class="font_red font_12">
                                        <i class="glyphicon glyphicon-exclamation-sign"></i> Dostawa w tym dniu wstrzymana.
                                    </span>
                                <? } else { ?>
                                    <span class="font_green font_12">
                                        <i class="glyphicon glyphicon-exclamation-sign"></i> W tym dniu <?=$d->meals?> <?=($d->meals == 5)?'dostaw':'dostawy'?>.
                                    </span>
                                <? } ?>
                                
                            <? } ?>
                            
                        </div>
                    
                    </td>
                    <td>
                        <table class="table table-bordered table-condensed margin_b_0">
                            <tr>
                                <? for($i=1;$i<=5;$i++) { ?>
                                    <th class="<?=(in_array($i, unserialize($order->meals_selected)))?'active':''?>">Posiłek #<?=$i?></th>
                                <? } ?>
                            </tr>
                            <tr>
                                <? for($i=1;$i<=5;$i++) { ?>
                                    <td class="<?=(in_array($i, unserialize($order->meals_selected)))?'active':''?>">
                                    
                                        <div class="form-group margin_b_10">
                                            <? $key = 'meal_' . $i . '_w'; ?>
                                            W: <?=($all_deliveries_grammage[$d->delivery_id]->$key)?$all_deliveries_grammage[$d->delivery_id]->$key:0?>
                                        </div>
                                        <div class="form-group margin_b_0">
                                            <? $key = 'meal_' . $i . '_b'; ?>
                                            B: <?=($all_deliveries_grammage[$d->delivery_id]->$key)?$all_deliveries_grammage[$d->delivery_id]->$key:0?>
                                        </div>
                                        
                                    </td>
                                <? } ?>
                            </tr>
                        </table>
                    </td>
                    <td>
                    	<?=$d->user_notice?>
                    </td>
                    <td>
                    	<? if($all_deliveries_grammage[$d->delivery_id]->keyword) { ?>
                        	<?=$all_deliveries_grammage[$d->delivery_id]->keyword?><br />
                        <? } ?>
                    	<?=$all_deliveries_grammage[$d->delivery_id]->notice?>
                    </td>
                    <td>
                    	<?=$d->notice?>
                    </td>
                    <?php /*?>
                    <td>
                                            
                        <a href="<?=base_url()?>admin/order/read/<?=$d->order_id?>/delivery/<?=$d->delivery_id?>" class="btn btn-default btn-lg pull-right"><i class="glyphicon glyphicon-pencil"></i></a>
     
                    </td>
                    <?php */?>
                </tr>
                
				<? if($d->stopped == 0) { 
                    $active_days++;
                } else {
                    $stopped_days++;	
                }?>
        
            <? } ?>
        </table>
    
        <table class="table table-bordered margin_t_20">
            <thead>
                <tr>
                    <th colspan="2">Podsumowanie</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><h4>Dni które są aktywne i mają dostawę</h4></td>
                    <td><h4><strong><?=($active_days)?$active_days:0?> dni</strong></h4></td>
                </tr>
                <tr>
                    <td>Dni za które użytkownik zapłacił</td>
                    <td><?=($order->payed_days)?$order->payed_days:0?> dni</td>
                </tr>
                <tr>
                    <td>Dni które użytkownik otrzymał GRATIS</td>
                    <td><?=($order->free_days)?$order->free_days:0?> dni</td>
                </tr>
                <tr>
                    <td>Dni w które użytkownik ma wstrzymaną dostawę</td>
                    <td><?=($stopped_days)?$stopped_days:0?> dni</td>
                </tr>
            </tbody>
        </table>
    
    </div>
   
</div>
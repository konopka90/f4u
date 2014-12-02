<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('cp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Klienta</a></li>
    <li class="active">Twoje pakiety i faktury</li>
</ol>      

<div class="row margin_t_10">

    <div class="col-md-4">
    
        <h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon-th-large muted"></i> &nbsp; Twoje pakiety</h3>

		<?=$this->load->view('cp/packets/_elements/packets_list', array('user_packets' => $user_packets, 'active_packet' => $active_packet), true)?>
        
        <div class="btn-group btn-group-justified margin_b_20">
            <a href="<?=base_url()?>cp/packets/prolong" class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> &nbsp; ZAMÓW DIETĘ </a>
        </div>
		
        <?php /*?>
        <p class="margin_t_20 margin_b_20">
        	<i class="glyphicon glyphicon-exclamation-sign"></i> Nowy pakiet będzie aktywny najwcześniej <?=$first_avalible_day?>.
        </p>
        <?php */?>
    </div>
    
    <div class="col-md-8">
        
        <h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon glyphicon-th-list muted"></i> &nbsp; Twoje zamówienia</h3>
    
    
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Data</th>
                    <th></th>
                    <th class="text-right">Kwota</th>
                    <th class="text-center" style="width: 130px">Status płatności</th>
                    <th class="text-right">Faktura</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <? if(count($orders) > 0) { ?>
                    <? foreach($orders as $o) { ?>
                        <tr class="<?=($o->payment != 2)?'danger':''?>" id="order_<?=$o->order_id?>">
                            <td>
								<?=date("Y-m-d H:i", strtotime($o->date))?><br />
                                <span class="font_12"><?=$o->order_number?></span>
                            </td>
                            <td>
                            
                            	 <?=$products[$o->product_id]->name?>
                            
                            </td>
                            <td class="text-right">
                            
                                <div class=""><?=$o->price?> PLN</div>
                                
                                
       
                                
                            </td>
                            <td class="text-center">
                            
                                <?
                                
                                    $dotpay_values = dotpay_values();
                                
                                ?>

                            
                                <span class="label <?=$dotpay_values[$o->payment][1]?>"><?=$dotpay_values[$o->payment][0]?></span><br />
                                
                                <? if($o->payment == 2) {
                                    
                                    $dotpay_channels_values = dotpay_channels_values();
                                    if($o->payment_channel) {
                                        echo "<em class='font_10'>" . $dotpay_channels_values[$o->payment_channel] . "</em><br />";
                                    }
                                    if($o->payment_date && $o->payment_date != '0000-00-00 00:00:00') {
                                        echo "<em class='font_10'>" . $o->payment_date . "</em>";
                                    }
                                } ?>
                                
                                <? if($o->payment != 2) { ?>
                                    
                                    <div class="clearfix btn-group margin_t_5">
                                        <a href="<?=$this->order->create_dotpay_url($o)?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-usd"></i></a>
                                        <a href="<?=$this->order->create_dotpay_url($o)?>" class="btn btn-danger btn-xs">ZAPŁAĆ</a>
                                    </div>
                                <? } ?>
                                
                            </td>
                            <td class="text-right">
                                <? if($o->payment == 2 && $o->invoice_number && $o->invoice_date && $o->invoice_date != '0000-00-00') { ?>
                                
                                    <a href="<?=base_url()?>cp/order/<?=$o->order_id?>/save">
                                        <i class="glyphicon glyphicon-save tooltipa" data-original-title="Pobierz fakturę VAT"></i>
                                    </a>
                                    
                                <? } else { ?>
                                
                                    <a href="<?=base_url()?>cp/order/<?=$o->order_id?>/save">
                                        <i class="glyphicon glyphicon-save tooltipa" data-original-title="Pobierz fakturę Proforma"></i>
                                    </a>

                                <? } ?>
                            </td>
                            <td class="text-right">
                            
                                <a href="<?=base_url()?>cp/order/<?=$o->order_id?>"><i class="glyphicon glyphicon-list-alt tooltipa" data-original-title="Szczegóły zamówienia"></i></a>
                            
                                <? if($o->payment != 2) { ?>
                                    <a href="<?=$this->order->create_dotpay_url($o)?>" class="margin_l_10"><i class="glyphicon glyphicon-usd tooltipa" data-original-title="Zapłać za zamówienie"></i></a>
                                <? } ?>
                                
                            </td>	
                        </tr>
                    <? } ?>
                <? } else { ?>
                    <tr>
                        <td colspan="6">
                            <i class="glyphicon glyphicon-exclamation-sign"></i> Brak złożonych zamówień.
                        </td>
                    </tr>

                <? } ?>
            </tbody>
                            
        </table>
    	
    </div>
  
</div>


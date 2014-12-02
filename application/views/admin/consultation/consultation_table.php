<? if(count($all_consultations) > 0) { ?>

    <table class="table table-striped table-condensed table-hover table-bordered" id="consultations_table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Numer zamówienia</th>
                <th>Zamawiający</th>
                <th >Zamówił</th>
                <th class="text-right">Kwota</th>
                <th>Płatność</th>
                <th class="text-right">Faktura</th>
                <th class="text-right">Opcje</th>
            </tr>
        </thead>
        <tbody>
        
            <? foreach($all_consultations as $c) { ?>
                <tr>
                    <td><?=date("Y-m-d H:i", strtotime($c->date))?></td>
                    <td><?=$c->order_number?></td>
                    <td>
                        <?=$c->name_surname?>
                    </td>
                    <td>
                    
                        <? foreach($c->products as $product) { ?>
                            <?=$product->name?><br />
                        <? } ?>
                    
                    </td>
                    <td align="right">
                        <h3 class="margin_0 padding_0"><span class="label label-primary"><?=$c->price?> zł</span></h3>
                    </td>
                    <td>
                    
                
                        <a class="pointer btn_modal pull-right" data-id="<?=$c->order_id?>" data-cont="order" data-func="payment">
                            <i class="font_12 glyphicon glyphicon-pencil tooltipa" data-original-title="Zmień status płatności"></i>  
                        </a>
                        <div id="div_order_payment"></div>
                
                    
                        <? $dotpay_values = dotpay_values($c->payment); ?>
                       
                    
                        <span class="label <?=$dotpay_values[1]?>"><?=$dotpay_values[0]?></span><br />
                        
                        <? if($c->payment == 2) { ?>
                            
                            <? $dotpay_channels_values = dotpay_channels_values($c->payment_channel); ?>
                            <span class="font_10"><?=$dotpay_channels_values?></span><br />
                            
                            <? if($c->payment_date && $c->payment_date != '0000-00-00 00:00:00') { ?>
                                <span class="font_10"><?=$c->payment_date?></span>
                            <? } ?>
                            
                        <? } ?>
                    
                    </td>
                    <td class="text-right">
                    
                        <a href="<?=base_url()?>cp/order/<?=$c->order_id?>/save" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-save tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Pobierz fakturę"></i>
                        </a>
                        
                        <a href="<?=base_url()?>admin/order/invoice/<?=$c->order_id?>">
                            <i class="font_12 glyphicon glyphicon-pencil tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Wystaw lub edytuj fakturę"></i>  
                        </a> 
                        
                        <hr class="margin_0 margin_t_5 margin_b_5" />
                    
                        <? if($c->invoice_number && $c->invoice_date && $c->invoice_date != '0000-00-00') { ?>
                            
                            <?=$c->invoice_number?><br />
                            <?=$c->invoice_date?>
                            
                        <? } else { ?>
                        
                            Proforma
                            
                        <? } ?>

                    </td>
                    <td align="right">
             
                        <?php /*?>
                        <a href="<?=base_url()?>admin/consultation/read/<?=$c->order_id?>">
                            <i class="glyphicon glyphicon-info-sign tooltipa font_20" data-toggle="tooltip" data-placement="left" data-original-title="Zobacz szczegóły, skontaktuj się z użytkownikiem"></i>  
                        </a>
                        <?php */?>
                        
                        <a href="<?=base_url()?>admin/consultation/read/<?=$c->order_id?>" class="margin_r_10">
                            <i class="glyphicon glyphicon-info-sign tooltipa font_12" data-toggle="tooltip" data-placement="left" data-original-title="Zobacz szczegóły, skontaktuj się z użytkownikiem"></i>  
                        </a>  
                        
                        <a href="<?=base_url()?>admin/order/update/<?=$c->order_id?>" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-pencil tooltipa" data-original-title="Edycja zamówienia"></i>  
                        </a>
                        
                        <a href="<?=base_url()?>admin/order/remove/<?=$c->order_id?>" class="confirm">
                            <i class="font_12 glyphicon glyphicon-remove tooltipa" data-original-title="Usuń"></i>  
                        </a>
                     
                    </td>
                </tr>
            <? } ?>
            
        </tbody>
                        
    </table>

<? } else { ?>
    
    <div class="margin_t_20">
    	<?=$this->load->view('_elements/message', array('message' => 'Brak złożonych zamówień konsultacji'), true)?>  
    </div>
    
<? } ?>
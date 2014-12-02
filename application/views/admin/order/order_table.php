<? if(count($all_orders) > 0) { ?>
    <table class="table table-striped table-condensed table-hover table-bordered" id="orders_table">
        <thead>
            <tr>
                <th width="120px">Data</th>
                <th width="150px">Zamawiający</th>
                <th width="">Sprzedawca</th>
                <th width="270px">Catering</th>
                <th width="80px" class="text-right">Kwota</th>
                <? if($access == 'seller') { ?>
                	<th width="80px" class="text-right">Prowizja</th>
                <? } ?>
                <th width="80px">Płatność</th>
                <th width="100px">Gramatura</th>
                <th class="text-right">Faktura</th>
                <th width="140px" class="text-right">Opcje</th>
            </tr>
        </thead>
        <tbody>
        
            <? foreach($all_orders as $o) { ?>
                <tr class="<?=($o->first_delivery <= date('Y-m-d') && $o->last_delivery >= date('Y-m-d') && $o->payment == 2 && $o->grammage == 1)?'success':''?>">
                    <td>
                        <?=date("Y-m-d H:i", strtotime($o->date))?><br />
                        <span class="font_12"><?=$o->order_number?></span>
                    </td>
                    <td>
                        <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/user/details/<?=$o->user_id?>"><?=$o->name_surname?></a><br />
                        <em>tel.</em> <?=$o->phone?>
                        <?php /*?><br /><?=$o->address?>, <?=$o->postcode?> <?=$o->city?><br /><em>tel.</em> <?=$o->phone?><br /><em>email.</em> <?=$o->email?><?php */?>
                    </td>
                    <td>
                    	<? if($this->users[$o->seller_id]->name_surname) { ?>
                        
                        	<? if($access != 'seller') { ?>
                            	<a href="<?=base_url()?>admin/seller/details/<?=$o->seller_id?>">
                            <? } ?>
								<?=$this->users[$o->seller_id]->name_surname?>
                        	<? if($access != 'seller') { ?>
                            	</a>
                            <? } ?>
                            
                    	<? } else { ?>
                        	-
                        <? } ?>
                    </td>
                    <td>

                        <?=$products[$o->packet_id]->name?> <span class="font_gray"><?=(is_array(unserialize($o->meals_selected)))?'('.implode(", ", unserialize($o->meals_selected)).')':''?></span><br />
						
                        <?=($o->days)?$o->days:0?> <span class="font_gray">dni, od</span> <?=$o->first_delivery?> <span class="font_gray">do</span> <?=$o->last_delivery?>
                       
                    </td>
                    <td align="right">
                        <?=$o->price?> zł
                    </td>
                    
					<? if($access == 'seller') { ?>
                    
                        <td align="right">
                            <?=$o->price * ($o->seller_provision/100)?> zł
                        </td>
                    
                    <? } ?>
                    
                    <td>
                    
                		<? if($access != 'seller') { ?>
                            <a class="pointer btn_modal pull-right" data-id="<?=$o->order_id?>" data-cont="order" data-func="payment">
                                <i class="font_12 glyphicon glyphicon-pencil tooltipa" data-original-title="Zmień status płatności"></i>  
                            </a>
                        <? } ?>
                        <div id="div_order_payment"></div>
                
                    
                        <? $dotpay_values = dotpay_values($o->payment); ?>
                       
                    
                        <span class="label <?=$dotpay_values[1]?> tooltipa pointer" title="<?=$dotpay_values[0]?>"> &nbsp; </span><br />
                        
                        <? if($o->payment == 2) { ?>
                            
                            <?php /*?>
                            <? $dotpay_channels_values = dotpay_channels_values(); ?>
                            <span class="font_10"><?=$dotpay_channels_values[$o->payment_channel]?></span><br />
                            <?php */?>
                            
                            <? if($o->payment_date && $o->payment_date != '0000-00-00 00:00:00') { ?>
                                <hr class="margin_0 margin_t_5 margin_b_5" />
                                <?=date("Y-m-d", strtotime($o->payment_date))?>
                            <? } ?>
                            
                        <? } ?>
                    
                    </td>
                    <td class="">
                        
                        <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/order/grammage/<?=$o->order_id?>" class="pull-right margin_l_10">
                            <i class="font_12 glyphicon glyphicon-cutlery tooltipa" data-original-title="Edycja gramatur, komentarzy posiłów"></i>  
                        </a>
                        
                        <?
                            $full = $o->deliveries_count*$o->meals*2;
                            if(in_array(5, unserialize($o->meals_selected))) {
                                $full = $full-$o->deliveries_count;
                            }
                            $percentage = ($o->grammage_filled/(($full)?$full:1))*100;
                        ?>
                        
                        <div class="progress progress-striped tooltipa" title="Gramatura wypełniona w <?=$percentage?>%">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=$percentage?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percentage?>%">
                                <span class="sr-only"><?=$percentage?></span>
                            </div>
                        </div>
                        
                        <?php /*?>
                        <? if($o->grammage == 1) { ?>
                            <span class="label label-success">UZUPEŁNIONA</span>
                        <? } else { ?>
                            <span class="label label-danger">PUSTA</span>
                        <? } ?>
                        <?php */?>
                    </td>
                    <td class="text-right middle">
                    
                        <a href="<?=base_url()?>cp/order/<?=$o->order_id?>/save" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-save tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Pobierz fakturę"></i>
                        </a>
                        
                        <? if($access != 'seller') { ?>
                            <a href="<?=base_url()?>admin/order/invoice/<?=$o->order_id?>">
                                <i class="font_12 glyphicon glyphicon-pencil tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Wystaw lub edytuj fakturę"></i>  
                            </a> 
                        <? } ?>
                        
                        <hr class="margin_0 margin_t_5 margin_b_5" />
                    
                        <? if($o->invoice_number && $o->invoice_date && $o->invoice_date != '0000-00-00') { ?>
                            
                            <?=$o->invoice_number?><br />
                            <? /*$o->invoice_date*/?>
                            
                        <? } else { ?>
                        
                            Proforma
                            
                        <? } ?>

                    </td>
                    <td align="right" class="middle nowrap">

                        <? if($o->order_form_id) { ?>
                            <a class="pointer margin_r_10 btn_modal" data-id="<?=$o->order_id?>" data-cont="order" data-func="read_form">
                                <i class="font_12 glyphicon glyphicon-list tooltipa" data-original-title="Formularz żywieniowy"></i>  
                            </a>
                            
                        <? } ?>
                        
                        <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/order/delivery/<?=$o->order_id?>" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-plane tooltipa" data-original-title="Szczegóły i edycja dostaw"></i>  
                        </a>
                        
                        <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/order/read/<?=$o->order_id?>" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-info-sign tooltipa" data-original-title="Szczegóły i edycja zamówienia"></i>  
                        </a>
                        
                        <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/order/update/<?=$o->order_id?>" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-pencil tooltipa" data-original-title="Edycja zamówienia"></i>  
                        </a>
                        
                        <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/order/remove/<?=$o->order_id?>" class="confirm">
                            <i class="font_12 glyphicon glyphicon-remove tooltipa" data-original-title="Usuń"></i>  
                        </a>

                    </td>
                </tr>
            <? } ?>
        </tbody>
                        
    </table>

<? } else { ?>
    
    <div class="margin_t_20">
    	<?=$this->load->view('_elements/message', array('message' => 'Brak złożonych zamówień lub brak złożonych zamówień w wybranym okresie.'), true)?>  
    </div>
    
<? } ?>
        
<div id="div_order_read_form"></div>

<div class="margin_b_20 clearfix"><i class="glyphicon glyphicon-exclamation-sign"></i> Na zielono zaznaczono aktywne w dzisiejszym dniu dostawy</div>
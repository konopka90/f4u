<div class="modal fade" id="modal_delivery_<?=$date?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
     
        	<? if($pay == true) { ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                    <h4 class="modal-title">Dostawy w dniu <?=date("Y-m-d", strtotime($date))?> są nieaktywne</h4>
                </div>
                <div class="modal-body watermark text-left">
                
                	<h3 class="margin_0 margin_b_20">Opłać zamówienie aby aktywować dostawy</h3>

                    <?=$this->load->view('cp/packets/_elements/packets_list', array('user_packets' => $user_packets, 'active_packet' => $active_packet, 'closest_delivery' => $closest_delivery), true)?>
                    
                    <h2 class="text-right">do zapłaty <span class="label label-danger"> <?=end($user_packets)->price?> PLN </span></h2>
                    
                    <div class="btn-group btn-group-justified margin_t_20">
                        
                        <a href="<?=$dotpay_url?>" class="btn btn-danger btn-lg"><i class="glyphicon glyphicon-usd"></i> &nbsp; Zapłać za zamówienie </a>
                        <a href="<?=base_url()?>cp/packets#order_<?=end($user_packets)->order_id?>" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-th-list"></i> &nbsp; Przejdź do listy zamówień </a>
                    </div>
                    
                    <?php /*?><a href="<?=base_url()?>cp/packets/remove/<?=$d->packet_id?>" class="btn btn-danger btn-xs margin_t_20"> Usuń zamówienie </a><?php */?>
                    
                </div>
                <div class="modal-footer margin_t_0">
                
                	<div class="btn-group">
                    	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                  	</div>
                    
                </div>

            <? } else { ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                    <h4 class="modal-title">Dostawy w dniu <?=strftime("%d %B %Y, %A", strtotime($date))?></h4>
                </div>
                <div class="modal-body watermark">
                	
                    <p>
                    	<i class="glyphicon glyphicon-info-sign"></i> &nbsp; W tym dniu masz dostawę <strong><?=reset($delivery)->meals?> posiłków</strong>.
                        
                    </p>
                
                    <table class="table margin_b_0">
                        <thead>
                            <tr>
                                <th>Adres dostawy</th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach($delivery as $d) { ?>
                                <tr>
                                    <td>
                                        <?=$d->name_surname?><br />
                                        <?=$d->address?>, <?=$d->postcode?> <?=$d->city?><br />
                                        <em>tel.</em> <?=$d->phone?><br />
                                        <? if($d->hours) { ?>
                                        	<em>godz.</em> <?=reset(delivery_hours_values($d->hours))?>
                                        <? } ?>
                                    </td>
                                    <td class="text-right">
                                        <? if(date("Y-m-d", strtotime("+3 days")) > $d->date) { ?>
                                            <?php /*?><button class="btn btn-inverse btn-xs"><i class="glyphicon glyphicon-ban-circle"></i></button><?php */?>
                                        <? } else { ?>
                                           	<a href="<?=base_url()?>cp/delivery/update/<?=$d->delivery_id?>" class="btn btn-success btn-lg" style="padding: 27px"><i class="glyphicon glyphicon-pencil"></i></a>
                                            <? $editable = true; ?>
                                        <? } ?>
                                    </td>
                                </tr>
                                <? if($d->user_notice) { ?>
                                    <tr>
                                        <th colspan="2">Twoje uwagi</th>
                                    </tr>
                                    <tr>
                                    	<td colspan="2">
											<?=$d->user_notice?>
                                        </td>
                                    </tr>
                                <? } ?>
                            <? } ?>
        
                        </tbody>
                                        
                    </table>

                </div>
               
                <div class="modal-footer margin_t_0">
                
                	<div class="btn-group">
                    	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                  	</div>
                    
                </div>
                
        	<? } ?>
        </div>
    </div>
</div>
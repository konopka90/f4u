<? if(!empty($sellers)) { ?>

    <table class="table table-striped table-condensed table-hover table-bordered" id="users_table">
        <thead>
            <tr>
                <th width="30px">ID</th>
                <th width="250px">Imię i nazwisko</th>
                <th width="">Dane kontaktowe</th>

                <th>
                	Klienci, zamówienia, wartość
                </th>
                <th>
                    Prowizja i saldo
                </th>
				<th>
                    Oczekująca wypłata
                </th>
                <th width="120px" class="text-right">Opcje</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($sellers as $u) { ?>
                <tr class="">
                    <td><?=$u->user_id?></td>
                    <td>
                        <?=$u->name_surname?><br />
                        <? if($u->address && $u->postcode && $u->city) { ?>
                            <?=$u->address?>, <?=$u->postcode?> <?=$u->city?>
                        <? } ?>
                    </td>
                    <td>
						<?=$u->email?><br />
                    	<?=($u->phone)?$u->phone:'-'?>
                   	</td>
                    <td class="middle text-center">
                    	<i class="fa fa-user muted"></i> &nbsp;<span class="tooltipa pointer" title="Ilość klientów"><?=$u->clients_count?></span> <i class="margin_l_20 fa fa-shopping-cart muted"></i> &nbsp;<span class="tooltipa pointer" title="Ilość zamówień klientów"><?=$u->orders_count?></span>
                        <i class="fa fa-usd muted margin_l_20"></i> &nbsp;<span class="tooltipa pointer" title="Wartość zamówień klientów"><?=floatval($u->orders_price)?></span> zł
                    </td>
                    <td class="middle text-center">
                   		<i class="fa fa-usd muted"></i> &nbsp;<span class="muted"><?=floatval($u->orders_provision)?> zł</span><br />
                        <i class="fa fa-usd"></i> &nbsp;<strong><?=floatval($u->saldo)?> zł </strong>
                    </td>
                    <td class="middle text-center <?=($u->waiting_payout == 1)?'warning':''?>">
                   		<? if($u->waiting_payout == 1) { ?>
                        	OCZEKUJE 
                            
                            <a href="<?=base_url()?>admin/seller/details/<?=$u->user_id?>#payout_table" class="margin_l_10 tooltipa" title="Zrealizuj">
                                <i class="font_12 fa fa-pencil"></i>
                            </a>
                            
                        <? } ?>
                    </td>
                    <td align="right" class="middle">
                    
         				<?php /*?>
                        <a class="margin_r_10" href="<?=base_url()?>admin/order/create/<?=$u->user_id?>">
                            <i class="font_12 glyphicon glyphicon-plus tooltipa" data-original-title="Dodaj zamówienie"></i>  
                        </a>
                        <?php */?>
    
                        <a href="<?=base_url()?>admin/seller/update/<?=$u->user_id?>" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-pencil tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Edycja klientów i zamówień sprzedawcy"></i>
                        </a>
                    
                        <a href="<?=base_url()?>admin/seller/details/<?=$u->user_id?>" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-info-sign tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Szczegóły klientówi i zamówień sprzedawcy"></i>
                        </a>
                        <a href="<?=base_url()?>admin/seller/remove/<?=$u->user_id?>" class="margin_r_10 confirm">
                            <i class="font_12 glyphicon glyphicon-remove tooltipa" data-original-title="Usuń sprzedawcę (wszyscy dotychczasowi klienci i zamówienia tego sprzedawcy zostaną bez przypisanego sprzedawcy)"></i>  
                        </a>

                    </td>
                </tr>
            <? } ?>
    
        </tbody>
                        
    </table>
    
<? } else { ?>

	<?=$this->load->view('_elements/message', array('message' => 'Brak dodanych partnerów', 'message_status' => 0), true)?>  

<? } ?>
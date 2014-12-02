<? if(!empty($users)) { ?>

    <table class="table table-striped table-condensed table-hover table-bordered" id="users_table">
        <thead>
            <tr>
                <th width="30px">ID</th>
                <th width="250px">Imię i nazwisko</th>
                <th width="">Dane kontaktowe</th>
                <th width="180px">Klient od</th>
                <th>Zamówienia, wartość</th>
                <th>Prowizja od klienta</th>
                <th width="200px" class="text-right">Opcje</th>
            </tr>
        </thead>
        <tbody>
        
            <? foreach($users as $u) { ?>
                <tr class="">
                    <td><?=$u->user_id?></td>
                    <td>
                        <?=$u->name_surname?><br />
                        <? if($u->address && $u->postcode && $u->city) { ?>
                            <?=$u->address?>, <?=$u->postcode?> <?=$u->city?>
                        <? } ?>
                    </td>
                    <td>
						<em>email:</em> <?=$u->email?><br />
						<?=($u->phone)?'<em>tel. </em>'.$u->phone:'-'?>
                    </td>
                    <td class="middle"><?=($u->assigned)?$u->assigned:'-'?></td>
                    <td class="middle text-center">
                    	<i class="fa fa-shopping-cart muted"></i> &nbsp;<span class="tooltipa pointer" title="Ilość zamówień klientów"><?=$u->orders_count?></span>
                        <i class="fa fa-usd muted margin_l_20"></i> &nbsp;<span class="tooltipa pointer" title="Wartość zamówień klientów"><?=floatval($u->orders_price)?></span> zł
                    </td>
                    <td class="middle text-center">
                    	<i class="fa fa-usd muted"></i> &nbsp;<span class="tooltipa pointer" title="Prowizja za zamówienia klienta"><?=floatval($u->orders_price)*($u->seller_provision/100)?></span> zł
                    </td>
                    
                    <td align="right" class="middle">
                    
                        <a class="margin_r_10" href="<?=base_url()?><?=($access == 'admin')?'admin':'sp'?>/order/create/<?=$u->user_id?>">
                            <i class="font_12 glyphicon glyphicon-plus tooltipa" data-original-title="Dodaj zamówienie"></i>  
                        </a>
    
                        <a href="<?=base_url()?><?=($access == 'admin')?'admin':'sp'?>/user/details/<?=$u->user_id?>" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-info-sign tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Szczegóły użytkownika"></i>
                        </a>
                        
                        <a href="<?=base_url()?><?=($access == 'admin')?'admin':'sp'?>/user/update/<?=$u->user_id?>" class="margin_r_10">
                            <i class="font_12 glyphicon glyphicon-pencil tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Edycja użytkownika"></i>
                        </a>
                        
                        <a href="<?=base_url()?><?=($access == 'admin')?'admin':'sp'?>/user/remove/<?=$u->user_id?>" class="margin_r_10 confirm">
                            <i class="font_12 glyphicon glyphicon-remove tooltipa" data-original-title="Usuń (wraz z zamówieniami)"></i>  
                        </a>
    
                    </td>
                </tr>
            <? } ?>
    
        </tbody>            
    </table>
    
<? } else { ?>

<? } ?>
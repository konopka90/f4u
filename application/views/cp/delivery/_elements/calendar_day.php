<? if($delivery->payment == 2) { ?>

	<? if($delivery->stopped) { ?>

    
        <a href="<?=base_url()?>cp/delivery/update/<?=$delivery->delivery_id?>" class="popovera label label-<?=(strtotime($delivery->date) < strtotime(date("Y-m-d")))?'default':'danger'?> moved pointer" data-date="<?=$delivery->date?>" id="delivery_<?=$delivery->delivery_id?>" data-moved="delivery_<?=$delivery->moved_to?>" title="" data-content="Dostawa została przeniesiona na inny dzień">{day}</a>    
       
		
    <? } else { ?>
    
		<a class="popovera label label-<?=(strtotime($delivery->date) < strtotime(date("Y-m-d")))?'default':'success'?> pointer btn_delivery_day" data-date="<?=$delivery->date?>" id="delivery_<?=$delivery->delivery_id?>" data-moved="delivery_<?=$delivery->moved_to?>" title="" data-content="W tym dniu masz dostawę <?=$delivery->meals?> posiłków. Zamówienie <?=$delivery->order_number?> zostało opłacone." data-toogle="modal" data-target="#modal_delivery_<?=$delivery->date?>">{day}</a>
        
	<? } ?>
    


<? } else { ?>

	<a class="popovera label label-warning pointer btn_delivery_day" data-pay="true" data-date="<?=$delivery->date?>" title="" data-content="Dostawa nieaktywna. Zamówienie <?=$delivery->order_number?> nie zostało jeszcze opłacone." data-toogle="modal" data-target="#modal_delivery_<?=$delivery->date?>">{day}</a>

<? } ?>


<? if($message) { ?>
	<div class="alert alert-<?=($message_status == 2)?'error':(($message_status == 3)?'success':'info')?> bordered">
    	<a class="close" data-dismiss="alert" href="#">&times;</a>
		<?=$message?>
    </div>
<? } ?>
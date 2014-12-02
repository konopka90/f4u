<? if(count($food_form) > 0) { ?>
	<table class="table table-striped table-condensed font_12">
		<? foreach($food_form as $field => $ff) { ?>
        	<? //var_dump($ff); echo"<br />";?>
			<? if(!in_array($field, array('order_form_id', 'order_id', 'user_id', 'status')) && $ff !== NULL) { ?>
				<tr>
					<td><?=(lang($field))?lang($field):$field?></td>
					<td><?=$ff?></td>
				</tr>
			<? } ?>
		<? } ?>
	</table>
<? } else { ?>
	Brak rekordu
<? } ?>
<div class="quote_box editor_field" id="quote_box_<?=$quote_id?>">
	<h3>Cytat</h3>
    <div class="field_desc">
    	Autor
	</div>
    <img src="<?=base_url('skins/default/img/ico_delete.png')?>" class="remove_element_box_button remove_quote_box_button right" data-element_type="quote" data-element_id="<?=$element_id?>" data-quote_id="<?=$quote_id?>" />
	<div class="field">
		<?=form_input(array('name'=>'quote['.$quote_id.'][author]', 'id'=>'input-'.$quote_id.'', 'data-quote_id' => $quote_id, 'data-element_id' => $element_id,  'value' => ((isset($author))?$author:''), 'style'=>'width:300px'))?>
    </div>
    <div class="clear"></div>
    <div class="field_desc">
    	Cytat
	</div>
	<div class="field">
		<?=form_textarea(array('name'=>'quote['.$quote_id.'][quote]', 'id'=>'quote_textarea_'.$quote_id, 'value' => ((isset($quote))?$quote:''), 'style'=>'width:625px', 'rows'=>'2'))?>
    </div>
    <div class="clear"></div>
</div>
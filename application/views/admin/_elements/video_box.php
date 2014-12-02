<div class="video_box editor_field" id="video_box_<?=$video_id?>">
	<h3>Video z YouTube</h3>
    <div class="field_desc">
    	Adres URL
	</div>
    <img src="<?=base_url('skins/default/img/ico_delete.png')?>" class="remove_element_box_button remove_video_box_button right" data-element_type="video" data-element_id="<?=$element_id?>" data-video_id="<?=$video_id?>" />
	<div class="field">
		<?=form_input(array('name'=>'video', 'id'=>'input_'.$video_id, 'data-video_id' => $video_id, 'data-element_id' => $element_id, 'value' => ((isset($url))?$url:''), 'style'=>'width:610px'))?>
    </div>
    <div class="clear"></div>
    <div class="field_desc">
    	Opis
	</div>
	<div class="field">
		<?=form_textarea(array('name'=>'video', 'id'=>'video_textarea_'.$video_id, 'value' => ((isset($desc))?$desc:''), 'style'=>'width:625px', 'rows'=>'1'))?>
    </div>
    <div class="clear"></div>
</div>
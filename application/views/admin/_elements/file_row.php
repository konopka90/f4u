<li class="file_box" id="file_box_<?=$file_id?>">

	<div class="file_desc right" id="file_desc_<?=$file_id?>"><?=(isset($desc))?$desc:''?></div>
    <textarea id="file_desc_textarea_<?=$file_id?>" class="right" rows="2" cols="40" style="display:none"><?=(isset($desc))?$desc:''?></textarea>

	<img src="<?=base_url('skins/default/img/file_icon')?>/<?=(isset($extension) && $extension)?$extension:'default'?>.png" height="32" class="file_icon left"/>

    <img src="<?=base_url('skins/default/img/ico_delete.png')?>" class="remove_row_button remove_file_button left" data-file_id="<?=$file_id?>" data-modul="file"/>
    <img src="<?=base_url('skins/default/img/ico_edit_desc.png')?>" class="edit_desc_button edit_file_desc_button left" id="edit_file_desc_button_<?=$file_id?>" data-file_id="<?=$file_id?>" data-modul="file"/>
    <img src="<?=base_url('skins/default/img/ico_save.png')?>" class="save_desc_button save_file_desc_button left" id="save_file_desc_button_<?=$file_id?>" style="display:none" data-file_id="<?=$file_id?>" data-modul="file"/>
	<div class="file_name"><a href="<?=base_url('uploads')?>/<?=$path?>"><?=($name)?$name:$path?></a></div>
</li>
<div class="clear"></div>
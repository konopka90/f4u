<div class="editor_field folder_box" id="folder_box_<?=$folder_id?>">
	<h3>Folder</h3>
	<img src="<?=base_url('skins/default/img/ico_delete.png')?>" class="remove_element_box_button remove_folder_box_button right" data-element_type="folder" data-element_id="<?=$element_id?>" data-folder_id="<?=$folder_id?>" />
    <div class="add_file_box">
    	<a class="send_button" href="javascript: $('#file_upload_<?=$folder_id?>').uploadify('upload','*')">Wyślij pliki</a>
        <?=form_upload(array('name'=>'Filedata', 'id'=>'file_upload_'.$folder_id, 'class'=>'left'))?>
    </div>

    <ul class="files_list" id="files_list_<?=$folder_id?>">
    	<? if(isset($files_list[$folder_id])) { ?>
        	<? foreach($files_list[$folder_id] as $file_id => $v) { ?>
            	<?=$this->load->view('admin/_rows/file_row', $v, true)?>
            <? } ?>
        <? } ?>
    </ul>
</div>

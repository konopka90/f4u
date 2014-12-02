<div class="editor_field">
    <h3>Autor</h3>
    <?=form_dropdown('form_author', $users_list, ((isset($data->user_id))?$data->user_id:'0'), 'style="width:210px" id="form_author" class="ajax_save"')?>
</div>
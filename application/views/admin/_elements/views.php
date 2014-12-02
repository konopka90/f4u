<div class="editor_field">
    <h3>Ilość wyświetleń</h3>
    <?=form_input(array('class' => 'ajax_save', 'name' => 'form_views', 'id' => 'form_views', 'size' => '30', 'value' => ((isset($data->views))?$data->views:0)))?>
</div>
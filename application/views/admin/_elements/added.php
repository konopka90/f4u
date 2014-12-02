<div class="editor_field">
    <h3>Data dodania</h3>
    <?=form_input(array('name' => 'form_added', 'id' => 'form_added', 'size' => '30', 'value' => ((isset($data->added))?$data->added:date("Y-m-d H:i:s")), 'class'=>'datepicker ajax_save'))?>
</div>

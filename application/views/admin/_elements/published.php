<div class="editor_field">
    <h3>Publikacja</h3>
    <?=form_radio(array('class'=>'ajax_save', 'name'=>'form_published', 'id'=>'form_published[0]','value'=>0,'checked'=>((isset($data->published) && $data->published == 0)?true:false)))?> <?=form_label('nie publikuj', 'form_published[0]')?><br />
        <?=form_radio(array('class'=>'ajax_save','name'=>'form_published', 'id'=>'form_published[1]','value'=>1,'checked'=>((isset($data->published) && $data->published == 1)?true:false)))?> <?=form_label('publikuj', 'form_published[1]')?><br />
        <?=form_radio(array('class'=>'ajax_save','name'=>'form_published', 'id'=>'form_published[2]','value'=>2,'checked'=>((isset($data->published) && $data->published == 2)?true:false)))?> <?=form_label('publikuj okresowo', 'form_published[2]')?>
</div>
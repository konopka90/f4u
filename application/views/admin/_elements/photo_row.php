<div class="col-sm-4 col-md-3" id="photo_<?=$photo_id?>">
    <div class="thumbnail" style="background: transparent url(<?=base_url()?>img/<?=$medium_path?>) no-repeat center center">
    	
        <div style="height: 200px"></div>
        
    	<div class="caption">
        
      		<?php /*?>	  
        	<? if($desc) { ?>
                <p><?=$desc?></p>
            <? } ?>
            <?php */?>

            <div class="modal fade" id="photo_<?=$photo_id?>_modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        	<h4 class="modal-title">Edytujesz opis</h4>
                    	</div>
                    	<div class="modal-body">
                        	<img src="<?=base_url()?>img/<?=$medium_path?>" class="img-responsive margin_b_20">
                            
                            <textarea id="photo_<?=$photo_id?>_desc" id="photo_<?=$photo_id?>_desc" placeholder="Opis obrazka" class="form-control" rows="2"><?=$desc?></textarea>

  						</div>
                        <div class="modal-footer">
                        	<button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                        	<button type="button" class="btn btn-success btn_update_field" data-table="photo" data-field="desc" data-id="<?=$photo_id?>" data-value="#photo_<?=$photo_id?>_desc">Zapisz</button>
                        </div>
                    </div>
                </div>
            </div>
            


    		<p class="margin_b_0">
            	<a class="btn btn-primary btn-xs margin_b_0" data-toggle="modal" data-target="#photo_<?=$photo_id?>_modal"><i class="glyphicon glyphicon-pencil"></i> </a>
                <?php /*?>
                <a class="btn btn-default btn-xs btn_move margin_b_0" role="button"><i class="glyphicon glyphicon-move"></i></a>
                <?php */?>
                <a class="btn btn-danger btn-xs btn_remove_element margin_b_0" data-type="photo" data-id="<?=$photo_id?>"><i class="glyphicon glyphicon-trash"></i></a>
            </p>
            
            
            
    	</div>
    </div>
</div>



<?php /*?>
<li data-photo_id="<?=$photo_id?>">

	<div class=" " id=" "><?=(isset($desc))?$desc:''?></div>
    
    <textarea id="photo_desc_textarea_<?=$photo_id?>" class="right" rows="4" cols="17" style="display:none"><?=(isset($desc))?$desc:''?></textarea>

	<img src="<?=base_url()?>img/<?=isset($thumb_path)?$thumb_path:$original_path?>" height="70" class=""/>
    
  
    <img src="<?=base_url('skins/default/img/ico_delete.png')?>" class="remove_row_button remove_photo_button left" data-photo_id="<?=$photo_id?>" data-module="photo" /><br><br>
    <img src="<?=base_url('skins/default/img/ico_move.png')?>" class="pointer move_button left" data-photo_id="<?=$photo_id?>" data-module="photo" /><br><br>
    <img src="<?=base_url('skins/default/img/ico_edit_desc.png')?>" class="edit_desc_button edit_photo_desc_button left" id="edit_photo_desc_button_<?=$photo_id?>" data-photo_id="<?=$photo_id?>" data-modul ="photo" />
    <img src="<?=base_url('skins/default/img/ico_save.png')?>" class="save_desc_button save_photo_desc_button" id="save_photo_desc_button_<?=$photo_id?>" style="display:none" data-photo_id="<?=$photo_id?>" data-modul ="photo" />
   
</li>
<?php */?>
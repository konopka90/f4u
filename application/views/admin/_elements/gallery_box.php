<div class="well" id="gallery_<?=$gallery_id?>">

	<a class="btn btn-danger btn_remove_element pull-right margin_l_10" data-type="gallery" data-id="<?=$gallery_id?>"><i class="glyphicon glyphicon-trash"></i></a>
    <?php /*?><a class="btn btn-default btn_move_element pull-right" data-type="gallery" data-id="<?=$gallery_id?>"><i class="glyphicon glyphicon-move"></i></a><?php */?>

	<h3>Galeria</h3>

	<input type="file" name="Filedata" id="gallery_upload_<?=$gallery_id?>" class="uploadify" data-type="gallery" data-id="<?=$gallery_id?>" />

    <div class="row" id="gallery_<?=$gallery_id?>_photos">
        <? if(isset($page_elements_photos[$gallery_id])) { ?>
            
            <? $i = 0; ?>
            <? foreach($page_elements_photos[$gallery_id] as $photo_id => $v) { ?>
            
                <? if($i%4 == 0) { ?>
                    <?php /*?><div class="row"><?php */?>
                <? } ?>
            
                <? $v->i = $i; ?>

                <?=$this->load->view('admin/_elements/photo_row', $v, true)?>
                
                <? if($i%4 == 3) { ?>
                    <?php /*?></div><?php */?>
                <? } ?>
                
                <? $i++; ?>
                
            <? } ?>
        <? } ?>
    </div>
   
    <?php /*?>
    <script>
		$(function() {
			$( "#photos_list_<?=$gallery_id?>" ).sortable({
				revert: "invalid",
				iframeFix: true,
				handle: 'img.move_button',
				update: function(event, ui) {
					var first = ui.item[0].id;
					$('.photo_box').removeClass('first');
					$('#' + first).addClass('first');
					var tree = $(this).sortable('toArray', {attribute: 'data-photo_id'});
					console.log(tree);
					$.ajax({
						url: '<?=base_url()?>ajax/photos_order',
						type: 'POST',
						data: {tree: tree }
					}); 
					
				}
			});
			$( "#photos_list_<?=$gallery_id?>" ).disableSelection();
		});
    </script>
    <?php */?>
</div>

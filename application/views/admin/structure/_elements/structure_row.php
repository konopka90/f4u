<div class="well well-sm margin_b_5">

	<div class="btn-group pull-right margin_l_20">
    
    	<a class="margin_l_10 tooltipa pointer btn_publication_change" id="btn_publication_change_<?=$v['structure_id']?>" data-original-title="Zmień status publikacji" data-id="<?=$v['structure_id']?>" data-publication="<?=$v['publication']?>"><i class="glyphicon glyphicon-eye-<?=($v['publication'] == 0)?'close':'open'?>"></i></a>
    
    	<a class="margin_l_10 tooltipa pointer" data-original-title="Edytuj" href="<?=base_url()?>admin/structure/edit/<?=$v['structure_id']?>"><i class="glyphicon glyphicon-pencil"></i></a>
        <?php /*?><a class="btn btn-primary btn-xs" href="<?=base_url()?>admin/structure/edit/<?=$v['structure_id']?>"> edytuj </a><?php */?>
        
        <a class="move margin_l_10 tooltipa pointer" data-original-title="Przenieś"><i class="glyphicon glyphicon-move"></i></a>
        <?php /*?><a class="move btn btn-default btn-xs"> przesuń </a><?php */?>
        
        <a class="btn_remove_row margin_l_10 tooltipa pointer" data-original-title="Usuń" data-id="<?=$v['structure_id']?>"><i class="glyphicon glyphicon-trash"></i></a>
        <?php /*?><a class="btn btn-danger btn-xs btn_remove_row" data-id="<?=$v['structure_id']?>"> usuń </a><?php */?>
        
        
        
 	</div>
     
 	<?php /*?><span class="pull-right muted font_9">(dodano <?=$v['added']?>)</span><?php */?>
 
    <a href="<?=base_url()?>admin/structure/edit/<?=$v['structure_id']?>" />
		<?=($v['name'])?$v['name']:'<i>brak tytułu</i>'?>
    </a>
    
</div>
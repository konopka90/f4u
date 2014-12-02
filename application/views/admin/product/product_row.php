<div class="well well-sm margin_b_5">

	<div class="btn-group pull-right margin_l_20">
    
    	<a class="margin_l_10 tooltipa pointer" data-original-title="Edytuj" href="<?=base_url()?>admin/product/update/<?=$v['product_id']?>"><i class="glyphicon glyphicon-pencil"></i></a>
        <?php /*?><a class="btn btn-primary btn-xs" href="<?=base_url()?>admin/structure/edit/<?=$v['product_id']?>"> edytuj </a><?php */?>
        
        <a class="move margin_l_10 tooltipa pointer" data-original-title="Przenieś"><i class="glyphicon glyphicon-move"></i></a>
        <?php /*?><a class="move btn btn-default btn-xs"> przesuń </a><?php */?>
        
        <a class="btn_remove_row margin_l_10 tooltipa pointer" data-original-title="Usuń" data-id="<?=$v['product_id']?>"><i class="glyphicon glyphicon-trash"></i></a>
        <?php /*?><a class="btn btn-danger btn-xs btn_remove_row" data-id="<?=$v['product_id']?>"> usuń </a><?php */?>
        
         
        
 	</div>
     
 	<?php /*?><span class="pull-right muted font_9">(dodano <?=$v['added']?>)</span><?php */?>
 
    <a href="<?=base_url()?>admin/product/update/<?=$v['product_id']?>" />
		<?=($v['name'])?$v['name']:'<i>brak tytułu</i>'?> - <strong><?=$v['price']?> zł</strong>
    </a>
    
    <p class="margin_0"><?=$v['desc']?></p>
    
</div>
<? if(count($v['childs']) > 0 && $v['depth'] == 0) { ?>

	<a data-toggle="dropdown" href="#"> <?=$v['name']?> <span class="caret"></span> </a>
    
<? } elseif($v['depth'] > 1) { ?>

	<a href="<?=base_url()?>page/<?=$v['link']?>"> <?=str_repeat(" &nbsp; &nbsp; ", $v['depth'])?> <?=$v['name']?> </a>
    
<? } else { ?>

	<a href="<?=base_url()?>page/<?=$v['link']?>"> <?=$v['name']?> </a>
	
<? } ?>
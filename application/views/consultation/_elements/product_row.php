<?
	//czy jest w sesji?
	$consultation_products = $this->session->userdata('consultation_products');
	$checked = false;
	if(is_array($consultation_products) && count($consultation_products) > 0) {
		foreach($consultation_products as $p) {
			if($p->product_id == $v['product_id']) {
				$checked = true;
				break;	
			}
		}
	}
?>

<? if(!$v['parent_id']) { ?>

	<? if(count($v['childs']) > 0) { ?>
		<h3 class="font_gray"><?=$v['name']?></h3>
    <? } else { ?>
        <h3 class="font_green margin_b_0">
        
            <input type="checkbox" name="<?=clean_chars($v['name'])?>" id="<?=$v['product_id']?>" class="product" value="1" <?=($checked)?'checked':''?>> &nbsp; 
            <label for="<?=$v['product_id']?>"><?=$v['name']?></label> 
            <span class="pull-right label label-primary"><?=$v['price']?> PLN</span>
            
        </h3>
		<? if($v['name']) { ?>
            <p class="margin_0 margin_l_30"><?=$v['desc']?></p>
        <? } ?>
    <? } ?>

	<hr />
    
<? } else { ?>

    <?
        

        $level = $v['depth'] + 1;		
    
    ?>

	<? if(count($v['childs']) > 0) { ?>
		<h4 class="font_gray margin_l_<?=(($level - 1) * 30)?>">
			<?=$v['name']?>
       	</h4>
    <? } else { ?>

        <h4 class="font_green margin_b_0"> 
            
            <input type="checkbox" name="<?=clean_chars($v['name'])?>" id="<?=$v['product_id']?>" class="product margin_l_<?=(($level - 1) * 30)?>" value="1" <?=($checked)?'checked':''?>> 
            <label class="margin_l_10" for="<?=$v['product_id']?>"><?=$v['name']?></label>
            
            <span class="pull-right label label-primary"><?=$v['price']?> PLN</span>
        
        </h4>
    
		<? if($v['name']) { ?>
            <p class="margin_l_<?=(($level - 1) * 30 * 2)?>"><?=$v['desc']?></p>
        <? } ?>
    
    <? } ?>
    


<? } ?>


<div class="row margin_t_30">
    
    <h2 class="margin_b_30 border_b_3 padding_b_10"><?=$page->name?></h2>

	<div class="row">
    
        <div class="col-md-8">
    
            <?=$this->load->view('_elements/elements', array('elements' => $page_elements, 'page_elements_photos' => $page_elements_photos), true)?>
    
            <? if(count($packets) > 0) { ?>
    
                
                
                <? foreach($packets as $p) { ?>
                
                    <? 
                    $packets_meals_per_day_values = packets_meals_per_day_values($p->meals_per_day); 
                    
                    $t = explode('_', $p->meals_per_day);
                    
                    ?>
                    
                    <div class="jumbotron pricing" style="background: transparent url(<?=base_url()?>img/meals_<?=end($t)?>.jpg)">
                        <h1 class="pull-right margin_0" style="position: relative;top: -48px;right: -61px"><span class="label label-danger"><?=$p->price_for_day?> PLN</span></h1>
                        <h1 class=""><strong><?=$packets_meals_per_day_values[0]?></strong></h1>
                        <p><?=$p->desc?></p>
                       
                    </div>
                            
                <? } ?>
                
            <? } ?>
            
        </div>
        
        <div class="col-md-4">
        
			<?=$this->load->view('_elements/right_column', array(), true)?>
                        
            <div class="btn-group btn-group-justified">
            
            	<a href="<?=base_url()?>page/zamowienia" class="btn btn-success btn-lg">ZŁÓŻ ZAMÓWIENIE</a>
            
            </div>
            
            
        </div>
        
	</div>
    
</div>





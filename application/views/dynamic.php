<div class="row">

    <div class="col-md-12">

        <h2 class="margin_t_30 margin_b_30 border_b_3 padding_b_10"><?=$page->name?></h2>
        
        <? //printr($page_elements_photos); ?>
        
        <?=$this->load->view('_elements/elements', array('elements' => $page_elements, 'page_elements_photos' => $page_elements_photos), true)?>
                    
    </div>
  
</div>



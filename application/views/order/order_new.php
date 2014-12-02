<div class="row margin_t_30">
	<div class="col-md-8 padding_b_30" style="">
    
		<h2 class="margin_b_30">Złóż zamówienie i zostań naszym klientem już dzisiaj!</h2>
        
        <div class="font_18">Najpierw sprecyzuj parametry swojego zamówienia, zrobisz to szybciej niż Ci się wydaje! Możesz to zrobić na 3 sposoby - wybierając zakres dni w które chcesz mieć dostawę, wybierając iość posiłków lub wybierając konkretne dni!</div>
        
        <div style="min-height: 1000px; background: transparent url(<?=base_url()?>img/ks_bg.png) no-repeat left bottom">
			<?=$this->load->view('order/_elements/calculator_new', array('packets_names' => $packets_names, 'user' => $user), true)?>
        </div>
        
        
        
	</div>
    <div class="col-md-4">
    
    	<?=$this->load->view('_elements/right_column', array(), true)?>
	
	</div>
</div>
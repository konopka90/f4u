<div class="row margin_t_30">
	<div class="col-md-8 padding_b_30" style="background: transparent url(<?=base_url()?>img/ks_bg.png) no-repeat left bottom">
    
		<h2>Złóż zamówienie i zostań naszym klientem już dzisiaj!</h2>
        
        <p class="alert  alert-dismissable">Najpierw sprecyzuj parametry swojego zamówienia, zrobisz to szybciej niż Ci się wydaje!</p>
        
        <div style="min-height: 350px;">
			<?=$this->load->view('order/_elements/calculator', array('packets_names' => $packets_names, 'user' => $user), true)?>
        </div>
        
        
        
	</div>
    <div class="col-md-4">
    
    	<?=$this->load->view('_elements/right_column', array(), true)?>
	
	</div>
</div>
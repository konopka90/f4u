<h2 class="margin_t_30 margin_b_10 text-center"><?=base64_decode($name_surname)?>, Twoje zamówienie zostało złożone!</h2>                     

<div class="row ">

    <div class="col-md-3">
    
    </div>
    
    <div class="col-md-6">

		<p class="alert alert-dismissable margin_b_30 padding_0 text-center">
        	Skontaktujemy sie z Tobą w przeciągu maksymalnie 30 minut. 
        </p>
        
        <hr />
        
        <? if($user->user_id) { ?>

			<div class="btn-group btn-group-justified margin_b_20">
       			<a href="<?=base_url()?>cp/packets" class="btn btn-success btn-lg">Przejdź do Panelu klienta</a>   
            </div>
            
        <? } else { ?>
        
            <p class="alert alert-dismissable margin_b_30 padding_0 text-center">
                Złożyłeś właśnie u nas swoje pierwsze zamówienie, miło nam poinformować że założyliśmy dla ciebie konto w naszym panelu klienta! Zaloguj się korzystając z podanego podczas procesu składania zamówienia <strong>adresu e-mail</strong> i <strong>hasła, które otrzymałeś w ostatnim e-mailu od nas</strong> i sprawdź jakie ciekawostki przygotowaliśmy! 
            </p>
    
            <div class="dropdown margin_b_30 text-center">
                <?=$this->load->view('user/login_form', array('redirect' => base64_encode(base_url() . 'cp')), true)?>
            </div>
            
        <? } ?>
        
    </div>
    
    <div class="col-md-3">
    
    </div>
    
</div>

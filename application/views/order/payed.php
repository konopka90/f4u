<div class="row">

	<div class="col-md-12 text-center margin_t_30">
    
    	<? if($this->input->get('status') == 'OK') { ?>
        
            <h2 class="margin_0 margin_t_30">Płatność za Twoje zamówienie została zaksięgowana!</h2>
			
            <? if($this->data['order']->products[0]->type == 'packet') { ?>
            	<h4 class="margin_0 margin_t_20 margin_b_20">Od tej pory, wszystkie Twoje dostawy stały się aktywne!</h4>
            <? } else { ?>
            	<h4 class="margin_0 margin_t_20 margin_b_20">Teraz pora na nasz ruch - już, zaraz skontaktujemy się z Tobą!</h4>
            <? } ?>

   
            <p class="alert alert-dismissable margin_t_20 margin_b_20 padding_0 text-center">
            
                Złożyłeś właśnie u nas zamówienie, jeśli to było Twoje pierwsze zamówienie - miło nam poinformować że założyliśmy dla ciebie konto w naszym panelu klienta! Zaloguj się korzystając z podanego podczas procesu składania zamówienia <strong>adresu e-mail</strong> i <strong>hasła, które otrzymałeś w e-mailu od nas</strong>.
    
            </p>
            
            <p class="alert alert-dismissable margin_t_20 margin_b_20 padding_0 text-center">
    
                Jeśli jesteś naszym stałym użytkownikiem i masz już konto w serwisie - zaloguj się na nie.   
                
            </p>
            
            <div class="row">
            
                <div class="col-md-4"></div>
                
                <div class="col-md-4">
            
                    <div class="dropdown margin_b_20 text-center">
                        <?=$this->load->view('user/login_form', array('redirect' => base64_encode(base_url() . 'cp')), true)?>
                    </div>
                  
                </div>

                <div class="col-md-4"></div>
                
            </div>


        <? } else { ?>
        
            <h2 class="margin_0 margin_t_30">Płatność zakończyła się niepowodzeniem!</h2>
			
            <h4 class="margin_t_20 margin_b_20">Twoje zamówienie wciąż nie zostało opłacone, skontaktuj się z administratorem - jesli uważasz że coś poszło nie tak, lub</h4>

            <div class="row margin_b_30">
            
                <div class="col-md-4"></div>
                
                <div class="col-md-4">
            
                    <div class="btn-group-justified">
                        <a href="<?=$dotpay_url?>" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-minus-sign"></i> &nbsp; Zapłać za zamówienie </a>
                    </div>
                  
                </div>
                
                <div class="col-md-4"></div>
                
            </div>

            <? if($this->data['order']->products[0]->type == 'packet') { ?>
            
            <? } else { ?>
       
            <? } ?>
            
        <? } ?>


</div>
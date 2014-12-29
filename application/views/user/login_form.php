<form method="post" action="<?=base_url()?>user/login/<?=$redirect?>" class="form-horizontal login_form text-left">
    
    <? if($redirect) { ?>
    	<input type="hidden" name="redirect" id="redirect" value="<?=$redirect?>">
    <? } ?>
    
    <?
	
		$warnings = validation_errors();
	
		if($warnings) { ?>
        
            <div class="alert alert-warning">
                <?=$warnings?>
            </div>
        
        <? } 
	
	?>
    
    <div class="form-group">
    	<div class="col-xs-12">
            <div class="my-description-in-form">Twój Email</div>
    		<input type="email" name="email" id="email<?=($popover == true)?'_ajax':''?>" class="form-control">
    	</div>
    </div>
    
    <div class="form-group">
    	<div class="col-xs-12">
            <div class="my-description-in-form">Hasło</div>
    		<input type="password" name="password" id="password<?=($popover == true)?'_ajax':''?>" class="form-control" >
   	 	</div>
    </div>
    
    <? if($popover != true) { ?>
        <div class="form-group">
            <div class="col-sm-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Nie wyloguj, gdy zamknę przeglądarkę
                    </label>
                </div>
            </div>
            <div class="col-sm-6 text-right">
                <a href="<?=base_url()?>user/password_remind" class="btn"><i class="glyphicon glyphicon-flash"></i> Zapomniałem hasła</a>
            </div>
        </div>
    <? } ?>
                <div class="btn-group">
                <button type="submit" class="btn my-button my-button-send" data-login="true"> Zaloguj </button>
        </div>

	<? if($popover == true) { ?>
    
    	<hr />
    
		<div class="btn-group btn-group-justified margin_b_20">
		   
			<a class="btn btn_register btn-lg my-button"> Jestem nowym użytkownikiem </a>	
		   
		</div>
        
        <p>
        	Jeśli jesteś nowym użytkownikiem i nie masz jeszcze konta w naszym serwisie skorzystaj z tej opcji, Twoje konto zostanie załozone podczas składania zamówienia, a hasło wyślemy na twojego emaila.
        </p>
        
	<? } ?>

</form>
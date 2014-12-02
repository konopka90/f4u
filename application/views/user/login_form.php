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
    		<input type="email" name="email" id="email<?=($popover == true)?'_ajax':''?>" class="form-control" placeholder="Twój email">
    	</div>
    </div>
    
    <div class="form-group">
    	<div class="col-xs-12">
    		<input type="password" name="password" id="password<?=($popover == true)?'_ajax':''?>" class="form-control" placeholder="Hasło">
   	 	</div>
    </div>
    
    <? if($popover != true) { ?>
        <div class="form-group">
            <div class="col-xs-12">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Nie wylogowywuj, gdy zamknę przeglądarkę
                    </label>
                </div>
            </div>
        </div>
    <? } ?>
    
    <div class="form-group margin_b_0">
    	<div class="col-xs-6">
        	<div class="btn-group">
            	<button type="submit" class="btn btn-primary <?=($popover == true)?'btn_login':''?>"><i class="glyphicon glyphicon-user"></i></button>
                <button type="submit" class="btn btn-primary <?=($popover == true)?'btn_login':''?>" data-login="true"> Zaloguj </button>
            </div>
    	</div> 
        <div class="col-xs-6 text-right">
        	<a href="<?=base_url()?>user/password_remind" class="btn btn-link"><i class="glyphicon glyphicon-flash"></i> Zapomniałem hasła</a>
        </div>
    </div>
    

	<? if($popover == true) { ?>
    
    	<hr />
    
		<div class="btn-group btn-group-justified margin_b_20">
		   
			<a class="btn btn-success btn_register btn-lg"> Jestem nowym użytkownikiem </a>	
		   
		</div>
        
        <p>
        	Jeśli jesteś nowym użytkownikiem i nie masz jeszcze konta w naszym serwisie skorzystaj z tej opcji, Twoje konto zostanie załozone podczas składania zamówienia, a hasło wyślemy na twojego emaila.
        </p>
        
	<? } ?>

</form>
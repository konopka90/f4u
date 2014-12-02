<div class="row margin_t_30">

	<div class="col-md-6">
    
    	<? $name = reset(explode(" ", $user->name_surname)); ?>
    
    	<h2 class="margin_0 margin_b_10 border_b_3 padding_b_10"><?=$name?>, witaj w naszym serwisie!</h2>

		<h4 class="margin_t_20 margin_b_20 font_green">Logujesz się tutaj pierwszy raz - ze względów bezpieczeństwa musisz zmienić domyślne hasło które od nas otrzymałeś na dowolne inne. Jest to jednorazowa czynność.</h4>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>  
        
        <div class="margin_b_30 clearfix">
        
			<form method="post" action="<?=base_url()?>user/first_login" class="form-horizontal login_form text-left">
                
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
                        <input type="password" name="new_password" id="password" class="form-control" placeholder="Nowe hasło" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="password" name="new_password_repeated" id="" class="form-control" placeholder="Powtórz nowe hasło" required>
                    </div>
                </div>
                
                
                <div class="form-group margin_b_0">
                    <div class="col-xs-6">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-user"></i></button>
                            <button type="submit" class="btn btn-primary"> Zmień hasło </button>
                        </div>
                    </div> 
                </div>
                
            
            </form>
        
        </div>
    </div>
    
    <div class="col-md-6" style="background: transparent url(<?=base_url()?>img/a_gdy_sie_zalogujesz.png) no-repeat left top;height: 270px">
    
    
    </div>
    
</div>
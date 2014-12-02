<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('cp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Klienta</a></li>
    <li class="active">Edycja konta</li>
</ol>
<h3 class="margin_0 margin_b_10 border_b_3 padding_b_10"><i class="glyphicon glyphicon-user muted"></i>&nbsp; Edycja konta</h3>

<div class="row">

	<div class="col-md-12">
    
        <form class="form" role="form" method="post" action="<?=current_url()?>" id="user_form">

			<?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => 0), true)?>

            <div class="row margin_t_30">

                <div class="col-md-6">
					<h4 class="margin_0 margin_b_20">Dane osobowe</h4>
                    
                    <div class="form-group">
                        <label>Imię i nazwisko *</label>
                        <input type="text" name="name_surname" class="form-control" placeholder="Imię i nazwisko" value="<?=$user->name_surname?>" required>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label>Adres *</label>
                        <input type="text" name="address" class="form-control" placeholder="Adres" value="<?=$user->address?>" required>
                        
                        <div class="row margin_t_15">
                            <div class="col-lg-4">
                                <input type="text" name="postcode" class="form-control" placeholder="Kod pocztowy" value="<?=$user->postcode?>" required> 
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="city" class="form-control" placeholder="Miasto" value="<?=$user->city?>" required>
                            </div>
                        </div>
                        <span class="help-block margin_b_0 margin_t_10"><i class="glyphicon glyphicon-info-sign"></i> Jest to domyślny adres do fakturowania i wysyłki dla przyszłych zamówień, który zawsze możesz zmienić w trakcie składania kolejnego zamówienia.</span>
                    </div>
                    
                    <div class="form-group">
                        <label>Telefon *</label>
                        <input type="phone" name="phone" class="form-control" placeholder="Telefon" value="<?=$user->phone?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Skype</label>
                        <input type="text" name="skype" class="form-control" placeholder="Skype" value="<?=$user->skype?>">
                    </div>
                    
                    <? if($user->is_seller == 1) { ?>
                        <div class="form-group">
                            <label>Numer konta bankowego</label>
                            <input type="text" name="account_number" class="form-control" placeholder="Numer konta" value="<?=$user->account_number?>">
                            <span class="help-block margin_b_0 margin_t_10"><i class="glyphicon glyphicon-info-sign"></i> Na ten rachunek będziesz otrzymywał prowizje za swoich klientów</span>
                        </div>
                    <? } ?>

                </div>
                
                <div class="col-md-6">
                
                    <div class="well">
                        <h4 class="margin_0 margin_b_20">Dane do logowania</h4>
                        <div class="form-group margin_b_10">
                            <label>Adres email *</label>
                            <input type="email" name="email" id="email" data-unique="true" data-except="<?=$user->email?>" class="form-control" placeholder="Adres email" value="<?=$user->email?>" required>
                            <span class="help-block margin_t_10 margin_b_0"><i class="glyphicon glyphicon-info-sign"></i> Podany wyżej adres jest również adresem kontaktowym.</span>
                        </div>
                        <hr class="margin_b_10 margin_t_10"/>
                        <span class="help-block margin_b_10"><i class="glyphicon glyphicon-info-sign"></i> Pozostaw poniższe pola puste, jesli niechcesz zmieniać hasła.</span>	
                        
                        <div class="form-group">
                            <label>Aktualne hasło</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Aktualne hasło">
                        </div>
                        
                        <div class="form-group">
                            <label>Nowe hasło</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Nowe hasło">
                        </div>
                        
                        <div class="form-group">
                            <label>Powtórz nowe hasło</label>
                            <input type="password" name="new_password_repeated" id="new_password_repeated" class="form-control" placeholder="Powtórz nowe hasło" >
                        </div>
                        
                        

                    </div>

                    
                </div>

            </div>

            <div class="row clearfix">
                <div class="col-md-12">

                    <div class="form-group margin_t_30 margin_b_30">
      
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zapisz edycję</button>
                            <a href="<?=base_url()?>cp" class="btn btn-default btn-lg">Powrót do panelu klienta</a>
                        </div>
         
                    </div>
                
                </div>
            </div>
            
        </form>
    
    </div>
    
</div>
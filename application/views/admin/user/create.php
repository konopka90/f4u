<div class="row">
    <div class="col-md-12">
    	<? if($access == 'seller') { ?>
        	<?=$this->load->view('sp/_elements/menu', array(), true)?>
        <? } else { ?>
        	<?=$this->load->view('admin/_elements/menu', array(), true)?>
        <? } ?>
    </div>
</div>

<ol class="breadcrumb">

	<? if($access == 'seller') { ?>

        <li><a href="<?=base_url()?>sp">Panel Partnera</a></li>
        <li><a href="<?=base_url()?>sp" class="label label-primary">Klienci</a></li>
        <? if(isset($update_user)) { ?>
            <li class="active">Edytujesz klienta <?=$update_user->name_surname?></li>
        <? } else { ?>
            <li class="active">Dodajesz nowego klienta</li>
        <? } ?>
    
    <? } else { ?>
    
        <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
        <li><a href="<?=base_url()?>admin/user" class="label label-primary">Użytkownicy</a></li>
        <? if(isset($update_user)) { ?>
            <li class="active">Edytujesz użytkownika <?=$update_user->name_surname?></li>
        <? } else { ?>
            <li class="active">Dodajesz nowego użytkownika</li>
        <? } ?>
        
    <? } ?>
    
</ol>

<div class="row">
    <div class="col-md-12">
    
		<? if(isset($update_user)) { ?>
            <h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-user"></i>&nbsp; Edytujesz <?=($access == 'seller')?'klienta':'użytkownika'?> <?=$update_user->name_surname?></h3>
        <? } else { ?>
            <h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-user"></i>&nbsp; Dodajesz nowego <?=($access == 'seller')?'klienta':'użytkownika'?></h3>
        <? } ?>

        <form class="form" role="form" method="post" action="<?=base_url()?>admin/user/<?=(isset($update_user))?'update/' . $update_user->user_id:'create'?>" id="user_form">

			<?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => 0), true)?>

            <div class="row margin_t_30">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Imię i nazwisko *</label>
                        <input type="text" name="name_surname" class="form-control input-sm" placeholder="Imię i nazwisko" value="<?=$update_user->name_surname?>" required>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label>Adres *</label>
                        <input type="text" name="address" class="form-control input-sm" placeholder="Adres" value="<?=$update_user->address?>" required>
                        
                        <div class="row margin_t_15">
                            <div class="col-lg-4">
                                <input type="text" name="postcode" class="form-control input-sm" placeholder="Kod pocztowy" value="<?=$update_user->postcode?>" required> 
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="city" class="form-control input-sm" placeholder="Miasto" value="<?=$update_user->city?>" required>
                            </div>
                        </div>
                        <span class="help-block margin_b_0"><i class="glyphicon glyphicon-info-sign"></i> Będzie to domyślny adres do fakturowania i wysyłki dla przyszłych zamówień.</span>
                    </div>
                    
                    <div class="form-group">
                        <label>Telefon *</label>
                        <input type="phone" name="phone" class="form-control input-sm" placeholder="Telefon" value="<?=$update_user->phone?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Skype</label>
                        <input type="text" name="skype" class="form-control input-sm" placeholder="Skype" value="<?=$update_user->skype?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Uwagi</label>
                        <textarea name="user_notice" class="form-control input-sm" placeholder="Uwagi" rows="5"><?=$update_user->user_notice?></textarea>
                    </div>
                    
                </div>
                
                <div class="col-md-6">
                
                    <div class="well">
                        <h4 class="margin_0 margin_b_20">Dane do logowania</h4>
                        <div class="form-group">
                            <label>Adres email *</label>
                            <input type="email" name="email" id="email" data-unique="true" data-except="<?=$update_user->email?>" class="form-control input-sm" placeholder="Adres email" value="<?=$update_user->email?>" autocomplete="off" required>
                            <span class="help-block margin_b_0"><i class="glyphicon glyphicon-info-sign"></i> Podany wyżej adres będzie również adresem kontaktowym.</span>
                        </div>
                        
                        <div class="form-group">
                            <label>Hasło <?=(isset($update_user))?'':'*'?></label>
                            <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Hasło" autocomplete="off" <?=(isset($update_user))?'':'required'?>>
                        </div>
                        
                        <div class="form-group">
                            <label>Powtórz hasło <?=(isset($update_user))?'':'*'?></label>
                            <input type="password" name="password_repeated" id="password_repeated" class="form-control input-sm" placeholder="Powtórz hasło" autocomplete="off" <?=(isset($update_user))?'':'required'?>>
                        </div>
                        
                        <? if(isset($update_user)) { ?>
                        	<span class="help-block margin_b_0"><i class="glyphicon glyphicon-info-sign"></i> Pozostaw pola puste, aby nie zmieniać hasła użytkownikowi.</span>	
                        <? } ?>
					
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="password_to_change" value="1" <?=((isset($update_user))?(($update_user->password_to_change)?'checked':''):'checked')?>> Wymuś na użytkowniku zmiane hasła podczas najbliższego logowania
                            </label>
                        </div>
                    
                    </div>

                    
                </div>

            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                            
                    <? if($access != 'seller') { ?>
                        <div class="form-group has-warning">
                            <label>Poziom uprawnień <span class="muted">*</span></label>
                      
                            <select name="access" class="form-control input-lg" required>
                                <option value=""> -- wybierz -- </option>
                                <option value="1" <?=($update_user->access == 1)?'selected':''?>> Użytkownik </option>
                                <option value="4" <?=($update_user->access == 4)?'selected':''?>> Kucharz/Dostawca </option>
                                <option value="5" <?=($update_user->access == 5)?'selected':''?>> Administrator </option>
                            </select>
                    
                        </div>
                        
                        <div class="form-group">
                            <label>Czy użytkownik ma być sprzedawcą?</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_seller" value="1" <?=((isset($update_user))?(($update_user->is_seller)?'checked':''):'')?>> Tak, mianuj użytkownika sprzedawcą
                                </label>
                            </div>
                            <span class="help-block margin_b_0"><i class="glyphicon glyphicon-info-sign"></i> Gdy mianujesz użytkownika sprzedawcą, będziesz mógł przypisywać klientów za kórych zamówień otrzyma odpowiednio wysokie prowizje. Będzie miał on dostęp do Panelu Sprzedawcy, w który zobaczy kompletne info o wszystkich zamówieniach przypisanych klientów.</span>	
                        </div>
                        
                        <div class="well">
                        
                        	<h4 class="margin_t_0">Ustawienia sprzedawcy</h4>
                        
                            <div class="form-group">
                                <label>Jak wysoką prowizję od zamówień ma otrzymywać sprzedawca? (% od kwoty zamówienia)</label>
                                
                                <input type="text" name="seller_provision" id="seller_provision" class="form-control input-sm" placeholder="Wysokość prowizji np. 7.00" autocomplete="off"  value="<?=((isset($update_user) && $update_user->seller_provision)?$update_user->seller_provision:'0.00')?>">
                                
                                <span class="help-block margin_b_0"><i class="glyphicon glyphicon-info-sign"></i> Wybierz jaką prowizję od zamówień będzie otrzymywał sprzedawca. Po zmianie, prowizja zostanie na nowo przeliczona dla użytkownika, na podstawie wcześniejszych zamówień</span>	
                            </div>
                            
                            <div class="form-group margin_b_0">
                                <label>Numer konta bankowego</label>
                                
                                <input type="text" name="account_number" id="account_number" class="form-control input-sm" placeholder="Numer konta bankowego" autocomplete="off"  value="<?=((isset($update_user) && $update_user->account_number)?$update_user->account_number:'')?>">
                                
                                <span class="help-block margin_b_0"><i class="glyphicon glyphicon-info-sign"></i> Numer konta bankowego na które partner będzie otrzymywał prowizje</span>	
                            </div>
                        
                        </div>
                        
                	<? } else { ?>
                    
                    	<input type="hidden" name="seller_id" value="<?=$this->user->user_id?>" />
                    
                    <? } ?>
                    
                    <div class="form-group">
                        <label>Data rejestracji *</label>
                        <input type="text" name="joined" class="dtp form-control input-sm" placeholder="Data rejestracji" value="<?=($update_user->joined)?$update_user->joined:date("Y-m-d H:i:s")?>" required>
                    </div>
                    
                    <div class="form-group margin_t_30 margin_b_30">
      
                        <div class="btn-group">
                        	<? if($access == 'seller') { ?>
                                <button type="submit" class="btn btn-success btn-lg" name="save_client" value="1">Zapisz klienta</button>
                                <button type="submit" class="btn btn-success btn-lg" name="save_client_and_order" value="1">Zapisz klienta i przejdź do składania zamówienia</button>
                                <a href="<?=base_url()?>sp" class="btn btn-default btn-lg">Powrót do zamówień klientów</a>

                            <? } else { ?>
                                <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zapisz użytkownika</button>
                                <button type="submit" class="btn btn-success btn-lg" name="save_and_order" value="1">Zapisz użytkownika i przejdź do składania zamówienia</button>
                                <a href="<?=base_url()?>admin/user" class="btn btn-default btn-lg">Powrót do listy użytkowników</a>
                            <? } ?>
                        </div>
         
                    </div>
                
                </div>
            </div>
            
        </form>

    </div>

</div>


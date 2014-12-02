<form role="form" method="post" action="<?=base_url()?>page/order/make" id="order_form">

	<input type="hidden" name="order_form_hash" value="<?=$this->session->userdata('order_form_hash')?>" />

    <div class="modal fade order_modals" id="order_modal_personal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Składasz zamówienie!</h3>
                </div>
                <div class="modal-body">
                
                    <img src="<?=base_url()?>img/order_progress_1.jpg" class="img-responsive"/>
                    
                    <hr />

                    <h4>Dane do fakturowania</h4>
                    
                    <hr />
                    
                    <div class="row invoice_data">
                    
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Imię i nazwisko *</label>
                                <input type="text" name="name_surname" class="form-control input-sm" placeholder="Imię i nazwisko" value="<?=$user->name_surname?>" required>
                            </div>
                            
                            <div class="form-group clearfix">
                                <label>Adres *</label>
                                <input type="text" name="address" class="form-control input-sm" placeholder="Adres" value="<?=$user->address?>" required>
                                
                                <div class="row margin_t_15">
                                    <div class="col-lg-4">
                                        <input type="text" name="postcode" class="form-control input-sm" placeholder="Kod pocztowy" value="<?=$user->postcode?>" required> 
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" name="city" class="form-control input-sm" placeholder="Miasto" value="<?=$user->city?>" required>
                                    </div>
                                </div>

                            </div>

                            
                        </div>
                        
                        <div class="col-md-6">
                        
                            <div class="form-group">
                                <label>Adres email *</label>
                                <input type="email" name="email" id="order_email" data-unique="true" data-except="<?=$user->email?>" class="form-control input-sm" placeholder="Adres email" value="<?=$user->email?>">
                            </div>
                            
                            <div class="form-group">
                                <label>Telefon *</label>
                                <input type="phone" name="phone" class="form-control input-sm" placeholder="Telefon" value="<?=$user->phone?>" required>
                            </div>
                            
                        </div>
                    
                    </div>

                </div>
                <div class="modal-footer">
                    
                    
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-circle"></i> </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                    </div>
                    
                    <div class="btn-group margin_l_10">
                        <a data-toggle="modal" href="#order_modal_details" class="btn_order_modal_details btn btn-primary"> Dalej </a>
                        <a data-toggle="modal" href="#order_modal_details" class="btn_order_modal_details btn btn-primary"> <i class="glyphicon glyphicon-circle-arrow-right"></i> </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    
    
    <div class="modal fade order_modals" id="order_modal_details" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Składasz zamówienie!</h3>
                </div>
                <div class="modal-body">
                
                    <img src="<?=base_url()?>img/order_progress_2.jpg" class="img-responsive"/>
                
                    <hr class="margin_b_0"/>
                    
                    <? $packets_meals_per_day_values = packets_meals_per_day_values($order_product->meals_per_day); ?>
					<? $free_days = get_free_days($order_product->days); ?>
           
					<p class="alert alert-dismissable margin_b_0">
                    	Wybrałeś dietę <strong><?=$order_product->name?></strong> przez <strong><?=$order_product->days?></strong> dni 
                        <? if($free_days > 0) { ?>
                        	+ <strong class="font_green"><?=$free_days?> dni GRATIS</strong> = <span class="label label-primary"><?=$order_product->days+$free_days?> dni</span>
                        <? } ?>
                        !
                    </p>
                            
                    <div class="row">
                    
                    	<?
							$cols = count($calendars);
							if($cols > 0)
								$cols = 12/$cols;
						?>
                        
                        <? if($calendars[0]) { ?>
                            <div class="col-md-<?=$cols?>">
                                <?=$calendars[0]?>
                            </div>
                        <? } ?>
                        <? if($calendars[1]) { ?>
                            <div class="col-md-<?=$cols?>">
                                <?=$calendars[1]?>
                            </div>
                        <? } ?>
                        <? if($calendars[2]) { ?>
                            <div class="col-md-<?=$cols?>">
                                <?=$calendars[2]?>
                            </div>
                        <? } ?>
                        <? if($calendars[3]) { ?>
                            <div class="col-md-<?=$cols?>">
                                <?=$calendars[3]?>
                            </div>
                        <? } ?>
                        <? if($calendars[4]) { ?>
                            <div class="col-md-<?=$cols?>">
                                <?=$calendars[4]?>
                            </div>
                        <? } ?>
                        <? if($calendars[5]) { ?>
                            <div class="col-md-<?=$cols?>">
                                <?=$calendars[5]?>
                            </div>
                        <? } ?>
                        
                    </div>
                    
                    <button type="button" class="btn btn-primary pull-right btn-xs btn_delivery_like_invoice">Taki sam jak fakturowania</button>
                    <h4 class="margin_t_0 margin_b_20">Adres dostawy</h4>      
                    
                    <div class="row form-horizontal delivery_data">
                        <div class="col-md-6">

                            <div class="form-group clearfix">
                            
                                <label class="col-lg-3 control-label">Adres *</label>
                                
                                <div class="col-lg-9">
                                    <input type="text" name="delivery_address" class="form-control input-sm" placeholder="Adres" required>
                                    
                                    <div class="row margin_t_15">
                                        <div class="col-lg-5">
                                            <input type="text" name="delivery_postcode" class="form-control input-sm" placeholder="Kod pocztowy" required> 
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="text" name="delivery_city" class="form-control input-sm" placeholder="Miasto" required>
                                        </div>
                                    </div>
                                </div>
                                
    
                            </div>           


                        </div>
                
                        
                        <div class="col-md-6">
                                
                        
                            <div class="form-group clearfix">
                                <label class="col-lg-3 control-label">Imię *</label>
                                <div class="col-lg-9">
                                    <input type="text" name="delivery_name_surname" class="form-control input-sm" placeholder="Imię i nazwisko osoby odbierającej" required>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="col-lg-3 control-label">Telefon *</label>
                                <div class="col-lg-9">
                                    <input type="text" name="delivery_phone" class="form-control input-sm" placeholder="Telefon" required>
                                </div>
                            </div>
                                
                        </div>
					</div>

                   <h4 class="margin_t_0 margin_b_20">Preferowana godzina dostawy i uwagi</h4>      
                    
                    <div class="row form-horizontal details_data">
                        <div class="col-md-6">

                            <div class="form-group clearfix">
                            
                                <label class="col-lg-6 control-label">Godzina dostawy *</label>
                                
                                <div class="col-lg-6">
                                    <select class="form-control input-sm" name="delivery_hours" required>
                                    	<option value=""> -- wybierz -- </option>
										<? if(count(delivery_hours_values()) > 0) { ?>
                                            <? foreach(delivery_hours_values() as $id => $v) { ?>
                                                <option value="<?=$id?>"><?=reset($v)?></option> 
                                            <? } ?>
                                        <? } ?>
                                    </select>
                                </div>
                                
    
                            </div>           


                        </div>
                
                        
                        <div class="col-md-6">
                                
                        
                            <div class="form-group clearfix">
                                <label class="col-lg-3 control-label">Uwagi</label>
                                <div class="col-lg-9">
                                    <textarea type="text" name="delivery_user_notice" class="form-control input-sm" placeholder="Uwagi" rows="3"></textarea>
                                </div>
                            </div>

                        </div>
                        
                        
					</div>




                    
                    
                    
                    
                    
                </div>
                <div class="modal-footer">
                
                
                	<div class="pull-left btn-group">
                    	<a data-toggle="modal" href="#order_modal_personal" class="pull-left btn btn-primary"> <i class="glyphicon glyphicon-circle-arrow-left"></i> </a>
                        <a data-toggle="modal" href="#order_modal_personal" class="pull-left btn btn-primary"> Zmień </a>
                    </div>
                    
                    <div class="btn-group">
                        <a data-toggle="modal" href="#order_modal_interview" class="btn_order_modal_interview btn btn-primary"> Dalej </a>
                        <a data-toggle="modal" href="#order_modal_interview" class="btn_order_modal_interview btn btn-primary"> <i class="glyphicon glyphicon-circle-arrow-right"></i> </a>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade order_modals" id="order_modal_interview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Składasz zamówienie!</h3>
                </div>
                <div class="modal-body">
                
                    <img src="<?=base_url()?>img/order_progress_3.jpg"  class="img-responsive"/>
                    
                    <hr />

                    <h4>Formularz dietetyczny</h4>
                    <h6>Jeżeli jesteś naszym stałym klientem, możesz pominąć kwestionariusz <a data-toggle="modal" href="#order_modal_payment" class="btn_order_modal_payment label label-primary">POMIJAM &rarr;</a></h6>
                    
                    <hr />
 					
                    <h4>Dane podstawowe</h4>
                    
        			<div class="form-group clearfix">
                        <label class="col-lg-4">Data urodzenia</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_born" class="form-control input-sm" placeholder="Data urodzenia">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Wzrost</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_height" class="form-control input-sm" placeholder="Wzrost">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Aktualna masa ciała</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_weight" class="form-control input-sm" placeholder="Aktualna masa ciała">
                        </div>
                    </div>
 
  					<h4>Stan zdrowotny</h4>
                    
        			<div class="form-group clearfix">
                        <label class="col-lg-4">Alergie pokarmowe</label>
                        <div class="col-lg-6">
                            <textarea name="form_alergy" class="form-control input-sm" placeholder="Alergie pokarmowe"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Czy masz zdiagnozowane choroby wymagające specjalistycznego żywienia?</label>
                        <div class="col-lg-6">
                            <textarea name="form_illness" class="form-control input-sm" placeholder="Czy masz zdiagnozowane choroby wymagające specjalistycznego żywienia?"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Czy jesteś w trakcie terapi hormonalnej?</label>
                        <div class="col-lg-6">
                            <textarea name="form_therapy" class="form-control input-sm" placeholder="Czy jesteś w trakcie terapi hormonalnej?"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Czy masz nadciśnienie?</label>
                        <div class="col-lg-6">
                            <textarea name="form_over" class="form-control input-sm" placeholder="Czy masz nadciśnienie?"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Czy próbowałeś diet?</label>
                        <div class="col-lg-6">
                            <textarea name="form_diets_effects" class="form-control input-sm" placeholder="Czy próbowałeś diet? Jeśli tak - wymień jakie, kiedy, przebieg i skutki"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Czy masz przebyte kontuzję/zabiegi, problemy z układem kostnym/mięśniowym?</label>
                        <div class="col-lg-6">
                            <textarea name="form_operation" class="form-control input-sm" placeholder="Czy masz przebyte kontuzję/zabiegi, problemy z układem kostnym/mięśniowym?"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Twoje uwagi</label>
                        <div class="col-lg-6">
                            <textarea name="form_notices_1" class="form-control input-sm" placeholder="Twoje uwagi"></textarea>
                        </div>
                    </div>
                    
                    <h4>Nawyki żywieniowe i analiza stylu życia</h4>
                    
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Ile posiłków spożywasz w ciągu dnia?</label>
                        <div class="col-lg-6">
                            <textarea name="form_meals_per_day" class="form-control input-sm" placeholder="Ile posiłków spożywasz w ciągu dnia?"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Określ pory i okoliczności spożywania posiłków</label>
                        <div class="col-lg-6">
                            <textarea name="form_meals_time" class="form-control input-sm" placeholder="Określ pory i okoliczności spożywania posiłków"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Czy podjadasz między posiłkami i jak często?</label>
                        <div class="col-lg-6">
                            <textarea name="form_meals_additional" class="form-control input-sm" placeholder="Czy podjadasz między posiłkami i jak często?"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Ile pijesz wody dziennie?</label>
                        <div class="col-lg-6">
                            <textarea name="form_water_count" class="form-control input-sm" placeholder="Ile pijesz wody dziennie?"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Czy zażywasz suplementy diety - wymień jakie?</label>
                        <div class="col-lg-6">
                            <textarea name="form_suplements" class="form-control input-sm" placeholder="Czy zażywasz suplementy diety - wymień jakie?"></textarea>
                        </div>
                    </div>

                    <h4>Ile razy dziennie/w tygodniu spożywasz poniższe produkty?</h4>
                    
        			<div class="form-group clearfix">
                        <label class="col-lg-4">Kawa</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_coffee" class="form-control input-sm" placeholder="Kawa">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Herbata</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_tea" class="form-control input-sm" placeholder="Herbata">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Cukier/słodycze</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_sugar" class="form-control input-sm" placeholder="Cukier/słodycze">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Sól/ słone przyprawy</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_saltz" class="form-control input-sm" placeholder="Sól/ słone przyprawy">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Słodzone napoje gazowane</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_drinks" class="form-control input-sm" placeholder="Słodzone napoje gazowane">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Dania typu fast-food</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_fastfood" class="form-control input-sm" placeholder="Dnia typu fast-food">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Alkohol</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_alcohol" class="form-control input-sm" placeholder="Alkohol">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Papierosy</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_cigarettes" class="form-control input-sm" placeholder="Papierosy">
                        </div>
                    </div>
                    
                    
                    <h4>Opisz krótko poszczególne posiłki</h4>
                    
        			<div class="form-group clearfix">
                        <label class="col-lg-4">Śniadanie</label>
                        <div class="col-lg-6">
                            <textarea name="form_breakfast" class="form-control input-sm" placeholder="Śniadanie"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Śniadanie II</label>
                        <div class="col-lg-6">
                            <textarea name="form_breakfast_2" class="form-control input-sm" placeholder="Śniadanie II"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Posiłek główny</label>
                        <div class="col-lg-6">
                            <textarea name="form_dinner" class="form-control input-sm" placeholder="Posiłek główny"></textarea>
                        </div>
                    </div>

					<div class="form-group clearfix">
                        <label class="col-lg-4">Podwieczorek</label>
                        <div class="col-lg-6">
                            <textarea name="form_dinner_2" class="form-control input-sm" placeholder="Podwieczorek"></textarea>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="col-lg-4">Kolacja</label>
                        <div class="col-lg-6">
                            <textarea name="form_supper" class="form-control input-sm" placeholder="Kolacja"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Przekąski</label>
                        <div class="col-lg-6">
                            <textarea name="form_snacks" class="form-control input-sm" placeholder="Przekąski"></textarea>
                        </div>
                    </div>
                  
                    <h4>Preferencje żywieniowe</h4>
                    
        			<div class="form-group clearfix">
                        <label class="col-lg-4">Zbożowe</label>
                        <div class="col-lg-6">
                            <textarea name="form_cereal" class="form-control input-sm" placeholder="Zbożowe"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Mięso</label>
                        <div class="col-lg-6">
                            <textarea name="form_meat" class="form-control input-sm" placeholder="Mięso"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Ryby</label>
                        <div class="col-lg-6">
                            <textarea name="form_fish" class="form-control input-sm" placeholder="Ryby"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Warzywa</label>
                        <div class="col-lg-6">
                            <textarea name="form_vegetables" class="form-control input-sm" placeholder="Warzywa"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Owoce</label>
                        <div class="col-lg-6">
                            <textarea name="form_fruits" class="form-control input-sm" placeholder="Owoce"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Mleczne</label>
                        <div class="col-lg-6">
                            <textarea name="form_milk" class="form-control input-sm" placeholder="Mleczne"></textarea>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Inne</label>
                        <div class="col-lg-6">
                            <textarea name="form_other" class="form-control input-sm" placeholder="Inne"></textarea>
                        </div>
                    </div>
                    
                    <h4>Aktywność fizyczna</h4>
                    
        			<div class="form-group clearfix">
                        <label class="col-lg-4">Rodzaj wykonywanej pracy/zajęcia w trakcie dnia</label>
                        <div class="col-lg-6">
                            <textarea name="form_work" class="form-control input-sm" placeholder="Rodzaj wykonywanej pracy/zajęcia w trakcie dnia"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Czy korzystasz z dodatkowych form aktywności fizycznej?</label>
                        <div class="col-lg-6">
                            <textarea name="form_activity" class="form-control input-sm" placeholder="Czy korzystasz z dodatkowych form aktywności fizycznej? Podaj rodzaj i częstotliwość"></textarea>
                        </div>
                    </div>
                    
                    <h4>Harmonogram dnia</h4>
                    
                    <? for($h = 5; $h <= 23; $h++) { ?>
                        <div class="form-group clearfix">
                            <label class="col-lg-4 text-right"><?=$h?>:00 - <?=($h+1)?>:00</label>
                            <div class="col-lg-6">
                                <input type="text" name="form_harmonogram_<?=$h?>" class="form-control input-sm" placeholder="<?=$h?>:00 - <?=($h+1)?>:00">
                            </div>
                        </div>
                    <? } ?>
                    
                    <h4>Stopień otłuszczenia ciała</h4>

					<div class="form-group clearfix">
                        <div class="col-lg-offset-4 col-lg-6">
                            <img src="<?=base_url()?>img/fat.jpg" class="img-responsive">
                        </div>
                    </div>
                    
					<div class="form-group clearfix">
                        <label class="col-lg-4">Jaki w przybliżeniu udział procentowy otłuszczenia ciała posiadasz?</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_fat" class="form-control input-sm" placeholder="Jaki w przybliżeniu udział procentowy otłuszczenia ciała posiadasz?">
                        </div>
                    </div>
                    
                    <h4>Typ morficzny budowy ciała</h4>
                    
					<div class="form-group clearfix">
                        <div class="col-lg-offset-4 col-lg-6">
                    		<img src="<?=base_url()?>img/morphism.jpg" class="img-responsive">
                       </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Typ morficzny jaki reprezentuje to</label>
                        <div class="col-lg-6">
                            <input type="text" name="form_morphism" class="form-control input-sm" placeholder="Typ morficzny jaki reprezentuje to">
                        </div>
                    </div>
                    
                    <h4>Jaki jest cel Twojej diety?</h4>
                    
        			<div class="form-group clearfix">
                        <label class="col-lg-4">Jaki jest cel Twojej diety?</label>
                        <div class="col-lg-6">
                            <textarea name="form_target" class="form-control input-sm" placeholder="Jaki jest cel Twojej diety?"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <label class="col-lg-4">Inne uwagi</label>
                        <div class="col-lg-6">
                            <textarea name="form_notices_2" class="form-control input-sm" placeholder="Inne uwagi"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    
                	<div class="pull-left btn-group">
                    	<a data-toggle="modal" href="#order_modal_details" class="pull-left btn btn-primary"> <i class="glyphicon glyphicon-circle-arrow-left"></i> </a>
                        <a data-toggle="modal" href="#order_modal_details" class="pull-left btn btn-primary"> Zmień </a>
                    </div>
                    
                    <div class="btn-group">
                        <a data-toggle="modal" href="#order_modal_payment" class="btn_order_modal_payment btn btn-primary"> Dalej </a>
                        <a data-toggle="modal" href="#order_modal_payment" class="btn_order_modal_payment btn btn-primary"> <i class="glyphicon glyphicon-circle-arrow-right"></i> </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    

    <div class="modal fade order_modals" id="order_modal_payment" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Składasz zamówienie!</h3>
                </div>
                <div class="modal-body">
                
                    <img src="<?=base_url()?>img/order_progress_4.jpg" class="img-responsive" />
                    
                    <hr />

                    <h4>Płatność</h4>
                    
                    <hr />
                    
                    <div class="form-group clearfix">
                        <label class="">Skąd dowiedziałes się o fit4you?</label>
                        <div class="">
                            <select id="how_about_f4u" class="form-control input-sm">
                                <option value=""> -- wybierz -- </option>
                                <option value="Z google">Z google</option>
                                <option value="Znajomy mi polecił">Znajomy mi polecił</option>
                                <option value="Z kampanii reklamowej">Z kampanii reklamowej</option>
                                <option value="Z newslettera">Z newslettera</option>
                            </select>
                        </div>
                    </div>
            
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="rules" required> Zapoznałem się z <a href="<?=base_url()?>page/regulamin" class="label label-primary" target="_blank">regulaminem</a> *
                        </label>
                    </div>
 
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="personal_data" required> <span>Oświadczam, że zostałem/am poinformowany/a że administratorem danych osobowych pozyskanych w ankiecie jest firma FIT 4 YOU. Dane osobowe zbierane sa w celu przygotowania dla klienta diety zgodnie z jego preferencjami zywieniowymi oraz potrzebami zdrowotnymi, a takze sporzadzenia ewentualnej umowy o swiadczenie uslug cateringowych. Osoba wypelniajaca kwestionariusz ma pelne prawo dostepu do tresci swoich danych osobowych oraz ich poprawiania. 

Wypełniając i wysyłając ten formularz wyraża Pan/i zgodę na przetwarzanie swoich danych osobowych przez FIT 4 YOU w celu przygotowania diety zgodnie preferencjami żywieniowymi oraz potrzebami zdrowotnymi. Zgoda na przetwarzanie Pana/i danych obejmuje także przetwarzanie tych danych w przyszłości, o ile nie zmieni się cel ich przetwarzania *</span>
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="newsletter"> Dodaj mój adres do newslettera
                        </label>
                    </div>
                    
                    
                    <h1 class="text-right"><span style="font-size: 18px;color: #ccc">do zapłaty</span> <span class="label label-danger"><?=$order_product->price?> PLN</span></h1>

                </div>
                <div class="modal-footer">
                	<div class="pull-left btn-group">
                    	<a data-toggle="modal" href="#order_modal_interview" class="pull-left btn btn-primary"> <i class="glyphicon glyphicon-circle-arrow-left"></i> </a>
                        <a data-toggle="modal" href="#order_modal_interview" class="pull-left btn btn-primary"> Zmień </a>
                    </div>
                    
                    <?php /*?>
                    <div class="btn-group">
                    	<button type="submit" id="btn_make_order" class="btn btn-success btn-md"> <i class="glyphicon glyphicon-shopping-cart"></i> </a>
                        <button type="submit" id="btn_make_order" data-redirect="false" class="btn btn-success btn-md">Zamawiam i płacę później</a>
                    </div>
                    <?php */?>
                    
                    <div class="pull-right btn-group margin_l_10">
                    	<button type="submit" id="btn_make_order_1" class="btn btn-success btn-md"> <i class="glyphicon glyphicon-shopping-cart"></i> </button>
                        <button type="submit" id="btn_make_order" class="btn btn-success btn-md"> Zamawiam i płacę </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
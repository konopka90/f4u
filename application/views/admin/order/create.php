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
        <li><a href="<?=base_url()?>sp" class="label label-primary">Zamówienia</a></li>
        <? if(isset($order)) { ?>
            <li class="active">Edytujesz zamówienie <?=$order->order_number?></li>
        <? } else { ?>
            <li class="active">Dodajesz nowego zamówienie</li>
        <? } ?>
    
    <? } else { ?>
    
        <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
        <li><a href="<?=base_url()?>admin/order" class="label label-primary">Zamówienia</a></li>
        <? if(isset($order)) { ?>
            <li class="active">Edytujesz zamówienie <?=$order->order_number?></li>
        <? } else { ?>
            <li class="active">Dodajesz nowe zamówienie</li>
        <? } ?>
    
    <? } ?>
    
</ol>

<div class="row">
    <div class="col-md-12">

        <? if(isset($order)) { ?>
            <h3 class="margin_0 margin_b_30">Edytujesz zamówienie <?=$order->order_number?></h3>
        <? } else { ?>
            <h3 class="margin_0 margin_b_30">Dodajesz nowe zamówienie</h3>
        <? } ?>
            
        <form class="form" role="form" method="post" action="<?=(!$order_user && !$order)?current_url():base_url() . 'admin/order/' . ((!$order)?'create':'update') . '/' . $this->uri->segment(4)?>" id="order_form">
            
            <? if(!$order) { ?>
                <div class="form-group clearfix">
                    <label class="col-lg-2 control-label">Użytkownik <span class="muted">*</span></label>
                    <div class="col-lg-10">
                        <select name="order_user" class="form-control input-lg" required>
                            <option value=""> -- wybierz -- </option>
                            <? foreach($users as $u) { ?>
                                <option value="<?=$u->user_id?>" <?=($order_user->user_id == $u->user_id)?'selected':''?>><?=$u->name_surname?>, <?=$u->user_id?>, (<?=$u->email?>), <?=$u->address?>, <?=$u->postcode?> <?=$u->city?></option> 
                            <? } ?>
                        </select>
                    </div>
                </div>
            <? } ?>
        
        	<? if(!$order_user && !$order) { ?>
                <div class="form-group margin_t_20 margin_b_30">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-success btn-lg" name="select_user" value="1">Zapisz i przejdź do edycji szczegółów zamówienia</button>
                    </div>
                </div>
        	<? } ?>
               
            <? if($order_user || $order) { ?>
            
                <div class="row margin_t_30">
                    <div class="col-md-6">
                        <h3 class="margin_0 margin_b_20">Dane do fakturowania</h3>
                        
                       	<div class="row">
                        
                            <div class="col-md-6">
        
                                <div class="form-group">
                                    <label>Imię i nazwisko *</label>
                                    <input type="text" name="name_surname" class="form-control input-sm" placeholder="Imię i nazwisko" value="<?=($order)?$order->name_surname:$order_user->name_surname?>" <?=(!$order)?'readonly':'required'?>>
                                </div>
                                
                                <div class="form-group clearfix">
                                    <label>Adres *</label>
                                    <input type="text" name="address" class="form-control input-sm" placeholder="Adres" value="<?=($order)?$order->address:$order_user->address?>"  <?=(!$order)?'readonly':'required'?>>
                                    
                                    <div class="row margin_t_15">
                                        <div class="col-lg-4">
                                            <input type="text" name="postcode" class="form-control input-sm" placeholder="Kod pocztowy" value="<?=($order)?$order->postcode:$order_user->postcode?>"  <?=(!$order)?'readonly':'required'?>> 
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="city" class="form-control input-sm" placeholder="Miasto" value="<?=($order)?$order->city:$order_user->city?>"  <?=(!$order)?'readonly':'required'?>>
                                        </div>
                                    </div>
        
                                </div>
        
                                
                            </div>
                            
                            <div class="col-md-6">
                            
                                <div class="form-group">
                                    <label>Adres email *</label>
                                    <input type="email" name="email" id="order_email" data-unique="true" data-except="<?=($order)?$order->email:$order_user->email?>" class="form-control input-sm" placeholder="Adres email" value="<?=($order)?$order->email:$order_user->email?>"  <?=(!$order)?'readonly':'required'?>>
                                </div>
                                
                                <div class="form-group">
                                    <label>Telefon *</label>
                                    <input type="phone" name="phone" class="form-control input-sm" placeholder="Telefon" value="<?=($order)?$order->phone:$order_user->phone?>"  <?=(!$order)?'readonly':'required'?>>
                                </div>
                                
                            </div>
                    	</div>
                    
                    	<? if(!$order) { ?>
                            
                            <button type="button" class="btn btn-primary pull-right btn-xs margin_t_20 margin_r_20 btn_delivery_like_invoice">Taki sam jak fakturowania</button>
                            <h3 class="margin_t_20 margin_b_20">Adres dostawy</h3>
                        
                            <div class="row">
    
                                
                                <div class="col-md-6">
                                
                                    
            
                                    <div class="form-group">
                                    
                                        <label>Adres *</label>
            
                                        <input type="text" name="delivery_address" class="form-control input-sm" placeholder="Adres" required>
                                            
                                        <div class="row margin_t_15">
                                            <div class="col-lg-5">
                                                <input type="text" name="delivery_postcode" class="form-control input-sm" placeholder="Kod pocztowy" required/> 
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="text" name="delivery_city" class="form-control input-sm" placeholder="Miasto" required>
                                            </div>
                                        </div>
                                        
            
                                    </div>           
            
            
                                </div>
                        
                                
                                <div class="col-md-6">
                                        
                                
                                    <div class="form-group clearfix">
                                        <label>Imię i nazwisko *</label>
                                        <input type="text" name="delivery_name_surname" class="form-control input-sm" placeholder="Imię i nazwisko osoby odbierającej" required>
                                 
                                    </div>
            
                                    <div class="form-group clearfix">
                                        <label>Telefon *</label>
                                        <input type="text" name="delivery_phone" class="form-control input-sm" placeholder="Telefon" required>
                                    </div>
                                        
                                </div>
                            
                            </div>

                            <h3 class="margin_t_20 margin_b_20">Godzina dostawy i uwagi</h3>
                            
                            <div class="row">
                                <div class="col-md-6">
            
                                    <div class="form-group clearfix">
                                    
                                        <label>Preferowana godzina dostawy *</label>
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

                                <div class="col-md-6">
                                    <div class="form-group clearfix">
                                        <label>Uwagi</label>
                                        <textarea type="text" name="delivery_user_notice" class="form-control input-sm" placeholder="Uwagi (widoczne dla klienta - może je edytować)" rows="3"></textarea>
                                    </div>
                                </div> 
                            </div>

                    	<? } ?>
                            
                    </div>
                    
                    <div class="col-md-6">
                    
                    	<? if(!$order) { ?>
                    
                            <h3 class="margin_0 margin_b_20">Szczegóły zamówienia</h3>
                            
							<p class="margin_t_20 margin_b_20">
                                <span style="font-weight: bold;color:red"><i class="glyphicon glyphicon-exclamation-sign"></i>Zwróć uwagę aby starannie uzupełnić poniższy formularz - klient w <u>jeden dzień może mieć tylko jedną dostawę</u>. Pamiętaj takżę żę błędnie dodane zamówienie spowoduje błędy w przeliczaniu prowizji partnerów.</span> Gdy dodajesz zamówienie przez ten formularz: gratisowe posiłki nie są dodawane, emaile z powiadomieniami nie są wysyłane.
                            </p>
                            
                            <h4>Podsumowanie pakietów użytkownika</h4>
                            <div class="well">
								<? if(count($user_packets) > 0) { ?>
                                    <? foreach($user_packets as $p) { ?>
                                    
                                        <?
                                        
                                        $packets_meals_per_day_values = packets_meals_per_day_values($p->meals_per_day);
                                        $deliveries = $this->delivery->get_deliveries(FALSE, $p->order_id);
                                        
                                        $start = reset($deliveries)->date;
                                        $end = end($deliveries)->date;
                                        ?>
                                        
                                        <a href="<?=base_url()?>admin/order/read/<?=$p->order_id?>" class="margin_r_10 pull-left" target="_blank">
                                            <i class="font_12 glyphicon glyphicon-info-sign tooltipa" data-original-title="Szczegóły i edycja zamówienia"></i>  
                                        </a>
       
                                        <?=$products[$p->product_id]->name?> <span class="font_gray"><?=(is_array(unserialize($p->meals_selected)))?'('.implode(", ", unserialize($p->meals_selected)).')':''?></span><br />
                                        <?=($p->days)?$p->days:0?> <span class="font_gray">dni, od</span> <?=$start?> <span class="font_gray">do</span> <?=$end?>
                                        
                                        <? if($p != end($user_packets)) { ?>
                                        	<br /><br />
                                        <? } ?>
                                        
                                        <?php /*?>         
                                        dostawy od <em><?=strftime("%e-%m-%Y, %A", strtotime($start))?></em> do <em><?=strftime("%e-%m-%Y, %A", strtotime($end))?></em>. <em><?=$packets_meals_per_day_values[0]?></em> dziennie przez <em><?=$p->days?></em> dni.<br />
                                        <?php */?>
                                    
                                    <? } ?>
                                <? } else { ?>
                                    <em>Użytkownik nie zamawiał jeszcze pakietów.</em>
                                <? } ?>
                            </div>
                            
                            <h4>Sprzedawca użytkownika</h4>
                            <div class="well">
                            
                            	<? if($user_seller) { ?>
                                	<a href="<?=base_url()?>admin/seller/<?=$user_seller->user_id?>"><?=$user_seller->name_surname?></a>, otrzyma <?=$user_seller->seller_provision?>% od kwoty tego zamówienia
                                <? } else { ?>
                                	<em>Użytkownik nie ma przypisanego sprzedawcy. Możesz <a href="<?=base_url()?>admin/seller"><strong>wybrać partnera z listy</strong></a> i przypisać mu tego użytkownika, a później wrócić do dodawania zamówienia, jeśli chcesz by wliczało się ono do prowizji partnera.</em>
                                <? } ?>
             
                            </div>
                            
                            <div class="form-group clearfix margin_t_20">
                            	<label class="control-label">Jak chcesz wyznaczyć czas trwania dostaw dla tego zamówienia? <span class="muted">*</span></label>
                            	<div class="col-lg-12">
                                    <label class="radio-inline">
                                    	<input type="radio" name="mode" value="range" data-value="range" class="delivery_mode" checked /> Wybiorę zakres daty
                                    </label>
                                    <label class="radio-inline">
                                    	<input type="radio" name="mode" value="days" data-value="days" class="delivery_mode"> Podam ilość dni
                                    </label>
                               
                                    <label class="radio-inline">
                                    	<input type="radio" name="mode" value="calendar" data-value="calendar" class="delivery_mode"> Zaznaczę na kalendarzu
                                    </label>
                            
                                </div>
                            </div>
                            
                            <div class="hide form-group clearfix" id="delivery_mode_calendar">
                            
                            	<div class="row">
                                
                                    <div class="col-md-1 text-left">
                                    	<i class="glyphicon glyphicon-chevron-left margin_t_5 prev pointer" data-date=""></i>
                                    </div> 
                                    
									<div class="col-md-10" id="delivery_mode_calendar_" data-user_id="<?=$order_user->user_id?>">
                                    
                                    </div>
									<div class="col-md-1 text-right">
                                    	<i class="glyphicon glyphicon-chevron-right margin_t_5 next pointer" data-date=""></i>
                                    </div>
                                
                                </div>
                                
                                
                            
                            </div>
                            
                            <div class="form-group clearfix" id="delivery_mode_range">
                                <label class="control-label">Zakres w którym będą dostawy <span class="muted">*</span></label>
                                <div class="col-lg-12">

                                    <input type="text" class="form-control col-md-6 input-lg dr" name="delivery_range" id="delivery_range"/>
                                    
                                    <input type="hidden" name="delivery_range_days" id="delivery_range_days" value="" />
                                    <input type="hidden" name="delivery_range_start" id="delivery_range_start" value="" />
                                    <input type="hidden" name="delivery_range_end" id="delivery_range_end" value="" />
                                    
                           
                                </div>
                            </div>
                            
                            <div class="hide" id="delivery_mode_days">
                                <div class="form-group clearfix">
                                    <label class="control-label">Kiedy zaczyna się dostawa? <span class="muted">*</span></label>
                                    <div class="col-lg-12">
    
                                        <input type="text" class="form-control col-md-6 input-lg dp" name="delivery_start" id="delivery_start"/>
                               
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group clearfix">
                                    <label class="control-label">Przez ile dni będzie trwać dostawa? <span class="muted">*</span></label>
                                    <div class="col-lg-12">
                                    
                                        <select class="form-control input-lg" name="delivery_days" id="delivery_days">
                                        
                                            <option value=""> -- wybierz -- </option>
                                            <? for($i = 3; $i <= 40; $i++) { ?>
                                                <option value="<?=$i?>"><?=$i?> dni</option>
                                            <? } ?>
                                        
                                        </select>
                               
                                    </div>
                                    
                                </div>
                            </div>
  
                            <div class="form-group clearfix" id="div_delivery_day">
                            	<label class="control-label">W jakie dni tygodnia będą dostawy? <span class="muted">*</span></label>
                            	<div class="col-lg-12">
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="day[1]" class="delivery_day" value="1" checked> Pon
                                    </label>
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="day[2]" class="delivery_day" value="2" checked> Wto
                                    </label>
									<label class="checkbox-inline">
                                    	<input type="checkbox" name="day[3]" class="delivery_day" value="3" checked> Śro
                                    </label>
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="day[4]" class="delivery_day" value="4" checked> Czw
                                    </label>
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="day[5]" class="delivery_day" value="5" checked> Pią
                                    </label>
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="day[6]" class="delivery_day" value="6"> Sob
                                    </label>
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="day[7]" class="delivery_day" value="7"> Nie
                                    </label>
                                    
                                </div>
                            </div>
                            
                            
                            
                            <div class="form-group clearfix">
                                <label class="control-label">Jaką dietę wybierasz? <span class="muted">*</span></label>
                                <div class="col-lg-12">
                                    
                                    <select class="form-control input-lg" name="delivery_product" id="delivery_product" required>
                                        <option value=""> -- wybierz -- </option>
                                        <? if(count($products) > 0) { ?>
                                            
                                            <? foreach($products as $p) { ?>
                                            	<? if($p->type == 'diet') { ?>
                                                	<? $packets_meals_per_day_values = packets_meals_per_day_values($p->meals_per_day); ?>
                                                	<option value="<?=$p->product_id?>" data-price_per_day="<?=$p->price_for_day?>"><?=$p->name?>, <?=$p->price_for_day?> PLN/dzień</option>
                                            	<? } ?>
											<? } ?>
                                            
                                        <? } ?>
                                    </select>
                                    
                                    
                                </div>
                            </div>
                            
                            <p class="alert alert-warning" id="delivery_summary">Wybierz powyższe opcje dostawy, aby zobaczyć podsumowanie.</p>
                            
                            <div id="delivery_mode_calendar_days"></div>
                                                
                            <div class="form-group clearfix">
                            	<label class="control-label">Jakie to będą posiłki? <span class="muted">*</span></label>
                            	<div class="col-lg-12">
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="meal[1]" class="delivery_meal" value="1" checked> Śniadanie
                                    </label>
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="meal[2]" class="delivery_meal" value="2" checked> Posiłek 1
                                    </label>
									<label class="checkbox-inline">
                                    	<input type="checkbox" name="meal[3]" class="delivery_meal" value="3" checked> Posiłek 2
                                    </label>
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="meal[4]" class="delivery_meal" value="4" checked> Posiłek 3
                                    </label>
                                    <label class="checkbox-inline">
                                    	<input type="checkbox" name="meal[5]" class="delivery_meal" value="5" checked> Kolacja
                                    </label>

                                </div>
                            
                                
                                <p class="help-block">
                                    <span style="font-weight: bold;color:red"><i class="glyphicon glyphicon-exclamation-sign"></i> Zwróć uwagę, że ilość zaznaczonych posiłków musi się zgadzac z ilością posiłków wybranej diety.</span>
                                </p>
                                
                                
                            </div>

                            
                   		<? } else { ?>
                        
                            <div class="col-md-12">
                                    
                                <h3 class="margin_0 margin_b_20">Szczegóły zamówienia</h3>
                            
                                <div class="form-group clearfix">
                                    <label>Numer zamówienia *</label>
                                    <input type="text" name="order_number" class="form-control input-sm" placeholder="Numer zamówienia" value="<?=$order->order_number?>" required>
                                </div>
        
                                <div class="form-group clearfix">
                                    <label>Data zamówienia *</label>
                                    <input type="text" name="date" class="dtp form-control input-sm" placeholder="Data zamówienia" value="<?=$order->date?>" required>
                                </div>
                                
                                <div class="form-group clearfix">
                                    <label>Cena *</label>
                                    <input type="text" name="price" class="form-control input-sm" placeholder="Cena" value="<?=$order->price?>" required>
                                </div>
                                    
                            </div>
                        
                        <? } ?>     
                        
                    </div>          
                        
                    
                </div>
                
    
                <div class="row margin_t_20 margin_b_30">
                    <div class="col-lg-12">
                        <div class="btn-group">
                        
                        	<? if($access == 'seller') { ?>
                            
								<? if(isset($order)) { ?>
                                    <button type="submit" class="btn btn-success btn-lg" name="save_client_order" value="1">Zapisz</button>
                                <? } else { ?>
                                    <button type="submit" class="btn btn-success btn-lg" name="save_client_order" value="1">Zapisz i przejdź do edycji dostawy</button>
                                <? } ?>
    
                                <a href="<?=base_url()?>sp/order" class="btn btn-default btn-lg">Powrót do zamówień klientów</a>
                            
                            <? } else { ?>
                                                
								<? if(isset($order)) { ?>
                                    <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zapisz</button>
                                <? } else { ?>
                                    <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zapisz i przejdź do edycji dostawy</button>
                                <? } ?>
    
                                <a href="<?=base_url()?>admin/order" class="btn btn-default btn-lg">Powrót do zamówień</a>
                            
                            <? } ?>
                            
                        </div>
                    </div>
                </div>
                
            <? } ?>
            
        </form>

      
        
    </div>

</div>


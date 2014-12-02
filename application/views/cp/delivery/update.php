<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('cp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>cp">Panel Klienta</a></li>
    <li><a href="<?=base_url()?>index.php/cp/delivery" class="label label-primary">Dostawa</a></li>
    <li class="active">Zmiana opcji dostawy w dniu <?=$delivery->date?></li>
</ol>

<h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon-plane muted"></i>&nbsp; Edycja adresu dostawy <?=$delivery->date?></h3>

<?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>  

<div class="row margin_t_10">

    <div class="col-md-6 text-left">

        <form class="form-horizontal" role="form" method="post" action="<?=base_url()?>cp/delivery/update/<?=$delivery->delivery_id?>">
            <div class="form-group">
                <label class="col-lg-3 control-label">Odbiera <span class="muted">*</span></label>
                <div class="col-lg-9">
                    <input type="text" name="name_surname" class="form-control input-lg" placeholder="Nazwa firmy i/lub osoby odbierającej" value="<?=$delivery->name_surname?>" required <?=($delivery->stopped)?'readonly':''?>>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-3 control-label">Adres <span class="muted">*</span></label>
                <div class="col-lg-9">
                    <input type="text" name="address" class="form-control input-lg" placeholder="Adres" value="<?=$delivery->address?>" required <?=($delivery->stopped)?'readonly':''?>>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-3 control-label"></label>
                <div class="col-lg-3">
                    <input type="text" name="postcode" class="form-control input-lg" placeholder="Kod pocztowy" value="<?=$delivery->postcode?>" required <?=($delivery->stopped)?'readonly':''?>>
                </div>
                <div class="col-lg-6">
                    <input type="text" name="city" class="form-control input-lg" placeholder="Miejscowość" value="<?=$delivery->city?>" required <?=($delivery->stopped)?'readonly':''?>>
                </div>
            </div>
            
            
            <div class="form-group">
                <label class="col-lg-3 control-label">Telefon <span class="muted">*</span></label>
                <div class="col-lg-9">
                    <input type="phone" name="phone" class="form-control input-lg" placeholder="Telefon" value="<?=$delivery->phone?>" required <?=($delivery->stopped)?'readonly':''?>>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-3 control-label">Preferowana godzina dostawy <span class="muted">*</span></label>
                <div class="col-lg-9">

                    <select class="form-control input-lg" name="hours" required <?=($delivery->stopped)?'readonly':''?>>
                        <option value=""> -- wybierz -- </option>
                        <? if(count(delivery_hours_values()) > 0) { ?>
                            <? foreach(delivery_hours_values() as $id => $v) { ?>
                                <option value="<?=$id?>" <?=($delivery->hours == $id)?'selected':''?>><?=reset($v)?></option> 
                            <? } ?>
                        <? } ?>
                    </select>

                </div>
            </div>

            
            <div class="form-group">
                <label class="col-lg-3 control-label">Uwagi</label>
                <div class="col-lg-9">
                    <textarea name="user_notice" class="form-control input-lg" placeholder="Dodatkowe uwagi dotyczące dostawy i posiłku" rows="3" <?=($delivery->stopped)?'readonly':''?>><?=$delivery->user_notice?></textarea>
                </div>
            </div>
            
            <? if(!$delivery->stopped) { ?>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="user_notice_remember" value="1"> Kopiuj powyższe uwagi do wszystkich przyszłych dostaw
                            </label>
                        </div>
                    </div>
                </div>
    
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zmień adres dostawy</button>
                            <a href="<?=base_url()?>index.php/cp/delivery" class="btn btn-default btn-lg">Powrót do kalendarza</a>
                        </div>
                    </div>
                </div>
            <? } else { ?>
            	<br />
            <? } ?>
        </form>


    </div>

    <div class="col-md-6 text-left">
		
        <div class="well bg_line">
        
        	<? if($delivery->stopped == 0) { ?>
            	<h3 class="margin_t_0 margin_b_20 font_red">Wstrzymaj dostawę w ten dzień</h3>
    		<? } else { ?>
            	<h3 class="margin_t_0 margin_b_20 font_green">Wznów dostawę w ten dzień</h3>
            <? } ?>
            
            <form class="form-horizontal" role="form" method="post" action="<?=current_url()?>">
            
                <input type="hidden" name="date" value="<?=$delivery->date?>" />
                <input type="hidden" name="delivery_id" value="<?=$delivery->delivery_id?>" />
                <input type="hidden" name="order_id" value="<?=$delivery->order_id?>" />
                <input type="hidden" name="moved_to" value="<?=$delivery->moved_to?>" />
                <input type="hidden" name="moved_from" value="<?=$delivery->moved_from?>" />
            
                <? if($delivery->stopped == 0) { ?>
                
       
                    <div class="alert margin_t_20 padding_0">
                        <i class="glyphicon glyphicon-info-sign"></i> Możesz wstrzymać dostawę w ten dzień przenosząc ją na inny - wybrany przez Ciebie. Poniżej znajduje się lista dostepnych dni, na które możesz przesunąć tę dostawę.
                    </div>
                            
                    <div class="input-group">

                        <select class="form-control " name="new_date" required>
                        
                            <option value=""> -- wybierz -- </option>
                            <? foreach($free_days as $date) { ?>
                                <option value="<?=$date?>"><?=strftime("%e %B %Y, %A", strtotime($date))?></option>
                            <? } ?>
                        
                        </select>
                        
                        <span class="input-group-btn">	
                            <button type="submit" class="btn btn-danger" name="move" value="1">Przenieś dostawę na wybrany termin</button>
                            <button type="submit" class="btn btn-danger" name="move" value="1"><i class="glyphicon glyphicon-forward"></i></button>
                        </span>
                        
                    </div>
                    
					<? if($delivery->moved_from) { ?>
                    
                        <div class="input-group margin_t_20">
                        	<div class="btn-group">
								<? $d = $this->delivery->get_delivery($delivery->moved_from); ?>
                       		 	<button type="submit" class="btn btn-primary" name="back" value="1"><i class="glyphicon glyphicon-backward"></i></button>
                                <button type="submit" class="btn btn-primary" name="back" value="1">Przenieś dostawę z powrotem na <?=$d->date?></button>
                            </div>
                        </div>
                    
                        
                    <? } ?>

                 
                <? } else { ?>

                    <div class="alert padding_0 margin_t_20">
                    	<? $d = $this->delivery->get_delivery($delivery->moved_to); ?>
                        <i class="glyphicon glyphicon-info-sign"></i> Możesz wznowić dostawę w ten dzień - zostanie ona znów aktywowana, a dostawa z dnia <?=$d->date?> zostanie usunięta.
                    </div>
                	
                    
                	
                    <div class="btn-group">
                        <? $d = $this->delivery->get_delivery($delivery->moved_to); ?>
                        <button type="submit" class="btn btn-success" name="undo" value="1"><i class="glyphicon glyphicon-screenshot"></i></button>
                        <button type="submit" class="btn btn-success" name="undo" value="1">Chcę mieć dostawę w <u>ten</u> dzień, a nie jak wcześniej ustawiłem <?=$d->date?></button>
                    </div>
            
                    

                <? } ?>
    
            </form>
         
        
            <div class="alert alert padding_0 margin_t_20 margin_b_0">
                <i class="glyphicon glyphicon-info-sign"></i> Możesz dowolnie edytować adresy i daty dostaw na 2 dni przed jej faktycznym miejscem.
            </div>

        </div>
        
    </div>

</div>


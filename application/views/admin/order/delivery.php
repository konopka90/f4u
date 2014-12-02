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
        <li><a href="<?=base_url()?>sp/order" class="label label-primary">Zamówienia</a></li>
        <li class="active">Edycja dostaw zamówienia <?=$order->order_number?></li>
    
    <? } else { ?>
    
        <li><a href="<?=base_url()?>">Panel Admina</a></li>
        <li><a href="<?=base_url()?>admin/order" class="label label-primary">Catering</a></li>
        <li class="active">Edycja dostaw zamówienia <?=$order->order_number?></li>
    
    <? } ?>
    
</ol>

<div class="row margin_b_30">
    <div class="col-md-12">
    
    	<h3 class="margin_0 margin_b_30">Edycja dostaw zamówienia <?=$order->order_number?> (<?=$order->name_surname?>)</h3>
           
      	<?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>  
           
        <table class="table">
            <tr>
                <td width="50%">Pierwsza dostawa</td>
                <td><?=reset($all_deliveries)->date?></td>
            </tr>
            <tr>
                <td width="50%">Ostatnia dostawa</td>
                <td><?=end($all_deliveries)->date?></td>
            </tr>
        </table>
        
        
        <h4 class="margin_0 margin_b_20">Globalne ustawienia</h4>

		<table class="table table-bordered">
        	<tr>
            	<td>
                    <div class="row">
                        <div class="col-md-4">
            
                            <div class="form-group clearfix">
                            
                                <label>Adres *</label>
            
                                <input type="text" id="pattern_delivery_address" class="form-control input-sm" placeholder="Adres" value="<?=$d->address?>" required>
                                    
                                <div class="row margin_t_15">
                                    <div class="col-lg-5">
                                        <input type="text" id="pattern_delivery_postcode" class="form-control input-sm" placeholder="Kod pocztowy" value="<?=$d->postcode?>" required/> 
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" id="pattern_delivery_city" class="form-control input-sm" placeholder="Miasto" value="<?=$d->city?>" required>
                                    </div>
                                </div>
                                
            
                            </div>    
                            
                            <div class="form-group clearfix">
                                <label>Preferowane godziny dostawy *</label>
                                <select class="form-control input-sm" id="pattern_delivery_hours" required>
                                    <option value=""> -- wybierz -- </option>
                                    <? if(count(delivery_hours_values()) > 0) { ?>
                                        <? foreach(delivery_hours_values() as $id => $v) { ?>
                                            <option value="<?=$id?>"><?=reset($v)?></option> 
                                        <? } ?>
                                    <? } ?>
                                </select>
                            </div>     
            
            
                        </div>
                
                        
                        <div class="col-md-4">
                                
                        
                            <div class="form-group clearfix">
                                <label>Imię i nazwisko *</label>
                                <input type="text" id="pattern_delivery_name_surname" class="form-control input-sm" placeholder="Imię i nazwisko osoby odbierającej" value="<?=$d->name_surname?>" required>
                         
                            </div>
            
                            <div class="form-group clearfix">
                                <label>Telefon *</label>
                                <input type="text" id="pattern_delivery_phone" class="form-control input-sm" placeholder="Telefon" value="<?=$d->phone?>" required>
                            </div>
                                
                        </div>
                        
                        
                        <div class="col-md-4">
                                
                        
                            <div class="form-group clearfix">
                                <label>Uwagi</label>
                                <textarea id="pattern_notice" class="form-control input-sm" placeholder="Uwagi" rows="5"></textarea>
                         
                            </div>
                                
                        </div>
                    
                        
                    </div>  
        		</td>
        	</tr>
        </table>
                                
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-lg btn_copy_delivery">Kopiuj adres do wszystkich</button>
            <button type="button" class="btn btn-primary btn-lg btn_copy_notice">Kopiuj uwagi do wszystkich</button>
            <a href="<?=base_url()?>admin/order" class="btn btn-default btn-lg">Powrót do zamówień</a>
        </div>
  	</div>  
</div>     
        
<div class="row" id="plumb">
    <div class="col-md-12">
        
        <form class="form margin_b_0" role="form" method="post" action="<?=base_url()?>admin/order/delivery/<?=$order->order_id?>" id="grammage_form">
        
            <table class="table table-striped table-hover table-condensed" id="deliveries_table">
                <thead>
                    <tr>
                    
                        <th>Dostawa</th>
                        <th>Adres</th>
                        <th width="150px">Uwagi klienta</th>
                        <th width="150px">Uwagi</th>
                        <th>Wstrzymaj dostawe</th>
                        <th width="50px">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                	<?
						$active_days = 0;
						$stopped_days = 0;
					?>
                    <? foreach($all_deliveries as $d) { ?>
    					
                        <tr class="<?=(date("Y-m-d") == $d->date)?'success':''?>">
                            <td width="50px">
                            	
                                <div class="<?=($d->stopped)?'moved':''?>" data-date="<?=$d->date?>" id="delivery_<?=$d->delivery_id?>" data-moved="delivery_<?=$d->moved_to?>" id="delivery_<?=$d->delivery_id?>" >
                                	<?=$this->load->view('_elements/calendar_card', array('d' => $d), true)?>
                                </div>
 
                            <td>
                            	<div class="">
                            		<div class="col-md-5">
                
                                        <div class="form-group clearfix margin_b_0">
                
                                            <input type="text" name="delivery[<?=$d->delivery_id?>][address]" data-name="delivery_address" class="form-control input-sm input_delivery" placeholder="Adres" value="<?=$d->address?>" required>
                                                
                                            <div class="row margin_t_5">
                                                <div class="col-lg-5">
                                                    <input type="text" name="delivery[<?=$d->delivery_id?>][postcode]" data-name="delivery_postcode" class="form-control input-sm input_delivery" placeholder="Kod pocztowy" value="<?=$d->postcode?>" required/> 
                                                </div>
                                                <div class="col-lg-7">
                                                    <input type="text" name="delivery[<?=$d->delivery_id?>][city]" data-name="delivery_city" class="form-control input-sm input_delivery" placeholder="Miasto" value="<?=$d->city?>" required>
                                                </div>
                                            </div>
                                            
                
                                        </div>           
                
                
                                    </div>
                            
                                    
                                    <div class="col-md-5">
                                            
                                    
                                        <div class="form-group clearfix margin_b_5">
                                            <input type="text" name="delivery[<?=$d->delivery_id?>][name_surname]" data-name="delivery_name_surname" class="form-control input-sm input_delivery" placeholder="Imię i nazwisko osoby odbierającej" value="<?=$d->name_surname?>" required>
                                     
                                        </div>
                
                                        <div class="form-group clearfix margin_t_5 margin_b_5">
                                            <input type="text" name="delivery[<?=$d->delivery_id?>][phone]" data-name="delivery_phone" class="form-control input-sm input_delivery" placeholder="Telefon" value="<?=$d->phone?>" required>
                                        </div>
                                            
                                    </div>
                                    
                                    <div class="col-md-10">
                                        <div class="form-group clearfix margin_t_0 margin_b_0">
                                            <select class="form-control input-sm input_delivery"  name="delivery[<?=$d->delivery_id?>][hours]" data-name="delivery_hours" id="delivery[<?=$d->delivery_id?>][hours]" required>
                                                <option value=""> -- wybierz -- </option>
                                                <? if(count(delivery_hours_values()) > 0) { ?>
                                                    <? foreach(delivery_hours_values() as $id => $v) { ?>
                                                        <option value="<?=$id?>" <?=($d->hours == $id)?'selected':''?>><?=reset($v)?></option> 
                                                    <? } ?>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                                
                                    
                                </div>  
                               
                            </td>
                            <td class="font_12">
                            	<?=$d->user_notice?>
                            </td>
                            <td>
                            	<textarea name="delivery[<?=$d->delivery_id?>][notice]" id="delivery[<?=$d->delivery_id?>][notice]" class="form-control input-sm textarea_notice" placeholder="Uwagi" rows="5"><?=$d->notice?></textarea>
                            </td>
                            <td>

                                <div class="checkbox">
                                    <label>
                                    	<input name="delivery[<?=$d->delivery_id?>][stopped]" type="checkbox" value="1" <?=($d->stopped == 1)?'checked':''?>> Wstrzymana
                                    </label>
                                </div>
                            
                            </td>
                            <td>
                            
                            	<? //if($d == end($all_deliveries)) { ?>
                                	<? if($access == 'seller') { ?>
                                    	<a href="<?=base_url()?>admin/order/delivery/<?=$order->order_id?>/remove_by_seller/<?=$d->delivery_id?>">	
                                    <? } else { ?>
                                    	<a href="<?=base_url()?>admin/order/delivery/<?=$order->order_id?>/remove/<?=$d->delivery_id?>">
                                    <? } ?>
                                    
                                    	<i class="font_16 glyphicon glyphicon-remove tooltipa" data-original-title="Usuń"></i>  
                                        
                                    </a>
                                <? //} ?>
                            
                            </td>
                        </tr>
                        
                        <? if($d->stopped == 0) { 
							$active_days++;
						} else {
							$stopped_days++;	
						}?>
                        
                    <? } ?>
                </tbody>         
            </table>
                      
            <table class="table table-bordered margin_t_20">
            	<thead>
                	<tr>
                    	<th colspan="2">Podsumowanie</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    	<td><h4>Dni które są aktywne i mają dostawę</h4></td>
                        <td><h4><strong><?=($active_days)?$active_days:0?> dni</strong></h4></td>
                    </tr>
                	<tr>
                    	<td>Dni za które użytkownik zapłacił</td>
                        <td><?=($order->payed_days)?$order->payed_days:0?> dni</td>
                    </tr>
                    <tr>
                    	<td>Dni które użytkownik otrzymał GRATIS</td>
                        <td><?=($order->free_days)?$order->free_days:0?> dni</td>
                    </tr>
                    <tr>
                    	<td>Dni w które użytkownik ma wstrzymaną dostawę</td>
                        <td><?=($stopped_days)?$stopped_days:0?> dni</td>
                    </tr>
                </tbody>
            </table>
                        
            <div class="btn-group margin_b_30">
            
            	<? if($access == 'seller') { ?>
                
					<? if($this->session->flashdata('adding_order')) { ?>
                        <button type="submit" class="btn btn-success btn-lg" name="save_client_order_and_grammage" value="1">Zapisz i przejdź do edycji gramatury</button> 
                    <? } else { ?>
                        <button type="submit" class="btn btn-success btn-lg" name="save_client_order" value="1">Zapisz</button>
                    <? } ?>
                    <a href="<?=base_url()?>sp/order/grammage/<?=$order->order_id?>" class="btn btn-default btn-lg">Edytuj gramature</a>
                    <a href="<?=base_url()?>sp/order" class="btn btn-default btn-lg">Powrót do zamówień klientów</a>
                
                <? } else { ?>
                
					<? if($this->session->flashdata('adding_order')) { ?>
                        <button type="submit" class="btn btn-success btn-lg" name="save_and_grammage" value="1">Zapisz i przejdź do edycji gramatury</button> 
                    <? } else { ?>
                        <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zapisz</button>
                    <? } ?>
                    <a href="<?=base_url()?>admin/order/grammage/<?=$order->order_id?>" class="btn btn-default btn-lg">Edytuj gramature</a>
                    <a href="<?=base_url()?>admin/order" class="btn btn-default btn-lg">Powrót do zamówień</a>
                
                <? } ?>

            </div>
            
  		</form>
        
        
        <form class="form-inline margin_b_30 clearfix" method="POST" role="form" action="<?=base_url()?>admin/order/delivery/<?=$order->order_id?>/<?=($access == 'seller')?'add_by_seller':'add'?>">
            
            <div class="input-group">
            
                <input type="text" class="form-control input-lg dp" name="date" placeholder="Data dostawy" required>
                <span class="input-group-btn">
                
                	<? if($access == 'seller') { ?>
                   		<button type="submit" class="btn btn-success btn-lg" name="add_client_order" value="1">Dodaj w wybranym dniu</button> 
                    <? } else { ?>
                    	<button type="submit" class="btn btn-success btn-lg" name="add" value="1">Dodaj w wybranym dniu</button>
                    <? } ?>
 
                    <a class="btn btn-primary btn-lg" href="<?=base_url()?>admin/order/delivery/<?=$order->order_id?>/<?=($access == 'seller')?'add_by_seller':'add'?>/<?=date("Ymd", strtotime("+1day", strtotime($d->date)))?>">Dodaj dostawę w dniu <?=strftime("%Y-%m-%d, %A", strtotime("+1day", strtotime($d->date)))?></a>
                </span>
                
            </div>
            
        </form>
          
    </div>
    
    
</div>


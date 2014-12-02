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

        <li><a href="<?=base_url()?>sp">Panel Sprzedawcy</a></li>
        <li><a href="<?=base_url()?>sp/order" class="label label-primary">Zamówienia</a></li>
        <li class="active">Edycja gramatur zamówienia <?=$order->order_number?></li>
    
    <? } else { ?>
    
        <li><a href="<?=base_url()?>">Panel Admina</a></li>
        <li><a href="<?=base_url()?>admin/order" class="label label-primary">Catering</a></li>
        <li class="active">Edycja gramatur zamówienia <?=$order->order_number?></li>
    
    <? } ?>

</ol>

<div class="row margin_b_30">
    <div class="col-md-12">
    
    	<h3 class="margin_0 margin_b_30">Edycja gramatury zamówienia <?=$order->order_number?> (<?=$order->name_surname?>)</h3>
                
        <?
			$meals_selected = unserialize($order->meals_selected);
		
		?>
                
        <table class="table">
            <tr>
                <td width="50%">Pierwsza dostawa</td>
                <td><?=reset($all_deliveries)->date?></td>
            </tr>
            <tr>
                <td width="50%">Ostatnia dostawa</td>
                <td><?=end($all_deliveries)->date?></td>
            </tr>
            <tr>
                <td width="50%"><strong>Catering</strong></td>
                <td>
                
            		<?=reset($order->products)->name?> <span class="font_gray"><?=(is_array(unserialize($order->meals_selected)))?'('.implode(", ", unserialize($order->meals_selected)).')':''?></span><br />
            		<?=($order->days)?$order->days:0?> <span class="font_gray">dni, od</span> <?=reset($all_deliveries)->date?> <span class="font_gray">do</span> <?=end($all_deliveries)->date?>
            
                </td>
            </tr>
        </table>
        
        <h4 class="margin_0 margin_b_20">Globalne ustawienia</h4>
        
        <table class="table table-bordered table-condensed">
            <tr>
                <? for($i=1;$i<=5;$i++) { ?>
                    <th class="text-center <?=(in_array($i, $meals_selected))?'active':''?>">Posiłek #<?=$i?></th>
                <? } ?>
                <th>Uwagi</th>
                <th>Słowa kluczowe</th>
                <th>Cena</th>
            </tr>
            <tr>
                <? for($i=1;$i<=5;$i++) { ?>
                    <td class="<?=(in_array($i, $meals_selected))?'active':''?>">
                    	<div class="form-group margin_b_10">
                            <input type="text" id="pattern_<?=$i?>_name" class="form-control input-sm" placeholder="Nazwa posiłku" style="">
                        </div>
                        <div class="form-group margin_b_10">
                            <input type="text" id="pattern_<?=$i?>_w" class="form-control input-sm" placeholder="Węglowodany <?=(in_array($i, $meals_selected))?'*':''?>" style="">
                        </div>
                        <div class="form-group margin_b_0">
                            <input type="text" id="pattern_<?=$i?>_b"  class="form-control input-sm" placeholder="Białko <?=(in_array($i, $meals_selected))?'*':''?>" style="">
                        </div>
                        
                    </td>
                <? } ?>
                <td>
                    <textarea id="pattern_notice" class="form-control input-xs margin_b_0" placeholder="Uwagi wobec posiłku" rows="5"></textarea>
                </td>
                <td>
                    <textarea id="pattern_keyword" class="form-control input-xs margin_b_0" placeholder="Słowa kluczowe - brane pod uwagę podczas sortowania, doklejane do uwag do gramatury i traktowane jako całość uwag" rows="5"></textarea>
                </td>
                <td>
                    <textarea id="pattern_price" class="form-control input-xs margin_b_0" placeholder="Cena np. 10 albo 9.99" rows="5"></textarea>
                </td>
            </tr>
        </table>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-lg btn_copy_grammage">Kopiuj posiłki</button>
            <button type="button" class="btn btn-primary btn-lg btn_copy_notice">Kopiuj uwagi</button>
            <button type="button" class="btn btn-primary btn-lg btn_copy_keyword">Kopiuj słowa kluczowe</button>
            <button type="button" class="btn btn-primary btn-lg btn_copy_price">Kopiuj cenę</button>
            <?php /*?><button type="button" class="btn btn-success btn-lg btn_submit_grammage_form">Zapisz</button><?php */?>
            <? if($access == 'seller') { ?>
            	<a href="<?=base_url()?>cp/order" class="btn btn-default btn-lg">Powrót do zamówień klientów</a>
            <? } else { ?>
            	<a href="<?=base_url()?>admin/order" class="btn btn-default btn-lg">Powrót do zamówień</a>
            <? } ?>
        </div>
  	</div>  
</div>     
        
<div class="row">
    <div class="col-md-<?=($order->order_form_id)?'9':'12'?>">
        
        <form class="form" role="form" method="post" action="<?=base_url()?>admin/order/grammage/<?=$order->order_id?>" id="grammage_form">
        
            <table class="table table-striped table-hover table-condensed">
                <thead>
                    <tr>
                    
                        <th>Dostawa</th>
                        <th>Gramatura</th>
                        
                        <th width="150px">Uwagi klienta</th>
                        <th width="150px">Uwagi</th>
                        <th width="100px">Słowa kluczowe</th>
                        <th>Cena</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach($all_deliveries as $d) { ?>
    					
                        <tr class="<?=(date("Y-m-d") == $d->date)?'success':''?>" id="delivery_<?=$d->delivery_id?>">
                            <td width="50px">
                                <?=$this->load->view('_elements/calendar_card', array('d' => $d), true)?>
                            <td>
                                <table class="table table-bordered table-condensed margin_b_0">
                                    <tr>
                                        <? for($i=1;$i<=5;$i++) { ?>
                                            <th class="<?=(in_array($i, $meals_selected))?'active':''?> text-center"> &nbsp;&nbsp;&nbsp;&nbsp;#<?=$i?>&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                        <? } ?>
                                    </tr>
                                    <tr>
                                        <? for($i=1;$i<=5;$i++) { ?>
                                            <td class="<?=(in_array($i, $meals_selected))?'active':''?>">
                                            
                                                <div class="form-group margin_b_10">
                                                	<? $key = 'meal_' . $i; ?>
                                                    <input type="text" name="delivery[<?=$d->delivery_id?>][<?=$i?>][name]" id="delivery_<?=$i?>_name" data-meal="<?=$i?>" data-type="name" class="input_grammage form-control input-sm" placeholder="Nazwa posiłku" value="<?=$all_deliveries_grammage[$d->delivery_id]->$key?>">
                                                </div>
                                                <div class="form-group margin_b_10">
                                                	<? $key = 'meal_' . $i . '_w'; ?>
                                                    <input type="text" name="delivery[<?=$d->delivery_id?>][<?=$i?>][w]" id="delivery_<?=$i?>_w" data-meal="<?=$i?>" data-type="w" class="input_grammage form-control input-sm" placeholder="Węglowodany <?=(in_array($i, $meals_selected))?'*':''?>" value="<?=$all_deliveries_grammage[$d->delivery_id]->$key?>">
                                                </div>
                                                <div class="form-group margin_b_0">
                                                	<? $key = 'meal_' . $i . '_b'; ?>
                                                    <input type="text" name="delivery[<?=$d->delivery_id?>][<?=$i?>][b]" id="delivery_<?=$i?>_b" data-meal="<?=$i?>" data-type="b" class="input_grammage form-control input-sm" placeholder="Białko <?=(in_array($i, $meals_selected))?'*':''?>" value="<?=$all_deliveries_grammage[$d->delivery_id]->$key?>">
                                                </div>
                                                
                                            </td>
                                        <? } ?>
                                    </tr>
                                </table>
                            </td>
                            <td class="font_12">
                            	<?=$d->user_notice?>
                            </td>
                            <td>
                            
                                <textarea name="delivery[<?=$d->delivery_id?>][notice]" id="delivery_notice" class="textarea_notice form-control input-xs margin_b_0" placeholder="Uwagi wobec posiłku" rows="6"><?=$all_deliveries_grammage[$d->delivery_id]->notice?></textarea>
                            
                            </td>
                            <td>
                            
                                <textarea name="delivery[<?=$d->delivery_id?>][keyword]" id="delivery_keyword" class="textarea_keyword form-control input-xs margin_b_0" placeholder="Słowa kluczowe" rows="6"><?=$all_deliveries_grammage[$d->delivery_id]->keyword?></textarea>
                            
                            </td>
                            <td>
                            
                                <textarea name="delivery[<?=$d->delivery_id?>][price]" id="delivery_price" class="textarea_price form-control input-xs margin_b_0" placeholder="Cena" rows="6"><?=$all_deliveries_grammage[$d->delivery_id]->price?></textarea>
                            
                            </td>
                            <input type="hidden" name="delivery[<?=$d->delivery_id?>][delivery_id]" value="<?=$d->delivery_id?>" />
                        </tr>
                    <? } ?>
                </tbody>         
            </table>
            <div class="btn-group margin_b_30">
            
            	<? if($access == 'seller') { ?>

					<button type="submit" class="btn btn-success btn-lg" name="save_client_order" value="1">Zapisz</button>
                    <a href="<?=base_url()?>sp/order/delivery/<?=$order->order_id?>" class="btn btn-default btn-lg">Edytuj dostawy</a>
                    <a href="<?=base_url()?>sp/order" class="btn btn-default btn-lg">Powrót do zamówień klientów</a>
                
                <? } else { ?>
            
					<? if($this->session->flashdata('adding_order')) { ?>
                        <button type="submit" class="btn btn-success btn-lg" name="save_and_invoice" value="1">Zapisz i przejdź do wystawienia faktury</button> 
                    <? } else { ?>
                        <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zapisz</button>
                    <? } ?>
                    <a href="<?=base_url()?>admin/order/delivery/<?=$order->order_id?>" class="btn btn-default btn-lg">Edytuj dostawy</a>
                    <a href="<?=base_url()?>admin/order" class="btn btn-default btn-lg">Powrót do zamówień</a>
                
                <? } ?>
                
            </div>
  		</form>
              
    </div>
    
    <? if($order->order_form_id) { ?>
        <div class="col-md-3">
        
            <? if(count($food_form) > 0) { ?>
                <div style="overflow: auto;" id="adiv_food_form">
                    <h3 class="margin_0 margin_b_20">Formularz żywieniowy</h3>
                    <?=$this->load->view('admin/order/food_form', array('food_form' => $food_form), true)?>
                </div>
            <? } ?>
        
        </div>
    <? } ?>
</div>


<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Admina</a></li>
    <li class="active">Dostawy do klientów</li>
</ol>


<div class="row">
    <div class="col-md-12">
        
        <div class="row">
        	<div class="col-md-8">
    			<h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-plane"></i>&nbsp; Dostawy na najbliższe dni <span class="label label-default font_12"><i class="glyphicon glyphicon-info-sign"></i> tylko opłacone pakiety</span><span class="margin_l_10 label label-default font_12"><i class="glyphicon glyphicon-info-sign"></i> tylko pakiety z wypisaną gramaturą</span><span class="margin_l_10 label label-default font_12"><i class="glyphicon glyphicon-info-sign"></i> tylko niewstrzymane dostawy</span></h3>
            </div>
                
            <div class="col-md-4">
                <form class="form" method="post" action="<?=current_url()?>">
                    <div class="input-group">
                        <input type="text" class="dr form-control" name="deliveries_range" id="deliveries_range" value="<?=$this->session->userdata('deliveries_start')?> do <?=$this->session->userdata('deliveries_end')?>" required/>
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary" name="save" value="1"><i class="glyphicon glyphicon-search tooltipa" title="Pokaż dostawy<br>w wybrane dni"></i></button>
                            
                            <button type="submit" class="btn btn-danger" name="reset" value="1"><i class="glyphicon glyphicon-record tooltipa" title="Resetuj na 3 dni do przodu"></i></button>
                            
                            <a href="<?=base_url()?>admin/delivery/download_statistics?v=<?=time()?>" class="btn btn-default"><i class="glyphicon glyphicon-stats tooltipa" title="Statystyki liczby klientów i<br />posiłków na <u>aktualnie</u> wybrane dni"></i></a>
                            
                        </div>
                    </div>
                </form>
            </div>
  		</div>
          


        <?php /*?>
        <div class="btn-group margin_b_30" data-toggle="buttons">
            <label class="btn btn-default">
           		Pokazuj:
            </label>
            <label class="btn btn-info">
           		<input type="checkbox"> Adres dostawy
            </label>
            <label class="btn btn-info">
            	<input type="checkbox"> Gramaturę posiłków
            </label>
            <label class="btn btn-info">
            	<input type="checkbox"> Komentarze
            </label>
        </div>
		<?php */?>

        <table class="table table-striped table-bordered table-condensed" style="white-space:nowrap">
            <thead>
                <tr>
                	<th width="<?=100/($days_forward+1)?>%" rowspan="2">Imię i nazwisko</tt>
                	<? for($i=0;$i<$days_forward;$i++) { ?>
                    	<th width="<?=100/($days_forward+1)?>%">
                            
							<?=strftime("%Y-%m-%d, %A", strtotime("+{$i}day", strtotime($date_start)))?>

                        </th>
                    <? } ?>
                </tr>
                <tr>
                	
                	<? for($i=0;$i<$days_forward;$i++) { ?>
                    	<th width="<?=100/($days_forward+1)?>%">
                            
                            <a data-toggle="collapse" data-parent=".accordion_<?=date("Ymd", strtotime("+{$i}day", strtotime($date_start)))?>" href=".collapse_<?=date("Ymd", strtotime("+{$i}day", strtotime($date_start)))?>" class="pull-right" style="margin-right: 16px">
                            	<i class="glyphicon glyphicon-collapse-down font_green pull-right"></i>
                            </a> 
             
                            <a data-toggle="modal" data-target="#download_grammage_delivery" class="pointer font_primary tooltipa margin_r_20 btn_download_grammage_delivery" title="Pobierz w pdf" data-date="<?=date("Y-m-d", strtotime("+{$i}day", strtotime($date_start)))?>">
                            	<i class="glyphicon glyphicon-download-alt"></i>
                            </a>

                        </th>
                    <? } ?>
                </tr>
            </thead>
            <tbody>
            
            	<? if(count($all_users) > 0) { ?>
                
                	<? foreach($all_users as $u) { ?>
                    	<tr>
                        	<td>
                            	<?=$u->name_surname?><br />
                                <? if($u->phone) { ?>
                  					<span class="label label-info">tel: <?=$u->phone?></span>
                                <? } ?>
                      
                            </td>
                                
                                
                            <? for($i=0;$i<$days_forward;$i++) { ?>
                                
                                <td class="<?=(false)?'success':''?>">
                                    <? if(count($all_deliveries[date("Y-m-d", strtotime("+{$i}day", strtotime($date_start)))][$u->user_id]) > 0) { ?>
                                    
                                        <? foreach($all_deliveries[date("Y-m-d", strtotime("+{$i}day", strtotime($date_start)))][$u->user_id] as $d) { ?>
                                        
                                            <?
                                                $packets_names_values = packets_names_values($d->name);
                                            ?>
                                            
                                            <div class="panel-group accordion accordion_<?=$u->user_id?> accordion_<?=date("Ymd", strtotime("+{$i}day", strtotime($date_start)))?>">
                                                <div class="panel panel-<?=($d->date == date("Y-m-d"))?'success':'default'?> margin_b_0">
                                                
                                                    <div class="panel-heading">
                                                        <a data-toggle="collapse" data-parent=".accordion_<?=$u->user_id?>" href=".collapse_<?=$u->user_id?>">
                                                        	<i class="glyphicon glyphicon-collapse-down font_green pull-right"></i>
                                                        </a>
                                                        <h3 class="panel-title">
															<?=$d->meals?> <?=($d->meals > 4)?'posiłów':'posiłki'?>
                                                        </h3>
                                                    </div>
                            
                                                	<div class="collapse_<?=$u->user_id?> collapse_<?=date("Ymd", strtotime("+{$i}day", strtotime($date_start)))?> panel-collapse collapse">
                                                        
                                                            <div class="panel-body padding_5 font_12">
                                                                <?=$d->name_surname?><br /><?=$d->address?>, <?=$d->postcode?> <?=$d->city?><br /><em>tel.</em> <?=$d->phone?>
                                                                
                                                                <table class="table table-condensed table-bordered font_10 margin_t_10 margin_b_0">
                                                                    <tr>
                                                                        <th class="text-center <?=(in_array(1, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">1</th>
                                                                        <th class="text-center <?=(in_array(2, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">2</th>
                                                                        <th class="text-center <?=(in_array(3, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">3</th>
                                                                        <th class="text-center <?=(in_array(4, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">4</th>
                                                                        <th class="text-center <?=(in_array(5, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">5</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="<?=(in_array(1, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">
                                                                        	<?=($d->meal_1)?$d->meal_1 . '<br />':''?>
																			<?=($d->meal_1_w)?$d->meal_1_w:0?>/<?=($d->meal_1_b)?$d->meal_1_b:0?>
                                                                        </td>
                                                                        <td class="<?=(in_array(2, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">
                                                                        	<?=($d->meal_2)?$d->meal_2 . '<br />':''?>
																			<?=($d->meal_2_w)?$d->meal_2_w:0?>/<?=($d->meal_2_b)?$d->meal_2_b:0?>
                                                                        </td>
                                                                        <td class="<?=(in_array(3, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">
                                                                        	<?=($d->meal_3)?$d->meal_3 . '<br />':''?>
																			<?=($d->meal_3_w)?$d->meal_3_w:0?>/<?=($d->meal_3_b)?$d->meal_3_b:0?>
                                                                        </td>
                                                                        <td class="<?=(in_array(4, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">
                                                                        	<?=($d->meal_4)?$d->meal_4 . '<br />':''?>
																			<?=($d->meal_4_w)?$d->meal_4_w:0?>/<?=($d->meal_4_b)?$d->meal_4_b:0?>
                                                                        </td>
                                                                        <td class="<?=(in_array(5, unserialize($all_deliveries_selected_meals[$d->order_id]->meals_selected)))?'active':''?>">
                                                                        	<?=($d->meal_5)?$d->meal_5 . '<br />':''?>
																			<?=($d->meal_5_w)?$d->meal_5_w:0?>/<?=($d->meal_5_b)?$d->meal_5_b:0?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                
                                                            </div>
                                                            <div class="panel-footer font_10">
                        										
                                                                <a href="<?=base_url()?>admin/order/grammage/<?=$d->order_id?>#delivery_<?=$d->delivery_id?>" class="pull-right margin_l_10">
                                                                    <i class="font_16 glyphicon glyphicon-cutlery tooltipa" data-original-title="Edycja gramatur, komentarzy posiłów"></i>  
                                                                </a>
                                                                
                                                                <a href="<?=base_url()?>admin/order/delivery/<?=$d->order_id?>#delivery_<?=$d->delivery_id?>" class="pull-right">
                                                                    <i class="font_16 glyphicon glyphicon-plane tooltipa" data-original-title="Edycja dostaw"></i>  
                                                                </a>
                                                                                                   
                                                               	&nbsp;
                                                                <br />
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                
                                                </div>
                                                
                                            </div>

                                        <? } ?>
                                    <? } else { ?>
                                        - 
                                    <? } ?>
                                
                                </td>
                                
                            <? } ?>
                            
                            
                        </tr>
                    <? } ?>
                
                <? } ?>
                
                <? if(count($all_deliveries) > 0) { ?>
                
                	<tr>

                    </tr>	
                    
                <? } else { ?>
                	<tr>
                    	<td colspan="<?=$days_forward+1?>">
							<i class="glyphicon glyphicon-exclamation-sign"></i> Brak dostaw.
                        </td>
                    </tr>
                <? } ?>
                
               
            </tbody>
                            
        </table>
        
            
        
        
        
    </div>
</div>


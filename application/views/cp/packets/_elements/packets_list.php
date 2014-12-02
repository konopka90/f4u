<? if(count($user_packets) > 0) { ?>
    <div class="list-group">
        <? foreach($user_packets as $i => $p) { ?>
    
            <?
            
                $packets_meals_per_day_values = packets_meals_per_day_values($p->meals_per_day);
                $deliveries = $this->delivery->get_deliveries(FALSE, $p->order_id);
                
                $start = reset($deliveries)->date;
                $end = end($deliveries)->date;
            
            ?>
        
            <a href="<?=base_url()?>cp/packets" class="list-group-item <?=($i == 0)?'':''?> <?=(date("Y-m-d") > $end)?'bg_line font_gray':''?>">
                
                <? if($user->user_id == 12) { ?>
                
					<? if($p->payment == 2) { ?>
                    	
                     	<? if($closest_delivery->order_id == $p->order_id) { ?>
                        	<span class="pull-right label label-success">OPŁACONY I AKTYWNY</span>
                        <? } else { ?>
                        	<span class="pull-right label label-success">OPŁACONY</span>
                        <? } ?>   
                        
                    <? } else { ?>
                    	<span class="pull-right label label-danger">NIEZAPŁACONY</span>
                    <? } ?>
                    
               	<? } else { ?> 
                
					<? if($closest_delivery->order_id == $p->order_id) { ?>
                        <span class="pull-right label label-<?=(($p->payment == 2)?'success':'danger')?>"><?=(($p->payment == 2)?'AKTYWNY':'NIEZAPŁACONY')?></span>
                    <? } elseif(date("Y-m-d") > $end) { ?>
                    
                    <? } else { ?>
                        <span class="pull-right label label-<?=(($p->payment == 2)?'success':'danger')?>"><?=(($p->payment == 2)?'ZAPŁACONY':'NIEZAPŁACONY')?></span>
                    <? } ?>
                    
                <? } ?>
                
                
				<h4 class="list-group-item-heading margin_b_10">
					<?=$p->name?><?php /*?><span class="font_gray"><?=(is_array(unserialize($p->meals_selected)))?'('.implode(", ", unserialize($p->meals_selected)).')':''?></span><?php */?> x <?=($p->days)?$p->days:0?> dni<br />
                </h4>
                
                <?php /*?><h4 class="list-group-item-heading margin_b_10"><strong><?=$packets_meals_per_day_values[0]?></strong> dziennie<br />przez <strong><?=$p->days?></strong> dni</h4><?php */?>
                
                
                
                <p class="list-group-item-text font_14">
                
                	<em>Dostawy od</em> <?=strftime("%e-%m-%Y, %A", strtotime($start))?> <em>do</em> <?=strftime("%e-%m-%Y, %A", strtotime($end))?>.<br />
                    <?php /*?><em>Cena:</em> <strong><?=$p->price?></strong> zł<?php */?>
                    
                </p>
                
                <? if($closest_delivery->order_id == $p->order_id) {
                    
					//AKTYWNY PAKIET
					$total_days = (strtotime($end)-strtotime($start))	/	(3600*24) + 1;

					$step = 100/$total_days;
					$current_day = (time()-strtotime($start))	/	(3600*24) + 1;

					$display = ((time() > strtotime($start))?$current_day * $step:0);

                    ?>

                    <div class="progress progress-striped margin_t_10 margin_b_10">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=$display?>" aria-valuemin="0" aria-valuemax="<?=$display?>" style="width: <?=$display?>%">
                            <span class="sr-only"><?=$display?>%</span>
                        </div>
                    </div>
                    
                <? } elseif(date("Y-m-d") > $end) { ?>
                    <div class="progress progress-striped margin_t_10 margin_b_10">
                        <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">100%</span>
                        </div>
                    </div>
				<? } ?>
                    
            </a>
        
        <? } ?>
    </div>
<? } else { ?>
    <p class="margin_t_20 margin_b_20">
        <i class="glyphicon glyphicon-exclamation-sign"></i> Brak wykupionych pakietów.
    </p>
<? } ?>

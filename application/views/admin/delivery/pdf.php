<table cellspacing="3" cellpadding="3" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 12px;">
    <tr>
        <td width="100%" valign="middle" align="center" >
		
        	<img src="<?=base_url()?>img/logo.png" style="width: 200px">	
            
        </td>
 	</tr>
    <tr>
        <td width="100%" bgcolor="#b9d044" align="center" style="color: #000; color:#fff;font-size: 16px">
        
        	<strong>
            	<? if($data['grammage'] == 1 && !$data['delivery']) { ?>
                	posiłki w dniu 
                <? } elseif(!$data['grammage'] && $data['delivery'] == 1) { ?>
                	dostawy w dniu 
                <? } else { ?>
            		posiłki i dostawy w dniu 
				<? } ?>
				<?=strftime("%Y-%m-%d, %A", strtotime($date))?>
            </strong>
        
        </td>
    </tr>
    <?php /*?>
    <tr align="center">
		<td width="34%" valign="bottom" style="border: 1px solid #eee">
        
		</td>
    </tr>
    <?php */?>
</table>

<br>

<table cellspacing="0" cellpadding="3" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 14px;">
    <tr bgcolor="#412b1e" style="color: #fff;font-weight:normal;font-weight:bold">
    
        <th align="center" width="2%" style="line-height: 10px;padding: 10px 10px 5px 10px">Nr</th>
        <th align="left" width="16%" style="line-height: 10px;padding: 10px 10px 5px 10px">Imię i nazwisko</th>
        
        <? if($data['grammage'] == 1) { ?>
            <th align="center" width="9%" style="line-height: 10px;padding: 10px 10px 5px 10px">
                Posiłek 1<br />
                <span style="font-size: 10px;color:#b8d044">W / B</span>
            </th>
            <th align="center" width="9%" style="line-height: 10px;padding: 10px 10px 5px 10px">
                Posiłek 2<br />
                <span style="font-size: 10px;color:#b8d044">W / B</span>
            </th>
            <th align="center" width="9%" style="line-height: 10px;padding: 10px 10px 5px 10px">
                Posiłek 3<br />
                <span style="font-size: 10px;color:#b8d044">W / B</span>
            </th>
            <th align="center" width="9%" style="line-height: 10px;padding: 10px 10px 5px 10px">
                Posiłek 4<br />
                <span style="font-size: 10px;color:#b8d044">W / B</span>
            </th>
            <th align="center" width="9%" style="line-height: 10px;padding: 10px 10px 5px 10px">
                Posiłek 5<br />
                <span style="font-size: 10px;color:#b8d044">W / B</span>
            </th>
       	<? } ?>
        
        <? if($data['notice'] == 1) { ?>
        	<th align="left" style="line-height: 10px">Uwagi klienta</th>
        <? } ?>
        
        
        <? if($data['grammage'] == 1) { ?>     
            <th align="left" style="line-height: 10px">Uwagi</th>
        <? } ?>
        
        <? if($data['delivery'] == 1) { ?>
			<th align="left" style="line-height: 10px">Adres dostawy</th>
            <th align="left" style="line-height: 10px">Uwagi</th>
        <? } ?>
        
        <? if($data['price'] == 1) { ?>     
            <th align="left" style="line-height: 10px">Cena</th>
        <? } ?>
        
    </tr>
    
    <?

	$i = 1;
	
	$meal[1][w] = 0;
	$meal[1][b] = 0;
	$meal[2][w] = 0;
	$meal[2][b] = 0;
	$meal[3][w] = 0;
	$meal[3][b] = 0;
	$meal[4][w] = 0;
	$meal[4][b] = 0;
	$meal[5][w] = 0;
	$meal[5][b] = 0;
	
	$total_price = 0;
	
	foreach($all_users as $u) { ?>
    
    	<tr style=" <?=($i%2)?'background: #f2f2f2':''?>">
        	<td align="center" valign="top" style="color: #000;border: 1px solid #eee"><?=$i?></td>
            <td valign="top" style="color: #000;border: 1px solid #eee;font-size: 10px">
            
            	<?=$u->name_surname?><br />
                tel.: <?=$u->phone?><br />
               
                
            </td>
            <? if($data['grammage'] == 1) { ?>
                <td align="center" valign="top" style="color: #000;border: 1px solid #eee;font-size:14px">
                
                    <span style="font-size: 10px;line-height: 8px"><?=($all_deliveries[$u->user_id][0]->meal_1)?$all_deliveries[$u->user_id][0]->meal_1.'<br />':''?></span>
                
                    <?=($all_deliveries[$u->user_id][0]->meal_1_w)?$all_deliveries[$u->user_id][0]->meal_1_w:0?>/<?=($all_deliveries[$u->user_id][0]->meal_1_b)?$all_deliveries[$u->user_id][0]->meal_1_b:0?>
                    <?
                        $meal[1][w] += $all_deliveries[$u->user_id][0]->meal_1_w;
                        $meal[1][b] += $all_deliveries[$u->user_id][0]->meal_1_b;
                    ?>
                
                </td>
                <td align="center" valign="top" style="color: #000;border: 1px solid #eee;font-size:14px">
                
                    <span style="font-size: 10px;line-height: 8px"><?=($all_deliveries[$u->user_id][0]->meal_2)?$all_deliveries[$u->user_id][0]->meal_2.'<br />':''?></span>
                
                    <?=($all_deliveries[$u->user_id][0]->meal_2_w)?$all_deliveries[$u->user_id][0]->meal_2_w:0?>/<?=($all_deliveries[$u->user_id][0]->meal_2_b)?$all_deliveries[$u->user_id][0]->meal_2_b:0?>
                    <?
                        $meal[2][w] += $all_deliveries[$u->user_id][0]->meal_2_w;
                        $meal[2][b] += $all_deliveries[$u->user_id][0]->meal_2_b;
                    ?>            
                </td>
                <td align="center" valign="top" style="color: #000;border: 1px solid #eee;font-size:14px">
                
                    <span style="font-size: 10px;line-height: 8px"><?=($all_deliveries[$u->user_id][0]->meal_3)?$all_deliveries[$u->user_id][0]->meal_3.'<br />':''?></span>
                
                    <?=($all_deliveries[$u->user_id][0]->meal_3_w)?$all_deliveries[$u->user_id][0]->meal_3_w:0?>/<?=($all_deliveries[$u->user_id][0]->meal_3_b)?$all_deliveries[$u->user_id][0]->meal_3_b:0?>
                    <?
                        $meal[3][w] += $all_deliveries[$u->user_id][0]->meal_3_w;
                        $meal[3][b] += $all_deliveries[$u->user_id][0]->meal_3_b;
                    ?>    
                </td>
                <td align="center" valign="top" style="color: #000;border: 1px solid #eee;font-size:14px">
                
                    <span style="font-size: 10px;line-height: 8px"><?=($all_deliveries[$u->user_id][0]->meal_4)?$all_deliveries[$u->user_id][0]->meal_4.'<br />':''?></span>
                
                    <?=($all_deliveries[$u->user_id][0]->meal_4_w)?$all_deliveries[$u->user_id][0]->meal_4_w:0?>/<?=($all_deliveries[$u->user_id][0]->meal_4_b)?$all_deliveries[$u->user_id][0]->meal_4_b:0?>
                    <?
                        $meal[4][w] += $all_deliveries[$u->user_id][0]->meal_4_w;
                        $meal[4][b] += $all_deliveries[$u->user_id][0]->meal_4_b;
                    ?>       
                
                </td>
                <td align="center" valign="top" style="color: #000;border: 1px solid #eee;font-size:14px">
                
                    <span style="font-size: 10px;line-height: 8px"><?=($all_deliveries[$u->user_id][0]->meal_5)?$all_deliveries[$u->user_id][0]->meal_5.'<br />':''?></span>
                    
                    <?=($all_deliveries[$u->user_id][0]->meal_5_w)?$all_deliveries[$u->user_id][0]->meal_5_w:0?>/<?=($all_deliveries[$u->user_id][0]->meal_5_b)?$all_deliveries[$u->user_id][0]->meal_5_b:0?>
                    <?
                        $meal[5][w] += $all_deliveries[$u->user_id][0]->meal_5_w;
                        $meal[5][b] += $all_deliveries[$u->user_id][0]->meal_5_b;
                    ?>    
                </td>
                
			<? } ?>
            
            <? if($data['notice'] == 1) { ?>
                <td align="left" valign="top" style="color: #000;border: 1px solid #eee;font-size:10px">
                
                    <?=$all_deliveries[$u->user_id][0]->user_notice?>
                
                </td>
            <? } ?>
            
            
            <? if($data['grammage'] == 1) { ?>  
                <td align="left" valign="top" style="color: #000;border: 1px solid #eee;font-size:10px">
                
                	<? if($all_deliveries[$u->user_id][0]->keyword) { ?>
                    	<?=$all_deliveries[$u->user_id][0]->keyword?><br />
                    <? } ?>
                
                    <?=$all_deliveries[$u->user_id][0]->notice?>
                
                </td>
            <? } ?>
            
            <? if($data['delivery'] == 1) { ?>
                <td align="left" valign="top" style="color: #000;border: 1px solid #eee;font-size:10px">
                
                    <?=$all_deliveries[$u->user_id][0]->name_surname?><br />
                    <?=$all_deliveries[$u->user_id][0]->address?><br />
                    <?=$all_deliveries[$u->user_id][0]->postcode?> <?=$all_deliveries[$u->user_id][0]->city?><br />
                	<? if($all_deliveries[$u->user_id][0]->hours) { ?>
						<?=reset(delivery_hours_values($all_deliveries[$u->user_id][0]->hours))?>
					<? } ?>
					                    
                </td>
                <td align="left" valign="top" style="color: #000;border: 1px solid #eee;font-size:10px">
                
                	<?=$all_deliveries[$u->user_id][0]->delivery_notice?><br />
                	
                </td>
    		<? } ?>
            
            <? if($data['price'] == 1) { ?>
                <td align="center" valign="middle" style="font-size: 14px;line-height: 8px">
                
                    <?=($all_deliveries[$u->user_id][0]->price)?$all_deliveries[$u->user_id][0]->price:0?>
                
                	<? $total_price += $all_deliveries[$u->user_id][0]->price; ?>
                </td>
            <? } ?>

        </tr>
    	<? $i++; ?>
    <? } ?>
    
    <tr bgcolor="#412b1e" style="color: #fff;font-weight:normal;font-size: 14px;font-weight: bold">
        <td align="center" style="">
			<?=$i-1?>
        </td>
        <td style="">
        
            
            
        </td>
        <? if($data['grammage'] == 1) { ?>
            <td align="center" style="">
                <?=$meal[1][w]?>/<?=$meal[1][b]?>    
            </td>
            <td align="center" style="">
                <?=$meal[2][w]?>/<?=$meal[2][b]?>    
            </td>
            <td align="center" style="">
                <?=$meal[3][w]?>/<?=$meal[3][b]?>   
            </td>
            <td align="center" style="">
                <?=$meal[4][w]?>/<?=$meal[4][b]?>   
            </td>
            <td align="center" style="">
                <?=$meal[5][w]?>/<?=$meal[5][b]?>      
            </td>
		<? } ?>
        
        <? if($data['notice'] == 1) { ?>
            <td align="right" style="">
     
            </td>
        <? } ?>
        
        <? if($data['grammage'] == 1) { ?>
        
        	<td align="right" style="">
     
            </td>
        
        <? } ?>
        
        
         <? if($data['delivery'] == 1) { ?>
        	<td align="right" style="">
     
            </td>
            <td align="right" style="">
     
            </td>
        
        <? } ?>
        
        <? if($data['price'] == 1) { ?>
            <td align="center" style="">
     			<?=$total_price?>
            </td>
        <? } ?>
    </tr>

</table>

<h2 style="font-family: Lato; font-size: 18px;color:#412b1e;font-weight: bold">Proszę czytać uwagi klientów!</h2>

<?
	//printr($all_users);
	//printr($all_deliveries);
?>
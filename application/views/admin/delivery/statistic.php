<table cellspacing="3" cellpadding="3" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 12px;">
    <tr>
        <td width="100%" valign="middle" align="center" >
		
        	<img src="<?=base_url()?>img/logo.png" style="width: 200px">	
            
        </td>
 	</tr>
    <tr>
        <td width="100%" bgcolor="#b9d044" align="center" style="color: #000; color:#fff;font-size: 16px">
        
        	<strong>
            	podsumowanie ilościowe posiłków i użytkowników od <?=$date_start?> do <?=$date_end?>
            </strong>
        
        </td>
    </tr>
</table>

<br>

<? 
	$total_meals = 0;
	$total_clients = 0;
?>

<? if($all_deliveries) { ?>
	<? foreach($all_deliveries as $date => $user) { //FOREACH DZIEN ?>
    
        <table cellspacing="0" cellpadding="3" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 14px;">
            <tr bgcolor="#412b1e" style="color: #fff;font-weight:normal;font-weight:bold">
                <th align="center" valign="top" width="9%" style="line-height: 10px;padding: 10px 10px 5px 10px;">
                    Data
                </th>
                <th align="center" valign="top" style="line-height: 10px;padding: 10px 10px 5px 10px">
                    Posiłek 1<br />
                    <?php /*?><span style="font-size: 10px;color:#b8d044">Śniadanie</span><?php */?>
                </th>
                <th align="center" valign="top" style="line-height: 10px;padding: 10px 10px 5px 10px">
                    Posiłek 2
                </th>
                <th align="center" valign="top" style="line-height: 10px;padding: 10px 10px 5px 10px">
                    Posiłek 3
                </th>
                <th align="center" valign="top" style="line-height: 10px;padding: 10px 10px 5px 10px">
                    Posiłek 4
                </th>
                <th align="center" valign="top" style="line-height: 10px;padding: 10px 10px 5px 10px">
                    Posiłek 5<br />
                    <?php /*?><span style="font-size: 10px;color:#b8d044">Kolacja</span><?php */?>
                </th>
                <th align="center" valign="top" style="line-height: 10px;padding: 10px 10px 5px 10px">
                    RAZEM
                </th>
            </tr>
            
            <tr bgcolor="#f2f2f2" style="color: #3d3d3d;font-weight:normal;font-size: 14px;font-weight: bold;white-space:nowrap">
                <td align="center" style="">
                    <?=$date?> 
                </td>
                <td align="center" style="">
                    <?=$stat[$date][1]?> 
                </td>
                <td align="center" style="">
                    <?=$stat[$date][2]?>	
                </td>
                <td align="center" style="">
                    <?=$stat[$date][3]?>	
                </td>
                <td align="center" style="">
                    <?=$stat[$date][4]?>	
                </td>
                <td align="center" style="">
                    <?=$stat[$date][5]?>	
                </td>
            
                <td align="center" style="">
                    <? 
                        $total_meals += $meals = $stat[$date][1]+$stat[$date][2]+$stat[$date][3]+$stat[$date][4]+$stat[$date][5]; 
                        $total_clients += $clients = count($all_deliveries[$date]);
                    ?>
                    <?=$meals?> posiłków<br />
                    <?=$clients?> klientów
                </td>
               
            </tr>
        
        </table>
        
        <br />
        
    <? } ?>
<? } else { ?>
    
    <table cellspacing="0" cellpadding="3" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 14px;">
        <tr bgcolor="#f2f2f2" style="color: #3d3d3d;font-weight:normal;font-size: 14px;font-weight: bold;white-space:nowrap">
            <td align="center" style="">
                Brak zamówień w tym okresie.
            </td>
		</tr>
  	</table>
    <br />
<? } ?>

<table cellspacing="0" cellpadding="3" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 16px;">
    <tr bgcolor="#b8d044" style="color: #412b1e;font-weight:normal;font-weight:bold">
    	<th align="left" valign="middle" style="line-height: 14px;padding: 8px 10px 8px 10px">
        	od <?=$date_start?> do <?=$date_end?><br />
    		<?=$days_forward?> dni
       	</th>
        <th align="right" valign="middle" style="line-height: 14px;padding: 8px 10px 8px 10px">
			<?=$total_meals?> posiłków<br />
            <?=count($all_users)?> unikalnych klientów
        </th>
    </tr>	
</table>

<? //printr($all_deliveries); ?>
<? //printr($all_users); ?>
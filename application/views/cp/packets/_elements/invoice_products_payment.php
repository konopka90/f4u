<table cellspacing="0" cellpadding="6" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 12px;">
    <tr bgcolor="#412b1e" style="color: #fff;font-weight:normal;">
    
        <th align="center" width="2%" style="line-height: 10px">Nr</th>
        <th style="line-height: 10px">Nazwa</th>
        <th align="center" width="2%" style="line-height: 10px">Ilość</th>
        
        <th align="center" width="10%" style="line-height: 10px">Cena<br>netto</th>
        <th align="center" width="10%" style="line-height: 10px">Wartość<br>netto</th>
        
        <th align="center" width="10%" style="line-height: 10px">Stawka<br>VAT</th>
        <th align="center" width="10%" style="line-height: 10px">Kwota<br>VAT</th>
        
        <th align="center" width="10%" style="line-height: 10px">Wartość<br>brutto</th>
    </tr>
    
    <?

	foreach($order->products as $product) {
		
		$vat_values[$product->vat] = array( 'netto' => 0.00,
											'vat_value' => 0.00, 
											'brutto' => 0.00	);
	
	}


	$i = 1;
	
	
	foreach($order->products as $product) { ?>
    
    	<tr>
        	<td align="center" style="color: #000;border: 1px solid #eee"><?=$i?></td>
            <td style="color: #000;border: 1px solid #eee">
            
            	<? if($product->type == 'delivery') { ?>
				
					<? $packets_meals_per_day_values = packets_meals_per_day_values($product->meals_per_day); ?>

                    Catering <strong><?=$packets_meals_per_day_values[0]?></strong> dziennie przez <strong><?=$order->payed_days?></strong> dni
                    
				<? } elseif($product->type == 'diet') { ?>
                
                	Dieta <strong><?=$product->name?></strong> przez <strong><?=$order->payed_days?></strong> dni
                
				<? } else {
					
					echo $product->name;
					
				} ?>
                
            </td>
            <td align="right" style="color: #000;border: 1px solid #eee">1</td>
            <td align="right" style="color: #000;border: 1px solid #eee">
			
            	<?
					
					$price = $product->price;
					$vat = $product->vat;
					
					$netto = $price - ($vat/100 * $price);
                	
					echo $this->cart->format_number($netto);
					
                ?>

            </td>
            
            <td align="right" style="color: #000;border: 1px solid #eee">
				<? 
				
					$netto_value = 1 * $netto;
					
					$vat_values[$product->vat]['netto'] += $netto_value;
					$vat_values[$product->vat]['vat_value'] += $product->price * 1 - $netto_value;
					$vat_values[$product->vat]['brutto'] += $product->price;
					
					echo $this->cart->format_number($netto_value);
					
				?>
            </td>
            
            <td align="right" style="color: #000;border: 1px solid #eee">
            
            	<?
                	echo $product->vat . "%";
				?>
                
            </td>
            
            <td align="right" style="color: #000;border: 1px solid #eee">
            	<? 
					$vat_value = $product->price * 1 - $netto_value;
					
					echo $this->cart->format_number( $vat_value );
				?>
            </td>
            
            <td align="right" style="color: #000;border: 1px solid #eee">
				<?
                	$brutto_value = $product->price * 1;
					echo $this->cart->format_number(	$brutto_value	);
				?>
            </td>
        </tr>
    	<? $i++; ?>
    <? } ?>
    
    <tr>
    	<td colspan="8" height="5"></td>
    </tr>

    <tr>
    	<td colspan="2"></td>
    
        <td colspan="2" align="right" bgcolor="#b9d044" style="color: #fff">	
            <strong>RAZEM</strong>
        </td>
        
        <td align="right" bgcolor="#b9d044" style="color: #fff">	
        	<strong>
            
            	<? 
				$sum = 0.00;
				foreach($vat_values as $vat => $values) {
					$sum += $values['netto'];
				}
			
				echo $this->cart->format_number($sum);
				
				?>
                
            </strong>
        </td>
        
        <td align="right" bgcolor="#b9d044" style="color: #fff">	
        	<strong>X</strong>
        </td>
        
        <td align="right" bgcolor="#b9d044" style="color: #fff">	
        	<strong>
            
            	<? 
				$sum = 0.00;
				foreach($vat_values as $vat => $values) {
					$sum = $values['vat_value'];
				}
			
				echo $this->cart->format_number($sum);
				
				?>
                
            </strong>
        </td>
        
        <td align="right" bgcolor="#b9d044" style="color: #fff">	
            <strong><?=$this->cart->format_number($order->price)?></strong>
        </td>
        
    </tr>
    
    <? foreach($vat_values as $vat => $values) { ?>
    
    	<? if($values['brutto'] != 0) { ?>
                
            <tr>
            	<td colspan="2"></td>
                
                <td colspan="2" align="right" bgcolor="#f2f2f2" style="color: #000;border: 1px solid #ccc">	
                    <strong>W tym</strong>
                </td>
                
                <td align="right" style="color: #000;border: 1px solid #eee">
                    <?=$this->cart->format_number($values['netto'])?>
                </td>
                
                <td align="right" style="color: #000;border: 1px solid #eee">
                    <?=$vat . '%'?>
                </td>
                
                <td align="right" style="color: #000;border: 1px solid #eee">
                    <?=$this->cart->format_number($values['vat_value'])?>
                </td>
                
                <td align="right" style="color: #000;border: 1px solid #eee">
                    <strong><?=$this->cart->format_number($values['brutto'])?></strong>
                </td>
                
            </tr>
        
        <? } ?>
    
    <? } ?>
    
    
    <tr>
    	<td colspan="8" height="5"></td>
    </tr>

    <tr>
    
        <td colspan="2" align="left" bgcolor="#f2f2f2" style="color: #000;border: 1px solid #eee;font-size: 16px">	
            <strong>Razem do zapłaty: &nbsp; <span style="color: #412b1e"><?=$this->cart->format_number($order->price)?> PLN</span></strong>
        </td>
        
        <td colspan="6">	
        	
        </td>

    </tr>

</table>

<br>

<table cellspacing="0" cellpadding="6" border="0" valign="middle" width="100%" style="font-family: Lato;font-size: 12px;">
    <tr> 
        <td style="color: #000;border: 1px solid #eee">	
           Słownie: <?=say_number($order->price)?>
        </td>
    </tr>
</table>
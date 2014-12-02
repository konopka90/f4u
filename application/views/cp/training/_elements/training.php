<table cellspacing="3" cellpadding="6" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 12px;">
    <tr>
        <td rowspan="2" width="33%" valign="middle" align="center" >
		
        	<img src="<?=base_url()?>img/logo.png" style="width: 200px">	
            
        </td>
        <td bgcolor="#b9d044" align="center" style="color: #000; color:#fff;font-size: 16px"><strong>FAKTURA VAT</strong></td>
        <td align="center" height="40px" style="border: 1px solid #eee">
        	Numer zamówienia: #<?=($order->order_number)?$order->order_number:' &nbsp; &nbsp; - '?>
        	Numer faktury: <?=($order->invoice_number)?$order->invoice_number:' &nbsp; &nbsp; - '?><br />
        </td>
    </tr>
    <tr align="center">
        <td width="34%" valign="bottom" style="border: 1px solid #eee">
            <?=($order->date && $order->date != '0000-00-00')?date("Y-m-d", strtotime($order->date)):' - '?><br>
            data wystawienia
        </td>
       <td width="33%" height="40px" style="border: 1px solid #eee">
            <?=date("Y-m-d", strtotime($order->date))?><br>
            data sprzedaży
       </td>
    </tr>
</table>

<br>

<table cellspacing="3" cellpadding="6" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 12px;">
    <tr>
    	<td style="border: 1px solid #eee" bgcolor="#f2f2f2" width="50%">
    
            Sprzedawca: <strong>Fir For You S.C. Klaudia Badura, Konrad Szczepanik</strong><br>
            Adres: <strong>ul. Wicherkiewicza 23, 30-389 Kraków</strong><br>
            NIP: <strong>9452170277</strong><br>
                
        </td>
        <td bgcolor="#f1f1f1">
			<strong><?=$order->name_surname?></strong><br>
            
            Adres: <strong><?=$order->address?></strong><br>
            <?=$order->postcode?> <?=$order->city?>
            
            <? if($order->nip) {?>
            	NIP: <strong><?=$order->nip?></strong><br>
            <? } ?>

            
            <?php /*?>
            <? if($order->phone) {?>
            	Telefon: <strong><?=$order->phone?></strong><br>
            <? } ?>
            <?php */?>
            <?php /*?>
            <? if($order->email) {?>
            	Email: <strong><?=$order->email?></strong><br>
            <? } ?>
            <?php */?>
            
        </td>
    </tr>
</table>

<br>

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
            
            	<? if($product->type == 'packet') {
					
					$packets_names_values = packets_names_values($product->name);
					$packets_weeks_values = packets_weeks_values($product->weeks);
					$packets_days_per_week_values = packets_days_per_week_values($product->days_per_week);
					$packets_meals_per_day_values = packets_meals_per_day_values($product->meals_per_day);
						
					?>
                    
                    Pakiet "<strong><?=$packets_names_values[0]?></strong>", przez <?=$packets_weeks_values[0]?>, <?=$packets_days_per_week_values[0]?> w tygodniu, <?=$packets_meals_per_day_values[0]?> dziennie
					
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

<br>

<table cellspacing="3" cellpadding="6" border="0" valign="bottom" width="100%" style="font-family: Lato; font-size: 12px;">
    <tr> 
        <td width="50%" align="center" style="border: 1px solid #eee">
        	<br /><br /><br /><br />
            ............................................................................................<br>
            <span>czytelny podpis osoby upoważnionej do odbioru rachunku</span>
        </td>
        <td width="50%" align="center" style="border: 1px solid #eee">
        	<br /><br /><br /><br />
            ............................................................................................<br>
            <span>czytelny podpis osoby wystawiającej rachunek</span>
        </td>
    </tr>
</table>

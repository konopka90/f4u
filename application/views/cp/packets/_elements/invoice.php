<table cellspacing="3" cellpadding="6" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 12px;">
    <tr>
        <td rowspan="2" width="33%" valign="middle" align="center" >
		
        	<img src="<?=base_url()?>img/logo.jpg" style="width: 200px">	
            
        </td>
        <td bgcolor="#b9d044" align="center" style="color: #000; color:#fff;font-size: 16px">
        
        	<? if($order->payment == 2 && $order->invoice_number && $order->invoice_date && $order->invoice_date != '0000-00-00') { ?>
            	<strong>FAKTURA VAT</strong>
            <? } else { ?>
            	<strong>FAKTURA PROFORMA</strong>
            <? } ?>
        
        </td>
        <td align="center" height="40px" style="border: 1px solid #eee">
        	Numer zamówienia: <?=($order->order_number)?$order->order_number:' &nbsp; &nbsp; - '?><br />
        	Numer faktury: <?=($order->invoice_number)?$order->invoice_number:' &nbsp; &nbsp; - '?>
        </td>
    </tr>
    <tr align="center">
        <td width="34%" valign="bottom" style="border: 1px solid #eee">
            <?=($order->invoice_date && $order->invoice_date != '0000-00-00')?date("Y-m-d", strtotime($order->invoice_date)):' - '?><br>
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
        
        	Sprzedawca: <strong>Konrad Szczepanik</strong><br>
            Adres: <strong>ul. Krańcowa 3, 97-300 Piotrków Trybunalski</strong><br>
            NIP: <strong>7712819734</strong><br>
    
    		<?php /*?>
            Sprzedawca: <strong>Fir For You S.C. Klaudia Badura, Konrad Szczepanik</strong><br>
            Adres: <strong>ul. Wicherkiewicza 23, 30-389 Kraków</strong><br>
            NIP: <strong>9452170277</strong><br>
            <?php */?>
                
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

<table cellspacing="3" cellpadding="6" border="0" valign="middle" width="100%" style="font-family: Lato; font-size: 12px;">
    <tr>
    	<td style="border: 1px solid #eee" bgcolor="#f2f2f2" width="100%">
        
        	<? if($order->invoice_payment_method) { ?>
				<? $payment_method_values = payment_method_values($order->invoice_payment_method); ?>
    
                Sposób płatności: <strong><?=$payment_method_values[0]?></strong> &nbsp; &nbsp; 
                <? if($order->invoice_payment_method == 2 && $order->invoice_payment_deadline && $order->invoice_payment_deadline != '0000-00-00') { ?>
                    Termin płatności: <strong><?=$order->invoice_payment_deadline?></strong> 
                <? } ?>
                <br>
			<? } ?>
            Numer konta: <strong>04 2490 0005 0000 4500 8850 6016</strong> &nbsp; &nbsp; Bank: <strong>Alior Bank</strong><br>
            
        </td>
    </tr>
</table>

<br>

	<?=$this->data['template'] = $this->load->view('cp/packets/_elements/invoice_products_payment', array('order' => $order), true);?>

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

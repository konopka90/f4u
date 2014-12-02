<? if(!empty($payouts)) { ?>

	<table class="table" id="payout_table">
		<thead>
			<tr>
				<th width="210px">Data zgłoszenia</th>
				<th width="170px">Kwota wypłaty</th>
				<th>Status realizacji</th>
                <th>Uwagi</th>
                <? if($access == 'admin') { ?>
                    <th></th>
                <? } ?>
			</tr>
		</thead>
		

    
        <? foreach($payouts as $i => $p) { ?>
            <? $payouts_values = provision_payout_realisation_values($p->realisation); ?>
                    
            <? if($access == 'admin') { ?>
                <form action="<?=current_url()?>" method="post">
            <? } ?>
                
                <tbody>
                    <tr class="<?=($p->realisation == 2)?'success':(($p->realisation == 3)?'danger':'')?>">
                        <td class="middle">
							<?=$p->date?><br>
                            <? if($p->payout_account_number) { ?>
                            	<span class="font_10">nr konta <?=$p->payout_account_number?></span>
                            <? } ?>
                         </td>
                        <td class="middle">
                        
                            <? if($p->provision_saldo_after && $p->provision_saldo_after != 0.00) { ?>
                            	<span class="muted font_10">saldo po wypłacie <?=$p->provision_saldo_after?> zł</span><br />
                            <? } ?>
                        	
                            <? if($access == 'admin') { ?>
                                <input type="text" name="provision_payout" class="form-control input-sm margin_b_5 margin_t_5" value="<?=$p->provision_payout?>" />
                            <? } else { ?>
                                <?=$p->provision_payout?> zł<br />
                            <? } ?>
                            
                            <? if($p->provision_saldo_before && $p->provision_saldo_before != 0.00) { ?>
                            	<span class="muted font_10">saldo przed wypłatą <?=$p->provision_saldo_before?> zł</span>
                            <? } ?>
                            
                        </td>
                        <td class="middle">
                        	
                            <span class="label <?=$payouts_values[1]?> uppercase"><?=$payouts_values[0]?></span><br>
                      
                      		<div class="padding_t_5 muted">
								<? if($access == 'admin') { ?>
                                    <input type="text" name="realisation_date" class="form-control input-sm dtp" value="<?=($p->realisation_date)?$p->realisation_date:date("Y-m-d H:i:s")?>" placeholder="Data statusu (realizacji/odrzucenia)" /><br />
                                <? } else { ?>
                                	<? if(!in_array($p->realisation_date, array('', '0000-00-00 00:00:00'))) { ?>
                                    	<?=$p->realisation_date?><br />
                                    <? } ?>
                                <? } ?>
                            </div>
                            
                        </td>
                        <? if($access == 'admin') { ?>
                            <td>
                                <textarea name="desc" class="form-control input-sm" value="<?=$p->desc?>" placeholder="Uwagi do wypłaty"  rows="4"><?=$p->desc?></textarea>
                            </td>
                            <td class="text-right middle">
                                <input type="hidden" name="seller_payout_id" value="<?=$p->seller_payout_id?>" />
                                <button type="submit" name="payout" value="realise" class="btn btn-success btn-sm">Realizuj</button>
                                <button type="submit" name="payout" value="deny" class="btn btn-danger btn-sm">Odrzuć</button>
                            </td>
                        <? } else { ?>
                        	<td class="middle">
                        		<?=($p->desc)?$p->desc:'-'?>
                            </td>
                        <? } ?>
                    </tr>
                </tbody>
                        
            <? if($access == 'admin') { ?>
                </form>
            <? } ?>
            
            <? if($limit && $i >= $limit) {
				break;
			} ?>
                
        <? } ?>
        

        
	</table>
    
<? } else { ?>

	<div class="margin_t_20">
		<?=$this->load->view('_elements/message', array('message' => 'Nie wypłacałeś jeszcze prowizji', 'message_status' => 0), true)?>  
    </div>
     
<? } ?>
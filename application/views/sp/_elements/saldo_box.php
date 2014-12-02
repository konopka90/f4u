<div class="well text-center bg_line">
    <h4 class="margin_b_0">aktualne saldo</h4>
    
    <h1 class="font_80 margin_t_0 font_orange"><?=$seller_provision?> zł</h1>
    
    <? if($this->user->account_number) { ?>
    
        <form class="form form-horizontal" role="form" method="post" action="<?=base_url() . 'sp/provision'?>" id="payout_form">
            <div class="input-group">
                
                <input type="number" min="10" step="any" max="<?=$seller_provision?>" name="payout_provision" class="form-control" placeholder="Kwota, którą chcesz wypłacić" required>
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" name="payout" value="1"> Wypłać </button>
                </div>
                
            </div>
            
            <input type="hidden" name="payout_account_number" value="<?=$this->user->account_number?>">
                
            <p class="help-block text-left">
                <i class="glyphicon glyphicon-exclamation-sign"></i> &nbsp; na konto: <?=$this->user->account_number?> &nbsp; <a href="<?=base_url()?>user/update"><i class="fa fa-pencil muted"></i></a>
            </p>
    
        </form>
    
    <? } else { ?>
    
    	<?=$this->load->view('_elements/message', array('message' => '<a href="'.base_url().'user/update">Ustaw numer konta, aby wypłacić swoje prowizje &nbsp; <i class="fa fa-pencil"></i></a>', 'message_status' => 0), true)?>  
    
    <? } ?>
        
	<? if($this->uri->segment(2) != 'provision') { ?>
        <a href="<?=base_url()?>sp/provision/index" class="btn btn-primary btn-block margin_t_20">Historia operacji</a>
    <? } ?>
		

</div>
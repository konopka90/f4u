<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
    <li><a href="<?=base_url()?>admin/user" class="label label-primary">Sprzedawcy</a></li>
    <li class="active">Szczegóły sprzedawcy <?=$seller->name_surname?></li>
</ol>

<div class="row margin_b_20">
    <div class="col-md-12">
    
		<h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-user"></i>&nbsp; Szczegóły sprzedawcy <?=$seller->name_surname?></h3>
        
        <div class="btn-group margin_b_20">
            <a href="<?=base_url()?>admin/seller/update/<?=$seller->user_id?>" class="btn btn-default">Edytuj klientów i zamówienia sprzedawcy</a>
            <a href="<?=base_url()?>admin/seller/remove/<?=$seller->user_id?>" class="btn btn-danger confirm">Usuń sprzedawcę</a>
        </div>
            
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
        
        <table class="table table-bordered margin_b_30">
        
            <tr>
                <td>Imię i nazwisko</td>
                <td>
					<?=$this->users[$seller->user_id]->name_surname?><br />
                    <?=$this->users[$seller->user_id]->address?><br />
                    <?=$this->users[$seller->user_id]->postcode?> <?=$this->users[$seller->user_id]->city?>
                    <? if($this->users[$seller->user_id]->nip) { ?>
                    	<em>NIP:</em> <?=$this->users[$seller->user_id]->nip?>
                    <? } ?>
                </td>
            </tr>
            <tr>
                <td>Dane kontaktowe</td>
                <td>
					<em>email:</em> <?=$this->users[$seller->user_id]->email?><br />
                    <? if($this->users[$seller->user_id]->phone) { ?>
                    	<em>tel.</em> <?=$this->users[$seller->user_id]->phone?>
                    <? } ?>
                </td>
            </tr>
            <tr>
                <td>Prowizja od sprzedaży</td>
                <td>
					<?=$seller->seller_provision?> %
                </td>
            </tr>
            <tr>
                <td>Klientów / zamówień / wartość zamówień</td>
                <td>
					<?=$seller->clients_count?> / <?=$seller->orders_count?> / <?=floatval($seller->orders_price)?> zł
                </td>
            </tr>
            <tr>
                <td>Łączna prowizja / aktualne saldo</td>
                <td>
					<?=$seller->orders_provision?> / <?=$seller->saldo?> zł
                </td>
            </tr>
            <tr>
                <td>Aktualny numer konta</td>
                <td>
					<?=$seller->account_number?>
                </td>
            </tr>
           
        </table>

		<h4 class="margin_b_20 margin_t_20">Klienci użytkownika</h4>
        
        <?=$this->load->view('sp/user/user_table', array('access' => 'admin'), true)?>

        <h4 class="margin_b_20 margin_t_20">Zamówienia klientów użytkownika</h4>
        
        <?=$this->load->view('admin/order/order_table', array('all_orders' => $all_orders, 'access' => 'admin'), true)?>
        
        <h4 class="margin_b_20 margin_t_20">Wypłaty użytkownika</h4>
        
        <table class="table table-bordered margin_b_30">

            <tr>
                <td>Aktualny numer konta</td>
                <td>
					<?=$seller->account_number?>
                </td>
            </tr>
        
            <tr>
                <td>Łączna prowizja</td>
                <td>
					<?=$seller->orders_provision?>
                </td>
            </tr>
            
            <tr class="font_20 active">
                <td>Aktualne saldo</td>
                <td>
					<strong><?=$seller->saldo?> zł</strong>
                </td>
            </tr>
           
        </table>
        
        <?=$this->load->view('sp/order/payout_table', array('payouts' => $payouts, 'access' => 'admin'), true)?>
     
    </div>

</div>


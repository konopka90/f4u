<div class="row">
    <div class="col-md-12">
    	<? if($access == 'seller') { ?>
        	<?=$this->load->view('sp/_elements/menu', array(), true)?>
        <? } else { ?>
        	<?=$this->load->view('admin/_elements/menu', array(), true)?>
        <? } ?>
    </div>
</div>

<ol class="breadcrumb">

	<? if($access == 'seller') { ?>

        <li><a href="<?=base_url()?>sp">Panel Partnera</a></li>
        <li><a href="<?=base_url()?>sp/user" class="label label-primary">Klienci</a></li>
        <li class="active">Szczegóły klienta <?=$usera->name_surname?></li>
        
    <? } else { ?>
    
        <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
        <li><a href="<?=base_url()?>admin/user" class="label label-primary">Użytkownicy</a></li>
        <li class="active">Szczegóły użytkownika <?=$usera->name_surname?></li>
    
    <? } ?>

</ol>

<div class="row margin_b_20">
    <div class="col-md-12">
    
		<h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-user"></i>&nbsp; Szczegóły <?=($access == 'seller')?'klienta':'użytkownika'?> <?=$usera->name_surname?></h3>
        
        <div class="btn-group margin_b_20">
        	<a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/order/create/<?=$usera->user_id?>" class="btn btn-default confirm">Dodaj zamówienie</a>
            <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/user/update/<?=$usera->user_id?>" class="btn btn-default">Edytuj użytkownika</a>
            <a href="<?=base_url()?><?=($access == 'seller')?'sp':'admin'?>/user/remove/<?=$usera->user_id?>" class="btn btn-danger confirm">Usuń użytkownika</a>
        </div>
            
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
        
        <table class="table table-bordered margin_b_30">
            <tr>
                <td>Imię i nazwisko</td>
                <td><?=$usera->name_surname?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?=$usera->email?></td>
            </tr>
            <tr>
                <td>Adres</td>
                <td>
					<?=$usera->address?><br />
                    <?=$usera->postcode?> <?=$usera->city?><br />
                </td>
            </tr>
            <tr>
                <td>Telefon</td>
                <td><?=$usera->phone?></td>
            </tr>
            <tr>
                <td>Skype</td>
                <td><?=($usera->skype)?$usera->skype:'-'?></td>
            </tr>
            <tr>
                <td>Uwagi</td>
                <td><?=($usera->user_notice)?$usera->user_notice:'-'?></td>
            </tr>
            <tr>
                <td>Ostatnio aktywny</td>
                <td>
					<?=($usera->last_seen && $usera->last_seen != '0000-00-00 00:00:00')?$usera->last_seen:' - '?><br />
                    <?=$usera->last_seen_where?>
                </td>
            </tr>
        </table>

		<h4 class="margin_b_20 margin_t_20">Catering użytkownika</h4>
        
        <?=$this->load->view('admin/order/order_table', array('all_orders' => $user_orders, 'access' => $access), true)?>
        
        <h4 class="margin_b_20 margin_t_20">Kalendarz dostaw użytkownika</h4>
        
        <input type="hidden" id="current_client_id" value="<?=$usera->user_id?>" />
        <input type="hidden" id="controler" value="<?=($access == 'seller')?'sp':'admin'?>" />
        
        <div class="row" id="plumb">
            <div class="col-md-4 text-center">
        
                <?=$calendar_curr?>
                
            </div>
            <div class="col-md-4 text-center">
                
                <?=$calendar_next?>
                
            </div>
            <div class="col-md-4 text-center">
                
                <?=$calendar_next_2?>
                
            </div>
        </div>
        
        <div id="div_delivery"></div>
        
        <? if($access != 'seller') { ?>
        
            <h4 class="margin_b_20 margin_t_20">Konsultacje użytkownika</h4>
            
            <?=$this->load->view('admin/consultation/consultation_table', array('all_consultations' => $user_consultations), true)?>
         
            <h4 class="margin_b_20 margin_t_20">Kontakt z użytkownikiem</h4>
         
            <?=$this->load->view('admin/user/message_form', array('usera' => $usera), true)?>
        
        <? } ?>
     
    </div>

</div>


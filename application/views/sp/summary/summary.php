<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('sp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>sp">Panel Partnera</a></li>
    <li class="active">Dostawy Twoich klientów</li>
</ol>
<h3 class="margin_0 margin_b_10 border_b_3 padding_b_10"><i class="fa fa-truck muted"></i>&nbsp; Kalendarz dostaw Twoich klientów</h3>

<? if(!empty($clients)) { ?>

    <ul class="nav nav-tabs margin_b_20">
    	<? $i = 0; ?>
		<? foreach($clients as $user_id => $c) { ?>
        	<? $condition = ($c->user_id == $this->uri->segment(4)) || (!$this->uri->segment(4) && $c->user_id == $this->session->userdata('client_id')); ?>


            <li class="<?=($condition)?'active':''?>"><a href="<?=base_url()?>sp/summary/index/<?=$c->user_id?>"><?=$c->name_surname?></a></li>
            
            <? 
				if($condition) {
					$current_user_id = $c->user_id;
					$current_name_surname = $c->name_surname;
				}
			?>
            <? $i++; ?>
        <? } ?>
        <input type="hidden" id="current_client_id" value="<?=$current_user_id?>" />
    </ul>

<? } ?>


<? if(count($clients) > 0) { ?>

    <div class="row margin_b_10">
        <div class="col-md-4">
        	<h4 class="margin_0">Dostawy użytkownika <a href="<?=base_url()?>sp/user/details/<?=$current_user_id?>"><?=$current_name_surname?> &nbsp; <i class="fa fa-external-link font_14"></i></a></h4>
        </div>
        <div class="col-md-8 text-right">
            <span class="label label-default tooltipa" title="Dostawa, która miała już miejsce">DOSTAWA JUŻ SIĘ ODBYŁA</span>
            <span class="label label-success tooltipa" title="Nadchodząca dostawa">DOSTAWA</span>
            <span class="label label-danger tooltipa" title="Dostawa którą została przeniesiona na inny dzień">DOSTAWA PRZENIESIONA</span>
            <span class="label label-warning tooltipa" title="Dostawa która jest nieaktywna, ponieważ zamówienie nie zostało opłacone">DOSTAWA NIEAKTYWNA</span>
        </div>
    </div>
    
    <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>  
    
</div>  

	<div class="container">
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
    </div>
    
    <div id="div_delivery"></div>

<div class="container">
    
    
<? } else { ?>

    <div class="jumbotron" id="make_order_jumbotron">
        <div class="container">
        
            <h1><a href="<?=base_url()?>cp/packets/prolong"><i class="glyphicon glyphicon-add muted"></i> &nbsp; Dodaj klientów!</a></h1>

        </div>
    </div>
        


<? } ?>


<div class="row margin_b_30 margin_t_20">
    <div class="col-md-8 text-left">
    
        <h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon-usd muted"></i>&nbsp; Ostatnie zamówienia</h3>
        
        <? if(count($clients_orders) > 0) { ?>
            <table class="table table-hover table">
            	<?php /*?>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Adres</th>
                        <th>&nbsp;  </th>
                    </tr>
                </thead>
                <?php */?>
                <tbody>
			
                    <? foreach($clients_orders as $i => $o) { ?>
                        <tr>
                            <td width="60px" class="nowrap middle">
                            	
                                <?=date("Y-m-d", strtotime($o->date))?>

                            </td>
                            <td class="middle" width="30%">
                                <strong><?=$o->name_surname?></strong><br>
                                tel.: <?=$o->phone?><br />
                                
                                <em>Adres:</em> <?=$o->address?><br>
                                <?=$o->postcode?> <?=$o->city?>
                                
                                <? if($o->nip) {?>
                                    <em>NIP:</em> <?=$o->nip?><br>
                                <? } ?>
                            </td>
                            
                            <td class="middle">
								<?=$products[$o->packet_id]->name?> <span class="font_gray"><?=(is_array(unserialize($o->meals_selected)))?'('.implode(", ", unserialize($o->meals_selected)).')':''?></span><br />
                                
                                <?=($o->days)?$o->days:0?> <span class="font_gray">dni, od</span> <?=$o->first_delivery?> <span class="font_gray">do</span> <?=$o->last_delivery?>
                            </td>
                            
                            <td class="middle">
                            	<?=$o->price?><br /> 
                            </td>
                            
                            <td class="middle">
							
                            	
                        	</td>
                        </tr>
                        
                        <? if($i >= 3) {
							break;
						} ?>
                        
                    <? } ?>
    
                </tbody>
                                
            </table>
            
            <a href="<?=base_url()?>sp/order/index" class="btn btn-primary btn-xs margin_t_20 margin_b_20">Wszystkie zamówienia</a>
            
		<? } else { ?>
        
            <?=$this->load->view('_elements/message', array('message' => 'Brak złożonych zamówień'), true)?>  
        
        <? } ?>
        
    
    </div>
    
    <div class="col-md-4 text-left">
    

        <h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon-th-large muted"></i> &nbsp; Twoje saldo</h3>
        
        <?=$this->load->view('sp/_elements/saldo_box', array(), true)?>
        
        <?php /*?>
        <p class="margin_t_20 margin_b_20">
        	<i class="glyphicon glyphicon-exclamation-sign"></i> Nowy pakiet będzie aktywny najwcześniej <?=$first_avalible_day?>.
        </p>
        <?php */?>
        
        <? /*$this->delivery->get_first_free_day($user->user_id)*/ ?>
        
    </div>
    
    <?php /*?>
    <div class="col-md-6 text-left">

        <h3 class="margin_t_0 margin_b_30">Wstrzymaj dostawę</h3>
        
        <div class="alert alert-warning">Aby wstrzymać dostawę należy określić termin wstrzymania dostaw. Termin od którego ma nastąpić wstrzymanie musi być z dwu dniowym wyprzedzeniem od dnia wstrzymywania!</div>
        
        <div class="row margin_b_30">

            <div class="col-lg-12">
                                
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Od">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="do">
                  </div>

                  <button type="submit" class="btn btn-danger">WSTRZYMAJ</button>
                </form>

            </div>
            
        </div>


    </div>
    <?php */?>
</div>

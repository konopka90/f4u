<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('cp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Klienta</a></li>
    <li class="active">Dostawa</li>
</ol>
<h3 class="margin_0 margin_b_10 border_b_3 padding_b_10"><i class="glyphicon glyphicon-cutlery muted"></i>&nbsp; Kalendarz Twoich dostaw</h3>

<? if(count($deliveries) > 0) { ?>

    <div class="row margin_b_10">
        <div class="col-md-12">
            <span class="label label-default tooltipa" title="Dostawa, która miała już miejsce">DOSTAWA JUŻ SIĘ ODBYŁA</span>
            <span class="label label-success tooltipa" title="Nadchodząca dostawa">DOSTAWA</span>
            <span class="label label-danger tooltipa" title="Dostawa którą została przeniesiona na inny dzień">DOSTAWA PRZENIESIONA</span>
            <span class="label label-warning tooltipa" title="Dostawa która jest nieaktywna, ponieważ zamówienie nie zostało opłacone">DOSTAWA NIEAKTYWNA</span>
            <span class="label label-primary tooltipa" title="Klikając w to pole możesz przejść do formularza przedłużania pakietu">PRZEDŁUŻ PAKIET</span>
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
	
     <?php /*?>
    <div id="delivery_calendar_carousel" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators text-center">
            <li data-target="#delivery_calendar_carousel" data-slide-to="0" class="active"></li>
            <li data-target="#delivery_calendar_carousel" data-slide-to="1" class=""></li>
        </ol>
    
		<div class="container">
            <div class="carousel-inner">
                <div class="item active">
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
               
                <div class="item">
                    <div class="row">
                        <div class="col-md-4 text-center">
                    
                            <?=$calendar_next_3?>
                            
                        </div>
                        <div class="col-md-4 text-center">
                            
                            <?=$calendar_next_4?>
                            
                        </div>
                        <div class="col-md-4 text-center">
                            
                            <?=$calendar_next_5?>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        
    </div>
    <?php */?>
    
    <div id="div_delivery"></div>

<div class="container">
    
    
<? } else { ?>

    <div class="jumbotron" id="make_order_jumbotron">
        <div class="container">
        
            <h1><a href="<?=base_url()?>cp/packets/prolong"><i class="glyphicon glyphicon-shopping-cart muted"></i> &nbsp; Kliknij i złoż zamówienie!</a></h1>
            
            
    
        </div>
    </div>
        


<? } ?>


<div class="row margin_b_30 margin_t_20">
    <div class="col-md-8 text-left">
    
        <h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon-plane muted"></i>&nbsp; Najbliższe dostawy</h3>
        
        <? if(count($deliveries) > 0) { ?>
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

                    <? foreach($deliveries as $i => $d) { ?>
                        <tr>
                            <td width="60px" class="<?=($d->stopped == 1)?'bg_line':''?> <?=($i == 0)?'border_t_0':''?>">
                            	
                                <?=$this->load->view('_elements/calendar_card', array('d' => $d), true)?>

                            </td>
                            <td class="<?=($d->stopped == 1)?'bg_line':''?> <?=($i == 0)?'border_t_0':''?>" width="40%">
	  
                                <div class="clearfix">

                                    <span class="<?=($d->stopped == 1)?'font_gray':''?>">
										<?=$d->name_surname?><br /><?=$d->address?>, <?=$d->postcode?> <?=$d->city?><br />
                                        <em>tel.</em> <?=$d->phone?><br />
                                        
                                    </span>
                                    
                                    <? if($d->payment != 2) { ?>
                                        <span class="font_orange font_12">
                                            <i class="glyphicon glyphicon-exclamation-sign"></i> Dostawa nieaktywna - pakiet niezostał opłacony.
                                        </span>
                                    <? } else { ?>
                                    
										<? if($d->stopped == 1) { ?>
                                            <span class="font_red font_12">
                                                <i class="glyphicon glyphicon-exclamation-sign"></i> Dostawa przeniesiona na inny dzień.
                                            </span>
                                        <? } else { ?>
                                            <span class="font_green font_12">
                                                <i class="glyphicon glyphicon-exclamation-sign"></i> W tym dniu masz <?=$d->meals?> <?=($d->meals == 5)?'dostaw':'dostawy'?>.
                                            </span>
                                        <? } ?>
                                        
                                    <? } ?>
                                    
                                </div>
             
                            
                            </td>
                            
                            <td class="<?=($d->stopped == 1)?'bg_line':''?> <?=($i == 0)?'border_t_0':''?>">
                            
                            	<div class="clearfix">
                                    
                                    <? if($d->user_notice) { ?>
                                        <div class="pull-right margin_r_20 font_14">
                                        
                                            <span class="muted text-right">Twoje uwagi</span><br />
                                            <?php /*?><hr class="margin_t_5 margin_b_5"/><?php */?>
                                            <?=$d->user_notice?>
                                        
                                        </div>
                                    <? } ?>
                            
                            	</div>
                            
                            </td>
                            
                            <td class="<?=($d->stopped == 1)?'bg_line':''?> <?=($i == 0)?'border_t_0':''?>" width="90px">
							
                            	<div class="clearfix">
                                
                                    <? if($d->payment == 2) { ?>
                                        <? if(date("Y-m-d", strtotime("+3 days")) > $d->date) { ?>
                                            <button class="btn btn-lg pull-right" style="padding: 27px"><i class="glyphicon glyphicon-ban-circle"></i></button>
                                        <? } else { ?>
                                            <a href="<?=base_url()?>cp/delivery/update/<?=$d->delivery_id?>" class="btn btn-default btn-lg pull-right" style="padding: 27px"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <? } ?>
                                    <? } ?>
                            	</div>        
                        	</td>
                        </tr>
                    <? } ?>
    
                </tbody>
                                
            </table>
            
		<? } else { ?>
        
            <p class="margin_t_20 margin_b_20">
                <i class="glyphicon glyphicon-exclamation-sign"></i> Brak wykupionych pakietów.
            </p>
        
        <? } ?>
        
    
    </div>
    
    <div class="col-md-4 text-left">
    

        <h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon-th-large muted"></i> &nbsp; Twoje pakiety</h3>

		<?=$this->load->view('cp/packets/_elements/packets_list', array('user_packets' => $user_packets, 'active_packet' => $active_packet, 'closest_delivery' => $closest_delivery), true)?>
    	
        <div class="btn-group btn-group-justified margin_b_20">
            <a href="<?=base_url()?>cp/packets/prolong" class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> &nbsp; ZAMÓW DIETĘ </a>
        </div>
        
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

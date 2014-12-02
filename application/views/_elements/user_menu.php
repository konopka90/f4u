<? if($user->user_id) { ?>

	<?
		$packets_names_values = packets_names_values();
	?>

	<div class="row">
		<div class="col-md-12 text-right"> 

    
            <div class="clearfix">
                <div class="btn-group">
                    <button type="button" class="btn btn-default"> <i class="glyphicon glyphicon-user"></i> </button>
                    <button type="button" class="btn btn-default">Zalogowany jako </button>
                    <button type="button" class="btn btn-primary "><?=$user->name_surname?></button>
                    <button type="button" class="btn btn-default  dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Menu</span>
                    </button>
                    <ul class="dropdown-menu text-left pull-right" role="menu">
                        <li><a href="<?=base_url()?>page"><i class="glyphicon glyphicon-home"></i> &nbsp; Strona głowna </a></li>
                        <li><a href="<?=base_url()?>consultation"><i class="glyphicon glyphicon-comment"></i> &nbsp; Konsultacje </a></li>
                        <? if($user->access != 4) { ?>
                        	<li><a href="<?=base_url()?>cp"><i class="glyphicon glyphicon-user"></i> &nbsp; Panel klienta </a></li>
                        <? } ?>
						<? if($user->is_seller == 1) { ?>
                        	<li><a href="<?=base_url()?>sp"><i class="glyphicon glyphicon-transfer"></i> &nbsp; Panel partnera </a></li>
                        <? } ?>
                        <? if($user->access == 5) { ?>
                        	<li class="divider"></li> 
                            <div class="text-center">
                                <div class="btn btn-group padding_0" style="margin: auto">
                                    <a href="<?=base_url()?>admin/delivery" class="btn btn-success pull-left"><i class="glyphicon glyphicon-plane tooltipa" title="Dostawy"></i></a>
                                    <a href="<?=base_url()?>admin/order" class="btn btn-success pull-left"><i class="glyphicon glyphicon-cutlery tooltipa" title="Catering"></i></a>
                                    <a href="<?=base_url()?>admin/consultation" class="btn btn-success pull-left"><i class="glyphicon glyphicon-comment tooltipa" title="Konsultacje"></i></a>
                                    <a href="<?=base_url()?>admin/user" class="btn btn-success pull-left"><i class="glyphicon glyphicon-user tooltipa" title="Użytkownicy"></i></a>
                                </div>
                            </div>
                        <? } elseif($user->access == 4) { ?>
                        	<li class="divider"></li>
                            <li><a href="<?=base_url()?>admin"><i class="glyphicon glyphicon-globe"></i> &nbsp; Posiłki i dostawy </a></li>
						<? } ?>
                        
                        <?php /*?>
                        <li class="divider"></li>
                        <li><a href="<?=base_url()?>user/edit"><i class="glyphicon glyphicon-pencil"></i> &nbsp; Edytuj swoje konto </a></li>
                        <?php */?>
                        
                        <li class="divider"></li>
                        <li><a href="<?=base_url()?>user/update"><i class="glyphicon glyphicon-pencil"></i> &nbsp; Edytuj profil </a></li>
                        <li><a href="<?=base_url()?>user/logout"><i class="glyphicon glyphicon-off"></i> &nbsp; Wyloguj </a></li>
                    </ul>
                </div>
            </div>
            
			<?php /*?>
			<? if($active_packet->product_id) { ?>
           		<span class="muted">Aktualny pakiet <strong><?=$packets_names_values[$active_packet->name][0]?></strong> 
                
                <? if($active_packet->payment == 2) { ?>
                
               		(pozostało jeszcze <strong><?=((strtotime($active_packet->expires)-strtotime(date("Y-m-d")))/(3600*24))?> dni</strong>). 

                <? } else { ?>
                
                	&nbsp; <span class="label label-danger"> NIEZAPŁACONY</span> &nbsp;  Dostawy są nieaktywne, zapłać za pakiet. 
                    
                <? } ?>
                
                </span>
                
            <? } else { ?>
            	<span class="muted">Brak aktywnych pakietów, <a href="<?=base_url()?>page/zamowienia">złoż zamówienie</a>. </span>	
            <? } ?>
            <?php */?>

			<? if($user->access != 4) { ?>
            	<div class="margin_t_10 margin_b_15 muted">
					<? if($closest_delivery) { ?>
                        <i class="glyphicon glyphicon-info-sign"></i>&nbsp; Najbliższa dostawa <a href="<?=base_url()?>cp/delivery"><strong><?=strftime("%e %B %Y, %A", strtotime($closest_delivery->date))?></strong></a>
                    <? } else { ?>
                        <i class="glyphicon glyphicon-info-sign"></i>&nbsp; Brak nadchodzących dostaw.
                    <? } ?>
                </div>
			<? } ?>
			
		</div>
		<?php /*?>
		<div class="col-md-4 text-center"> 
		
			
			<div class="btn-group-vertical margin_b_20">
			
				<div class="btn-group btn-group-justified">
					<a href="<?=base_url()?>page" class="btn btn-md btn-default text-left"><i class="glyphicon glyphicon-home"></i> &nbsp; Strona głowna </a>
				</div>
				<div class="btn-group btn-group-justified">
					<a href="<?=base_url()?>consultation" class="btn btn-md btn-default text-left"><i class="glyphicon glyphicon-comment"></i> &nbsp; Konsultacje </a>
				</div> 
				<div class="btn-group btn-group-justified">
					<a href="<?=base_url()?>user/logout" class="btn btn-md btn-danger text-left"><i class="glyphicon glyphicon-off"></i> &nbsp; Wyloguj </a>
				</div>
				
			</div>
			
		</div>
		<?php */?>
	</div>


<? } else { ?>
	<div class="row margin_t_10 margin_b_10" id="user_menu">
 
    	<div class="col-md-12 text-right"> 

        	<div class="btn-group">
                <div class="btn-group">
                    <a class="btn btn-success btn-lg" href="<?=base_url()?>user/login"><i class="fa fa-lock"></i> &nbsp; Zaloguj się</a>   
                    <button type="button" class="btn btn-success btn-lg dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </button>                  
                    <div class="dropdown-menu padding_20" style="width: 360px; margin-left: -50%">
        
                        <?=$this->load->view('user/login_form', array('popover' => false, 'redirect' => base64_encode(base_url() . 'cp')), true)?>
        
                    </div>
                    
                </div>
				<a class="btn btn-primary btn-lg popovera_click" title="" data-placement="left" data-content="<strong>Po prostu złoż zamówienie!</strong> Twoje konto zostanie założone automatycznie podczas składania zamówienia na catering lub konsultacje - hasło otrzymasz na podany do fakturowania adres email, który będzie Twoim loginem."><i class="fa fa-sign-in"></i> &nbsp; Załóż konto</a>  
        	</div>
        </div>
        
	</div>

<? } ?>
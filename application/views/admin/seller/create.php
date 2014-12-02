<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
    <li><a href="<?=base_url()?>admin/user" class="label label-primary">Sprzedawcy</a></li>
    <? if(isset($seller)) { ?>
    	<li class="active">Edytujesz sprzedawcę <?=$seller->name_surname?></li>
    <? } else { ?>
    	<li class="active">Dodajesz nowego sprzedawcę</li>
    <? } ?>
</ol>

<div class="row margin_b_20">
    <div class="col-md-12">
    
		<? if(isset($seller)) { ?>
            <h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-user"></i>&nbsp; Edytujesz sprzedawcę <?=$seller->name_surname?></h3>
        <? } else { ?>
            <h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-user"></i>&nbsp; Dodajesz nowego sprzedawcę</h3>
        <? } ?>
    
        
        <form class="form form-horizontal" role="form" method="post" action="<?=current_url()?>" id="seller_form">

			<?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => 0), true)?>

            <div class="row margin_t_30">

                <div class="col-md-12">

                    <div class="form-group">

                        <label class="col-lg-2 control-label">Użytkownik <span class="muted">*</span></label>
                        <div class="col-lg-10">
                            <select name="seller_id" class="form-control input-lg" required>
                                <option value=""> -- wybierz -- </option>
                                <? foreach($users as $u) { ?>
                                    <option value="<?=$u->user_id?>" <?=(!empty($seller) && $seller->user_id == $u->user_id)?'selected':''?>><?=$u->name_surname?>, <?=$u->user_id?>, (<?=$u->email?>), <?=$u->address?>, <?=$u->postcode?> <?=$u->city?></option> 
                                <? } ?>
                            </select>

                    
                    		<span class="help-block"><i class="glyphicon glyphicon-info-sign"></i> Sprzedawcą może zostać tylko istniejący już użytkownik, jeśli nie dodałeś jeszcze użytkownika i nie ma go na powyższej liście<br /><a href="" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>&nbsp; Dodaj nowego użytkownika</a><br />i wróć tutaj.</span>
                           
                    	</div>
                            
                    </div>
                    
                    
                    <div class="form-group">

                        <label class="col-lg-2 control-label">Prowizja dla partnera <span class="muted">*</span></label>
                        <div class="col-lg-10">
                        
                        	<input type="text" name="seller_provision" id="seller_provision" class="form-control input-lg" placeholder="Wysokość prowizji np. 7.00" autocomplete="off"  value="<?=$seller->seller_provision?>">
                            
							<span class="help-block"><i class="glyphicon glyphicon-info-sign"></i> Wybierz jaką prowizję od zamówień będzie otrzymywał sprzedawca. Po zmianie, prowizja zostanie na nowo przeliczona dla użytkownika, na podstawie wcześniejszych zamówień, a saldo zaaktualizowane</span>
                           
                    	</div>
                            
                    </div>
                    
                    
                    <div class="form-group">

                        <label class="col-lg-2 control-label">Numer konta bankowego <span class="muted">*</span></label>
                        <div class="col-lg-10">
                        
							<input type="text" name="account_number" class="form-control input-lg" value="<?=$seller->account_number?>" required />
                           
                           <span class="help-block"><i class="glyphicon glyphicon-info-sign"></i> Numer konta do wypłat prowizji</span>
                           
                    	</div>
                            
                    </div>
                    
                    
                    <div class="form-group">

                        <label class="col-lg-2 control-label">Przypisani klienci</label>
                        
                        <div class="col-lg-8">
                        
                            <select name="user_id[]" id="select_user_id" class="form-control" multiple size="20">
                                <? foreach($users as $u) { ?>
                                    <option value="<?=$u->user_id?>" <?=(!empty($seller_users_orders['user']['ids']) && in_array($u->user_id, $seller_users_orders['user']['ids']))?'selected':''?>><?=$u->name_surname?>, <?=$u->user_id?>, (<?=$u->email?>), <?=$u->address?>, <?=$u->postcode?> <?=$u->city?></option> 
                                <? } ?>
                            </select>
                            
                            <h4 class="margin_t_20"><i class="fa fa-check"></i> &nbsp; Aktualnie wybrani</h4>
                            
                            <div id="div_user_id">
                            </div> 
                        
                        </div>
                    	<div class="col-lg-2">
                    		<span class="help-block"><i class="glyphicon glyphicon-info-sign"></i> Możesz przypisać sprzedawcy stałych klientów - wszystkie ich nowe zamówienia będą mu automatycznie przypisywane. <strong>Przytrzymaj CTRL podczas kilkania, aby zaznaczać i odznaczać kilka pozycji.</strong></span>   
                 		</div>

                            
                    </div>
                    
                    <?php /*?>
                    <div class="form-group">

                        <label class="col-lg-2 control-label">Przypisane zamówienia</label>

                        <div class="col-lg-8">
                            <select name="order_id[]" id="select_order_id" class="form-control" multiple size="10">
                                <? foreach($orders as $o) { ?>
                                    <option value="<?=$o->order_id?>" <?=(!empty($seller_users_orders['order']['ids']) && in_array($o->order_id, $seller_users_orders['order']['ids']))?'selected':''?>><?=$o->date?>, <?=$o->order_number?>, <?=$o->name_surname?>, <?=$products[$o->packet_id]->name?>, <?=$o->price?> zł</option> 
                                <? } ?>
                            </select>

                            <h4 class="margin_t_20"><i class="fa fa-check"></i> &nbsp; Aktualnie wybrane</h4>
                            <div id="div_order_id"></div> 
                            
                        </div>
                    	<div class="col-lg-2">
                           
                    		<span class="help-block"><i class="glyphicon glyphicon-info-sign"></i> Możesz także przypisać konkretne zamówienia. <strong>Przytrzymaj CTRL podczas kilkania, aby zaznaczać i odznaczać kilka pozycji.</strong></span>

                    	</div>
                            
                    </div>
                    <?php */?>
                    
                    <div class="form-group margin_t_20 margin_b_20">
      
      					<div class="col-lg-10 col-lg-offset-2">
                            <div class="btn-group">
                                <? if(isset($seller)) { ?>
                                    <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zapisz edycją sprzedawcy</button>
                                <? } else { ?>
                                    <button type="submit" class="btn btn-success btn-lg" name="add" value="1">Dodaj sprzedawcę</button>
                                <? } ?>
                                <a href="<?=base_url()?>admin/seller" class="btn btn-default btn-lg">Powrót do listy sprzedawców</a>
                            </div>
                        </div>
         
                    </div>

                </div>

            </div>
 
        </form>

    </div>

</div>


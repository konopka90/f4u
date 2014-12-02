<nav class="navbar navbar-default margin_b_20" role="navigation" id="">
  <!-- Brand and toggle get grouped for better mobile display -->
 
    <ul class="nav navbar-nav" id="menu">
    
        <li class="dropdown <?=($this->uri->segment(2) == 'delivery')?'active':''?>">
        	
            <a href="<?=base_url()?>admin/delivery" class="dropdown-toggle"><i class="glyphicon glyphicon-plane"></i>&nbsp; Dostawy <b class="caret"></b></a>
            
            <ul class="dropdown-menu">
            	
            	<li><a href="<?=base_url()?>admin/delivery/<?=date("Ymd")?>/download/pdf" target="_blank"><i class="glyphicon glyphicon-download-alt"></i>&nbsp; .pdf dostaw i posiłków na dzisiaj</a></li>
                <li><a href="<?=base_url()?>admin/delivery/<?=date("Ymd")?>/download/xls" target="_blank"><i class="glyphicon glyphicon-download-alt"></i>&nbsp; .xls dostaw i posiłków na dzisiaj</a></li>
                
                <li class="divider"></li>
                
                <li class=""><a data-toggle="modal" data-target="#download_grammage_delivery" class="pointer"><i class="glyphicon glyphicon-hand-down"></i>&nbsp; Pobierz dostawy i/lub posiłki...</a></li>
 
            </ul>
            
        </li>

        <? if($this->user->access > 4) { ?>
        
            <li class="dropdown <?=($this->uri->segment(2) == 'order')?'active':''?>">
                <a href="<?=base_url()?>admin/order" class="dropdown-toggle"><i class="glyphicon glyphicon-cutlery"></i>&nbsp; Catering <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?=base_url()?>admin/order/create"><i class="glyphicon glyphicon-plus"></i>&nbsp; Dodaj zamówienie</a></li>
                </ul>
            </li>
            
            <li class="<?=($this->uri->segment(2) == 'consultation')?'active':''?>">
                 <a href="<?=base_url()?>admin/consultation"><i class="glyphicon glyphicon-comment"></i>&nbsp; Konsultacje</a>
            </li>
            
            
            <li class="dropdown <?=($this->uri->segment(2) == 'user')?'active':''?>">
                <a href="<?=base_url()?>admin/user" class="dropdown-toggle"><i class="glyphicon glyphicon-user"></i>&nbsp; Użytkownicy <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?=base_url()?>admin/user/create"><i class="glyphicon glyphicon-plus"></i>&nbsp; Dodaj nowego użytkownika</a></li>
                </ul>
            </li>
            
            
            <li class="dropdown <?=($this->uri->segment(2) == 'seller')?'active':''?>">
                <a href="<?=base_url()?>admin/seller" class="dropdown-toggle"><i class="fa fa-users"></i>&nbsp; Partnerzy <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?=base_url()?>admin/seller/create"><i class="fa fa-plus"></i>&nbsp; Dodaj nowego partnera</a></li>
                </ul>
            </li>
            
            
            <li>
                <a href="<?=base_url()?>admin/product"><i class="glyphicon glyphicon-th-large"></i>&nbsp; Produkty</a>
            </li>
            
            
            <li>
                <a href="<?=base_url()?>admin/structure"><i class="glyphicon glyphicon-th-list"></i>&nbsp; Struktura strony</a>
            </li>
            
            <?php /*?>
            <li>
                <a href="#">Treningi</a>
            </li>
            
            
            <li>
                <a href="#">Diety</a>
            </li>
            <?php */?>
            
            <?php /*?>
            <li>
                <a href="#">Ustawienia</a>
            </li>
            <?php */?>
            
            
            <li class="dropdown">
                 <a href="<?=base_url()?>admin/newsletter" class="dropdown-toggle"><i class="glyphicon glyphicon-envelope"></i>&nbsp; Newsletter <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?=base_url()?>admin/newsletter">Newsletter</a></li>
                    <li><a href="<?=base_url()?>admin/newsletter/email">Baza adresów email</a></li>
                </ul>
            </li>
            
            <li class="dropdown">
                <a href="<?=base_url()?>admin/setting/banner" class="dropdown-toggle"><i class="glyphicon glyphicon-pencil"></i>&nbsp; Ustawienia <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?=base_url()?>admin/setting/banner">Slidery</a></li>
                </ul>
            </li>
        
        <? } ?>
        
    </ul>


</nav>

                
<div class="modal fade" id="download_grammage_delivery" tabindex="-1" aria-labelledby="download_grammage_delivery_label" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pobierz dostawy i/lub posiłki</h4>
            </div>
            <form role="form" method="POST" action="<?=base_url()?>admin/delivery/download">
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label>Datę</label>
                        <input type="text" class="form-control dp" name="date" id="delivery_download_date" placeholder="Wybierz datę" value="<?=date("Y-m-d")?>" required>
                    </div>
                    <div class="form-group">
                        <label>Format pliku</label>
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="extension" value="pdf"> .pdf
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="extension" value="xls" checked> .xls
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Zawarte informacje</label>
                        <div>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="data[notice]" value="1" checked> Uwagi klienta
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="data[grammage]" value="1" checked> Gramatura, uwagi do posiłków
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="data[delivery]" value="1"> Adres dostawy, uwagi do dostawy
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="data[price]" value="1"> Cena
                            </label>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer margin_t_0">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    <div class="btn-group margin_l_10">
                    	<button type="submit" class="btn btn-primary" name="download" value="1"><i class="glyphicon glyphicon-download-alt"></i></button>
                        <button type="submit" class="btn btn-primary" name="download" value="1">Pobierz</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
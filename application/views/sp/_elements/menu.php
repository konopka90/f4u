<nav class="navbar navbar-default margin_b_20" role="navigation" id="sp_menu">

    <ul class="nav navbar-nav" id="menu">
    
        <li class="<?=($this->uri->segment(2) == 'summary')?'active':''?>">
        	<a href="<?=base_url()?>sp/summary/index"><i class="fa fa-truck"></i>&nbsp; Dostawy klientów </a>
        </li>
        
        <li class="dropdown <?=($this->uri->segment(2) == 'user')?'active':''?>">
            <a href="<?=base_url()?>sp/user/index" class="dropdown-toggle"><i class="fa fa-user"></i>&nbsp; Klienci <b class="caret"></b></a>
            <ul class="dropdown-menu">
            	<li><a href="<?=base_url()?>sp/user/create"><i class="fa fa-plus"></i>&nbsp; Dodaj klienta</a></li>
            </ul>
        </li>
        
        <li class="dropdown <?=($this->uri->segment(2) == 'order')?'active':''?>">
            <a href="<?=base_url()?>sp/order/index" class="dropdown-toggle"><i class="glyphicon glyphicon-th-large"></i>&nbsp; Zamówienia i prowizje <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="<?=base_url()?>sp/order/create"><i class="fa fa-plus"></i>&nbsp; Dodaj zamówienie</a></li>
            </ul>
        </li>
        
        <li class="<?=($this->uri->segment(2) == 'provision')?'active':''?>">
        	<a href="<?=base_url()?>sp/provision/index"><i class="fa fa-usd"></i>&nbsp; Prowizje </a>
        </li>
        
        <?php /*?>
        <li class="<?=($this->uri->segment(2) == 'provision')?'active':''?>">
        	<a href="<?=base_url()?>sp/provision"><i class="glyphicon glyphicon-usd"></i>&nbsp; Moje prowizje </a>
        </li>
        <?php */?>
        
        <?php /*?>
        <li class="dropdown <?=($this->uri->segment(2) == 'packets')?'active':''?>">
            <a href="<?=base_url()?>cp/packets" class="dropdown-toggle"><i class="glyphicon glyphicon-th-large"></i>&nbsp; Moje prowizje <b class="caret"></b></a>
            <ul class="dropdown-menu">
            	<li><a href="<?=base_url()?>cp/packets"><i class="glyphicon glyphicon-th-large"></i>&nbsp; Podsumowanie pakietu i płatności, faktury</a></li>
            	<li><a href="<?=base_url()?>cp/packets/prolong"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp; Przedłuż pakiet</a></li>
            </ul>
        </li>
        <?php */?>
        
    </ul>


</nav>
<nav class="navbar navbar-default margin_b_20" role="navigation" id="navbar_menu">
  <!-- Brand and toggle get grouped for better mobile display -->
 

    
    <ul class="nav navbar-nav" id="menu">
        <li class="<?=(!$this->uri->segment(2) || $this->uri->segment(2) == 'delivery')?'active':''?>">
        	<a href="<?=base_url()?>cp/delivery"><i class="glyphicon glyphicon-cutlery"></i>&nbsp; Kalendarz dostaw </a>
        </li>
        
        <li class="dropdown <?=($this->uri->segment(2) == 'packets')?'active':''?>">
            <a href="<?=base_url()?>cp/packets" class="dropdown-toggle"><i class="glyphicon glyphicon-th-large"></i>&nbsp; Zamówienia i płatności <b class="caret"></b></a>
            <ul class="dropdown-menu">
            	<li><a href="<?=base_url()?>cp/packets"><i class="glyphicon glyphicon-th-large"></i>&nbsp; Podsumowanie pakietu i płatności, faktury</a></li>
            	<li><a href="<?=base_url()?>cp/packets/prolong"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp; Przedłuż pakiet</a></li>
            </ul>
        </li>
        
        <?php /*?>
        <li class="dropdown">
        	<a href="<?=base_url()?>cp/consultation">Konsultacje</a>
        </li>
        
        <li class="dropdown">
        	<a href="<?=base_url()?>cp/training">Plany treningowe</a>
        </li>
        
        <li class="dropdown">
        	<a href="<?=base_url()?>cp/diet">Diety </a>
        </li>
        
        <li class="dropdown">
        	<a href="<?=base_url()?>cp/messager">Komunikator</a>
        </li>
        <?php */?>
        
    </ul>


</nav>
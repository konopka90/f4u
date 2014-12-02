<ul class="media-list">

    <li class="media gradient padding_10">
        <a class="pull-left" href="#">
            <img class="media-object" src="<?=base_url()?>img/ico_apple.png" />
        </a>
        <div class="media-body">
            Stawiasz właśnie 1 krok w kierunku osiągnięcia sukcesu! W celu złożenia zamówienia <strong>prosimy o dokładne wypełnienie formularza</strong> zgłoszeniowego.
        </div>
    </li>
    
    <li class="media gradient padding_10">
        <a class="pull-left" href="#">
            <img class="media-object" src="<?=base_url()?>img/ico_fruit_1.png" />
        </a>
        <div class="media-body">
            W zależności od długości pakietu <strong>przewidujemy dodatkowe dni dostawy</strong>!<br />
            <i class="glyphicon glyphicon-ok font_10"></i> &nbsp; więcej niż 30 dni + 1 dzień GRATIS</i>!<br />
            <i class="glyphicon glyphicon-ok font_10"></i> &nbsp; więcej niż 40 dni + 2 dni GRATIS!</i>
        </div>
    </li>
    
    <li class="media gradient padding_10">
        <a class="pull-left" href="#">
            <img class="media-object" src="<?=base_url()?>img/ico_fruit_2.png" />
        </a>
        <div class="media-body">
            <br />
            Dla stałych klientów oferujemy oczywiście bonusy - zostań naszym klientem i przekonaj się jakie!
        </div>
    </li>
    
    <? if($this->uri->segment(2) == 'cennik') { ?>
        <li class="media gradient padding_10">
            <a class="pull-left" href="#">
                <img class="media-object" src="<?=base_url()?>img/ico_fruit_3.png" />
            </a>
            <div class="media-body">
                Przy zamówieniu na co najmniej miesiąc skorzystaj z darmowych treningów personalnych oraz zabiegów fizjoterapii na terenie Krakowa.
            </div>
        </li>
    <? } ?>
    
</ul>
<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('cp/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>cp">Panel Klienta</a></li>
    <li><a href="<?=base_url()?>cp/packets" class="label label-primary">Twoje pakiety i faktury</a></li>
    <li class="active">Przedłuż pakiet</li>
</ol>

<div class="row margin_t_10">
    <div class="col-md-4">
    
        <h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon-th-large muted"></i> &nbsp; Twoje pakiety</h3>

		<?=$this->load->view('cp/packets/_elements/packets_list', array('user_packets' => $user_packets, 'active_packet' => $active_packet), true)?>

        
    </div>
    
    <div class="col-md-8" style="background: transparent url(<?=base_url()?>img/ks_bg.png) no-repeat left bottom">
    
        <h3 class="margin_0 margin_b_20 border_b_3 padding_b_10"><i class="glyphicon glyphicon-shopping-cart muted"></i> &nbsp; Zamów pakiet</h3>
        
        

        <ul class="media-list">
        
            <li class="media gradient padding_10 radius_5" style="border: 1px solid #f2f2f2">
                <a class="pull-left" href="#">
                    <img class="media-object" src="<?=base_url()?>img/ico_apple.png" style="width: 40px" />
                </a>
                <div class="media-body" style="">
                    Najpierw sprecyzuj parametry swojego zamówienia, zrobisz to szybciej niż Ci się wydaje! Możesz to zrobić na 3 sposoby - wybierając zakres dni w które chcesz mieć dostawę, wybierając iość posiłków lub wybierając konkretne dni!
                </div>
            </li>
        
        </ul>
    
        
        <div class="margin_b_20 clearfix" style="min-height: 482px;">
            
            <?=$this->load->view('order/_elements/calculator_new', array('packets_names' => $packets_names, 'user' => $user), true)?>
        
        </div>
  	</div>
</div>
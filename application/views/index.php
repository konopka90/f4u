<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <? $lang = $this->session->userdata('lang'); ?>
         
        <title>
		
			<?=$config->name?>
        
        	<? if($page) { ?>
            	- <?=$page->name?>. Twój catering dietetyczny w Krakowie!
            <? } elseif($this->uri->segment(1) == 'consultation') { ?>
				- zamów konsultacje online! Twój catering dietetyczny w Krakowie!
            <? } else {  ?>
            	- Twój catering dietetyczny w Krakowie!
            <? } ?>
        
        
        </title>
        <meta name="description" content="<?=$config->desc?>">
        <meta name="keywords" content="<?=$config->keywords?>">
        
        <meta name="viewport" content="width=device-width">
		<link href="<?=base_url()?>favicon.ico" rel="icon" type="image/x-icon" />
        
        <link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css?v=<?=time()?>">
        <link rel="stylesheet" href="<?=base_url()?>css/bootstrap-theme.min.css?v=<?=time()?>">
        <link rel="stylesheet" href="<?=base_url()?>css/font-awesome.css">

        <link rel="stylesheet" href="<?=base_url()?>js/datetimepicker/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="<?=base_url()?>js/daterangepicker/daterangepicker-bs3.css" />
        
        <link rel="stylesheet" href="<?=base_url()?>js/uploadify/uploadify.css" />
        
        <link rel="stylesheet" href="<?=base_url()?>css/main.min.css?v=<?=time()?>">
        <link rel="stylesheet" href="<?=base_url()?>css/main.css?v=<?=time()?>">
 
        <script src="<?=base_url()?>js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
    </head>
    <body> 
        <!--[if lt IE 8]>
        
        	<div class="container">
            	<a class="close" data-dismiss="alert" href="#">×</a>
            	<p class="chromeframe alert alert-error">
                    Używasz <strong>baardzo starej</strong> przeglądarki. Prosimy <a href="http://browsehappy.com/">zaktualizować</a> lub <a href="http://www.google.com/chromeframe/?redirect=true">pobrać Google Chrome <strong>(zalecane)</strong></a> aby skorzystać z wszystkich funkcji serwisu i zapewnić sobie stabilność działania.
                </p>
            </div>
            
        <![endif]-->

		<div class="top">
            <div class="container">
            	<div class="row">

						<div class="col-md-5 padding_t_0 padding_b_0"> 
                        	<a href="<?=base_url()?>">
                            	<img src="<?=base_url()?>img/logo.png" height="167px">
                            </a>
                        </div>
                        
                        <div class="col-md-7 padding_t_20 padding_b_20"> 
                        
                         	<?=$this->load->view('_elements/user_menu', array('user'=>$user, 'active_packet'=>$active_packet, 'closest_delivery' => $closest_delivery), true)?>
                            
                        </div>
            
               
                </div>
    		</div>
		</div>
        
        
        <? if( $no_slider != true && !empty($page_banners[56])) { ?>
        	<? if($this->uri->segment(2) != 'oferta') { ?>
            
                <div id="carousel-example-generic" class="carousel slide">
                
                    <?php /*?>
                    <ol class="carousel-indicators">
                        
                        <? $i = 0; ?>
                        <? foreach($page_banners[56] as $b) { ?>
                            <li data-target="#carousel-example-generic" data-slide-to="<?=$i?>" class="<?=($i == 0)?'active':''?>"></li> 
                            <? $i++; ?>
                        <? } ?>
    
                    </ol>
                    <?php */?>
                    
                    <div class="carousel-inner">
                    
                        <? $i = 0; ?>
                        <? foreach($page_banners[56] as $b) { ?>
                        
                            <? if(true) { ?>
                                <div class="item <?=($i == 0)?'active':''?>" style="height: 450px;background: url(<?=base_url()?>img/<?=$b->original_path?>) no-repeat center center">
                                    
                                    
                                    <? if($b->desc) { ?>
                                        <div class="container">
                                            <div class="row clearfix">
                                                <div class="my-col-a"></div>
                                                <div class="my-col-b clearfix">
                                                    
                                                        <div class="pull-left " style=" <?=$s?>">
                                                            <h1 class="my-banner-header"><?=$b->desc?></h1>
                                                        </div>                                                 
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
        
                                </div>
                                
                                                        
                            <? } else { ?>
                            
                                <div class="item <?=($i == 0)?'active':''?>">
                                    <img src="<?=base_url()?>img/<?=$b->original_path?>">
                                </div>
                            
                            <? } ?>
                            
                                
                                                        
                            <? $i++; ?>
                        <? } ?>
    
                    </div>
          
                    
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="icon-prev"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="icon-next"></span>
                    </a>
                
                </div>
        	<? } ?>
        <? } ?>
                
        <div id="content">
        
            <div class="container">
        
				<? if(isset($template)) { ?>
                    <?=$template?>
                <? } ?>
                
                <div id="preloader"><img src="<?=base_url()?>img/preloader.gif" /></div>
                
            </div>
            
        </div>
		<?php /*?>
		<div id="facebook" class="bg_watermark">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    
                        <div class="fb-like-box" data-href="https://www.facebook.com/pages/FIT4YOU/110994019051211" data-width="1000" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false" style="width: 100%"></div>
                    
                    </div>
                </div>
            </div>
        </div>
        <?php */?>
        <div id="footer" class="margin_b_10 padding_t_20 ">
            <div class="container">
	
                <div class="row">
                   
                        
                        <div class="col-sm-3 col-md-3"><img src="<?=base_url()?>img/logo_white.png" class="my-footer-logo"/></div>
                        <div class="col-sm-3 col-md-3">
                            <ul>
                                <li class="footer_heading">FitLab Catering</li>
                                <li>ul. Bocheńska 5/LU3</li>
                                <li>31-061 Kraków</li>
                                <li><div class="divider" style="margin-bottom: 20px;"></div></li>
                                <li><a href="<?=base_url()?>page/regulamin">Regulamin</a></li>
                                <li><a href="">PressPack</a></li>
                            </ul>
                            <div></div>
                            
                            <div></div>
                            <div></div>
                            
                        </div>
                        <div class="col-sm-3 col-md-3" style="padding-left: 5%;">
                            <ul>
                                <li class="footer_heading">Mapa strony</li>
                                <li><div class="divider"/></div></li>
                                <li><a href="<?=base_url()?>page/o_nas">O nas</a></li>
                                <li><a href="<?=base_url()?>page/fitlab">Oferta FitLab</a></li>
                                <li><a href="<?=base_url()?>page/zamowienia">Zamówienia</a></li>
                                <li><a href="<?=base_url()?>page/kontakt">Kontakt</a></li>
                            </ul>                        
                        </div>
                        <div class="col-sm-3 col-md-3" style="text-align:right; padding-right: 100px;">
                            <ul>
                                <li><span class="footer_heading"><span class="my-copyright">©</span> FitLab Catering</span></li>
                                <li><button class="btn btn-sm my-button my-footer-button popovera_click" title="" data-placement="top" 
                    data-content='<span style="color: rgb(48,48,48);"><span style="font-weight: bold; color: rgb(48,48,48);">Po prostu złoż zamówienie!</b></span> Twoje konto zostanie założone automatycznie podczas składania zamówienia na catering lub konsultacje - hasło otrzymasz na podany do fakturowania adres email, który będzie Twoim loginem.</span>'>
                    &nbsp; Załóż konto <span class="glyphicon glyphicon-star my-glyph-size" aria-hidden="true" ></span></button></li>
                                <li><a class="btn btn-sm my-button my-footer-button" href="<?=base_url()?>user/login">&nbsp; Zaloguj się <i class="fa fa-lock my-glyph-size"></i></a></li>
                                <li><div class="divider" style="float:right;"></div></li>
                                <li><div class="my-footer-small" style="clear:both;">Made with Love<br/>by BlürbStudio</div></li>
                            </ul>
                            
                        </div>
                                                
      
                </div>
    
            </div>
        </div>
        
        <script src="<?=base_url()?>js/vendor/jquery-1.10.1.min.js"></script>
        
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false&language=<?=$this->session->userdata('lang')?>"></script>

        <script src="<?=base_url()?>js/vendor/bootstrap.min.js"></script>
        
        <script src="<?=base_url()?>js/vendor/jquery.lazyload.js"></script>
        
        <script src="<?=base_url()?>js/vendor/jquery.actual.js"></script>
        
        <script src="<?=base_url()?>js/vendor/jquery.scroolTo.js"></script>
        
        <script src="<?=base_url()?>js/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?=base_url()?>js/datetimepicker/js/locales/bootstrap-datetimepicker.pl.js"></script>
        <script src="<?=base_url()?>js/daterangepicker/moment.js"></script>
        <script src="<?=base_url()?>js/daterangepicker/daterangepicker.js"></script>
        
        <script src="<?=base_url()?>js/jsplumb/jquery.jsPlumb-1.5.4-min.js"></script>
        
        <script src="<?=base_url()?>js/skrollr.min.js"></script>
		<script type="text/javascript">
        	var s = skrollr.init();
        </script>

        <script src="<?=base_url()?>js/plugins.js"></script>
        <script src="<?=base_url()?>js/main.js?v=<?=time()?>"></script>
		<script src="<?=base_url()?>js/my-fitlab.js"></script>
             
        <? if(	file_exists('js/' . $this->router->fetch_class() . '_' . $this->router->fetch_method() . '.js')	) { ?>
        	<script src="<?=base_url()?>js/<?=$this->router->fetch_class()?>_<?=$this->router->fetch_method()?>.js?v=<?=time()?>"></script>
        <? } ?>
        <? $load_js = load_js($this->router->fetch_class() . '_' . $this->router->fetch_method()); ?>
        <? if(!empty($load_js)) { ?>
        	<? foreach($load_js as $i => $filename) { ?>
				<? if(	file_exists('js/' . $filename . '.js')	) {  ?>
                    <script src="<?=base_url()?>js/<?=$filename?>.js?v=<?=time()?>"></script>
                <? } ?>
            <? } ?>
        <? } ?>
		<? $this->firephp->log(		$this->router->fetch_class() . '_' . $this->router->fetch_method()	); ?>  
             
                
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1&appId=141311919343679";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			ga('create', 'UA-34525395-5', 'fit4you.pl');
			ga('send', 'pageview');
        </script>
        
    </body>
</html>

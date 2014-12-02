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

                    
						<div class="col-md-5 padding_t_30 padding_b_30"> 
                        	<a href="<?=base_url()?>">
                            	<img src="<?=base_url()?>img/logo.png" height="107px">
                            </a>
                        </div>
                        
                        <div class="col-md-7 padding_t_50 padding_b_20"> 
                        
                         	<?=$this->load->view('_elements/user_menu', array('user'=>$user, 'active_packet'=>$active_packet, 'closest_delivery' => $closest_delivery), true)?>
                            
                        </div>
            
               
                </div>
    		</div>
		</div>
        
        <div class="" id="top_navigation">
			
            <div class="container">
            
                <nav class="navbar navbar-default margin_b_0" role="navigation">
                   
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    
                    
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                 
                        <?	
						if(!class_exists('M_Tree_Menu')) { 
						
							class M_Tree_Menu extends M_Tree { 
                            
                                function show_start_li($v, $array) {
									
									if($v['depth'] == 0) {
										
										$count = 2;
										foreach($array as $p) {
											if($p['depth'] == 0) {
												$count++;
											}
										}
	
										echo '<li style="width:' . 100/$count . '%" class="' . (($this->uri->segment(2) == reset(explode("/", $v['link'])))?'active':'') . ' '.$v['link'].'">';
									
									} else {
									
										echo '<li class="' . (($this->uri->segment(2) == reset(explode("/", $v['link'])))?'active':'') . ' ">';
										
									}
									
                                }
                                
                                function show_start_ul($v, $array) {
                                
									if(	count($v['childs']) > 0 && $v['depth'] == 0	) {
                                    	echo '<ul class="nav dropdown-menu" role="menu">';
									} else {
										echo '<ul class="nav">';	
									}
                        
                                } 
                                
                                function show_end_li() { echo '</li>'; }
                                function show_end_ul() { echo '</ul>'; }
                            
                            }
						}
                            
							
						$tree_menu = new M_Tree_Menu();
                            
                        ?>
                        
                        <ul class="nav navbar-nav" id="menu">
                        	
                            <li style="width:<?=100/(count($menu_tree)+2)?>%"><a href="<?=base_url()?>page">Home</a></li>
                            
                            <? $tree_menu->show($menu_tree, '_elements/menu_row', false, $page); ?>
                            
                            <li style="width:<?=100/(count($menu_tree)+2)?>%" class="konsultacje"><a href="<?=base_url()?>consultation">Konsultacje</a></li>
                            
                        </ul>
               
                    </div>
                </nav>
                
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
                                                <div class="col-md-12 clearfix">
                                                    
                                                    <div class="" style="margin-top: 335px;">
                                                        <div class="pull-left" style="height: 90px">
                                                            <img src="<?=base_url()?>img/banner_bg_left.png" />
                                                        </div>
                                                        
                                                        <?
                                                            
                                                            if(strlen($b->desc) < 55) {
                                                                $s = 'height: 90px; background: transparent url('.base_url().'img/banner_bg.png) repeat-x left top;white-space:nowrap;line-height: 90px;font-size: 36px;color: #442918;padding-left: 20px;padding-right: 20px';
                                                            } elseif(strlen($b->desc) < 70) {
                                                                $s = 'height: 90px; background: transparent url('.base_url().'img/banner_bg.png) repeat-x left top;white-space:nowrap;line-height: 90px;font-size: 30px;color: #442918;padding-left: 20px;padding-right: 20px';
                                                            } else {
                                                                $s = 'height: 90px; background: transparent url('.base_url().'img/banner_bg.png) repeat-x left top;line-height: 24px;padding-top: 21px;font-size: 26px;color: #442918;padding-left: 20px;padding-right: 20px;max-width: 75%';
                                                            }
                                                        
                                                        ?>
                                                        
                                                        <div class="pull-left latobold" style=" <?=$s?>">
                                                            <?=$b->desc?>
                                                        </div>
                                                        <div class="pull-left" style="height: 90px">
                                                            <img src="<?=base_url()?>img/banner_bg_right.png" />
                                                        </div>
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
        <div id="footer" class="bg_line">
            <div class="container">
	
                <div class="row">
                    <div class="col-md-12 text-right clearfix">
                    
                    	<a href="http://www.strefa-ruchu.com.pl/" target="_blank">
                    		<img src="<?=base_url()?>img/partner_1.png" class="partner pull-left margin_r_20">
                        </a>
                        
                        <a href="http://72d.pl/" target="_blank">
                        	<img src="<?=base_url()?>img/partner_3.png" class="partner pull-left">
						</a>
                        <?php /*?>
                        
                        <a href="http://flyartstudio.pl/" target="_blank">
                        	<img src="<?=base_url()?>img/partner_2.png" class="partner pull-left">
						</a>
                        <?php */?>
                        <a href="http://dream-factory.pl/" target="_blank">
                        	<img src="<?=base_url()?>img/partner_4.png" class="partner pull-left">
						</a>

                        <div class="margin_t_50">
							© <?=date("Y")?> Copyright by Fit4You. All rights reserved.
 						</div>
                        
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
             
        <? if(	file_exists('js/' . $this->router->fetch_class() . '_' . $this->router->fetch_method() . '.js')	) { ?>
        	<script src="<?=base_url()?>js/<?=$this->router->fetch_class()?>_<?=$this->router->fetch_method()?>.js?v=<?=time()?>"></script>
        <? } ?>
        <? $load_js = load_js($this->router->fetch_class() . '_' . $this->router->fetch_method()); ?>
        <? if(!empty($load_js)) { ?>
        	<? foreach($load_js as $i => $filename) { ?>
				<? if(	file_exists('js/' . $filename . '.js')	) { ?>
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

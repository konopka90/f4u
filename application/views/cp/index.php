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
        
        <link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url()?>css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?=base_url()?>css/font-awesome.css">

        <link rel="stylesheet" href="<?=base_url()?>js/datetimepicker/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="<?=base_url()?>js/daterangepicker/daterangepicker-bs3.css" />
        
        <link rel="stylesheet" href="<?=base_url()?>js/uploadify/uploadify.css" />
        
        <link rel="stylesheet" href="<?=base_url()?>js/datatable/media/css/jquery.dataTables.css" />
        <link rel="stylesheet" href="<?=base_url()?>js/datatable/BS3/examples/css/datatables.css" />
        
        <link rel="stylesheet" href="<?=base_url()?>js/bootstrap-dialog-master/css/bootstrap-dialog.css" />
        
        <link rel="stylesheet" href="<?=base_url()?>css/main.min.css?v=<?=time()?>">
        <link rel="stylesheet" href="<?=base_url()?>css/main.css?v=<?=time()?>">
        <link rel="stylesheet" href="<?=base_url()?>css/user_panel.css?v=<?=time()?>">
 
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

		<div class="top <?=(in_array($this->uri->segment(1), array('cp', 'sp', 'admin')))?'cp':''?>">
            <div class="container">
            	<div class="row">

                    <? if(!$this->uri->segment(1)) { ?>
                    
                        <div class="col-md-12 text-center padding_t_30" style="padding-bottom: 20px"> 
                            <img src="<?=base_url()?>img/logo.png" class="margin_b_10">
                            
                            <?php /*?>
            				<div style="width: 60%;margin:auto">
                            	<a class="close" data-dismiss="alert" href="#">×</a>
                            	<h2 class="margin_t_10 font_red">Wszystkiego Najlepszego w Nowym Roku!</h2>
                            	<h5>życzy zespół fit4you</h5>
                            </div>
                            <?php */?>
                            
                        </div>
                        
                    <? } else {  ?>
                    
						<div class="col-md-8 padding_t_30 padding_b_30"> 
                        	<a href="<?=base_url()?><?=$this->uri->segment(1)?>">
                            	<img src="<?=base_url()?>img/logo.png" height="50px">
                            </a>
                        </div>
                        
                        <div class="col-md-4 padding_t_30"> 
                        
                         	<?=$this->load->view('_elements/user_menu', array('user'=>$user, 'active_packet'=>$active_packet, 'closest_delivery'=>$closest_delivery), true)?>

                        </div>
                    
                    <? } ?>    
               
                </div>
    		</div>
		</div>
                
        <div id="content" class="<?=$this->router->fetch_class()?>_<?=$this->router->fetch_method()?> <?=($this->uri->segment(1) == 'cp')?'cp':''?>">
        	
            
            
            <div class="container">
        
				<? if(isset($template)) { ?>
                    <?=$template?>
                <? } ?>
                
                <div id="preloader"><img src="<?=base_url()?>img/preloader.gif" /></div>
                
            </div>
            
            
            
        </div>

        
        <div id="footer" class="bg_line">
            <div class="container">
	
                <div class="row">
                    <div class="col-md-12 text-center padding_t_50 padding_b_50">

						© <?=date("Y")?> Copyright by FitLab. All rights reserved.
 
                    </div>
                </div>
    
            </div>
        </div>
        
        <script src="<?=base_url()?>js/vendor/jquery-1.10.1.min.js"></script>
        <script src="http://codeorigin.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>
        
        <?php /*
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false&language=<?=$this->session->userdata('lang') ?>"></script>
        */?>

        <script src="<?=base_url()?>js/vendor/bootstrap.min.js"></script>
        
        <script src="<?=base_url()?>js/ckeditor/ckeditor.js"></script>
        
        <script src="<?=base_url()?>js/vendor/jquery.lazyload.js"></script>
        
        <script src="<?=base_url()?>js/vendor/jquery.actual.js"></script>
        
        <script src="<?=base_url()?>js/jquery.mjs.nestedSortable.js"></script>
        
        <script src="<?=base_url()?>js/uploadify/jquery.uploadify.js"></script>
        
        <script src="<?=base_url()?>js/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?=base_url()?>js/datetimepicker/js/locales/bootstrap-datetimepicker.pl.js"></script>
        <script src="<?=base_url()?>js/daterangepicker/moment.js"></script>
        <script src="<?=base_url()?>js/daterangepicker/daterangepicker.js"></script>
        
        <script src="<?=base_url()?>js/jsplumb/jquery.jsPlumb-1.5.4-min.js"></script>
        
		<script src="<?=base_url()?>js/datatable/media/js/jquery.dataTables.js" ></script>
        <script src="<?=base_url()?>js/datatable/BS3/examples/js/datatables.js" ></script>
        
        <script src="<?=base_url()?>js/bootstrap-dialog-master/js/bootstrap-dialog.js" ></script>

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
          js.src = "//connect.facebook.net/<?=($this->session->userdata('lang') == 'pl')?'pl_PL':'en_EN'?>/all.js#xfbml=1";
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

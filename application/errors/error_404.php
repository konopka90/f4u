<!DOCTYPE html>
<html lang="en">
    <head>
        <title>404 Page Not Found</title>
        
        <link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url()?>css/responsive.min.css">
        <link rel="stylesheet" href="<?=base_url()?>css/main.min.css?v=<?=time()?>">
        
        <style type="text/css">
        
            #container {
                position: absolute;
                left: 50%;
                top: 50%;
                width: 400px;
                margin-left: -220px;
                margin-top: -240px;
            }
        
        </style>
    </head>
    
    <body>
    
        <div id="container" class="well text-center">
        	<a href="<?=base_url()?>"><img src="<?=base_url()?>img/logo.png" class="img-responsive" id="logo" /></a>
            
            <h4 class="margin_t_30 margin_b_30"><?php echo $message; ?></h4>
            <a class="btn btn-primary btn-large" href="<?=base_url()?>"><?=lang('main_RETURN_TO_HOME')?></a></h2>
        </div>
        
    </body>
    
</html>
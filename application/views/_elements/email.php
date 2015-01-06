<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0">    <!-- So that mobile webkit will display zoomed in -->
    <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->

    <title>FitLab</title>
    <style type="text/css">


        /* Resets: see reset.css for details */
        .ReadMsgBody { width: 100%; background-color: #ebebeb;}
        .ExternalClass {width: 100%; background-color: #ebebeb;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
        body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
        body {margin:0; padding:0;}
        table {border-spacing:0;}
        table td {border-collapse:collapse;}
        .yshortcuts a {border-bottom: none !important;}


        /* Constrain email width for small screens */
        @media screen and (max-width: 600px) {
            table[class="email_container"] {
                width: 95% !important;
            }
        }

        /* Give content more room on mobile */
        @media screen and (max-width: 480px) {
            td[class="email_container-padding"] {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
        }


        /* Styles for forcing columns to rows */
        @media only screen and (max-width : 600px) {

            /* force email_container columns to (horizontal) blocks */
            td[class="force-col"] {
                display: block;
                padding-right: 0 !important;
            }
            table[class="col-3"] {
                /* unset table align="left/right" */
                float: none !important;
                width: 100% !important;

                /* change left/right padding and margins to top/bottom ones */
                margin-bottom: 12px;
                padding-bottom: 12px;
                border-bottom: 1px solid #eee;
            }

            /* remove bottom border for last column/row */
            table[id="last-col-3"] {
                border-bottom: none !important;
                margin-bottom: 0;
            }

            /* align images right and shrink them a bit */
            img[class="col-3-img"] {
                float: right;
                margin-left: 6px;
                max-width: 130px;
            }
        }

    </style>
</head>
<body style="margin:0; padding:10px 0;" bgcolor="#ebebeb" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<br>

<!-- 100% wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#ebebeb">
  <tr>
    <td align="center" valign="top" bgcolor="#ebebeb" style="background-color: #ebebeb;">

      <!-- 600px email_container (white background) -->
      <table border="0" width="600" cellpadding="0" cellspacing="0" class="email_container" bgcolor="#ffffff">
      
		<tr>
        	<td class="email_container-padding" bgcolor="#ffffff" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 14px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;">
                
                <table border="0" cellpadding="0" cellspacing="0" class="columns-email_container">
                  <tr>
                    <td class="force-col" style="padding-right: 20px;" valign="top">
    
                        <!-- ### COLUMN 1 ### -->
                        <table border="0" cellspacing="0" cellpadding="0" width="262" align="left" class="col-3">
                        <tr>
                            <td align="left" valign="middle" height="90" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                
                            <img src="<?=base_url()?>img/logo.png" height="50"/>
                                
                            </td>
                        </tr>
                        </table>
    
                    </td>
                    <td class="force-col" style="padding-right: 20px;" valign="top">
    
                        <!-- ### COLUMN 2 ### -->
                        <table border="0" cellspacing="0" cellpadding="0" width="262" align="left" class="col-3">
                        <tr>
                            <td align="right" valign="middle" height="90" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                    
                            	<a href="http://fitlab.pl" style="text-decoration: none; color: #2b2b33"><h5>www.fitlab.pl</h5></a>
                                
                            </td>
                        </tr>
                        </table>
    
                    </td>
                  </tr>
                </table><!--/ end .columns-email_container-->
            
            <hr style="border:0; border-top: 1px solid #f2f2f2; background:none; margin: 0"/>
            </td>
        
        </tr>
      	
        <tr>
          <td class="email_container-padding" bgcolor="#ffffff" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 14px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;">
			<br />

            <!-- ### BEGIN CONTENT ### -->
            <div style="font-weight: bold; font-size: 18px; line-height: 24px; color: #2b2b33">
            	<?=$title?>
            </div>

            <?=$text?>

            <!-- ### END CONTENT ### -->
			
            <br />

          </td>
        </tr>
        
		<tr>
        	<td class="email_container-padding" bgcolor="#f2f2f2" style="background-color: #f2f2f2; padding-left: 30px; padding-right: 30px; font-size: 14px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;">
                
                <table border="0" cellpadding="0" cellspacing="0" class="columns-email_container">
                  <tr>
                    <td class="force-col" style="padding-right: 20px;" valign="top">
    
                        <!-- ### COLUMN 1 ### -->
                        <table border="0" cellspacing="0" cellpadding="0" width="262" align="left" class="col-3">
                        <tr>
                            <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                            	
                                <? if($config->facebook || $config->youtube) { ?>
                                	<h4 style="margin-top: 25px">Dołącz do nas:</h4>
                                <? } ?>
                                
                                <? if($config->facebook) { ?>
                                    <p style="background-color: #3b5999;text-align:center;line-height: 10px">
                                        <a href="<?=$config->facebook?>" class="soc-btn fb">
                                            <img src="<?=base_url()?>img/ico_facebook.jpg" />
                                        </a>
                                    </p>
                                <? } ?>
                                
                                <? if($config->youtube) { ?>
                                    <p style="background-color: #fff;text-align:center;line-height: 10px">
                                        <a href="<?=$config->youtube?>" class="soc-btn fb">
                                            <img src="<?=base_url()?>img/ico_youtube.jpg" />
                                        </a>
                                    </p>
                                <? } ?>
                            </td>
                        </tr>
                        </table>
    
                    </td>
                    <td class="force-col" style="padding-right: 20px;" valign="top">
    
                        <!-- ### COLUMN 2 ### -->
                        <table border="0" cellspacing="0" cellpadding="0" width="262" align="left" class="col-3">
                        <tr>
                            <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">

								<? if($config->short_address) { ?>
                                    <h4 style="margin-top: 25px">Kontakt:</h4>	
                                    <?=$config->short_address?>
                                <? } ?>
                                                                
                            </td>
                        </tr>
                        </table>
    
                    </td>
                  </tr>
                </table><!--/ end .columns-email_container-->
                
                <br>
    
                <div style="text-align: center; font-size: 10px;">
                
					<a href="<?=base_url()?>page/regulamin" style="text-decoration:none; color: #2b2b33">Regulamin</a>
                    <? if($email) { ?>
             			&nbsp; &nbsp; &nbsp; &nbsp; 
                    	<a style="text-decoration:none; color: #2b2b33" href="<?=base_url()?>page/unsubscribe_newsletter/<?=base64_encode($email)?>"><unsubscribe>Wypisz się z newslettera</unsubscribe></a>
                    <? } ?>

                </div>
                <br>
            
            </td>
        
        </tr>
        
      </table>
      <!--/600px email_container -->

    </td>
  </tr>
</table>
<!--/100% wrapper-->
</body>
</html>
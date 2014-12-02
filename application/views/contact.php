<div class="row">
    


    <div class="col-md-6">
    
        <h3 class="margin_t_30 margin_b_20 border_b_3 padding_b_10"><strong><?=$page->name?></strong></h3>
    
        <?=$this->load->view('_elements/elements', array('elements' => $page_elements, 'page_elements_photos' => $page_elements_photos), true)?>

		<hr />
        
        <h4 class="margin_b_20"><img class="pull-left" src="<?=base_url()?>img/ico_fruit_2.png" width="24px"/> &nbsp; <strong>Nie wahaj się dłużej - skontaktuj się z nami!</strong></h4>

        
    </div>
    
        
    
    <? if($config->dane_adres) { ?>
    

        <div class="col-md-4">
        
            <h3 class="margin_t_30 margin_b_20"><strong>Mapa dojazdu</strong></h3>
        
            <div id="map-canvas" class="margin_t_20 radius" data-position='<?=$config->dane_adres?>' data-infowindow_content='<?=$config->dane_adres_2?>'></div>

            <div class="btn-group margin_t_20">
    
                <a class="btn btn-default margin_bottom" href="#map_modal" data-toggle="modal"><strong>Duża mapa</strong></a>
                
            </div>             
            
            <div class="modal fade" id="map_modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog text-left">
                    <div class="modal-content">
                    
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="margin_0 font_white"><strong><?=lang('main_SEE_US_AT_GOOGLEMAPS')?></strong></h3>
                        </div>
                        
                        <div class="modal-body padding_0">
                        
                            
                        
                        </div>
                        
                        <div class="modal-footer margin_t_0">
                            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><strong><?=lang('main_CLOSE')?></strong></button>
                        </div>
                        
                    </div>
                </div>
            </div>
        
        </div>
                
    <? } ?>
    
    <div class="col-md-6">  
    
        <h2 class="margin_t_30 margin_b_20"><strong>Formularz kontaktowy</strong></h2>

        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
                
        <form class="form-horizontal margin_b_20" role="form" method="POST" action="<?=current_url()?>">
        
            <div class="form-group">
                <?php /*?><label class="col-lg-3 control-label"><?=lang('main_Your_email')?></label><?php */?>
                <div class="col-lg-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" class="form-control input-lg" name="email" placeholder="<?=lang('main_Your_email')?>">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <?php /*?><label class="col-lg-3 control-label"><?=lang('main_Your_name_and_surname')?></label><?php */?>
                <div class="col-lg-12">
                
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control input-lg" name="name_surname"  placeholder="<?=lang('main_Your_name_and_surname')?>">
                    </div>
                    
                    
                </div>
            </div>
            
            <div class="form-group">
                <?php /*?><label class="col-lg-3 control-label"><?=lang('main_Text')?></label><?php */?>
                <div class="col-lg-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                        <textarea class="form-control input-lg" rows="5" name="text" placeholder="<?=lang('main_Text')?>"></textarea>
                    </div>
                </div>
            </div>
        
            <?php /*?>
            <div class="form-group">
                <div class="col-lg-offset-4 col-lg-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="send_confirm">  <?=lang('main_Send_confirm_to_me')?>
                        </label>
                    </div>
                </div>
            </div>
            <?php */?>
            
            <div class="form-group margin_b_0">
                <div class="col-lg-12">
                    <div class="btn-group">
                        <button class="btn btn-success btn-lg"><span class="glyphicon glyphicon-ok-sign"></span></button>
                        <button type="submit" name="contact" value="1" class="btn btn-success btn-lg"><strong><?=lang('main_SEND')?></strong></button>
                    </div>
                </div>
            </div>
        
        </form>
    
    </div>


</div>





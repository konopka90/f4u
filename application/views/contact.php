<div class="row" >
    <div class="row my-row-contact">
        <div class="my-col-a my-col-with-heading"><h1 class="my-heading"><?=$page->name?></h1></div>
        <div class="my-col-b"><hr/>
            <p>Skontaktuj się z nami aby dowiedzieć się więcej.<br/>Chętnie odpowiemy na twoje pytania.</p>
            <p class="my-subheader">
               Klaudia: +48 506 608 680<br/>
               Ewa: +48 606 266 160
            </p>
            <p class="my-subheader">info@fitlabcatering.pl</p>
        </div>
    </div>
    <div class="row my-row-contact">
    
        
                
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
                
                <div class="my-col-a my-col-with-heading">  
                
                    <h1 class="my-heading">Formularz</h1>

                  
                
                </div>
                <div class="my-col-b"><hr/>
                  <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
                            
                    <form class="form-horizontal margin_b_20" role="form" method="POST" action="<?=current_url()?>">
                        <div class="form-group">
                            <?php /*?><label class="col-lg-3 control-label"><?=lang('main_Your_name_and_surname')?></label><?php */?>
                            <div class="col-lg-12">
                                <div class="my-description-in-form">Twoje Imię</div>
                                <input type="text" class="form-control input-lg" name="name_surname" />                           
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <?php /*?><label class="col-lg-3 control-label"><?=lang('main_Your_email')?></label><?php */?>
                            <div class="col-lg-12">
                                <div class="my-description-in-form">Twój Adres Email</div>
                                <input type="text" class="form-control input-lg" name="email" />
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <?php /*?><label class="col-lg-3 control-label"><?=lang('main_Text')?></label><?php */?>
                            <div class="col-lg-12">
                                <div class="my-description-in-form">Wiadomość</div>
                                <textarea class="form-control input-lg my-textarea" rows="5" name="text" ></textarea>
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
                                <div class="btn-group" style="float:right;">
                                    <button type="submit" name="contact" value="1" class="btn my-button my-button-send">Wyślij</button>
                                </div>
                            </div>
                        </div>
                    
                    </form>
                </div>
    </div>


</div>





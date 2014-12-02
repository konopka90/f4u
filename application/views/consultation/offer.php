<h2 class="margin_t_30 margin_b_10 text-center" id="welcome_back_text">Witaj ponownie <?=base64_decode($name_surname)?>! Dziękujęmy za zainteresowanie.</h2>         
<h4 class="margin_b_30 text-center">Sprecyzuj swoje oczekiwania.</h4>     

<form action="<?=base_url()?>consultation/order/make" method="post" id="consultation_form">
    <div id="consultation_offer_carousel" class="carousel slide">
    
        <div class="carousel-inner">
            <div class="item active">
    
                
                <div class="row">
                
                    <div class="col-md-2">
                    
                    </div>
                    
                    <div class="col-md-8">

                            <?	class M_Tree_Left_Menu extends M_Tree { 
                                
                                    function show_start_li($v, $array) { echo ''; }
                                    function show_start_ul($v, $array) { echo ''; }
                                    function show_end_li($v, $array) { echo ''; }
                                    function show_end_ul($v, $array) { echo ''; }
                                
                                }
                                
                                $tree_menu = new M_Tree_Left_Menu();
                            
                            ?>
                        
                 
                            
                            <? $tree_menu->show($consultation_offer_tree, 'consultation/_elements/product_row', false, $page); ?>

                            <div class="text-right margin_t_20">
                                
                                <button type="button" class="btn btn-success btn-lg" id="btn_consultation_next">Dalej &rarr;</button>
                                
                            </div>
                            
                        
                        
                        <p class="alert alert-bite margin_b_30 margin_t_30">
                            Po zamówieniu skontaktujemy sie z Tobą w przeciagu maksymalnie 30 minut. 
                        </p>
                        
                    </div>
                    
                    <div class="col-md-2">
                    
                    </div>
                    
                </div>
    
    
    
            </div>
            <div class="item">
                <div class="row">
                
                    <div class="col-md-2">
          
                    
                    </div>
                    
                    <div class="col-md-8">
                    
                        <h3 class="margin_b_30 font_gray" id="get_data_for_invoice_text">Podaj dane do fakturowania</h3>
                        
                        <div class="row">
                        
                            <div class="col-md-6">
    
                                <div class="form-group">
                                    <label>Imię i nazwisko</label>
                                    <input type="text" name="name_surname" class="form-control input-lg" placeholder="Imię i nazwisko" value="<?=$user->name_surname?>" required>
                                </div>
                                
                                <div class="form-group clearfix">
                                    <label>Adres</label>
                                    <input type="text" name="address" class="form-control input-lg" placeholder="Adres" value="<?=$user->address?>" required>
                                    
                                    <div class="row margin_t_15">
                                        <div class="col-lg-5">
                                            <input type="text" name="postcode" class="form-control input-lg" placeholder="Kod pocztowy" value="<?=$user->postcode?>" required> 
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="text" name="city" class="form-control input-lg" placeholder="Miasto" value="<?=$user->city?>" required>
                                        </div>
                                    </div>
    
                                </div>
    
                                
                            </div>
                            
                            <div class="col-md-6">
                            
                                <div class="form-group">
                                    <label>Adres email</label>
                                    <input type="email" name="email" id="consultation_email" class="form-control input-lg" data-unique="true" data-except="<?=$user->email?>" value="<?=$user->email?>" placeholder="Adres email" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Telefon</label>
                                    <input type="text" name="phone" class="form-control input-lg" placeholder="Telefon" value="<?=$user->phone?>" required>
                                </div>
                                
                            </div>
                        
                        </div>
    
                        <div id="div_summary"></div>
                        
                        <p class="alert alert-bite margin_b_30 margin_t_30">
                            Po zamówieniu skontaktujemy sie z Tobą w przeciagu maksymalnie 30 minut. 
                        </p>
                        
                    </div>
                    
                    <div class="col-md-2">
                    
                    </div>
                    
                </div>
                
            </div>
        </div>
        
    
    </div>
</form>


<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">

    <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
    <li><a href="<?=base_url()?>admin/product" class="label label-primary">Produkty</a></li>
    
    <? if(isset($product)) { ?>
    	<li class="active">Edytujesz produkt <?=$product->name?></li>
    <? } else { ?>
    	<li class="active">Dodajesz nowy produkt</li>
    <? } ?>
    
</ol>

<div class="row">
    <div class="col-md-12">
    
		<? if(isset($product)) { ?>
            <h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-th-large"></i>&nbsp; Edytujesz produkt <?=$product->name?></h3>
        <? } else { ?>
            <h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-th-large"></i>&nbsp; Dodajesz nowy produkt</h3>
        <? } ?>
 
        <form class="form" role="form" method="post" action="<?=current_url()?>" id="product_form">

			<?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => 0), true)?>

            <div class="row margin_t_30">

                <div class="col-md-12">

                    <div class="form-group">
                        <label>Nazwa produktu *</label>
                        <input type="text" name="name" class="form-control" placeholder="Nazwa" value="<?=$product->name?>" required>
                    </div>
					
                    <? if(!$catering) { ?>
                        <div class="form-group">
                            <label>Opis</label>
                            <textarea name="desc" class="form-control" placeholder="Krótki opis (kilka słów)" rows="3"><?=$product->desc?></textarea>
                        </div>
                    <? } else { ?>
                        <div class="form-group">
                            <label>Ilość posiłków dziennie *</label>
                            <select name="meals_per_day" class="form-control" required>
                            	<option> -- wybierz -- </option>
                                <? for($i=1;$i<=5;$i++) { ?>
                                	<option value="posilkow_<?=$i?>" <?=($product->meals_per_day == 'posilkow_' . $i)?'selected':''?>> <?=$i?> posiłków </option>
                                <? } ?>
                            </select>
                        </div>
                    <? } ?>
                    
                    <div class="form-group">
                        <label>Cena produktu *</label>
                        <input type="number" step="0.01" min="0" name="price" class="form-control" placeholder="Cena" value="<?=($catering)?$product->price_for_day:$product->price?>" required>
                    </div>
                    
                    <? if(!$catering) { ?>
                        <div class="">
                            <i class="glyphicon glyphicon-exclamation-sign"></i> Kolejność i poziom zagłębienia produktu możesz ustawić na <a href="<?=base_url()?>admin/product">liście wszystkich produktów</a>. Zauważ że zamawiać można tylko produkty najbardziej zagłębione w drzewie.
                        </div>
                    <? } ?>
                    
                </div>
                
            </div>

            <div class="row clearfix">
                <div class="col-md-12">

                    <div class="form-group margin_t_30 margin_b_30">
      
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zapisz produkt</button>
                            <button type="submit" class="btn btn-success btn-lg" name="save_and_redirect" value="1">Zapisz i wróć do listy produktów</button>
                            <a href="<?=base_url()?>admin/product" class="btn btn-default btn-lg">Powrót do listy produktów</a>
                        </div>
         
                    </div>
                
                </div>
            </div>
            
        </form>

    </div>

</div>


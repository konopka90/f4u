<div id="div_select_meals_per_day">
    <h4><span class="label label-success">KROK 1 z 3</span> &nbsp; &nbsp; Wybierz ilość posiłków dziennie</h4>
    <select class="form-control input-lg margin_b_30" id="select_meals_per_day">
    	<option value=""> -- wybierz -- </option>
        <? if(count($products) > 0) { ?>
        	
        	<? foreach($products as $p) { ?>
            	<? $packets_meals_per_day_values = packets_meals_per_day_values($p->meals_per_day); ?>
            	<option value="<?=$p->product_id?>" data-meals="<?=end(explode("_", $p->meals_per_day))?>"><?=$packets_meals_per_day_values[0]?>, <?=$p->price_for_day?>/dzień PLN</option>
            <? } ?>
        <? } ?>
    </select>
</div>

<div class="margin_b_30 hide" id="delivery_selected_meals" data-limit="">
	<h4><span class="label label-success">KROK 2 z 3</span> &nbsp; &nbsp; Które posiłki wybierasz? </h4>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-default">
        	<input type="checkbox" name="meal[1]" class="delivery_meal" value="1"> Śniadanie
        </label>
        <label class="btn btn-default">
        	<input type="checkbox" name="meal[2]" class="delivery_meal" value="2"> Posiłek 1
        </label>
        <label class="btn btn-default">
        	<input type="checkbox" name="meal[3]" class="delivery_meal" value="3"> Posiłek 2
        </label>
        <label class="btn btn-default">
        	<input type="checkbox" name="meal[4]" class="delivery_meal" value="4"> Posiłek 3
        </label>
        <label class="btn btn-default">
        	<input type="checkbox" name="meal[5]" class="delivery_meal" value="5"> Kolacja
        </label>
    </div>
</div>

<div id="div_select_days" class="hide">
    <h4><span class="label label-success">KROK 3 z 3</span> &nbsp; &nbsp; Czas trwania pakietu</h4>
    <select class="form-control input-lg margin_b_30" id="select_days">
    
    	<option value=""> -- wybierz -- </option>
    	<? for($i = 3; $i <= 40; $i++) { ?>
        	<option value="<?=$i?>"><?=$i?> dni</option>
        <? } ?>
    
    </select>
</div>

<h1 id="text_price" class="alert hide padding_0 border_0 margin_b_20"></h1>
 
<div class="input-group margin_b_20 hide">
    <span class="input-group-addon">Data rozpoczęcia dostaw</span>
    <input id="delivery_start_date" data-start_date="<?=$first_avalible_day?>" class="form-control input-lg margin_b_20" name="start" value="" placeholder="Nie może to być wcześniej niż <?=$first_avalible_day?>" />
</div>

<? if($user->user_id) { ?>
    <a id="btn_order" class="btn_open_form btn btn-success btn-lg pull-right clearfix hide"> <i class="glyphicon glyphicon-shopping-cart"></i> &nbsp; Kupuje </a>
<? } else { ?>
    <a id="btn_order" class="btn_popover_login btn btn-success btn-lg pull-right clearfix hide" data-title="<h4 style='width: 350px'>Jeśli masz już u nas konto, zaloguj się</h4>" data-content='<?=$this->load->view('user/login_form', array('popover' => true, 'redirect' => false), true)?>' data-placement="top"> <i class="glyphicon glyphicon-shopping-cart"></i> &nbsp; Kupuje </a>
<? } ?>


<div id="div_order_form"></div>
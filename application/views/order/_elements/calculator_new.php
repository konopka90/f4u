<? if(true || in_array($this->user->user_id, array(12))) { ?>

	<h4 class="margin_t_20"><span class="label label-success">WYBÓR DIETY</span> &nbsp; &nbsp; Wybierz dietę, którą chcesz zamówić</h4>
    
    <div class="list-group margin_b_30">
    
    	<? foreach(offer_values() as $name => $v) { ?>
            <li class="list-group-item div_diet" id="div_diet_<?=$name?>">
            
                <div class="row">
                	
                    <? if($name == 'kaloryczna') { ?>
                    	<div class="col-md-6">
                    <? } else { ?>
                    	<div class="col-md-10">
                    <? } ?>
                        <h4 class="latobold"><?=$v['name']?></h4>
                    </div>
                    
                    <? if($name == 'kaloryczna') { ?>
                        
                        <div class="col-md-4">
                            <select class="form-control input-xs pull-right" id="diet_kaloryczna_calories">
                            
                                <option value="1000"> 1000 kcal </option>
                                <option value="1200"> 1200 kcal </option>
                                <option value="1500"> 1500 kcal </option>
                                <option value="1700"> 1700 kcal </option>
                                <option value="2000"> 2000 kcal </option>
                            
                            </select>
                        </div>
                        
                    <? } ?>
    
                    <div class="col-md-2 text-center">
                        <span class="badge">
                            <div class="checkbox padding_0 margin_t_5 margin_b_5">
                                <label>
                                    <input type="checkbox" class="margin_l_10 margin_r_10 padding_0 input_select_diet" data-name="<?=$name?>">
                                </label>
                            </div>
                        </span>
                    </div>
                    
                </div>
                
            </li >
        <? } ?>
        
        <input type="hidden" id="input_diet" value="" /> 
        
    </div>
    
    <h4 class="margin_t_30"><span class="label label-success">WYBÓR PŁCI</span> &nbsp; &nbsp; Wybierz swoją płeć</h4>

    <div class="btn-group btn-group-justified margin_b_30" data-toggle="buttons">
    
        <label class="btn btn-default btn-lg">
            <input type="radio" name="sex" class="select_sex" value="female"><i class="fa fa-female margin_r_20"></i>Kobieta
        </label>

        <label class="btn btn-default btn-lg">
            <input type="radio" name="sex" class="select_sex" value="male"><i class="fa fa-male margin_r_20"></i>Mężczyzna
        </label>
        
    </div>
    
    <input type="hidden" id="input_sex" name="input_sex" value="" />
    
    <h4 class="margin_t_20"><span class="label label-success">WYBÓR TERMINÓW</span> &nbsp; &nbsp; Wybierz terminy dostaw</h4>
    
<? } ?>



<div class="btn-group btn-group-justified" data-toggle="buttons" id="div_select_mode">
    <label class="btn btn-primary btn-lg">
        <input type="radio" name="mode" class="select_mode" value="range"> Wybiorę zakres daty
    </label>
    <label class="btn btn-primary btn-lg">
        <input type="radio" name="mode" class="select_mode" value="days"> Podam ilość dni
    </label>
    <label class="btn btn-primary btn-lg">
        <input type="radio" name="mode" class="select_mode" value="calendar"> Zaznaczę na kalendarzu
    </label>
    <input type="hidden" id="input_select_mode" name="input_select_mode" value="" />
</div>

<div id="div_range_mode" class="div_mode" style="display: none">

    <h4 class="margin_t_20"><span class="label label-success"><i class="fa fa-calendar-o"></i></span> &nbsp; &nbsp; W jakim czasie chcesz mieć dostawy?</h4>
    
    <div class="clearfix">
    
        <input type="text" class="form-control input-lg dr_" name="delivery_range" id="delivery_range" placeholder="Kliknij, aby wybrać zakres daty"/>
        <input type="hidden" name="delivery_range_days" id="delivery_range_days" value="" />
        <input type="hidden" name="delivery_range_start" id="delivery_range_start" value="" />
        <input type="hidden" name="delivery_range_end" id="delivery_range_end" value="" />

    </div>

</div>


<div id="div_days_mode" class="div_mode" style="display: none">

    <h4 class="margin_t_20"><span class="label label-success"><i class="fa fa-calendar-o"></i></span> &nbsp; &nbsp; Kiedy mają rozpocząć się dostawy</h4>
    
    <div class="clearfix">
    
        <input type="text" class="form-control input-lg dp_" name="delivery_days_start" id="delivery_days_start" placeholder="Kliknij, aby wybrać datę"/>

    </div>
    
    <h4 class="margin_t_20"><span class="label label-success"><i class="fa fa-truck"></i></span> &nbsp; &nbsp; Ile dostaw zamawiasz?</h4>
    
    <div class="clearfix">
    
        <select class="form-control input-lg" name="delivery_count_days" id="delivery_count_days">
        
            <option value=""> -- wybierz -- </option>
            <? for($i = 3; $i <= 40; $i++) { ?>
                <option value="<?=$i?>"><?=$i?> dni</option>
            <? } ?>
        
        </select>

    </div>


</div>


<div id="div_range_days_mode" class="div_mode" style="display: none">

	<h4 class="margin_t_20"><span class="label label-success"><i class="fa fa-calendar"></i></span> &nbsp; &nbsp; W jakie dni tygodnia?</h4> 
    
    <div class="btn-group btn-group-justified" data-toggle="buttons" id="delivery_week_days">
        <label class="btn btn-default active">
        	<input type="checkbox" name="day[1]" class="delivery_week_day" value="1" checked> Pon
        </label>
        <label class="btn btn-default active">
        	<input type="checkbox" name="day[2]" class="delivery_week_day" value="2" checked> Wt
        </label>
        <label class="btn btn-default active">
        	<input type="checkbox" name="day[3]" class="delivery_week_day" value="3" checked> Śr
        </label>
        <label class="btn btn-default active">
        	<input type="checkbox" name="day[4]" class="delivery_week_day" value="4" checked> Cz
        </label>
        <label class="btn btn-default active">
        	<input type="checkbox" name="day[5]" class="delivery_week_day" value="5" checked> Pt
        </label>
        <label class="btn btn-default active">
        	<input type="checkbox" name="day[6]" class="delivery_week_day" value="6" checked> Sb
        </label>
        <label class="btn btn-default active">
        	<input type="checkbox" name="day[7]" class="delivery_week_day" value="0" checked> Nd
        </label>
    </div>
    

</div>


<div id="div_calendar_mode" class="div_mode" style="display: none">

    
    <div id="div_select_meals_per_day">
        <h4 class="margin_t_20"><span class="label label-success"><i class="fa fa-calendar-o"></i></span> &nbsp; &nbsp; Wybierz dni, w które chcesz mieć dostawy</h4>
        
        <div class="margin_t_20" id="div_order_calculator_calendar">
        
            <div class="row">
            
                <div class="col-md-1 text-left">
                    <i class="glyphicon glyphicon-chevron-left margin_t_5 prev pointer tooltipa" title="Poprzedni miesiąc" data-date=""></i>
                </div> 
                
                <div class="col-md-10" id="order_calculator_calendar" data-user_id="<?=$this->user->user_id?>">
                
                </div>
                <div class="col-md-1 text-right">
                    <i class="glyphicon glyphicon-chevron-right margin_t_5 next pointer tooltipa" title="Następny miesiąc" data-date=""></i>
                </div>
            
            </div>
    
        </div>

    </div>

</div>

<div id="div_order_delivery_days"></div>

<div id="div_range_days_calendar_mode" class="div_mode" style="display: none">

	<h4 class="margin_t_20"><span class="label label-success"><i class="fa fa-cutlery"></i></span> &nbsp; &nbsp; Ile i jakie posiłki wybierasz? 	<span class="muted">Musisz wybrac minimum 3 posiłki.</span></h4> 
    
    <div class="btn-group btn-group-justified" data-toggle="buttons" id="delivery_calendar_day_selected_meals">
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
    
	<? if(count($products) > 0) { ?>
        <? foreach($products as $p) { ?>
            <input type="hidden" id="delivery_meal_<?=end(explode("_", $p->meals_per_day))?>_per_day" value="<?=$p->price_for_day?>" data-id="<?=$p->product_id?>"/>
        <? } ?>
    <? } ?>

    
</div>

<div id="delivery_summary" class="margin_t_20 clearfix"></div>

<div id="div_btn_order" class="btn-group pull-right clearfix margin_t_0" style="display:none">
	<? if($user->user_id) { ?>
    	<a class="btn_open_form btn btn-success btn-lg"><i class="fa fa-shopping-cart"></i></a>
        <a class="btn_open_form btn btn-success btn-lg"> &nbsp; Kupuje </a>
    <? } else { ?>
        <a class="btn_popover_login btn btn-success btn-lg" data-title="<h4 style='width: 350px'>Jeśli masz już u nas konto, zaloguj się</h4>" data-content='<?=$this->load->view('user/login_form', array('popover' => true, 'redirect' => false), true)?>' data-placement="top"> <i class="glyphicon glyphicon-shopping-cart"></i> &nbsp; Kupuje </a>
    <? } ?>
</div>


<div id="div_order_form"></div>

    <div class="row" data-0="margin-top: 60px" data-200="margin-top: 30px" id="anchor_offer">
    
        <div class="col-md-5">
        
        	<div id="div_oferta_holder">
            
            	<h1 class="text-center"><?=$page->name?></h1>
            
            </div>

        </div>
        
        <div class="col-md-3 text-center font_green_light">
        
            <div data-0="margin-top: 60px" data-200="margin-top: 30px">
                <i class="fa fa-truck font_40"></i>
                <p class="font_18">W zależności od długości pakietu przewidujemy dodatkowe dni dostawy!</p>
            </div>
            
        </div>
        
        <div class="col-md-4 text-center font_green_light">
        
            <div class="margin_t_30">
            
                <i class="fa fa-gift font_40"></i>
                <p class="font_18">Dla stałych klientów oferujemy bonusy - zostań naszym klientem i przekonaj się jakie!</p>
                
            </div>
            
        </div>
        
    </div>
    
    <div class="row margin_t_30 margin_b_0">
        <div class="col-md-12 text-center font_26 apolonialight">
            Drogi kliencie specjalnie dla Ciebie poszerzyliśmy swoje horyzonty, jeżeli wcześniej nie znalazłeś intersującej dla siebie oferty mamy nadzieję, że teraz nie będziesz mógł się zdecydować którą, z poniższych 5 diet wybrać!
            <? //$this->load->view('_elements/elements', array('elements' => $page_elements, 'page_elements_photos' => $page_elements_photos), true); ?>
        </div>
    </div>

	
    <? if(false) { ?>
        <div class="row margin_t_60 margin_b_40">
            <div class="col-md-6 col-md-offset-3">
                <?=$this->load->view('_elements/message', array('message' => 'Oferta w trakcie przygotowania', 'message_status' => $message_status), true)?> 
            </div>
        </div>
    <? } ?>
    
           
</div>



<div id="offer_individual" data-bottom-center="background-position: -650px 120px" data-center-center="background-position: -300px 0px;">

    <div class="container">
        
        <div class="row">
        
        	<div class="col-lg-4"> 
            	
                <img src="<?=base_url()?>img/offer_individual_ico.png" class="ico visible-lg" data-bottom-center="top: 130px; left: -680px" data-center-center="top: -30px; left: -240px" data-top-center="top: 0px; left: -380px"/>
                
            </div>
            
            <div class="col-lg-8">              
                                    
                <h1 class="text-center" data-bottom-center="margin-top: -50px" data-center-center="margin-top: 80px">Dieta FIT</h1>
                                    
                <div id="offer_individual_carousel" class="offer_carousel slide" data-ride="carousel">
                
                    <div class="carousel-inner" data-bottom-center="background-position: -650px 120px" data-center-center="background-position: -300px 0px;">
                        
                        <div class="item active text-center info">

                            <p>Zdrowe zbilansowane menu  stworzone z myślą o osobach prowadzących aktywny tryb życia, świadomych jak ważne  w życiu jest odżywianie.</p>
                            <p>Dieta oparta na produktach pełnowartościowych wysokiej jakości bez konserwantów , cukru , o niskim IG, podwyższonej zawartości błonnika  dążąca do osiągnięcia i utrzymania smukłej sylwetki oraz świetnego samopoczucia. Dzienny zestaw składa się z 5 zbilansowanych posiłków (możliwość wyboru min 3 posiłków) o zrównoważonej gramaturze makroelementów dla kobiet i mężczyzn.</p>
                            <h3 data-bottom-center="margin-top: 60px" data-center-center="margin-top: 0px">Dzięki konsultacji stworzymy perfekcyjnie dopasowaną diete dla Ciebie  oraz plan postępowania!</h3>
                        
                        </div>   
                                 
                        <div class="item text-center">
                
                            <table class="table margin_t_30 font_26 apolonialight">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>5 posiłków</td>
                                        <td>4 posiłki</td>
                                        <td>3 posiłki</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fa fa-male margin_r_20"></i>Mężczyzna</td>
                                        <td><span class="">75 zł</span></td>
                                        <td>70 zł</td>
                                        <td>65 zł</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-female margin_r_20"></i>Kobieta</td>
                                        <td>65 zł</td>
                                        <td>60 zł</td>
                                        <td>55 zł</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <a href="<?=base_url()?>page/zamowienia" class="btn_shape pull-right margin_t_10"><i class="fa fa-shopping-cart"></i>Zamów dietę</a>
                                    
                            <a class="btn_shape btn_shape_dark pull-right margin_t_10" data-toggle="modal" data-target="#offer_individual_modal">
                            	<i class="fa fa-shopping-cart"></i>Przykładowe menu
                            </a>

                        </div>
                    
                    </div>
                    
                </div>  
                
            </div>
            
        </div>
        
    </div>


    <div class="modal fade" id="offer_individual_modal" tabindex="-1" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border_0">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h1 class="text-center font_50">Dieta INDIVIDUAL</h1>
                </div>
                <div class="modal-body padding_t_0">
                    <div class="text-left font_12 latolight">
                        <strong>Poniedziałek</strong><br />
                        <i class="fa fa-check"></i> &nbsp; Granola  z  kremem kawowym na bazie twarogu<br />
                        <i class="fa fa-check"></i> &nbsp; Spaghetti z indykiem, cukinią i dynią oraz prażonymi  pestkami słonecznika<br />
                        <i class="fa fa-check"></i> &nbsp; Escabeche z kaszą jaglaną oraz brukselką<br />
                        <i class="fa fa-check"></i> &nbsp; Kotleciki z kurczaka, pieczarek i papryki  w sosie  prowansalskim z kaszą pęczak<br />
                        <i class="fa fa-check"></i> &nbsp; Zapiekanka warzywna z indykiem
                        <br /><br />
                        <strong>Wtorek</strong><br />
                        <i class="fa fa-check"></i> &nbsp; Kasza jaglana z  białkowym kremem malinowym<br />
                        <i class="fa fa-check"></i> &nbsp; Sałatka z wędzonym łososiem oraz żytnim pieczywem<br />
                        <i class="fa fa-check"></i> &nbsp; Bitki wołowe w sosie własnym , pełnoziarniste fusili oraz  buraczki z chrzanem<br />
                        <i class="fa fa-check"></i> &nbsp; Spaghetti bolognese<br />
                        <i class="fa fa-check"></i> &nbsp; Krem pomidorowy z kurczakiem
                        <br /><br />
                        <strong>Środa</strong><br />
                        <i class="fa fa-check"></i> &nbsp; Cynamonowe racuszki owsiane z twarogiem oraz jabłkiem<br />
                        <i class="fa fa-check"></i> &nbsp; Sałatka nicejska z makaronem pełnoziarnistym<br />
                        <i class="fa fa-check"></i> &nbsp; Łupacz w sosie miodowo- musztardowym , kuskus pomidorowy oraz  warzywa gotowane<br />
                        <i class="fa fa-check"></i> &nbsp; Gulasz wołowy z kaszą gryczaną  i  kiszonymi ogórkami<br />
                        <i class="fa fa-check"></i> &nbsp; Sałatka Cezar
                        <br /><br />
                        <strong>Czwartek</strong><br />
                        <i class="fa fa-check"></i> &nbsp; Pełnoziarniste pieczywo z pastą jajeczną oraz twarożkiem z papryką i pomidorkami<br />
                        <i class="fa fa-check"></i> &nbsp; Naleśniki bazyliowe z grillowanym kurczakiem i pieczarkami<br />
                        <i class="fa fa-check"></i> &nbsp; Pulpeciki z indyka w sosie pomidorowym z pełnoziarnistym ryżem z grillowanymi warzywami<br />
                        <i class="fa fa-check"></i> &nbsp; Rekin w sosie szpinakowym, makaron pełnoziarnisty oraz warzywa na parze<br />
                        <i class="fa fa-check"></i> &nbsp; Strogonow
                        <br /><br />
                        <strong>Piątek</strong><br />
                        <i class="fa fa-check"></i> &nbsp; Ciasteczka owsiane z truskawkowym kremem białkowym<br />
                        <i class="fa fa-check"></i> &nbsp; Naleśniki ze szpinakiem, kurczakiem oraz serem feta light<br />
                        <i class="fa fa-check"></i> &nbsp; Kotleciki z łososia w sosie  koperkowo - rzodkiewkowym, ryż jaśminowy z dzikim i włoska sałatka<br />
                        <i class="fa fa-check"></i> &nbsp; Kurczak w sosie słodko - kwaśnym, kuskus z groszkiem zielonymi<br />
                        <i class="fa fa-check"></i> &nbsp; Szaszłyki z indyka w imbirze na sałatce z grillowanymi warzywami

                        <br /><br />
                        <strong>Sobota</strong><br />
                        <i class="fa fa-check"></i> &nbsp; Omlet jajeczny z warzywami  oraz pełnoziarnistym pieczywem<br />
                        <i class="fa fa-check"></i> &nbsp; Bakłażan zapiekany z kurczakiem oraz dodatkiem mozarelli podany na kaszy jaglanej ze szpinakiem<br />
                        <i class="fa fa-check"></i> &nbsp; Miruna zapiekana z warzywami, ryż basmati  i sałatka z ogórków<br />
                        <i class="fa fa-check"></i> &nbsp; Roladki duszone z indyka z suszonymi pomidorami i papryką podane na zapiekanym pełnoziarnistym ryżu z warzywami<br />
                        <i class="fa fa-check"></i> &nbsp; Krem kalafiorowo- selerowy  z indykiem
                        <br /><br />
                        <strong>Niedziela</strong><br />
                        <i class="fa fa-check"></i> &nbsp; Sernik<br />
                        <i class="fa fa-check"></i> &nbsp; Przekładanka  kurczakowo - ananasowa na makaronie pełnoziarnistym z sosem jogurtowym oraz płatkami ryżowymi<br />
                        <i class="fa fa-check"></i> &nbsp; Sola duszona w sosie pomidorowym, ryż basmati oraz mix sałat<br />
                        <i class="fa fa-check"></i> &nbsp; Kurczak kapi na makaronie pene rigate, sałatka <br />
                        <i class="fa fa-check"></i> &nbsp; Leczo z soczewicą
    
                    </div>
                    
                    <a href="<?=base_url()?>page/zamowienia" class="btn_shape pull-right margin_t_10"><i class="fa fa-shopping-cart"></i>Zamów dietę</a>
                    
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>

</div>









<div id="offer_shape">

    <div class="container">
        
        <div class="row">
        
        	<div class="col-lg-4"> 
            	
                <img src="<?=base_url()?>img/offer_shape_ico.png" class="ico visible-lg" data-bottom-center="top: 130px; left: -100px" data-center-center="top: -30px; left: -300px" data-top-center="top: 0px; left: -250px"/>
                
            </div>
            
            <div class="col-lg-8">              
                                    
                <h1 class="text-center margin_t_80">Dieta SHAPE</h1>
                                    
                <div id="offer_shape_carousel" class="offer_carousel slide" data-ride="carousel">
                
                    <div class="carousel-inner" data-bottom-center="background-position: -650px 120px" data-center-center="background-position: -300px 0px;">
                        
                        <div class="item active text-center info">

                            <p class="font_white">Stworzona z myślą o sportowcach, osobach bardzo aktywnych fizycznie: trenujących siłowo, wytrzymałościowo oraz wydolnościowo, chcących osiągnąć jak najmniejszy poziom  tkanki tluszczowej, nadbudować masę mięśniową! To  zindywidualizowana i zbilansowana dieta oparta na produktach najwyższej jakości, nad którą stale czuwamy poprzez konsultację. Spełnimy wszystkie Twoje wymagania!</p>

                            <h3 data-bottom-center="bottom: -30px" data-200-center="bottom: 0px">W drodze na sam szczyt kazda wskazowka jest bardzo cenna!</h3>
                        
                        </div>   
                                 
                        <div class="item text-center">
                
                            <table class="table margin_t_30 font_24 apolonialight font_white">
                            	<thead>
                                    <tr>
                                        <td></td>
                                        <td>5 posiłków</td>
                                        <td>4 posiłki</td>
                                        <td>3 posiłki</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>już od</td>
                                        <td>75 zł</td>
                                        <td>70 zł</td>
                                        <td>65 zł</td>
                                    </tr>
                            	</tbody>
                            </table>
                            
                            <a href="<?=base_url()?>page/zamowienia" class="btn_shape pull-right margin_t_10"><i class="fa fa-shopping-cart"></i>Zamów dietę</a>
    
                        </div>
                    
                    </div>
                    
                </div>  
                
            </div>
            
        </div>
        
    </div>
    
</div>












<div id="offer_calories">

    <div class="container">
        
        <div class="row">
        
        	<div class="col-lg-4"> 
            	
                <img src="<?=base_url()?>img/offer_calories_ico.png" class="ico visible-lg" data-bottom-center="top: 400px;left:-30px;width: 200px" data-center-center="top: 40px;left:-180px;width: 540px" data-top-center="top: 100px;left:-150px;width: 480px"/>
                
            </div>
            
            <div class="col-lg-8">              
                                    
                <h1 class="text-center" data-bottom-center="margin-top: -10px" data-center-center="margin-top: 40px">Dieta KALORYCZNA</h1>
                                    
                <div id="offer_calories_carousel" class="offer_carousel slide" data-ride="carousel">
                
                    <div class="carousel-inner" data-bottom-center="background-position: -650px 120px" data-center-center="background-position: -300px 0px;">
                        
                        <div class="item active text-center info">

							<p class="font_brown">
                            	
                         		Dieta kaloryczna jest dedykowana osobom, które chcą pozbyć się tkanki tłuszczowej bądź utrzymać prawidłową masę ciała i odżywiać się zdrowo! Skomponowana jest z 5 posiłków, które dostarczą Twojemu organizmowi wszystkich niezbędnych witamin oraz mikroelementów. Opiera się na produktach wysokiej jakości o niskim IG oraz zwiększonej ilości błonnika, bez konserwantów, cukru oraz soli.  
							   
							</p>
                           

                        </div>   
                                 
                        <div class="item text-center">
                
                            <table class="table margin_t_30 font_24 apolonialight">
                            	<thead>
                                    <tr>
                                        <td></td>
                                        <td>1000</td>
                                        <td>1200</td>
                                        <td>1500</td>
                                        <td>1700</td>
                                        <td>2000</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>5 posiłków</td>
                                        <td>49 zł</td>
                                        <td>54 zł</td>
                                        <td>63 zł</td>
                                        <td>68 zł</td>
                                        <td>73 zł</td>
                                    </tr>
                            	</tbody>
                            </table>
                            
                            <a href="<?=base_url()?>page/zamowienia" class="btn_shape pull-right margin_t_0"><i class="fa fa-shopping-cart"></i>Zamów dietę</a>

            
                        </div>
                    
                    </div>
                    
                </div>  
                
                

                <!-- Nav tabs -->
                <ul class="nav nav-tabs font_48 margin_t_40" id="offer_calories_tab">
                    <li class="active"><a href="#tysiac" data-toggle="tab">1000</a></li>
                    <li><a href="#tysiacdwiescie" data-toggle="tab">1200</a></li>
                    <li><a href="#tysiacpiecset" data-toggle="tab">1500</a></li>
                    <li><a href="#tysiacsiedemset" data-toggle="tab">1700</a></li>
                    <li><a href="#dwatysiace" data-toggle="tab">2000</a></li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content font_16 text-center">
                    <div class="tab-pane active" id="tysiac">Nasi dietetycy pomogą Ci wybrać optymalny dla Ciebie program żywienia!</div>
                    <div class="tab-pane" id="tysiacdwiescie">Nasi dietetycy pomogą Ci wybrać optymalny dla Ciebie program żywienia!</div>
                    <div class="tab-pane" id="tysiacpiecset">Nasi dietetycy pomogą Ci wybrać optymalny dla Ciebie program żywienia!</div>
                    <div class="tab-pane" id="tysiacsiedemset">Nasi dietetycy pomogą Ci wybrać optymalny dla Ciebie program żywienia!</div>
                    <div class="tab-pane" id="dwatysiace">Nasi dietetycy pomogą Ci wybrać optymalny dla Ciebie program żywienia!</div>
                </div>
                
                            
                
            </div>
            
        </div>
        
    </div>
    
</div>










<div id="offer_nogluten">

    <div class="container">
        
        <div class="row">
            
            <div class="col-lg-9">              
                                    
                <h1 class="text-center margin_t_80" data-bottom-center="margin-left: 40px" data-center-center="margin-left: 0px">Dieta BEZGLUTENOWA</h1>
                                    
                <div id="offer_nogluten_carousel" class="offer_carousel slide" data-ride="carousel">
                
                    <div class="carousel-inner">
                        
                        <div class="item active text-center info">

                            <p>Dieta lecznicza przeznaczona dla osób z celiakią. Oprócz nietolerancji glutenu wskazaniem do stosowania diety jest nadwrażliwość na gluten oraz alergia na pszenicę. <br />

Dieta bez tego białka jest też pomocna przy chorobach autoimmunologicznych, m.in. stwardnieniu rozsianym, czy zaburzeniach neurologicznych, takich jak autyzm czy ADHD, także specjalnych potrzebach organizmu, np. w okresie rozwoju, ciąży, karmienia.</p>
                        
                        </div>   
                                 
                        <div class="item text-center">
                
                            <table class="table margin_t_30 font_26 apolonialight">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>5 posiłków</td>
                                        <td>4 posiłki</td>
                                        <td>3 posiłki</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fa fa-male margin_r_20"></i>Mężczyzna</td>
                                        <td><span class="">75 zł</span></td>
                                        <td>70 zł</td>
                                        <td>65 zł</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-female margin_r_20"></i>Kobieta</td>
                                        <td>65 zł</td>
                                        <td>60 zł</td>
                                        <td>55 zł</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <a href="<?=base_url()?>page/zamowienia" class="btn_shape pull-right margin_t_0"><i class="fa fa-shopping-cart"></i>Zamów dietę</a>
            
                        </div>
                    
                    </div>
                    
                </div>  
                
            </div>
            
        
        	<div class="col-lg-3"> 
            	
                <img src="<?=base_url()?>img/offer_nogluten_ico.png" class="ico visible-lg" data-bottom-center="top: 35px; left: -10px; opacity: 1" data-center-center="top: 35px; left: 20px; opacity: 1" data-top-center="top: 35px; left: 0px; opacity: 1"/>
                
            </div>
            
        </div>
        
    </div>
    
</div>




<div id="offer_vegetarian">

    <div class="container">
        
        <div class="row">
        
        	<div class="col-lg-4 text-center"> 
            	<div class="div_fork visible-lg">
                	<img src="<?=base_url()?>img/offer_vegetarian_ico_1.png" class="ico fork" data-bottom-center="top: 100px;" data-center-center="top: 0px;" data-top-center="top: 30px;"/>
                </div>
                <img src="<?=base_url()?>img/offer_vegetarian_ico_2.png" class="ico visible-lg" data-bottom-center="bottom: -30px;transform:rotate(0deg);" data-center-center="bottom: -80px;transform:rotate(0);"  />
                
            </div>
            
            <div class="col-lg-8">              
                                    
                <h1 class="text-center" data-bottom-center="margin-top: 60px" data-center-center="margin-top: 100px">Dieta WEGETARIAŃSKA</h1>
                                    
                <div id="offer_vegetarian_carousel" class="offer_carousel slide" data-ride="carousel">
                
                    <div class="carousel-inner">
                        
                        <div class="item active text-center info">

                            <p class="margin_b_0">
                            	Dieta z wykluczeniem lub ograniczeniem białka zwierzęcego.
                            </p>
                            
                            <h3>Dostępna również w wariantach dla</h3>
                            
                            <div class="row font_24 apolonialight nowrap">
                            	<div class="col-md-4">
                                	<i class="fa fa-check"></i> &nbsp; Laktoowowegetarian
                                </div>
                                <div class="col-md-4">
                                	<i class="fa fa-check"></i> &nbsp; Laktowegetarian
                                </div>
                                <div class="col-md-4">
                                	<i class="fa fa-check"></i> &nbsp; Owowegetarian
                                </div>
                            </div>
                        
                        </div>   
                                 
                        <div class="item text-center">
                
                            <table class="table margin_t_20 margin_b_10 font_26 apolonialight">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>5 posiłków</td>
                                        <td>4 posiłki</td>
                                        <td>3 posiłki</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fa fa-male margin_r_20"></i>Mężczyzna</td>
                                        <td><span class="">75 zł</span></td>
                                        <td>70 zł</td>
                                        <td>65 zł</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-female margin_r_20"></i>Kobieta</td>
                                        <td>65 zł</td>
                                        <td>60 zł</td>
                                        <td>55 zł</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <a href="<?=base_url()?>page/zamowienia" class="btn_shape pull-right margin_t_0"><i class="fa fa-shopping-cart"></i>Zamów dietę</a>
            
                        </div>
                    
                    </div>
                    
                </div>  
                
            </div>
            
        </div>
        
    </div>
    
</div>









<div id="offer_business" class="margin_t_50 margin_b_50">

    <div class="container">
        
        <div class="row">
        
        	<div class="col-lg-6 text-center"> 
                <img src="<?=base_url()?>img/offer_business_ico.png" class="ico margin_l_40 visible-lg" data-bottom-center="bottom: -30px;transform:rotate(-45deg);" data-center-center="bottom: -80px;transform:rotate(0);" />
                
            </div>
            
            <div class="col-lg-6">              
                                    
                <h1 class="text-center margin_t_60">Oferta dla firm</h1>
                                    
                <div id="offer_business_carousel" class="offer_carousel slide" data-ride="carousel">
                
                    <div class="carousel-inner">
                        
                        <div class="item active text-center info">

                            <p>
                            	Specjalna oferta przygotowana indywidualnie zgodnie z wymaganiami, oraz oczekiwaniami klienta.
                            </p>
                            
                            <a href="<?=base_url()?>page/kontakt" class="btn_shape pull-right"><i class="fa fa-phone"></i>Skontaktuj się</a>
                        
                        </div>   
                                 
                       
                    
                    </div>
                    
                </div>  
                
            </div>
            
        </div>
        
    </div>
    
</div>


<div class="container">

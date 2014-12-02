<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Admina</a></li>
    <li><a href="<?=base_url()?>admin/structure" class="label label-default">Struktura strony</a></li>
    <li class="active">Edycja</li>
</ol>

<h3 class="margin_0 margin_b_30">
	<? if($this->uri->segment(3) == 'edit') { ?>
    	Struktura strony, edytujesz: <?=($page->name)?$page->name:'<i>brak tytułu</i>'?>
    <? } else { ?>
    	Struktura strony, dodajesz nowy
    <? } ?>
</h3>

<div id="editor_form_message"></div>

<form id="editor_form" method="POST" action="">

	<input type="hidden" name="module_id" value="<?=(isset($page->structure_id))?$page->structure_id:0?>" />
    <input type="hidden" name="module" value="structure" />

    <div class="row">
    
    	
        
        <div class="col-md-9">
        
        	<div class="alert alert-success hide" id="message">
           
           		Zmiany zostały zapisane!
            
            </div>
        
            <div class="form-group">
                <label for="name">Tytuł</label>
                <input type="text" name="name" id="name" class="form-control ajax_save" value="<?=(isset($page->name))?$page->name:''?>" placeholder="Tytuł">
            </div>

			
            <? 

			echo $this->load->view('admin/_elements/elements', array(	'module' => 'structure',
																		'module_id' => $page->structure_id,
																		'page' => $page, 
																		'page_elements' => $page_elements, 
																		'page_elements_photos' => $page_elements_photos, 
																		'files_list' => $files_list, 
																		'answers_list' => $answers_list, 
																		'config' => array(	'gallery'=>1,
																							'text'=>1,
																							'folder'=>0,
																							'video'=>0,
																							'quote'=>0,
																							'poll'=>0)
																						), 
								true);
								
									
			?>
        
        	<hr />
            
            <div class="btn-group pull-right">
                
                <a class="btn btn-danger btn-lg" href="<?=base_url()?>admin/structure/remove/<?=$page->structure_id?>"><i class="glyphicon glyphicon-trash"></i></a>
                <a class="btn btn-danger btn-lg" href="<?=base_url()?>admin/structure/remove/<?=$page->structure_id?>"> Usuń </a>
                
            </div>
            
        
            <div class="btn-group">
                
                <button type="button" name="save" class="btn btn-success btn-lg btn_save_editor"><i class="glyphicon glyphicon-floppy-saved"></i></button>
                <button type="button" name="save" class="btn btn-success btn-lg btn_save_editor"> Zapisz! </button>
                
            </div>
            
            
            
            <hr />
            
        </div>
        
        <div class="col-md-3">
        
            <div class="form-group">
                <label for="template">Szablon strony</label>
                <select name="template" id="template" class="form-control ajax_save">
                	<? if(count($templates) > 0) { ?>
						<? foreach($templates as $t) { ?>
                        	<option value="<?=$t->structure_template_id?>" <?=($t->structure_template_id == $page->template)?'selected':''?>><?=$t->name?></option>
                        <? } ?>
                	<? } ?>
                </select>
            </div>
            <hr />
            <div class="form-group">
            
                <label for="parent_id">Strona nadrzędna</label>
                <select name="parent_id" id="parent_id" class="form-control ajax_save">
                	<option value="0"> -- brak -- </option>
                	<? if(count($pages) > 0) { ?>
						<? foreach($pages as $p) { ?>
                        	<option value="<?=$p->structure_id?>" <?=($p->structure_id == $page->parent_id)?'selected':''?>><?=str_repeat(" &nbsp; &nbsp; ", $p->depth)?><?=$p->name?></option>
                        <? } ?>
                	<? } ?>
                </select>
                
            </div>
        	<hr />
             <div class="form-group">
                <label for="lang">Język</label>
                <select name="lang" id="lang" class="form-control ajax_save">
                	<option value="pl"> Polski </option>
                </select>
            </div>
            <hr />
      		<div class="form-group">
                <label>Publikacja</label>
                
                <div class="radio">
                    <label>
                        <input type="radio" name="publication" id="publication" class="ajax_save" value="0" <?=($page->publication == 0)?'checked':''?>>
                        Nie publikuj
                    </label>
                </div>
                
                <div class="radio">
                    <label>
                        <input type="radio" name="publication" id="publication" class="ajax_save" value="1" <?=($page->publication == 1)?'checked':''?>>
                        Publikuj
                    </label>
                </div>
       		</div>
           	<hr /> 
            <div class="form-group">
                <label for="">Wyświetlanie strony</label>
                
                <div class="checkbox">
                    <label>
                    	<input type="checkbox" name="in_menu" class="ajax_save" value="1"<?=($page->in_menu == 1)?'checked':''?>> Pokaż w głównym menu
                    </label>
                </div>
                        
                
            </div>
            <?php /*?>
           	<hr />
            <div class="form-group">
                <label for="author">Autor</label>
                <input type="text" name="author" id="author" class="form-control ajax_save" value="<?=(isset($page->author))?$page->author:''?>" placeholder="Autor">
            </div>
            <?php */?>
            <hr />
            <div class="form-group">
                <label for="added">Data dodania</label>
                <input type="text" name="added" id="added" class="dtp form-control ajax_save" value="<?=(isset($page->added))?$page->added:''?>" placeholder="Data dodania">
            </div>
            <hr />
            <div class="form-group">
                <label for="views">Wyświetleń</label>
                <input type="text" name="views" id="views" class="form-control ajax_save" value="<?=(isset($page->views))?$page->views:''?>" placeholder="Wyświetleń">
            </div>
            
            <hr />
            <?php /*?>
            <script type="text/javascript"> 
                
                $(document).ready(function() {		
                    mapaStart();
                });
                
                var mapa;
                function mapaStart() {  
				
                    var wspolrzedne = new google.maps.LatLng(<?=$wynik['dane_adres']?>);
                    var opcjeMapy = {
                      zoom: 10,
                      center: wspolrzedne,
                      disableDefaultUI: true,
                      navigationControl: true,
                      mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    mapa = new google.maps.Map(document.getElementById("form_mapka"), opcjeMapy);

                    var opcjeMarkera =
                    {
                        position: wspolrzedne,
                        map: mapa,
                        title: 'Aktualny punkt!',
                        draggable: true,
                    }
                    var marker = new google.maps.Marker(opcjeMarkera);
                    
                    google.maps.event.addListener(marker,'dragend',function(zdarzenie) {
                        if(zdarzenie.latLng)  {
							var latlng = zdarzenie.latLng.toString();
                            var wynik = latlng.replace("(", "").replace(")", "");
                            $('#dane_adres').val(wynik);
                        }
                    });
                                                        
                } 
            
            </script>  

            <div class="form-group">
                <label for="views">Adres Mapy Google</label>
                
                <input type="text" name="map" id="map" class="form-control ajax_save margin_b_20" value="<?=(isset($page->map))?$page->map:''?>" placeholder="Współrzędne">
                
                <div id="form_mapka" style="height: 250px; border: 1px solid black;"></div>
                
            </div>
            <?php */?>
                   
            
            
             
        </div>
    
    </div>
                

</form>
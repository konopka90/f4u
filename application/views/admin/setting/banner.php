<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Admina</a></li>
    <li><a href="<?=base_url()?>">Ustawienia</a></li>
    <li class="active">Ustawienia bannerów</li>
</ol>

<div class="row">
    <div class="col-md-12">
    
    	<h3 class="margin_0 margin_b_20"><i class="glyphicon glyphicon-pencil"></i>&nbsp; Ustawienia bannerów</h3>

        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
        
		<form id="editor_form">

            <style>
				#editor_form .btn_remove_element[data-type="gallery"] {
					display: none;	
				}
			</style>
        
			<? if(isset($page_elements)) { ?>
                <? foreach($page_elements as $row) { ?>
                    <div class="margin_b_20">
                        <? if($row->type == 'gallery') { ?>
                            
                            <?=$this->load->view('admin/_elements/gallery_box', array ('element_id' => $row->element_id, 'gallery_id' => $row->gallery_id, 'page_elements_photos' => $page_elements_photos), true)?>
                            
                        <? } ?>
                    </div>
                <? } ?>
            <? } ?>
        
        </form>
        
    </div>
</div>


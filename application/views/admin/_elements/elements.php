<? if(isset($page_elements)) { ?>
	<? foreach($page_elements as $row) { ?>
    	<div class="margin_b_20">
			<? if($row->type == 'text') { ?>
                <?=$this->load->view('admin/_elements/text_box', array ('element_id' => $row->element_id, 'text'=>$row->text), true)?>
            <? } elseif($row->type == 'gallery') { ?>
            	
                <?=$this->load->view('admin/_elements/gallery_box', array ('element_id' => $row->element_id, 'gallery_id' => $row->gallery_id, 'page_elements_photos' => $page_elements_photos), true)?>
                
            <? } elseif($row->type == 'folder') { ?>
                <?=$this->load->view('admin/_elements/folder_box', array ('element_id' => $row->element_id, 'folder_id' => $row->folder_id, 'files_list' => $files_list), true)?>
            <? } elseif($row->type == 'quote') { ?>
                <?=$this->load->view('admin/_elements/quote_box', array ('element_id' => $row->element_id, 'quote_id'=> $row->quote_id, 'author' => $row->author, 'quote' => $row->quote), true)?>
            <? } elseif($row->type == 'video') { ?>
                <?=$this->load->view('admin/_elements/video_box', array ('element_id' => $row->element_id, 'video_id'=> $row->video_id, 'url' => $row->url, 'desc' => $row->video_desc), true)?>
            <? } elseif($row->type == 'poll') { ?>
                <?=$this->load->view('admin/_elements/poll_box', array ('element_id' => $row->element_id, 'poll_box'=> $row->poll_box, 'question' => $row->question, 'desc' => $row->poll_desc, 'answers_list' => $answers_list), true)?>
            <? } ?>
        </div>
	<? } ?>
<? } ?>

<div id="elements"></div>

<div class="margin_t_20">
    <? if($config['text']) { ?>
        <a class="btn_add_element btn btn-default btn-xs" data-module="<?=$module?>" data-module_id="<?=$module_id?>" data-type="text">Dodaj tekst</a>
    <? } ?>
	<? if($config['gallery']) { ?>
		<a class="btn_add_element btn btn-default btn-xs" data-module="<?=$module?>" data-module_id="<?=$module_id?>" data-type="gallery">Dodaj galerię</a>
    <? } ?>
    <? if($config['folder']) { ?>
        <a class="btn_add_element btn btn-default btn-xs" data-module="<?=$module?>" data-module_id="<?=$module_id?>" data-type="folder">Dodaj folder</a>
    <? } ?>
    <? if($config['video']) { ?>
        <a class="btn_add_element btn btn-default btn-xs" data-module="<?=$module?>" data-module_id="<?=$module_id?>" data-type="video">Dodaj film</a>
    <? } ?>
    <? if($config['quote']) { ?>
        <a class="btn_add_element btn btn-default btn-xs" data-module="<?=$module?>" data-module_id="<?=$module_id?>" data-type="quote">Dodaj cytat</a>
    <? } ?>
    <? if($config['poll']) { ?>
        <a class="btn_add_element btn btn-default btn-xs" data-module="<?=$module?>" data-module_id="<?=$module_id?>" data-type="poll">Dodaj ankiete</a>
    <? } ?>
</div>	
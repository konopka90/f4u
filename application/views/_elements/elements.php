<div class="elements">

	<? if(count($elements) > 0) { ?>
    
    	<?

			$photo_thumbs_size = '103px';
			$photo_medium_size = '209px';
			$photo_big_size = '100%';
			
			$videos = array();
		
		?>
    
		<? foreach($elements as $i => $e) { ?>
        
            <? if($e->type == 'text') { ?>
            
                <?=$e->text?>
                
            <? } elseif($e->type == 'gallery') { ?>
            	
                <? if(count($page_elements_photos[$e->gallery_id]) > 0) { ?>
					<? foreach($page_elements_photos[$e->gallery_id] as $photo_id => $p) { ?>
                    
    
                        <? if(file_exists(FCPATH . 'img/upload/' . $p->file)) { ?>
                    
                            <? if($p->option == 'thumb') { ?>
                            
                                <a class="fancybox image" rel="gallery" href="<?=base_url().'img/upload/original/'.$p->file?>" title="<?=$p->desc?>">
                                
                                    <img class="img-polaroid img-rounded" src="<?=base_url().'img/upload/thumbs/'.$p->file?>" width="<?=$photo_thumbs_size?>" alt="<?=$p->desc?>"/>
                                    
                                </a>
                                
                            <? } elseif($e->option == 'medium') { ?>
                            
                                <a class="fancybox image" rel="gallery" href="<?=base_url().'img/upload/original/'.$p->file?>" title="<?=$p->desc?>">
                                
                                    <? if($no_lazy == true) { ?>
                                        <img src="<?=base_url().'img/upload/'.$p->file?>" width="<?=$photo_medium_size?>" class="img-polaroid img-rounded" alt="<?=$p->desc?>" />
                                    <? } else { ?>
                                        <img class="lazy img-polaroid img-rounded" data-original="<?=base_url().'img/upload/'.$p->file?>" src="<?=base_url()?>img/preloader_square.gif" data-width="<?=$photo_medium_size?>" width="24px" alt="<?=$p->desc?>"/>
                                        
                                        <noscript><img src="<?=base_url().'img/upload/'.$p->file?>" width="<?=$photo_medium_size?>" class="img-polaroid img-rounded" alt="<?=$p->desc?>" /></noscript>
                                    <? } ?>
                                    
                                </a>
                                
                            <? } else { ?>
                       
                                <a class="fancybox image" rel="gallery" href="<?=base_url().'img/'.$p->original_path?>" title="<?=$p->desc?>">
                                
                                    <? if($no_lazy == true) { ?>
                                        <img src="<?=base_url().'img/'.$p->original_path?>" width="<?=$photo_big_size?>" />
                                    <? } else { ?>
                                        <img class="<?=($no_lazy == true)?'':'lazy'?>" data-original="<?=base_url().'img/'.$p->original_path?>" src="<?=base_url()?>img/preloader_square.gif" data-width="<?=$photo_big_size?>" width="24px" />
                                    
                                        <noscript><img src="<?=base_url().'img/'.$p->original_path?>" width="<?=$photo_big_size?>" /></noscript>
                                    <? } ?>
        
                                </a>
                                
                                <? if($p->desc) { ?>
                                    <p class="muted text-center"><?=$p->desc?></p>
                                <? } ?>
                            
                            <? } ?>
                
                        <? } ?>
                    <? } ?>
            	 <? } ?>    
            <? } elseif($e->type == 'folder') { ?>
            
            	<? if(file_exists(FCPATH . 'files/' . $e->file)) { ?>
                
                    <div class="media file">
                        <div class="icon pull-left">
                            <img src="<?=base_url()?>img/files/<?=get_extension($e->file)?>.png" />
                        </div>
                        <div class="media-body">
                            <a href="<?=base_url()?>plik/<?=$e->file_id?>"> 
                                <h5 class="no_margin_bottom oranged"><?=substr($e->file, 11, strlen($e->file))?></h5>
                                <? if($e->desc) { ?>
                                    <h6 class="no_margin_top"><?=$e->desc?></h6>
                                <? } ?>
                            </a>
                        </div>
                    </div>
                    
             	<? } ?>
    
            <? } elseif($e->type == 'movie') { ?>
            
            
                <div class="ytplayer" id="ytplayer-<?=$e->element_id?>"></div>
                
                <? array_push($videos, $e); ?>

				<? if($e->option) { ?>
                    <p class="muted text-center video_p"><?=$e->option?></p>
                <? } ?> 

            <? } ?>
            
        <? } ?>
        
        <? if(count($videos) > 0) { ?>
        
    		<script>

				var tag = document.createElement('script');
				tag.src = "//www.youtube.com/iframe_api";
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

				<? foreach($videos as $e) { ?>
					var player<?=$e->element_id?>;
				<? } ?>	
			
				function onYouTubeIframeAPIReady() {
					
					<? foreach($videos as $e) { ?>
						player<?=$e->element_id?> = new YT.Player('ytplayer-<?=$e->element_id?>', {
							height: '380',
							width: '100%',
							videoId: '<?=linkifyYouTubeURLs($e->text)?>'
						});
					<? } ?>

				}
				
			</script>

        <? } ?>
        
    <? } else { ?>

    	<?=$this->load->view('_elements/message', array('message' => 'Brak zawartości.', 'message_status' => 1), true)?>
    	
    <? } ?>
    
</div>
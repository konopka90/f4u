<div class="modal fade" id="modal_newsletter_read_<?=$newsletter->newsletter_id?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 650px;">
        <div class="modal-content">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title">Podgląd newslettera</h4>
            </div>
            
            <div class="modal-body watermark text-left padding_0">

 				<?=$this->load->view('_elements/email', array('config' => $config, 'title'=>'<h2 style="margin-top: 0">'.$newsletter->title.'</h2>', 'text'=>$newsletter->text. "<p>Pozdrawiamy!</p>"), true)?>

            </div>
            
            <div class="modal-footer margin_t_0">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Zamknij</button>
            </div>
            
        </div>
    </div>
</div>
 
 
 
 
 
 
 
 
 
 
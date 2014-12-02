<div class="modal fade" id="modal_user_message_<?=$usera->user_id?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title">Formularz kontaktowy z użytkownikiem <?=$usera->name_surname?></h4>
            </div>
            
            <div class="modal-body watermark text-left">
    
				<?=$this->load->view('admin/user/message_form', array('usera' => $usera), true)?>
                    
            </div>
            
            <div class="modal-footer margin_t_0">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zamknij</button>
            </div>
            
        </div>
    </div>
</div>
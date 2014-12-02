<div class="modal fade" id="modal_food_form_<?=$order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title">Formularz żywieniowy dla zamówienia <?=$order->order_number?> (<?=$order->name_surname?>)</h4>
            </div>
            
            <div class="modal-body watermark text-left">
    
                <?=$this->load->view('admin/order/food_form', array('food_form' => $food_form), true)?>
            
            </div>
            
            <div class="modal-footer margin_t_0">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Zamknij</button>
            </div>
            
        </div>
    </div>
</div>
 
 
 
 
 
 
 
 
 
 
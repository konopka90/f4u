<div class="modal fade" id="modal_order_payment_<?=$order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title">Szczegóły płatności za zamówienie <?=$order->order_number?></h4>
            </div>
            
            <form class="form-horizontal" method="POST" action="<?=base_url()?>admin/order/payment/<?=$order->order_id?>" role="form">
            
                <div class="modal-body watermark text-left">

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Status płatności <span>*</span></label>
                        <div class="col-sm-8">
                            <select name="payment" class="form-control" required>
                                <option value=""> -- wybierz -- </option>
                                <? foreach(dotpay_values() as $id => $dv) { ?>
                                    <option value="<?=$id?>" <?=($order->payment == $id)?'selected':''?>><?=$dv[0]?></option> 
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Data płatności</label>
                        <div class="col-sm-8">
                            <input type="text" name="payment_date" class="dtp form-control" placeholder="Data płatności" value="<?=$order->payment_date?>">
                        </div>
                    </div>
                    
                   
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kanał płatności</label>
                
                        <div class="col-sm-8">
                            <select name="payment_channel" class="form-control">
                                <option value=""> -- wybierz -- </option>
                                <? foreach(dotpay_channels_values() as $id => $name) { ?>
                                    <option value="<?=$id?>" <?=($order->payment_channel == $id)?'selected':''?>><?=$name?></option> 
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    
                
                
                </div>
                
                <div class="modal-footer margin_t_0">
                
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success" name="save" value="1">Zapisz i zamknij</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Zamknij</button>
                    </div>     
                </div>
            
            </form>
            
        </div>
    </div>
</div>
 
 
 
 
 
 
 
 
 
 
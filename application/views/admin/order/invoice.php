<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
    <li><a href="<?=base_url()?>admin/order" class="label label-primary">Zamówienia</a></li>
    <li class="active">Edycja faktury za zamówienie <?=$order->order_number?></li>
</ol>

<div class="row margin_t_10">

    <div class="col-md-12">
        
        <h3 class="margin_0 margin_b_30">Edytujesz fakturę za zamówienie <?=$order->order_number?></h3>

        <form class="form-horizontal" role="form" method="post" action="<?=base_url()?>admin/order/invoice/<?=$order->order_id?>">
            
            <div class="form-group">
                <label class="col-lg-2 control-label">Status płatności</label>
                <div class="col-lg-10">
					<? $dotpay_values = dotpay_values($order->payment); ?>
                    <span class="label <?=$dotpay_values[1]?>"><?=$dotpay_values[0]?></span>
					<? if($order->payment == 2) { ?>
                        <? $dotpay_channels_value = dotpay_channels_values($order->payment_channel); ?>
                        
                        <span class="margin_l_20"><?=$dotpay_channels_value?></span>
                        <span class="margin_l_20"><?=$order->payment_date?></span>
                        
                    <? } ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-2 control-label">Data wystawienia <span class="muted">*</span></label>
                <div class="col-lg-10">
                    <input type="text" name="invoice_date" class="form-control input-lg dp" placeholder="Data wystawienia" value="<?=$order->invoice_date?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Numer faktury <span class="muted">*</span></label>
                <div class="col-lg-10">
                    <input type="text" name="invoice_number" class="form-control input-lg" placeholder="Numer faktury" value="<?=$order->invoice_number?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-2 control-label">Sposób płatności <span class="muted">*</span></label>
                <div class="col-lg-10">
                	<select name="invoice_payment_method" class="form-control input-lg" required>
                    	<option value=""> -- wybierz -- </option>
						<? foreach(payment_method_values() as $id => $v) { ?>
                       		<option value="<?=$id?>" <?=($order->invoice_payment_method == $id)?'selected':''?>><?=$v[0]?></option> 
                        <? } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-2 control-label">Termin płatności</label>
                <div class="col-lg-10">
                    <input type="text" name="invoice_payment_deadline" class="dp form-control input-lg" placeholder="Termin płatności" value="<?=$order->invoice_payment_deadline?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success btn-lg" name="save" value="1">Zapisz</button>
                        <a href="<?=base_url()?>index.php/admin/order" class="btn btn-default btn-lg">Powrót do zamówień</a>
                        <a href="<?=base_url()?>cp/order/<?=$order->order_id?>/save" class="btn btn-default btn-lg">Pobierz fakturę</a>
                    </div>
                </div>
            </div>
            
        </form>

        <h3 class="margin_t_30 margin_b_30">Podgląd</h3>
        
        <div class="well well-lg">
        	<?=$invoice?>
        </div>
        
    </div>

</div>


<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
    <li class="active"><span class="label label-primary">Catering</span></li>
</ol>

<div class="row">
    <div class="col-md-12">
        
        <a href="<?=base_url()?>admin/order/create" class="btn btn-primary pull-right btn-xs"><i class="glyphicon glyphicon-plus"></i> Dodaj nowe zamówienie</a>
        
		<h3 class="margin_0 margin_b_20"><i class="glyphicon glyphicon-cutlery"></i>&nbsp; Zamówienia cateringu</h3>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>  

        <form method="post" action="<?=current_url()?>" class="form margin_b_5 clearfix">
            <div class="input-group">
                <input type="text" class="orders_filter_dr form-control" name="orders_range" id="orders_range" value="<?=$this->session->userdata('orders_start')?> do <?=($this->session->userdata('orders_end'))?$this->session->userdata('orders_end'):'teraz'?>" required/>
                <div class="input-group-btn">
                
                    <button type="submit" class="btn btn-primary" name="save" value="1"><i class="glyphicon glyphicon-search tooltipa" title="Pokaż dostawy<br>w wybrane dni"></i></button>
                    
                    <button type="submit" class="btn btn-danger" name="reset" value="1"><i class="glyphicon glyphicon-record tooltipa" title="Resetuj na 1 miesiąc do tył"></i></button>
                    
                    <a href="<?=base_url()?>admin/order/download_invoices?v=<?=time()?>" class="btn btn-default"><i class="glyphicon glyphicon-download tooltipa" title="Pobierz faktury za wybrany okres"></i></a>
                    
                </div>
            </div>
        </form>


    </div>
</div>

<?=$this->load->view('admin/order/order_table', array('all_orders' => $all_orders), true)?>
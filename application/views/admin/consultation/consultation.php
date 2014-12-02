<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Admina</a></li>
    <li class="active">Konsultacje</li>
</ol>

<div class="row">
    <div class="col-md-12">
        
		<h3 class="margin_0 margin_b_20">Zamówione konsultacje</h3>
        
		<?=$this->load->view('admin/consultation/consultation_table', array('all_consultations' => $all_consultations), true)?>
        
        
    </div>
</div>


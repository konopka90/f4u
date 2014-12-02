<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Admina</a></li>
    <li class="active">Produkty</li>
</ol>

<h3 class="margin_0 margin_b_30"><i class="glyphicon glyphicon-th-large"></i>&nbsp; Produkty</h3>

<?	class M_Tree_Products extends M_Tree { 
    
        function show_start_li($v, $array) {

        
            echo '<li id="product_'.$v['product_id'].'" data-name="'.$v['name'].'">';
                
                

        }
        
        function show_start_ul($v, $array) {
        
            echo '<ol class="">';

        } 
        
        function show_end_li() { echo '</li>'; }
        function show_end_ul() { echo '</ol>'; }
    
    }
    
    $tree_products = new M_Tree_Products();
	
?>
<div class="row">

	<div class="col-md-6">
    	
        <a href="<?=base_url()?>admin/product/create" class="btn btn-primary pull-right btn-xs"><i class="glyphicon glyphicon-plus"></i> Dodaj nowy produkt konsultacji</a>
        
    	<h4 class="margin_0 margin_b_20"><i class="glyphicon glyphicon-comment"></i> &nbsp; Oferta konsultacji</h4>
        
        <ol class="nav sortable margin_b_20" id="structure_tree">
        
            <? $tree_products->show($products_tree, 'admin/product/product_row', false, $page); ?>
            
        </ol> 
        
	</div>
    <div class="col-md-6 padding_b_20">
    
    	<?php /*?><a href="<?=base_url()?>admin/product/create/catering" class="btn btn-primary pull-right btn-xs"><i class="glyphicon glyphicon-plus"></i> Dodaj nowy produkt cateringu</a><?php */?>
    	<h4 class="margin_0 margin_b_20"><i class="glyphicon glyphicon-cutlery"></i> &nbsp; Oferta cateringu</h4>
        
        <? if(count($products) > 0) { ?>
        	<? foreach($products as $p) { ?>
            
                <div class="well well-sm margin_b_5" id="product_<?=$p->product_id?>" data-name="<?=$p->name?>">
                
                    <div class="btn-group pull-right margin_l_20">
                    
                        <?php /*?><a class="margin_l_10 tooltipa pointer" data-original-title="Edytuj" href="<?=base_url()?>admin/product/update/catering/<?=$p->product_id?>"><i class="glyphicon glyphicon-pencil"></i></a><?php */?>
    
                        <?php /*?><a class="btn_remove_row margin_l_10 tooltipa pointer" data-original-title="Usuń" data-id="<?=$p->product_id?>"><i class="glyphicon glyphicon-trash"></i></a><?php */?>

                    </div>

                    <?php /*?><a href="<?=base_url()?>admin/product/update/catering/<?=$p->product_id?>" /><?php */?>
                        <?=($p->name)?$p->name:'<i>brak tytułu</i>'?> - <strong><?=$p->price_for_day?> zł</strong>
                    <?php /*?></a><?php */?>
                    
                    <p class="margin_0"><?=$p->desc?></p>
                    
                </div>

            <? } ?>
        <? } ?>
    
    </div>
</div>
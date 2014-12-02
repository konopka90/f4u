<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Admina</a></li>
    <li class="active">Struktura strony</li>
</ol>

<a href="<?=base_url()?>admin/structure/add" class="btn btn-primary pull-right btn-xs"><i class="glyphicon glyphicon-plus"></i> Dodaj nową stronę</a>

<h3 class="margin_0 margin_b_30">Struktura strony</h3>

<?	class M_Tree_Structure extends M_Tree { 
    
        function show_start_li($v, $array) {

        
            echo '<li id="structure_'.$v['structure_id'].'" data-ip="'.$v['ip'].'" data-name="'.$v['name'].'">';
                
                

        }
        
        function show_start_ul($v, $array) {
        
            echo '<ol class="">';

        } 
        
        function show_end_li() { echo '</li>'; }
        function show_end_ul() { echo '</ol>'; }
    
    }
    
    $tree_structure = new M_Tree_Structure();
	
?>

<ol class="nav sortable margin_b_20" id="structure_tree">

    <? $tree_structure->show($structure_tree, 'admin/structure/_elements/structure_row', false, $page); ?>
    
</ol> 

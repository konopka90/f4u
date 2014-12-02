<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
    <li class="active"><span class="label label-primary">Użytkownicy</span></li>
</ol>

<div class="row">
    <div class="col-md-12">
        
        <a href="<?=base_url()?>admin/user/create" class="btn btn-primary pull-right btn-xs"><i class="glyphicon glyphicon-plus"></i> Dodaj nowego użytkownika</a>
        
		<h3 class="margin_0 margin_b_20"><i class="glyphicon glyphicon-user"></i>&nbsp; Lista użytkowników</h3>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
        
        <table class="table table-striped table-condensed table-hover table-bordered" id="users_table">
            <thead>
                <tr>
                    <th width="30px">ID</th>
                    <th width="250px">Imię i nazwisko</th>
                    <th width="">Adres email</th>
                    <th width="">Telefon</th>
                    <th width="180px">Rejestracja</th>
                    <th width="">Ostatnio widziany</th>
                    <th width="200px" class="text-right">Opcje</th>
                </tr>
            </thead>
            <tbody>
                <? foreach($users as $u) { ?>
                    <tr class="<?=($u->access == 5)?'success':(($u->access == 4)?'warning':'')?>">
                        <td><?=$u->user_id?></td>
                        <td>
							<?=$u->name_surname?><br />
                            <? if($u->address && $u->postcode && $u->city) { ?>
                           		<?=$u->address?>, <?=$u->postcode?> <?=$u->city?>
                            <? } ?>
                        </td>
                        <td><?=$u->email?></td>
                        <td><?=($u->phone)?$u->phone:'-'?></td>
                        <td><?=($u->joined)?$u->joined:'-'?></td>
                        <td>
							<?=($u->last_seen && $u->last_seen != '0000-00-00 00:00:00')?$u->last_seen:' - '?><br />
                        	<?=$u->last_seen_where?>
                        </td>
                        
                        <td align="right">
                        
                        	<a class="margin_r_10" href="<?=base_url()?>admin/order/create/<?=$u->user_id?>">
                                <i class="font_12 glyphicon glyphicon-plus tooltipa" data-original-title="Dodaj zamówienie"></i>  
                            </a>
                            
                            <a class="pointer margin_r_10 btn_modal" data-id="<?=$u->user_id?>" data-cont="user" data-func="message">
                                <i class="font_12 glyphicon glyphicon-comment tooltipa" data-original-title="Skontaktuj się z użytkownikiem"></i>  
                            </a>
                            
                            <a href="<?=base_url()?>admin/user/details/<?=$u->user_id?>" class="margin_r_10">
                                <i class="font_12 glyphicon glyphicon-info-sign tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Szczegóły użytkownika"></i>
                            </a>
                            
                            <a href="<?=base_url()?>admin/user/update/<?=$u->user_id?>" class="margin_r_10">
                                <i class="font_12 glyphicon glyphicon-pencil tooltipa" data-toggle="tooltip" data-placement="left" data-original-title="Edycja użytkownika"></i>
                            </a>
                            
                            <a href="<?=base_url()?>admin/user/remove/<?=$u->user_id?>" class="margin_r_10 confirm">
                                <i class="font_12 glyphicon glyphicon-remove tooltipa" data-original-title="Usuń (wraz z zamówieniami)"></i>  
                            </a>

                        </td>
                    </tr>
                <? } ?>

            </tbody>
                            
        </table>
        
        <div id="div_user_message"></div>
        
    </div>
</div>


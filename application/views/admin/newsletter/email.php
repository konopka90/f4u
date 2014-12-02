<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>admin">Panel Admina</a></li>
    <li><a href="<?=base_url()?>admin/newsletter" class="label label-primary">Newsletter</a></li>
    <li class="active">Baza adresów email</li>
</ol>

<div class="row">
    <div class="col-md-12">
    
        <div class="row margin_t_20 margin_b_20">
        	<div class="col-md-6">
    			<h3 class="margin_0">Baza adresów email</h3>
            </div>
                
            <div class="col-md-6">

                <form class="form-inline text-right" role="form" method="post" action="<?=current_url()?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name_surname" id="name_surname" placeholder="Imię i nazwisko" required />
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Adres email" required />
                    </div>
                	<button type="submit" class="btn btn-primary" name="add" value="1"><i class="glyphicon glyphicon-plus-sign"></i></button>
                </form>

            </div>
  		</div>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
        
        <table class="table">
            <thead>
                <tr>
                
                    <th width="200px">Adres email</th>
                    <th width="200px">Imię i nazwisko</th>
                    <th>Data dodania do newslettera</th>
                    <th>Data wypisania z newslettera</th>
                    <th class="text-right">Opcje</th>
                </tr>
            </thead>
            <tbody>
            	<? if(count($emails) > 0) { ?>
					<? foreach($emails as $i => $e) { ?>
                        <tr>
                        	
                            <td><?=$e->email?></td>
                            <td><?=($e->name_surname)?$e->name_surname:' - '?></td>
                            <td><?=($e->added)?$e->added:' - '?></td>
    						<td><?=($e->removed)?$e->removed:' - '?></td>
                            <td align="right">

                                <a href="<?=base_url()?>admin/newsletter/email/remove/<?=$e->newsletter_emails_id?>" class="margin_l_10">
                                    <i class="font_12 glyphicon glyphicon-remove tooltipa" data-original-title="Usuń"></i>  
                                </a>

                            </td>
                        </tr>
                    <? } ?>
                <? } else { ?>
					<tr>
                    	<td colspan="5"><i>Brak użytkowników zapisanych do newslettera</i></td>
					</tr>
				<? } ?>
            </tbody>
                            
        </table>
        
    </div>
</div>
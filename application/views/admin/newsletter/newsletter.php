<div class="row">
    <div class="col-md-12">
        <?=$this->load->view('admin/_elements/menu', array(), true)?>
    </div>
</div>

<ol class="breadcrumb">
    <li><a href="<?=base_url()?>">Panel Admina</a></li>
    <li class="active">Newsletter</li>
</ol>

<div class="row">
    <div class="col-md-12">
        
        <h3>Nowy newsletter</h3>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>
        
        <form class="form-horizontal margin_b_30" role="form" method="post" action="<?=current_url()?>">

            <div class="form-group">
            
                <label class="col-lg-2 control-label">Tytuł <span class="muted">*</span></label>
                <div class="col-lg-10">
                    <input type="text" name="title" class="form-control" required />
                </div>    
                
            </div>
            
            <div class="form-group">
            
                <label class="col-lg-2 control-label">Treść <span class="muted">*</span></label>
                <div class="col-lg-10">
                    <textarea name="text" id="newsletter_text" class="ckeditor"></textarea>
                </div>    
                
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Do kogo wysłać <span class="muted">*</span></label>
                <div class="col-lg-10">
                	<h4>Użytkownicy zapisani do newslettera <a class="btn btn-primary btn-xs btn_set_checkbox" data-selector=".saved_to_newsletter" data-value="true">Wszyscy</a> <a class="btn btn-primary btn-xs btn_set_checkbox" data-selector=".saved_to_newsletter" data-value="false">Nikt</a></h4>
                    <? foreach($emails as $e) { ?>
                        
						<h4 class="pull-left margin_r_5 margin_b_10 margin_t_0">
                            <label class="label label-default">
                                <input type="checkbox" name="email[<?=base64_encode($e->email)?>]" id="email[<?=base64_encode($e->email)?>]" value="1" class="saved_to_newsletter"> <span class="font_latolight"><?=$e->email?></span>
                            </label>
           				</h4>
                    
                    <? } ?>
                    <div class="clearfix"></div>
                    <h4 class="clearfix">Użytkownicy zarejestrowani <a class="btn btn-primary btn-xs btn_set_checkbox" data-selector=".registered" data-value="true">Wszyscy</a> <a class="btn btn-primary btn-xs btn_set_checkbox" data-selector=".registered" data-value="false">Nikt</a></h4>
                    <? foreach($emails_users as $eu) { ?>
                        
						<h4 class="pull-left margin_r_5 margin_b_10 margin_t_0">
                            <label class="label label-default">
                                <input type="checkbox" name="email[<?=base64_encode($eu->email)?>]" id="email[<?=base64_encode($e->email)?>]" value="1" class="registered"> <span class="font_latolight"><?=$eu->email?></span>
                            </label>
           				</h4>
                    
                    <? } ?>
                    <div class="clearfix"></div>
                    <p class="margin_t_20 margin_b_20 font_12">
                        <i class="glyphicon glyphicon-exclamation-sign"></i> Powtórki będą ignorowane (email zostanie wysłany raz).
                    </p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success btn-lg" name="send" value="1">Wyślij do wybranych osób</button>
                        <button type="submit" class="btn btn-default btn-lg" name="send_to_me" value="1">Wyślij tylko do mnie</button>
                        <?php /*?><a href="<?=base_url()?>index.php/admin/order" class="btn btn-default btn-lg">Pokaż podgląd</a><?php */?>
                    </div>
                </div>
            </div>
            
        </form>
        
        <hr />
        
		<h3 class="margin_0 margin_b_20">Historia newslettera</h3>
        
        <table class="table">
            <thead>
                <tr>
                    <th width="120px">Data wysłania</th>
                    <th width="200px">Tytuł</th>
                    <th>Wysłano do</th>
                    <th class="text-right">Opcje</th>
                </tr>
            </thead>
            <tbody>
            	<? if(count($newsletters) > 0) { ?>
					<? foreach($newsletters as $n) { ?>
                        <tr>
                            <td><?=date("Y-m-d H:i", strtotime($n->date))?></td>
                            
                            <td><?=$n->title?></td>
                            
                            <td class="font_12">
								<?
									$sended_to = unserialize($n->sended_to);
									if(is_array($sended_to) && count($sended_to) > 0) {
										echo implode(", ", $sended_to);
									} else {
										echo ' - ';
									}
								?>
                            
                            </td>
    
                            <td align="right">
                            
                            	<a class="pointer btn_modal" data-id="<?=$n->newsletter_id?>" data-cont="newsletter" data-func="read">
                                    <i class="font_12 glyphicon glyphicon-list tooltipa" data-original-title="Podgląd"></i>  
                                </a>
                                
                                <a href="<?=base_url()?>admin/newsletter/remove/<?=$n->newsletter_id?>" class="margin_l_10">
                                    <i class="font_12 glyphicon glyphicon-remove tooltipa" data-original-title="Usuń"></i>  
                                </a>

                            </td>
                        </tr>
                    <? } ?>
                <? } else { ?>
					<tr>
                    	<td colspan="3"><i>Brak wysłanych newsletterów</i></td>
					</tr>
				<? } ?>
            </tbody>
                            
        </table>
        
        <div id="div_newsletter_read"></div>
        
    </div>
</div>


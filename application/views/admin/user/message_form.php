<form role="form" action="<?=base_url()?>admin/user" method="post">

	<input type="hidden" name="controler" value="<?=$this->router->fetch_class() . '_' . $this->router->fetch_method()?>" />
    <input type="hidden" name="user_id" value="<?=$usera->user_id?>" />

    <div class="form-group">
        <label>Adres email</label>
        <input type="email" class="form-control" name="email" value="<?=$usera->email?>" placeholder="Adres email">
    </div>
    
    <div class="form-group">
        <label>Treść</label>
        <textarea name="text" id="user_message" class="ckeditor"></textarea>
    </div>
    
    
    <div class="checkbox">
        <label>
            <input type="checkbox" name="copy" value="1"> Wyslij kopię też do mnie (<?=$this->user->email?>)
        </label>
    </div>
    
    <div class="btn-group">
    	<button type="submit" class="btn btn-primary" name="send_email" value="1"><i class="glyphicon glyphicon-send"></i></button>
        <button type="submit" class="btn btn-primary" name="send_email" value="1">Wyślij</button>
    </div>
    
</form>
<div class="row margin_t_30">

	<div class="col-md-3">

	</div>
    

	<div class="col-md-6">
    
		<h2 class="margin_0 margin_b_10 border_b_3 padding_b_10">Przypomnij hasło</h2>
        
        <?=$this->load->view('_elements/message', array('message' => $this->session->flashdata('message'), 'message_status' => $message_status), true)?>  

        <form method="post" action="<?=current_url()?>" class="form-horizontal login_form text-left">
            
            <h4><span class="label label-success">KROK 1 z 2</span> &nbsp; &nbsp; Podaj swój adres email</h4>
            <div class="form-group">
                <div class="col-xs-6">
                    <input type="email" name="email" class="form-control" placeholder="Podaj swój adres email" required>
                </div>
                <div class="col-xs-6">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary my-button" name="send_code" value="1"> Wyślij kod do zmiany hasła </button>
                    </div>
                </div>
            </div>
            
        
        </form>
        
        <p class="margin_b_20 margin_t_20">Na podany przez Ciebie adres email wyślemy kod upoważniający Cię do zmiany hasła - kliknij w niego, lub przepisz do pola poniżej aby zresetować hasło. Nowe hasło zostanie wysłane na email i będziesz mógł się już normalnie zalogować się na konto.</p>
        
        <form method="post" action="<?=current_url()?>" class="form-horizontal login_form text-left margin_b_30">
        
            <h4><span class="label label-success">KROK 2 z 2</span> &nbsp; &nbsp; Wpisz kod który otrzymałeś emailem</h4>
            <div class="form-group">
                <div class="col-xs-6">
                    <input type="password" name="code" class="form-control" placeholder="Wpisz kod który otrzymałeś emailem" required>
                </div>

                <div class="col-xs-6">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success my-button" name="reset_password" value="1"> Zresetuj moje hasło </button>
                    </div>
                </div> 
            </div>
            
        
        </form>  

        

    </div>
    
	<div class="col-md-3">

	</div>
    
</div>
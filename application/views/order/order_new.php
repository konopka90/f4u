<div class="row margin_t_30">
	<div class="row">
		<div class="my-col-a my-col-with-heading"><h1 class="my-heading">Promocje</h1></div>
		<div class="my-col-b"><hr/>
			<p class="grotesk-bold">Zobacz jakie promocje przygotowaliśmy dla Ciebie. Wybierz dogodny dla siebie plan i zaznacz w zamówieniu.</p>
			<p>Informacje o promocjach. Sa dipit et esciaero errumqu aeresequi optatur 
				sunto exerum hitatestia excea nam, cus volore ped mo officab orest, sunt 
				moluptae nihil molorem que precteniam rentur? Qui consedi onestrum que 
				velitemporia venis a nitat de net porrum fugiandite sunto qui quibusam cu
			</p>
			<div class="my-diet-header my-diet-pink my-diet-header-clickable noselect">PROMO 1: SPRÓBUJ I PRZEKONAJ SIĘ  <span class="glyphicon glyphicon-plus my-diet-glyph" aria-hidden="true"></span></div>
			<div class="my-diet-body my-diet-pink hidden">
				<p class="my-diet-paragraph">Przy pierwszym zamówieniu na 3 dni możliwość skorzystania ze specjalnej oferty zniżkowej w cenie X PLN /dzień
				</p>											
			</div>
			<div class="my-diet-header my-diet-purple my-diet-header-clickable noselect">PROMO 2: DŁUŻEJ Z KORZYŚCIĄ <span class="glyphicon glyphicon-plus my-diet-glyph" aria-hidden="true"></span></div>
			<div class="my-diet-body my-diet-purple hidden">
				<p class="my-diet-paragraph">Przy złożeniu zamówienia na okres 20 dni otrzymasz od Nas 1 dzień dostaw w prezencie oraz przy zamówieniu na okres 30 dni otrzymasz 2 dni w prezencie.
				</p>											
			</div>
			<div class="my-diet-header my-diet-blue my-diet-header-clickable noselect">PROMO 3: RAZEM TANIEJ  <span class="glyphicon glyphicon-plus my-diet-glyph" aria-hidden="true"></span></div>
			<div class="my-diet-body my-diet-blue hidden">
				<p class="my-diet-paragraph">Zamawiając dwa zestawy pod jeden adres, w tym samym czasie otrzymujesz wraz z drugą osobą zniżkę w wysokości 10%. Zamówienie diety musi być złożone w tych samych terminach. W przypadku rozłączenia zamówienia, cena wzrasta do cen zamówień indywidualnych.
				</p>		
			</div>

		</div>
	</div>
	<div class="row">
		<div class="my-col-a my-col-with-heading"><h1 class="my-heading">Zamówienia</h1></div>
		<div class="my-col-b">
			<hr/>
			<p class="grotesk-bold">Złóż zamówienie i zostań naszym klientem już dzisiaj!</p>
			<p style="margin-top:30px;">Najpierw sprecyzuj parametry swojego zamówienia, zrobisz to szybciej niż 
				Ci się wydaje! Możesz to zrobić na 3 sposoby - wybierając zakres dni w 
				które chcesz mieć dostawę, wybierając iość posiłków lub wybierając konk-
				retne dni!</p>
			<p style="margin-top:30px;">Wybierz dietę:</p>
				<?=$this->load->view('order/_elements/calculator_new', array('packets_names' => $packets_names, 'user' => $user), true)?>
		</div>

	</div>


</div>
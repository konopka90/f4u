<h3 class="margin_b_30 font_gray">Podsumowanie</h3>

<? if(count($consultation_products) > 0) { ?>
    <div class="well ">
        <table class="table">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Nazwa</th>
                    <th>Cena</th>
                </tr>
            </thead>
            <tbody>
                <? $sum = 0.00; ?>
                <? foreach($consultation_products as $i => $product) { ?>
                    <tr>
                        <td><?=$i + 1?></td>
                        <td><?=$product->name?></td>
                        <td><?=$product->price?> PLN</td>
                        <? $sum += $product->price; ?>
                    </tr>
                <? } ?>
            </tbody>
        
        </table>
        
        <h1 class="text-right"><span style="font-size: 18px;color: #ccc">do zapłaty</span> <span class="label label-danger"><?=$sum?> PLN</span></h1>
        
        <hr />
        
        <div class="text-right">
            <button type="button" class="btn btn-default btn-lg pull-left" id="btn_consultation_prev">&larr; Chcę jeszcze coś zmienić</button>
            <button type="submit" class="btn btn-success btn-lg" id="btn_consultation_buy">Zamawiam i płacę</button>
        </div>
        
    </div>
    
<? } else { ?>

    <button type="button" class="btn btn-default btn-lg" id="btn_consultation_prev">&larr; Musisz dodać coś do koszyka...</button>
    
<? } ?>





<div class="round_5 <?=($d->payment != 2)?'label-warning':(($d->stopped)?'label-danger':'label-success')?> text-center" style="padding: 10px">
    <h3 class="margin_0"><?=date("d", strtotime($d->date))?></h3>
    <h5 class="margin_0"><?=strftime("%B", strtotime($d->date))?></h5>
    <h6 class="margin_0 <?=($d->payment != 2)?'font_orange':(($d->stopped)?'font_red':'font_green')?>"><?=strftime("%A", strtotime($d->date))?></h6>
</div>
<?php /*?><h6 class="text-center margin_b_0"><?=$d->number?>. dzień</h6><?php */?>
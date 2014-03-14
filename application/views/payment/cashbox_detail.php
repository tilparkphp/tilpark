<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>"><?php lang('Dashboard'); ?></a></li>
	<li><a href="<?php echo site_url('payment'); ?>">Kasa</a></li>
    <li><a href="<?php echo site_url('payment/cashbox'); ?>">Kasa Yönetimi</a></li>
	<li class="active"><?php echo $cashbox['key']; ?> Detayları</li>
</ol>

<h3 class="title"><i class="fa fa-puzzle-piece"></i> <?php echo $cashbox['key']; ?></h3>

<table class="table table-bordered table-hover table-condensed dataTable fs-12">
	<thead>
    	<tr>
        	<th class="hide"></th>
        	<th width="20"><?php lang('ID'); ?></th>
            <th width="100"><?php lang('Date'); ?></th>
            <th width="50">G/Ç</th>
            <th>Hesap Kartı</th>
            <th width="100">Ödeme Türü</th>
            <th>Açıklama</th>
            <th>Diğer</th>
            <th width="80">Giriş</th>
            <th width="80">Çıkış</th>
            <th width="80">Ara Toplam</th>
        </tr>
    </thead>
    <tbody>   
    <?php $sub_total = 0; ?> 
    <?php foreach($payments as $payment): ?>
    	<?php $account = get_account($payment['account_id']); ?>
    	<tr>
        	<td class="hide"></td>
        	<td><a href="<?php echo site_url('invoice/view/'.$payment['id']); ?>">#<?php echo $payment['id']; ?></a></td>
            <td class="fs-11"><?php echo substr($payment['date'],0,16); ?></td>
            <td class="fs-11"><?php echo get_text_in_out($payment['in_out']); ?></td>
            <td><a href="<?php echo site_url('account/get_account/'.$payment['account_id']); ?>" target="_blank"><?php echo $account['name']; ?></a></td>
            <td><?php echo get_text_payment($payment['val_1']); ?></td>
            <td><?php echo mb_substr($payment['description'],0,30,'utf-8'); ?></td>
            <td><?php echo $payment['val_2']; ?> <?php echo $payment['val_4']; ?></td>
            <?php if($payment['in_out'] == 'in'): ?>
            	<?php $sub_total = $sub_total + $payment['grand_total']; ?>
            	<td class="text-right"><?php echo get_money($payment['grand_total']); ?></td>
                <td></td>
            <?php elseif($payment['in_out'] == 'out'): ?>
            	<?php $sub_total = $sub_total - $payment['grand_total']; ?>
            	<td></td>
            	<td class="text-right"><?php echo get_money($payment['grand_total']); ?></td>
            <?php endif; ?>
            <td class="text-right"><?php echo get_money($sub_total); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table> <!-- /.table -->

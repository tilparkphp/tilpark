<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
	<li><a href="<?php echo site_url('payment'); ?>">Kasa</a></li>
    <li><a href="<?php echo site_url('payment/lists'); ?>">Ödeme Listesi</a></li>
	<li class="active">
		<?php if($form['in_out'] == 'in'): ?>
            Tahsilat
        <?php else: ?>
            Ödeme
        <?php endif; ?>
        #<?php echo $form['id']; ?>
    </li>
</ol>


<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#transactions" data-toggle="tab">İşlemler</a></li>
    <li class=""><a href="#history" data-toggle="tab">Geçmiş</a></li>
    <li class="dropdown">
		<a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown">Seçenekler <b class="caret"></b></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
			<li><a href="<?php echo site_url('user/new_message/?invoice_id='.$form['id']); ?>"><span class="glyphicon glyphicon-envelope mr9"></span><?php lang('New Message'); ?></a></li>
            <li><a href="<?php echo site_url('user/new_task/?invoice_id='.$form['id']); ?>"><span class="glyphicon glyphicon-globe mr9"></span><?php lang('New Task'); ?></a></li>
            
            <li class="divider"></li>
        	<li><a href="javascript:;" onclick="print_barcode();"><span class="glyphicon glyphicon-print mr9"></span><?php lang('Print Invoice'); ?></a></li>
            
            <?php if(get_the_current_user('role') <= 3): ?>
                <li class="divider"></li>
                <?php if($form['status'] == '1'): ?>
                    <li><a href="?status=0"><span class="glyphicon glyphicon-remove mr9"></span><?php lang('Delete'); ?></a></li>
                <?php else: ?>
                    <li><a href="?status=1"><span class="glyphicon glyphicon-remove mr9"></span><?php lang('Activate'); ?></a></li>
                <?php endif; ?>
            <?php endif; ?>
      </ul>
    </li>
</ul>


<div id="myTabContent" class="tab-content">

<div class="tab-pane fade active in" id="transactions">

<div class="row">
<div class="col-md-8">


	<?php
	if(@$formError) { alertbox('alert-danger', $formError);	 }
	echo @$alert['success'];
	?>

    <form name="form_new_product" id="form_new_product" action="" method="POST" class="validation">
        <h3><i class="fa fa-puzzle-piece"></i><?php if($form['in_out'] == 'in'): ?>
            Tahsilat Formu
        <?php else: ?>
            Ödeme Formu
        <?php endif; ?></h3>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date" class="control-label">Tarih</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        <input type="text" id="date" name="date" class="form-control required datepicker pointer" placeholder="<?php lang('Start Date'); ?>" minlength="3" maxlength="50" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
            <div class="col-md-8">
                <div class="form-group openModal-account_list">
                    <input type="hidden" name="account_id" id="account_id" value="<?php echo $form['account_id']; ?>" />
                    <label for="account_name" class="control-label">Hesap Kartı</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon pointer"><span class="fa fa-user"></span></span>
                        <input type="text" id="account_name" name="account_name" class="form-control required" placeholder="hesap kartı..." value="<?php echo $account['name']; ?>" autocomplete="off">
                    </div>
                </div> <!-- /.form-group -->
                <div class="search_account typeHead"></div>
                <script>
					// hesap karti arama ajax
					$(document).ready(function(e) {
						$('#account_name').keyup(function() {
							$('.typeHead').show();
							$.get("../search_account/"+$(this).val()+"", function( data ) {
							  $('.search_account').html(data);
							});
						});
					});
				</script>
            </div> <!-- /.col-md-8 -->
        </div> <!-- /.row -->
        
        
        <div class="row">
            <div class="col-md-8">
                
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="payment" class="control-label">Ödeme Tutarı</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-try"></span></span>
                        <input type="text" id="payment" name="payment" class="form-control required number" placeholder="0.00" maxlength="10" value="<?php echo get_money($form['grand_total']); ?>" onkeypress="calc_payment();" onkeyup="calc_payment();">
                    </div>
                </div> <!-- /.form-group -->
            </div> <!-- /.col-md-4 -->
        </div> <!-- /.row -->
    
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="payment_type" class="control-label"><?php lang('Payment Type'); ?></label>
                    <select name="payment_type" id="payment_type" class="form-control">
                        <option value="cash" <?php selected($form['val_1'], 'cash'); ?>>Nakit</option>
                        <option value="cheque" <?php selected($form['val_1'], 'cheque'); ?>>Banka Çeki</option>
                        <option value="bank_transfer" <?php selected($form['val_1'], 'bank_transfer'); ?>>Havale/EFT</option>
                    </select>
                    
                    
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                    <label for="payment_type" class="control-label">Kasa veya Banka</label>
                    <select name="cahsbox" id="cahsbox" class="form-control required">
                        <?php $cahsboxs = get_options(array('group'=>'cashbox'), array('order_by'=>'key ASC')); ?>
                        <?php if($cahsboxs): ?>
                        	<optgroup label="Kasalar" id="optgroup_cashbox">
								<?php foreach($cahsboxs as $cahsbox): ?>
                                    <option value="<?php echo $cahsbox['id']; ?>" <?php selected($cahsbox['id'],$form['val_int']); ?> ><?php echo $cahsbox['key']; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                        
                        <?php $banks = get_options(array('group'=>'bank'), array('order_by'=>'key ASC')); ?>
                        <?php if($banks): ?>
                            <optgroup label="Bankalar" id="optgroup_bank">
                                <?php foreach($banks as $bank): ?>
                                    <option value="<?php echo $bank['id']; ?>" <?php selected($bank['id'],$form['val_int']); ?>><?php echo $bank['key']; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                    </select>
                </div> <!-- /.form-group -->
                
                <script>
					function payment_type()
					{
						if($('#payment_type').val() == 'cheque')
							{ 
								$('#bank_info').show('blonde'); 
								$('#cheque_info').show('blonde'); 
								
								$('#optgroup_cashbox').removeAttr('disabled'); 
							}
							else if($('#payment_type').val() == 'bank_transfer')
							{ 
								$('#bank_info').show('blonde'); 
								$('#cheque_info').hide('blonde'); 
								
								$('#optgroup_cashbox').attr('disabled', 'disabled'); 
								$('#optgroup_cashbox option').removeAttr('selected'); 
							}
                            else
							{ 
								$('#bank_info').hide('blonde'); 
								$('#cheque_info').hide('blonde'); 
								
								$('#optgroup_cashbox').removeAttr('disabled'); 
							}
					}
					$('#payment_type').change(function() {
						payment_type();
					});
					
					$(document).ready(function() {
						payment_type();
					});
                    </script>
                
            </div> <!-- /.col-md-4 -->
            <div class="col-md-8">
            
            	<div id="bank_info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_name" class="control-label">Banka Adı</label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-font"></span></span>
                                    <input type="text" id="bank_name" name="bank_name" class="form-control" minlength="2" maxlength="50" value="<?php echo $form['val_2']; ?>">
                                </div>
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branch_code" class="control-label">Şube Adı veya Kodu</label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-font"></span></span>
                                    <input type="text" id="branch_code" name="branch_code" class="form-control" value="<?php echo $form['val_3']; ?>">
                                </div>
                            </div> <!-- /.form-group --> 
                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->
                    
                </div> <!-- /#bank_info --> 
                
                <div id="cheque_info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fall_due_on" class="control-label  "><?php lang('Fall Due On'); ?></label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input type="text" id="fall_due_on" name="fall_due_on" class="form-control   required datepicker pointer" placeholder="<?php lang('Fall Due On'); ?>" minlength="3" maxlength="50" value="<?php echo $form['val_4']; ?>" readonly>
                                </div>
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cheque_serial_no" class="control-label"><?php lang('Serial No'); ?></label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                    <input type="text" id="cheque_serial_no" name="cheque_serial_no" class="form-control" placeholder="<?php lang('Serial No'); ?>" value="<?php echo $form['val_5']; ?>">
                                </div>
                            </div> <!-- /.form-group --> 
                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->
                    
                </div> <!-- /#cheque_info --> 
                <script>
                	$('#bank_info').hide();
					$('#cheque_info').hide();
                </script>
                <div class="form-group">
                    <label for="description" class="control-label  "><?php lang('Description'); ?></label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                        <input type="text" id="description" name="description" class="form-control  " placeholder="<?php lang('Description'); ?>" minlength="3" maxlength="50" value="<?php echo $form['description']; ?>">
                    </div>
                </div> <!-- /.form-group --> 
            </div> <!-- /.col-md-8 -->
        </div> <!-- /.row -->
        
        
        <div class="h20"></div>
        <div class="text-right">
            <input type="hidden" name="log_time" value="<?php echo logTime(); ?>" />
            <input type="hidden" name="update" />
            <button class="btn btn-default">Güncelle &raquo;</button>
        </div> <!-- /.text-right -->
    </form>
    
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
	
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->

<div class="h20"></div>



</div> <!-- /#transactions -->





<div class="tab-pane fade in" id="history">
	<?php get_log_table(array('form_id'=>$form['id']), 'ASC'); ?>
</div> <!-- #history -->

</div> <!-- /#myTabContent -->

<?php calc_account_balance($form['account_id']); ?>
<ol class="breadcrumb">
	<li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
	<li><a href="<?php echo site_url('payment'); ?>">Kasa</a></li>
	<li class="active">
  	<?php if(isset($_GET['in'])): ?>
    	Tahsilat
    <?php else: ?>
    	Ödeme
    <?php endif; ?>
	</li>
</ol>


<div class="row">
<div class="col-md-8">

	<?php
	if(@$formError) { alertbox('alert-danger', $formError);	 }
	echo @$alert['success'];
	?>

    <form name="form_new_product" id="form_new_product" action="" method="POST" class="validation">
        <h3><i class="fa fa-puzzle-piece"></i> Yeni Ödeme - <?php if(isset($_GET['in'])): ?>
            Tahsilat
        <?php else: ?>
            Ödeme
        <?php endif; ?></h3>
        <div class="row">
            <div class="col-md-3">
            
                <div class="form-group">
                    <label for="date" class="control-label  ">Tarih</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        <input type="text" id="date" name="date" class="form-control required datepicker pointer" placeholder="<?php lang('Start Date'); ?>" minlength="3" maxlength="50" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                    <label for="payment_type" class="control-label">Ödeme Türü</label>
                    <select name="payment_type" id="payment_type" class="form-control  ">
                        <option value="cash">Nakit</option>
                        <option value="cheque">Banka Çeki</option>
                        <option value="bank_transfer">Havale/EFT</option>
                    </select>
                </div> <!-- /.form-group -->
                
                <div class="form-group">
                    <label for="payment_type" class="control-label">Kasa veya Banka</label>
                    <select name="cahsbox" id="cahsbox" class="form-control required">
                        <?php $cahsboxs = get_options(array('group'=>'cashbox', 'val_5'=>''), array('order_by'=>'key ASC')); ?>
                        <?php if($cahsboxs): ?>
                        	<optgroup label="Kasalar" id="optgroup_cashbox">
								<?php foreach($cahsboxs as $cahsbox): ?>
                                    <option value="<?php echo $cahsbox['id']; ?>" <?php selected($cahsbox['val_1'],'default'); ?>><?php echo $cahsbox['key']; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                        
                        <?php $banks = get_options(array('group'=>'bank', 'val_5'=>''), array('order_by'=>'key ASC')); ?>
                        <?php if($banks): ?>
                            <optgroup label="Bankalar" id="optgroup_bank">
                                <?php foreach($banks as $bank): ?>
                                    <option value="<?php echo $bank['id']; ?>"><?php echo $bank['key']; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                    </select>
                </div> <!-- /.form-group -->
                
            </div> <!-- /.col-md-3 -->
            <div class="col-md-9">
            
                <div class="form-group">
                    <input type="hidden" name="account_id" id="account_id" value="" />
                    <label for="account_name" class="control-label">Hesap Kartı</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon pointer"><span class="fa fa-user"></span></span>
                        <input type="text" id="account_name" name="account_name" class="form-control required" placeholder="hesap kartı..." value="" autocomplete="off">
                    </div>
                </div> <!-- /.form-group -->
                <div class="search_account typeHead"></div>
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="old_balance" class="control-label">Eski Bakiye</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try"></span></span>
                                <input type="text" id="old_balance" name="old_balance" class="form-control number" placeholder="0.00" value="" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="payment" class="control-label">Ödeme Tutarı</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon"><span class="fa fa-try"></span></span>
                                <input type="text" id="payment" name="payment" class="form-control required number" placeholder="0.00" maxlength="10" value="" onkeypress="calc_payment();" onkeyup="calc_payment();">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="new_balance" class="control-label">Yeni Bakiye</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon pointer"><span class="fa fa-try"></span></span>
                                <input type="text" id="new_balance" name="new_balance" class="form-control number" placeholder="0.00" value="" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                </div> <!-- /.row -->
                
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cashbox_old_balance" class="control-label">Kasa'nın Eski Bakiyesi</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon pointer"><span class="fa fa-archive"></span></span>
                                <input type="text" id="cashbox_old_balance" name="cashbox_old_balance" class="form-control number" placeholder="0.00" value="" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cashbox_new_balance" class="control-label">Kasa'nın Yeni Bakiyesi</label>
                            <div class="input-prepend input-group">
                                <span class="input-group-addon pointer"><span class="fa fa-archive"></span></span>
                                <input type="text" id="cashbox_new_balance" name="cashbox_new_balance" class="form-control   number" placeholder="0.00" value="" readonly="readonly">
                            </div>
                        </div> <!-- /.form-group -->
                    </div> <!-- /.col-md-4 -->
                </div> <!-- /.row -->
                
                
                <div id="bank_info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_name" class="control-label">Banka Adı</label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-font"></span></span>
                                    <input type="text" id="bank_name" name="bank_name" class="form-control" minlength="2" maxlength="50" value="">
                                </div>
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branch_code" class="control-label">Şube Adı veya Kodu</label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-font"></span></span>
                                    <input type="text" id="branch_code" name="branch_code" class="form-control">
                                </div>
                            </div> <!-- /.form-group --> 
                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->
                </div> <!-- /#bank_info --> 
                
                
                <div id="cheque_info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fall_due_on" class="control-label">Vade Tarihi</label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input type="text" id="fall_due_on" name="fall_due_on" class="form-control   required datepicker pointer" minlength="3" maxlength="50" value="<?php echo date('Y-m-d'); ?>" readonly>
                                </div>
                            </div> <!-- /.form-group -->
                        </div> <!-- /.col-md-6 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cheque_serial_no" class="control-label">Seri/Fiş/İşlem No</label>
                                <div class="input-prepend input-group">
                                    <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                                    <input type="text" id="cheque_serial_no" name="cheque_serial_no" class="form-control">
                                </div>
                            </div> <!-- /.form-group --> 
                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->
                </div> <!-- /#cheque_info --> 
                
                <div class="form-group">
                    <label for="description" class="control-label">Açıklama</label>
                    <div class="input-prepend input-group">
                        <span class="input-group-addon"><span class="fa fa-text-width"></span></span>
                        <input type="text" id="description" name="description" class="form-control" minlength="3" maxlength="50" value="">
                    </div>
                </div> <!-- /.form-group --> 
                
            </div> <!-- /.col-md-9 -->
        </div> <!-- /.row -->
        
        
        
        
        <div class="h20"></div>
        <div class="text-right">
            <input type="hidden" name="log_time" value="<?php echo logTime(); ?>" />
            <input type="hidden" name="add" />
            <button class="btn btn-default fs-2"><i class="fa fa-save"></i> Kaydet</button>
        </div> <!-- /.text-right -->
    </form>
    
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
	
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->

<div class="h20"></div>

<script>
$(document).ready(function(e) {
	
	/* hesap kartlarinin ajax aranmasi için kullanıacak fonksiyon */
	$('#account_name').keyup(function() {
		$('.typeHead').show();
		$.get("../search_account/"+$(this).val()+"", function( data ) {
		  $('.search_account').html(data);
		});
	});
	
	/* sayfa ilk yuklendiğinde kapanacak bölümler */
	$('#bank_info').hide();
	$('#cheque_info').hide();
});


/* odeme turu yani "nakit,çek,banka havalesi" gibi değerler değiştiğinde gösterilecek kutular */
$('#payment_type').change(function() {
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
});


/* kasa değiştiğinde çalışacak fonksiyon */
$.changeCashbox = function() {
	var cashbox_id = $('#cahsbox').val();
	var cashboxArray = [];
	<?php foreach($cashboxs as $cashbox): ?>
		cashboxArray[<?php echo $cashbox['id']; ?>] = "<?php echo $cashbox['val_decimal']; ?>";
	<?php endforeach; ?>
	<?php foreach($banks as $bank): ?>
		cashboxArray[<?php echo $bank['id']; ?>] = "<?php echo $bank['val_decimal']; ?>";
	<?php endforeach; ?>
	$('#cashbox_old_balance').val(parseFloat(cashboxArray[cashbox_id]).toFixed(2));
}
$.changeCashbox();
$('#cahsbox').change(function() {
	$.changeCashbox();
});

/* odeme kutularinin hesaplanmasi icin kullanilmaktadir */
function calc_payment()
{
	var old_balance = $('#old_balance').val(); old_balance = old_balance.replace(',','');
	var cashbox_old_balance = $('#cashbox_old_balance').val(); old_balance = old_balance.replace(',','');
	var payment = $('#payment').val();
	
	if(old_balance == ''){old_balance = 0;}
	if(payment == ''){payment = 0;}
	
	<?php if(isset($_GET['in'])): ?>
		var new_balance = parseFloat(old_balance) - parseFloat(payment);
		var new_cashbox_balance = parseFloat(cashbox_old_balance) + parseFloat(payment);
		$('#new_balance').val(parseFloat(new_balance).toFixed(2));
		$('#cashbox_new_balance').val(parseFloat(new_cashbox_balance).toFixed(2));
	<?php else: ?>
		var new_balance = parseInt(old_balance) + parseFloat(payment);
		var new_cashbox_balance = parseFloat(cashbox_old_balance) - parseFloat(payment);
		$('#new_balance').val(parseFloat(new_balance).toFixed(2));
		$('#cashbox_new_balance').val(parseFloat(new_cashbox_balance).toFixed(2));
	<?php endif; ?>
}
</script>
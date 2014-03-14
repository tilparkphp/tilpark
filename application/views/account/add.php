<ol class="breadcrumb">
  <li><a href="<?php echo site_url(); ?>"><?php lang('Dashboard'); ?></a></li>
  <li><a href="<?php echo site_url('account'); ?>"><?php lang('Account'); ?></a></li>
  <li class="active"><?php lang('New Account'); ?></li>
</ol>



<div class="row">
<div class="col-md-8">


<?php
if(isset($success['add_account'])){alertbox('alert-success', 'Hesap Kartı Eklendi', '"'.$account['code'].'" yeni bir hesap kartı eklendi.');}
if(@$formError) { alertbox('alert-danger', $formError);	 }
if(@$haveBarcode) { alertbox('alert-danger', '"'.$account['code'].'" Barkod kodu başka bir ürün kartında bulundu.', 
	'Başka bir ürün kartı "'.$account['code'].'" barkod kodunu kullanıyor. <br/> Barkod kodları eşsiz olmalı ve sadece bir ürün kartına ait olmalı.');	 }
?>
	
    <form name="form_new_product" id="form_new_product" action="" method="POST" class="validation">
    	<h3><i class="fa fa fa-puzzle-piece"></i> Yeni Hesap Kartı</h3>

            <div class="row">
                <div class="col-md-6">
                       
                    <div class="form-group">
                        <label for="code" class="control-label  "><?php lang('Account Code'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-barcode"></span></span>
                            <input type="text" id="code" name="code" class="form-control " placeholder="<?php lang('Barcode Code'); ?>" minlength="3" maxlength="30" value="<?php echo $account['code']; ?>">
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label  "><?php lang('Account Name'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                            <input type="text" id="name" name="name" class="form-control  required" placeholder="<?php lang('Account Name'); ?>" minlength="3" maxlength="30" value="<?php echo $account['name']; ?>">
                        </div>
                    </div>     
                </div> <!-- /.col-md-6 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name_surname" class="control-label  "><?php lang('Name and Surname'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                            <input type="text" id="name_surname" name="name_surname" class="form-control " placeholder="<?php lang('Name Surname'); ?>" value="<?php echo $account['name_surname']; ?>" minlengt="3" maxlength="30">
                        </div>
                    </div> <!-- /.form-group -->
                    <div class="form-group">
                        <label for="balance" class="control-label  "><?php lang('Balance'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                            <input type="text" id="balance" name="balance" class="form-control  number" placeholder="0.00" value="<?php echo $account['balance']; ?>">
                        </div>
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-6 -->
            </div> <!-- /.row -->
        
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone" class="control-label  "><?php lang('Phone'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                            <input type="text" id="phone" name="phone" class="form-control digits" minlength="7" maxlength="16" value="<?php echo $account['phone']; ?>">
                        </div>
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-4 -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="gsm" class="control-label  "><?php lang('Gsm'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
                            <input type="text" id="gsm" name="gsm" class="form-control   digits" minlength="7" maxlength="16" value="<?php echo $account['gsm']; ?>">
                        </div>
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-4 -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email" class="control-label  "><?php lang('E-mail'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input type="text" id="email" name="email" class="form-control   email" minlength="6" maxlength="50" value="<?php echo $account['email']; ?>">
                        </div>
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-4 -->
            </div> <!-- /.row -->
        
        
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="address" class="control-label  "><?php lang('Address'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                           <textarea class="form-control" name="address" id="address" style="height:84px;" minlength="3" maxlength="250"><?php echo $account['address']; ?></textarea>
                        </div>
                    </div> <!-- /.form-group -->
                </div> <!-- col-md-8 -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="county" class="control-label  "><?php lang('County'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                            <input type="text" id="county" name="county" class="form-control  " minlength="2" maxlength="20" value="<?php echo $account['county']; ?>">
                        </div>
                    </div> <!-- /.form-group -->
                    <div class="form-group">
                        <label for="city" class="control-label"><?php lang('City'); ?></label>
                        <div class="input-prepend input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                            <input type="text" id="city" name="city" class="form-control  " minlength="2" maxlength="20" value="<?php echo $account['city']; ?>">
                        </div>
                    </div> <!-- /.form-group -->
                </div> <!-- /.col-md-4 -->
            </div> <!-- /.row -->
        
        
            <div class="form-group">
                <label for="description" class="control-label"><?php lang('Description'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                   <textarea class="form-control" name="description" id="description" maxlength="500"><?php echo $account['description']; ?></textarea>
                </div>
            </div> <!-- /.form-group -->
            
            
            <div class="h20"></div>
            
            <div class="text-right">
                <input type="hidden" name="microtime" value="<?php echo logTime(); ?>" />
                <input type="hidden" name="add" />
                <button class="btn btn-default btn-lg"><?php lang('Save'); ?> &raquo;</button>
            </div> <!-- /.text-right -->
            
    </form>
	
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
<div class="widget">
	<div class="header">Açıklama</div>
	<div class="content padding-5">
        <p>Yeni hesap kartı açma alanında, müşteriler, bayiler, toptancılar, tedarikci firmalar ve imalatçıları ekleyebilirsin.</p>
        <p>Daha sonra bu hesaplara ödeme/çek verebilir ve alabilirsin. Ürün satabilir ve satın alabilirsin.</p>
	</div> <!-- /.content -->
</div> <!-- /.widget -->
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->

<div class="h20"></div>
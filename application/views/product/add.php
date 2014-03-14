<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('product'); ?>">Stok Yönetimi</a></li>
  <li class="active">Yeni Stok Kartı</li>
</ol>


<div class="row">
<div class="col-md-8">


<?php
if(@$add_product_success) { alertbox('alert-success', 'Stok Kartı Oluşturuldu.', 
'"'.$product['code'].'" stok kartı veritabanına eklendi.');	}
if(@$formError) { alertbox('alert-danger', $formError);	 }
if(@$haveBarcode) { alertbox('alert-danger', '"'.$product['code'].'" Barkod kodu başka bir ürün kartında bulundu.', 
	'Başka bir ürün kartı "'.$product['code'].'" barkod kodunu kullanıyor. <br/> Barkod kodları eşsiz olmalı ve sadece bir stok kartına ait olmalı.');	 }
if(@$error) { alertbox('alert-danger', $error);	 }
?>

<form name="form_new_product" id="form_new_product" action="" method="POST" class="validation">
	<h3>Yeni stok kartı</h3>
    <div class="content">
    <div class="row">
        <div class="col-md-8">
               
            <div class="form-group">
                <label for="code" class="control-label ff-1 "><?php lang('Barcode Code'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-barcode"></span></span>
                    <input type="text" id="code" name="code" class="form-control  ff-1" placeholder="<?php lang('Barcode Code'); ?>" minlength="3" maxlength="50" value="<?php echo $product['code']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="control-label ff-1 "><?php lang('Product Name'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                    <input type="text" id="name" name="name" class="form-control ff-1 required" placeholder="<?php lang('Product Name'); ?>" minlength="3" maxlength="100" value="<?php echo $product['name']; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="control-label">Açıklama</label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-text-width"></span></span>
                   <textarea class="form-control" name="description" id="description" maxlength="500" style="height:94px;"><?php echo $product['description']; ?></textarea>
                </div>
            </div>
            
    
                              
        </div> <!-- /.col-md-8 -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="cost_price" class="control-label ff-1 ">Maliyet Fiyatı Kdv Dahil</label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="fa fa-try fs-16"></span></span>
                    <input type="text" id="cost_price" name="cost_price" class="form-control ff-1 number" placeholder="0.00" value="<?php echo $product['cost_price']; ?>">
                </div>
            </div> <!-- /.form-group -->
            <div class="form-group">
                <label for="sale_price" class="control-label ff-1 ">Satış Fiyatı Kdv Dahil</label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><span class="fa fa-try fs-16"></span></span>
                    <input type="text" id="sale_price" name="sale_price" class="form-control  ff-1 number" placeholder="0.00" value="<?php echo $product['sale_price']; ?>">
                </div>
            </div> <!-- /.form-group -->
            <div class="form-group">
                <label for="tax_rate" class="control-label ff-1 "><?php lang('Tax Rate'); ?></label>
                <div class="input-prepend input-group">
                    <span class="input-group-addon"><strong>%</strong></span>
                    <input type="text" id="tax_rate" name="tax_rate" class="form-control  ff-1 digits" value="<?php echo $product['tax_rate']; ?>">
                </div>
            </div> <!-- /.form-group -->
            
            <div class="form-group">
                <label for="unit">Birim</label>
                <select name="unit" id="unit" class="form-control valid">
                    <option value="number">ADET</option>
                    <option value="gram">GRAM</option>
                    <option value="kilogram">KILOGRAM</option>
                    <option value="ton">TON</option>
                    <option value="millimeter">MILIMETRE</option>
                    <option value="centimeter">SANTIMETRE</option>
                    <option value="meter">METRE</option>
                    <option value="parcel">KOLI</option>
                </select>
            </div> <!-- /.form-group -->
            
        </div> <!-- /.col-md- -->
    </div> <!-- /.row -->
    
    
    
    <div class="h20"></div>
    <div class="text-right">
        <input type="hidden" name="log_time" value="<?php echo logTime(); ?>" />
        <input type="hidden" name="add_product" />
        <button class="btn btn-default"><?php lang('Save'); ?> &raquo;</button>
    </div> <!-- /.text-right -->
	</div> <!-- /.content -->
</form>
	
</div> <!-- /.col-md-8 -->
<div class="col-md-4">
	<div class="widget">
    	<div class="header"><i class="fa fa-bookmark-o"></i> Açıklama</div>
        <div class="content">
            <p>Bu bölümde yeni ürün kartı yani stok kartı oluşturabilirsin.</p>
            <p>Buradaki panele stok adet sayısını yazabileceğin bir alan eklemedik. Çünkü ürün alışı yapman gerekiyor. Ürün alışı yapıldığında stok adet sayısı artacaktır. Buna bağlı olarak ürün satışı yapıldığında, ürün adet sayısı azalacaktır. </p>
            <p>Ürün kartı eklerken KDV alanını boş bırakabilirsin.</p>
            <p>Maliyet fiyatı ve satış fiyatı alanlarının doğru girilmesi durumunda Kar-Zarar raporlarında net rapor alabilirsin.</p>
            <p>Kullanıcıların maliyet fiyatlarını görmemelerini istiyorsan, ayarlar bölümünden maliyet fiyatı gösterimini kapatabilirsin.</p>
    	</div> <!-- /.content -->
    </div> <!-- /.widget -->
</div> <!-- /.col-md-4 -->
</div> <!-- /.row -->

<div class="h20"></div>
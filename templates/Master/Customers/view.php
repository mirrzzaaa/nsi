<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-yellow"> 
            <h4 class="modal-title">Detail Customer</h4> 
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body"> 
            <div class="row m-b-15">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Kode</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="code"><?php echo (!empty($customer->code) ? $customer->code : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Nama</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="name"><?php echo (!empty($customer->name) ? $customer->name : '-') ?></i></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-2 col-sm-2">
                            <b>Title</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="kategori"><?php echo (!empty($customer->title) ? $customer->title : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Marketing</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="marketing"><?php echo (!empty($customer->user->name) ? $customer->user->name : '-') ?></i></div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Alamat Customer</b>
                        </div>
                        <div class="col-10 col-sm-10">: <i><?php echo (!empty($customer->address_penghasil) ? $customer->address_penghasil : '-') ?></i></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>NPWP</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="npwp"><?php echo (!empty($customer->npwp) ? $customer->npwp : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>No. Rekening</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="rek"><?php echo (!empty($customer->bank_name_ori) ? $customer->bank_name_ori : '-') . ' - ' . (!empty($customer->bank_norek_ori) ? $customer->bank_norek_ori : '-') ?></i></div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Contact Person</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="cp"><?php echo (!empty($customer->contact_person) ? $customer->contact_person : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Telepon</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="telp"><?php echo (!empty($customer->telp_person) ? $customer->telp_person : '-') ?></i></div>
                    </div>
                    <hr>
                    <div class="row mb-2">
                        <div class="col-2 col-sm-2">
                            <b>Nama Invoice</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="in"><?php echo (!empty($customer->name_invoice) ? $customer->name_invoice : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Telepon Invoice</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="telp_in"></i><?php echo (!empty($customer->phone_invoice) ? $customer->phone_invoice : '-') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Alamat Invoice</b>
                        </div>
                        <div class="col-10 col-sm-10">: <i><?php echo (!empty($customer->address_invoice) ? $customer->address_invoice : '-') ?></i></div>
                    </div>
                    <br>
                    <div class="row mb-2">
                        <div class="col-2 col-sm-2">
                            <b>Nama Faktur</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="fax"><?php echo (!empty($customer->name_tax_invoice) ? $customer->name_tax_invoice : '-') ?></i></div>
                        <div class="col-2 col-sm-2">
                            <b>Telepon Faktur</b>
                        </div>
                        <div class="col-4 col-sm-4">: <i id="telp_fax"><?php echo (!empty($customer->phone_tax_invoice) ? $customer->phone_tax_invoice : '-') ?></i></div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Alamat Faktur</b>
                        </div>
                        <div class="col-10 col-sm-10">: <i><?php echo (!empty($customer->address_tax_invoice) ? $customer->address_tax_invoice : '-') ?></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Tutup</a>
        </div>
    </div>
</div>

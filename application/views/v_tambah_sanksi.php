<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-gray-800">Pengajuan Sanksi Laporan Penanganan</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <h5 style="font-weight: 800;">Data Kasus</h5>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="id_fakultas" value="<?php echo $_REQUEST['id_fakultas']; ?>" />
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Kasus</label>
                            <div class="col-sm-9">
                                <input type="text" name="kasus" class="form-control" id="" placeholder="" value="<?php echo $fetch['kasus']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Korban</label>
                            <div class="col-sm-9">
                                <input type="text" name="korban" class="form-control" id="" placeholder="" value="<?php echo $fetch['korban']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Pelaku</label>
                            <div class="col-sm-9">
                                <input type="text" name="pelaku" class="form-control" id="" placeholder="" value="<?php echo $fetch['pelaku']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">SK</label>
                            <div class="col-sm-9">
                                <input required type="text" name="sk" class="form-control" id="" placeholder="" value="<?php echo $fetch['sk']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Sanksi</label>
                            <div class="col-sm-9">
                                <input required type="text" name="sanksi" class="form-control" id="" placeholder="" value="<?php echo $fetch['sanksi']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Jenis Sanksi</label>
                            <div class="col-sm-9">
                                <!-- <input type="text" name="jenis_sanksi" class="form-control" id="" placeholder="" value="<?php echo $fetch['jenis_sanksi']; ?>"> -->
                                <select required class="form-control" name="jenis_sanksi">
                                    <option <?php if ($fetch['jenis_sanksi'] == 'Ringan') { echo "selected='selected'"; } ?> value="Ringan">Ringan</option>
                                    <option <?php if ($fetch['jenis_sanksi'] == 'Sedang') { echo "selected='selected'"; } ?> value="Sedang">Sedang</option>
                                    <option <?php if ($fetch['jenis_sanksi'] == 'Berat') { echo "selected='selected'"; } ?> value="Berat">Berat</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <?php if ($_SESSION['role'] != 'rektor') { ?>
                                    <button class="btn btn-md btn-info">Simpan</button>
                                <?php } ?>
                                <a href="<?php echo base_url(); ?>dashboard/daftar_sanksi?id_fakultas=<?php echo $_REQUEST['id_fakultas']; ?>" class="btn btn-md btn-danger">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
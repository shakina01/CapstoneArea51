<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-gray-800">Pengajuan Laporan Penanganan</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <h5 style="font-weight: 800;">Data Pelapor</h5>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="id_fakultas" value="<?php echo $_REQUEST['id_fakultas']; ?>" />
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Pelapor</label>
                            <div class="col-sm-9">
                                <select required id="pelapor_id" class="form-control" name="pelapor_id" onchange="checkPelapor()">
                                    <option <?php if ($fetch['pelapor'] == 'Orang Lain') { echo "selected='selected'"; } ?> value="Orang Lain">Orang Lain</option>
                                    <option <?php if ($fetch['pelapor'] == 'Korban') { echo "selected='selected'"; } ?> value="Korban">Korban</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row orang-lain" <?php if ($fetch['pelapor'] == 'Korban') { echo "style='display: none';"; } ?> >
                            <label for="" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" name="pelapor_nama" class="form-control" id="" placeholder="" value="<?php echo $fetch['pelapor_nama']; ?>">
                            </div>
                        </div>
                        <div class="form-group row orang-lain" <?php if ($fetch['pelapor'] == 'Korban') { echo "style='display: none';"; } ?> >
                            <label for="" class="col-sm-3 col-form-label">NIM/NIP/NIK</label>
                            <div class="col-sm-9">
                                <input type="text" name="pelapor_nik" class="form-control" id="" placeholder="" value="<?php echo $fetch['pelapor_nik']; ?>">
                            </div>
                        </div>

                        <h5 style="font-weight: 800;" class="mt-5">Data Korban</h5>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input required type="text" name="korban_nama" class="form-control" id="" placeholder="" value="<?php echo $fetch['korban_nama']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">NIM/NIP/NIK</label>
                            <div class="col-sm-9">
                                <input required type="text" name="korban_nik" class="form-control" id="" placeholder="" value="<?php echo $fetch['korban_nik']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Tanggal Kejadian Peristiwa</label>
                            <div class="col-sm-9">
                                <input type="date" name="tanggal_kejadian" class="form-control" id="" placeholder="" value="<?php echo $fetch['tanggal_kejadian']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Data Pelaku (Nama, NIM/NIP/NIK)</label>
                            <div class="col-sm-9">
                                <input required type="text" name="pelaku" class="form-control" id="" placeholder="" value="<?php echo $fetch['pelaku']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Tingkat Kasus</label>
                            <div class="col-sm-9">
                                <!-- <input required type="text" name="tingkat_kasus" class="form-control" id="" placeholder="" value="<?php echo $fetch['tingkat_kasus']; ?>"> -->
                                <select required class="form-control" name="tingkat_kasus">
                                    <option <?php if ($fetch['tingkat_kasus'] == 'Ringan') { echo "selected='selected'"; } ?> value="Ringan">Ringan</option>
                                    <option <?php if ($fetch['tingkat_kasus'] == 'Sedang') { echo "selected='selected'"; } ?> value="Sedang">Sedang</option>
                                    <option <?php if ($fetch['tingkat_kasus'] == 'Berat') { echo "selected='selected'"; } ?> value="Berat">Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Klasifikasi</label>
                            <div class="col-sm-9">
                                <!-- <input type="text" name="klasifikasi" class="form-control" id="" placeholder="" value="<?php echo $fetch['klasifikasi']; ?>"> -->
                                <select required class="form-control" name="klasifikasi">
                                    <option <?php if ($fetch['klasifikasi'] == 'Ringan') { echo "selected='selected'"; } ?> value="Ringan">Ringan</option>
                                    <option <?php if ($fetch['klasifikasi'] == 'Sedang') { echo "selected='selected'"; } ?> value="Sedang">Sedang</option>
                                    <option <?php if ($fetch['klasifikasi'] == 'Berat') { echo "selected='selected'"; } ?> value="Berat">Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Deskripsi Kasus</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="deskripsi" id="" placeholder="" style="height: 150px;"><?php echo $fetch['deskripsi']; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <?php if ($_SESSION['role'] != 'rektor') { ?>
                                    <button class="btn btn-md btn-info">Simpan</button>
                                <?php } ?>
                                <a href="<?php echo base_url(); ?>dashboard/daftar_laporan?id_fakultas=<?php echo $_REQUEST['id_fakultas']; ?>" class="btn btn-md btn-danger">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
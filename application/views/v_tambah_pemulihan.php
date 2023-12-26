<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-gray-800">Pemulihan Kekerasan Seksual</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="id_fakultas" value="<?php echo $_REQUEST['id_fakultas']; ?>" />
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Korban</label>
                            <div class="col-sm-9">
                                <input required <?php if ($_SESSION['role'] == 'wali') { ?> disabled <?php } ?> type="text" name="korban" class="form-control" id="" placeholder="" value="<?php echo $fetch['korban']; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group row" <?php if ($_SESSION['role'] == 'wali') { ?> style="display: none;" <?php } ?> >
                            <label for="" class="col-sm-3 col-form-label">SK Sanksi</label>
                            <div class="col-sm-9">
                                <input required type="text" name="sk" class="form-control" id="" placeholder="" value="<?php echo $fetch['sk']; ?>">
                            </div>
                        </div>
                        <div class="form-group row" <?php if ($_SESSION['role'] == 'wali') { ?> style="display: none;" <?php } ?> >
                            <label for="" class="col-sm-3 col-form-label">Berita Acara</label>
                            <div class="col-sm-9">
                                <input type="file" name="berita_acara" />
                                <?php if ($fetch['berita_acara']) { ?>
                                    <br />
                                    <a class="btn btn-md btn-primary mt-3" href="<?php echo $fetch['berita_acara']; ?>" target="_blank">Lihat Lampiran</a>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Lampiran</label>
                            <div class="col-sm-9">
                                <input type="file" name="lampiran" />
                                <?php if ($fetch['lampiran']) { ?>
                                    <br />
                                    <a class="btn btn-md btn-primary mt-3" href="<?php echo $fetch['lampiran']; ?>" target="_blank">Lihat Lampiran</a>
                                <?php } ?>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Deskripsi Kasus</label>
                            <div class="col-sm-9">
                                <textarea <?php if ($_SESSION['role'] == 'wali') { ?> disabled <?php } ?> class="form-control" name="deskripsi_kasus" id="" placeholder="" style="height: 150px;"><?php echo $fetch['deskripsi_kasus']; ?></textarea>
                            </div>
                        </div>

                        <?php if ($_SESSION['role'] == 'wali') { ?>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Laporan Hasil</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="laporan_hasil" id="" placeholder="" style="height: 150px;"><?php echo $fetch['laporan_hasil']; ?></textarea>
                                </div>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="laporan_hasil" class="form-control" id="" placeholder="" value="<?php echo $fetch['laporan_hasil'] ? $fetch['laporan_hasil'] : ''; ?>">
                        <?php } ?>

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <?php if (!in_array($_SESSION['role'], ['rektor', 'fakultas'])) { ?>
                                    <button class="btn btn-md btn-info">Simpan</button>
                                <?php } ?>
                                <a href="<?php echo base_url(); ?>dashboard/daftar_pemulihan?id_fakultas=<?php echo $_REQUEST['id_fakultas']; ?>" class="btn btn-md btn-danger">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
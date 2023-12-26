<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-gray-800">Pengajuan Laporan Penanganan</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        <h5 style="font-weight: 800;">Data Kasus</h5>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="id_fakultas" value="<?php echo $_REQUEST['id_fakultas']; ?>" />
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Tanggal Kejadian</label>
                            <div class="col-sm-9">
                                <input required type="date" name="tanggal_kejadian" class="form-control" id="" placeholder="" value="<?php echo $fetch['tanggal_kejadian']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Nama Korban</label>
                            <div class="col-sm-9">
                                <input required type="text" name="nama_korban" class="form-control" id="" placeholder="" value="<?php echo $fetch['nama_korban']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Deskripsi Kasus</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="deskripsi_kasus" id="" placeholder="" style="height: 150px;"><?php echo $fetch['deskripsi_kasus']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Catatan Tambahan</label>
                            <div class="col-sm-9">
                                <input required type="text" name="catatan_tambahan" class="form-control" id="" placeholder="" value="<?php echo $fetch['catatan_tambahan']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Berita Acara</label>
                            <div class="col-sm-9">
                                <input type="file" name="berita_acara" />
                                <?php if ($fetch['berita_acara']) { ?>
                                    <br />
                                    <a class="btn btn-md btn-primary mt-3" href="<?php echo $fetch['berita_acara']; ?>" target="_blank">Lihat Lampiran</a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <?php if ($_SESSION['role'] != 'rektor') { ?>
                                    <button class="btn btn-md btn-info">Simpan</button>
                                <?php } ?>
                                <a href="<?php echo base_url(); ?>dashboard/daftar_lain_lain?id_fakultas=<?php echo $_REQUEST['id_fakultas']; ?>" class="btn btn-md btn-danger">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
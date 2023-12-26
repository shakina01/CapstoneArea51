<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-gray-800">Pengajuan Laporan Pencegahan</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="id_fakultas" value="<?php echo (int) $_REQUEST['id_fakultas']; ?>" />
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Tanggal Kegiatan</label>
                            <div class="col-sm-9">
                                <input required type="date" name="tanggal_kegiatan" class="form-control" id="" placeholder="" value="<?php echo $fetch['tanggal_kegiatan']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Nama Kegiatan</label>
                            <div class="col-sm-9">
                                <input required type="text" name="nama" class="form-control" id="" placeholder="" value="<?php echo $fetch['nama']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Jenis Kegiatan</label>
                            <div class="col-sm-9">
                                <input required type="text" name="jenis" class="form-control" id="" placeholder="" value="<?php echo $fetch['jenis']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Jumlah Peserta</label>
                            <div class="col-sm-9">
                                <input required type="number" name="jumlah_peserta" class="form-control" id="" placeholder="" value="<?php echo $fetch['jumlah_peserta']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Dokumentasi Kegiatan</label>
                            <div class="col-sm-9">
                                <input type="file" name="dokumentasi" />
                                <?php if ($fetch['dokumentasi']) { ?>
                                    <br />
                                    <a class="btn btn-md btn-primary mt-3" href="<?php echo $fetch['dokumentasi']; ?>" target="_blank">Lihat Lampiran</a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Deskripsi</label>
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
                                <a href="<?php echo base_url(); ?>dashboard/daftar_pencegahan?id_fakultas=<?php echo $_REQUEST['id_fakultas']; ?>" class="btn btn-md btn-danger">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
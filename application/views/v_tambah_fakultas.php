<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-gray-800">Tambah/Perbarui Fakultas</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Kode Fakultas</label>
                            <div class="col-sm-9">
                                <input required type="text" name="kode" class="form-control" id="" placeholder="" value="<?php echo $fetch['kode']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Nama Fakultas</label>
                            <div class="col-sm-9">
                                <input required type="text" name="nama" class="form-control" id="" placeholder="" value="<?php echo $fetch['nama']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <?php if ($_SESSION['role'] != 'rektor') { ?>
                                    <button class="btn btn-md btn-info">Simpan</button>
                                <?php } ?>
                                <a href="<?php echo base_url(); ?>dashboard/daftar_fakultas" class="btn btn-md btn-danger">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
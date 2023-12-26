<?php
header('Content-Type: text/html; charset=UTF-8');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800 mb-3">Pemulihan Kekerasan Seksual</h1>
    <?php if ($id_fakultas > 0 && in_array($_SESSION['role'], ['rektor', 'satgas'])) { ?>
        <a href="<?php echo base_url(); ?>dashboard/tambah_pemulihan?id_fakultas=<?php echo $id_fakultas; ?>" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm mb-3"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Laporan</a>
    <?php } ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if (in_array($_SESSION['role'], ['rektor', 'satgas'])) { ?>
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label>Data Fakultas</label>
                                        <select required class="form-control" name="id_fakultas">
                                            <option value="">Pilih Fakultas</option>
                                            <?php foreach ($fakultas as $f) { ?>
                                                <option value="<?php echo $f['id']; ?>" <?php if ($f['id'] == $id_fakultas) { echo "selected='selected'"; } ?> ><?php echo $f['nama']; ?> (<?php echo $f['kode']; ?>)</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-md btn-success w-100" value="Filter Data" />
                                        <a href="<?php echo base_url(); ?>dashboard/daftar_pemulihan" class="btn btn-md btn-danger w-100 mt-2">Reset Filter</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } ?>

                    <?php if ($id_fakultas > 0) { ?>
                        <?php if (in_array($_SESSION['role'], ['rektor', 'satgas'])) { ?> <hr /> <?php } ?>
                        <div class="table-responsive">
                            <h5 style="font-weight: 800;" class="text-center mb-2">Riwayat Laporan Pemulihan Konseling</h5>
                            <table class="table table-bordered" id="datatable2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Korban</th>
                                        <th>Deskripsi Kasus</th>
                                        <?php if ($_SESSION['role'] != 'wali') { ?>
                                            <th>SK Sanksi</th>
                                        <?php } ?>
                                        
                                        <th>Laporan Hasil</th>
                                        
                                        <?php if ($_SESSION['role'] != 'wali') { ?>
                                            <th>Berita Acara</th>
                                        <?php } ?>
                                        
                                        <th class="exclude-export">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($datasets as $d) { ?>
                                        <tr>
                                            <td><?php echo $no;
                                                $no++; ?></td>
                                            <td><?php echo $d['korban']; ?></td>
                                            <td><?php echo $d['deskripsi_kasus']; ?></td>
                                            <?php if ($_SESSION['role'] != 'wali') { ?>
                                                <td><?php echo $d['sk']; ?></td>
                                            <?php } ?>

                                            <td><?php echo $d['laporan_hasil']; ?></td>

                                            <?php if ($_SESSION['role'] != 'wali') { ?>
                                                <td>
                                                    <?php if ($d['berita_acara']) { ?>
                                                        <a href="<?php echo $d['berita_acara']; ?>" target="_blank">Lihat Lampiran</a>
                                                    <?php } else { ?>
                                                        <a href="#">Tidak ada Lampiran</a>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>

                                            <td class="exclude-export">
                                                <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>dashboard/tambah_pemulihan?id=<?php echo $d['id']; ?>&id_fakultas=<?php echo $id_fakultas; ?>"><i class="fa fa-pen"></i></a>
                                                <?php if (!in_array($_SESSION['role'], ['rektor', 'fakultas', 'wali'])) { ?>
                                                    <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>dashboard/delete_pemulihan?id=<?php echo $d['id']; ?>&id_fakultas=<?php echo $id_fakultas; ?>"><i class="fa fa-trash"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                    <form id="fileUploadForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>dashboard/import">
                        <input style="display: none;" type="file" id="filename" name="file" />
                    </form>
                    <script>
                        const fileInput = document.getElementById('filename');
                        fileInput.addEventListener('change', () => {
                            if (fileInput.files.length > 0) {
                                document.getElementById('fileUploadForm').submit();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
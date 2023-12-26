<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Naive Bayes</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.css" rel="stylesheet">
    <style>
        .c-active {
            background: #009099;
        }

        .sidebar .nav-item .collapse .collapse-inner .collapse-item,
        .sidebar .nav-item .collapsing .collapse-inner .collapse-item {
            color: #fff !important;
        }

        .sidebar .nav-item .collapse .collapse-inner .collapse-item:hover,
        .sidebar .nav-item .collapsing .collapse-inner .collapse-item:hover {
            background: #009099 !important;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#" style="background: #1D242E;">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Dashboard</div>
            </a>

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#" style="margin-bottom: 4%; margin-top: 4%;">
                <img src="<?php echo $_SESSION['foto']; ?>" class="img img-responsive" style="height: 50px; border-radius: 50px; width: 50px; object-fit: cover;" />
                <div class="sidebar-brand-text mx-3" style="text-align: left;"><?php echo $_SESSION['username']; ?><br />
                    <font style="font-size: 10px; color: yellow;">Naive Bayes</font>
                </div>
            </a>


            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php if ($active == 'dashboard') {
                                    echo 'active c-active';
                                } ?>">
                <a class="nav-link" href="<?php echo base_url(); ?>dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <?php if ($_SESSION['role'] == 'admin') { ?>
                <li class="nav-item <?php if ($active == 'datauser') {
                                        echo 'active';
                                    } ?>">
                    <a class="nav-link <?php if ($active == 'datauser') {
                                            echo 'c-active';
                                        } else {
                                            echo 'collapsed';
                                        } ?>" href="#" data-toggle="collapse" data-target="#collapseTwos" aria-expanded="true" aria-controls="collapseTwos">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Data User</span>
                    </a>
                    <div id="collapseTwos" class="collapse <?php if ($active == 'datauser') {
                                                                echo 'show';
                                                            } ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/daftar_user">Daftar</a>
                            <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/tambah_user">Tambah</a>
                        </div>
                    </div>
                </li>


                <li class="nav-item <?php if ($active == 'datalatih') {
                                        echo 'active';
                                    } ?>">
                    <a class="nav-link <?php if ($active == 'datalatih') {
                                            echo 'c-active';
                                        } else {
                                            echo 'collapsed';
                                        } ?>" href="#" data-toggle="collapse" data-target="#collapseTwoz" aria-expanded="true" aria-controls="collapseTwoz">
                        <i class="fas fa-fw fa-check"></i>
                        <span>Data Latih</span>
                    </a>
                    <div id="collapseTwoz" class="collapse <?php if ($active == 'datalatih') {
                                                                echo 'show';
                                                            } ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/daftar_datalatih">Daftar</a>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                                <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/tambah_datalatih">Tambah</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>

                <li class="nav-item <?php if ($active == 'dataset') {
                                        echo 'active';
                                    } ?>">
                    <a class="nav-link <?php if ($active == 'dataset') {
                                            echo 'c-active';
                                        } else {
                                            echo 'collapsed';
                                        } ?>" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-list"></i>
                        <span>Data Uji</span>
                    </a>
                    <div id="collapseTwo" class="collapse <?php if ($active == 'dataset') {
                                                                echo 'show';
                                                            } ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/daftar_dataset">Daftar</a>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                                <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/tambah_dataset">Tambah</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>

                <li class="nav-item <?php if ($active == 'klasifikasi') {
                                        echo 'active c-active';
                                    } ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>dashboard/klasifikasi">
                        <i class="fas fa-fw fa-pen"></i>
                        <span>Klasifikasi</span></a>
                </li>

            <?php } ?>

            <li class="nav-item <?php if ($active == 'laporan') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link <?php if ($active == 'laporan') {
                                        echo 'c-active';
                                    } else {
                                        echo 'collapsed';
                                    } ?>" href="#" data-toggle="collapse" data-target="#collapseC" aria-expanded="true" aria-controls="collapseC">
                    <i class="fa-fw fa fa-file"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseC" class="collapse <?php if ($active == 'laporan') {
                                                        echo 'show';
                                                    } ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/hasil_klasifikasi">Hasil Klasifikasi</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/hasil_tfidf">Hasil TF-IDF</a>
                        <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/wordcloud">Wordcloud</a>
                        <!-- <a class="collapse-item" href="<?php echo base_url(); ?>dashboard/laporan_pengembalian_buku">Laporan Pengembalian<br />Buku</a> -->
                    </div>
                </div>
            </li>

            <li class="nav-item <?php if ($active == 'data_admin') {
                                    echo 'active c-active';
                                } ?>">
                <a class="nav-link" href="<?php echo base_url(); ?>dashboard/data_admin">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Profil</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <!-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li> -->

                        <!-- Nav Item - Messages -->
                        <!-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="<?php echo base_url(); ?>assets/img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="<?php echo base_url(); ?>assets/img/undraw_profile_2.svg" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="<?php echo base_url(); ?>assets/img/undraw_profile_3.svg" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li> -->

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="<?php echo base_url(); ?>assets/img/yellow.png">
                                <span class="ml-2 d-none d-lg-inline text-gray-600 small"><strong>Halo, <?php echo $_SESSION['username']; ?>!</strong><br /><?php date_default_timezone_set("Australia/Perth"); echo date("d l Y H:i"); ?></span>
                            </a>

                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>dashboard/data_admin">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
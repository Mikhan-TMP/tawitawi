<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $title; ?></title>
  <!-- SWEET ALERT 2-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="sweetalert2.min.css"> 
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/sweetalert2.min.css"> 

  <!-- Custom fonts for this template-->
  <link rel="icon" href="<?= base_url('images/'); ?>LogoMSU.png" type="image/x-icon">
  <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <style>
    .nav-item.active {
        /* background: linear-gradient(180deg, #BE110E, #630908); Light gray background */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Optional shadow */
    }

    .nav-item.active a {
        color: #FFFFFF; /* Change text color */
        font-weight: bold; /* Make text bold */
    }
    </style>
</head>

<body style="
    background-image: url('<?= base_url('images/bg.png'); ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
">
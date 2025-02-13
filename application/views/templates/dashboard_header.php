<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $title; ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="sweetalert2.min.css"> 
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/sweetalert2.min.css"> 
  
  <!-- Custom fonts for this template-->
  <link rel="icon" href="<?= base_url('images/'); ?>LogoMSU.png" type="image/x-icon">
  <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url('assets/'); ?>https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Page level plugins -->
   <style>
    .col-auto{
      width: 30px;
      height: 30px;
      /* padding-bottom: 10px; */
      background: linear-gradient(45deg, black, transparent);
      margin: auto;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 10px;
      background: linear-gradient(180deg, #BE110E, #630963);
      color: #ffffff;
    }
   </style>
  <style>
    .nav-item.active {
        /* background: linear-gradient(180deg, #031084, #000748);  Light gray background */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Optional shadow */
    }
    .nav-item.active .nav-link a {
        color: #FFFFFF; /* Change text color */
        font-weight: bold; /* Make text bold */
    }
    </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
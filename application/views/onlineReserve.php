<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSU Online Reservation</title>
    <link rel="icon" href="<?= base_url('images/'); ?>favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap_m/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/sb-admin-2.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/online.css') ?>">
</head>
<body>
<div class="bg" style="background-image: url(<?= base_url('images/Home.png')?>)"></div>
    <div class="reserve">
        <div class="logo">
            <img src="<?php echo base_url('images/LogoMsu.png'); ?>" alt="Logo">
        </div>
        <h1>WELCOME</h1>
        <p>to Seat Reservation System</p>
        <hr>
        <form role="form" method="post">
            <div class="m-2">
            <?php if ($this->session->flashdata('message')): ?>
                <?= $this->session->flashdata('message'); ?>
            <?php endif; ?>
            </div>
            <div class="form__group field">
                <input type="input" name="surname" class="form__field" placeholder="Name" required="" autocomplete="off">
                <label for="name" class="form__label">Enter your Surname</label>
            </div>
            <div class="form__group field">
                <input type="input" name="studentID" class="form__field" placeholder="Student ID" required="" autocomplete="off">
                <label for="studentID" class="form__label">Enter your Student ID</label>
            </div>
            <button class="button-61" type="submit">Proceed</button>
        </form>
    </div>
</body>
</html>

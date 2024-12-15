<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link ke Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">Register</h5>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?php
                                foreach ($this->session->flashdata('error') as $va) {
                                    echo $va;
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php echo form_open('auth/do_register'); ?>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?php echo set_value('nama'); ?>" required>
                            <div style="color: red;"><?php echo form_error('nama'); ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" required>
                            <div style="color: red;"><?php echo form_error('email'); ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                            <div style="color: red;"><?php echo form_error('password'); ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm" required>
                            <div style="color: red;"><?php echo form_error('password_confirm'); ?></div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Register</button>
                        <?php echo form_close(); ?>

                        <div class="text-center mt-3">
                            <p>Sudah punya akun? <a href="<?php echo site_url('auth'); ?>">Login di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
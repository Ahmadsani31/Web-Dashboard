<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<?php $this->load->view('layout/header.php'); ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<style>
		.has-search .form-control {
			padding-left: 2.375rem;
		}

		.has-search .form-control-feedback {
			position: absolute;
			z-index: 2;
			display: block;
			width: 2.375rem;
			height: 2.375rem;
			line-height: 2.375rem;
			text-align: center;
			pointer-events: none;
			color: #aaa;
		}
	</style>
</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<?php $this->load->view('layout/sidebar.php'); ?>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<?php $this->load->view('layout/navbar.php'); ?>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800">Excel</h1>
					</div>


					<!-- Content Row -->

					<div class="row">

						<!-- Area Chart -->
						<div class="col-xl-12">
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<div class="card-header">
									<h5>Upload File Excel</h5>
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<?php if ($this->session->flashdata('error')): ?>
										<div class="alert alert-warning" role="alert">
											<?php echo $this->session->flashdata('error'); ?>
										</div>
									<?php elseif ($this->session->flashdata('success')): ?>
										<div class="alert alert-success" role="alert">
											<?php echo $this->session->flashdata('success'); ?>
										</div>
									<?php endif; ?>
									<form action="<?= base_url('excel/import'); ?>" method="post" enctype="multipart/form-data">
										<div class="mb-3">
											<label class="form-label">Excel</label>
											<input type="file" name="file" class="form-control">
										</div>
										<button type="submit" class="btn btn-primary">Import</button>
									</form>
								</div>
							</div>
						</div>
					</div>

					<!-- Content Row -->


				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<?php $this->load->view('layout/footer.php'); ?>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>


	<?php $this->load->view('layout/js.php'); ?>

</body>

</html>
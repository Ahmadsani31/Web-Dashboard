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
						<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
						<div class="input-group mb-3" style="width: 16.5rem">
							<div class="input-group-prepend">
								<span class="input-group-text bg-primary text-white" id="basic-addon1">
									<i class="fa fa-calendar" aria-hidden="true"></i>
								</span>
							</div>
							<input type="text" class="form-control" name="orderDate" id="orderDate" placeholder="Select date range...">
						</div>
					</div>
					<!-- Content Row -->
					<div class="row">

						<!-- Earnings (Monthly) Card Example -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-primary shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
												Total Sales</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800" id="tt_sales">0</div>
										</div>
										<div class="col-auto">
											<i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Earnings (Monthly) Card Example -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-success shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
												Total Income</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800" id="tt_income">0</div>
										</div>
										<div class="col-auto">
											<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>


					</div>

					<!-- Content Row -->

					<div class="row">

						<!-- Area Chart -->
						<div class="col-xl-12">
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<!-- Card Body -->
								<div class="card-body">
									<div id="chartLine"></div>
								</div>
							</div>
						</div>

					</div>

					<!-- Content Row -->

					<!-- Project Card Example -->
					<div class="card shadow mb-4">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table" id="DTable">
									<thead>
										<tr>
											<th>Name</th>
											<th>OrderDate</th>
											<th>OrderAmount</th>
											<th>EmployeePhone</th>
											<th>ClientName</th>
											<th>Office</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
									<tfoot>
										<tr>
											<th>Name</th>
											<th>OrderDate</th>
											<th>OrderAmount</th>
											<th>EmployeePhone</th>
											<th>ClientName</th>
											<th>Office</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
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

	<!-- Page level custom scripts -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

	<script>
		$(function() {
			$('input[name="orderDate"]').daterangepicker({
				autoUpdateInput: false,
				locale: {
					format: 'YYYY-MM-DD',
					cancelLabel: 'Clear'
				}
			});

			$('input[name="orderDate"]').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
				var dateOrder = picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD');
				// console.log(dateOrder);
				Dtabel.ajax.reload(null, false);
				grafik(dateOrder)
				total_order(dateOrder)
			});

			$('input[name="orderDate"]').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');
				// console.log('clear');
				Dtabel.ajax.reload(null, false);
				grafik('')
				total_order('')
			});
		});

		var options = {
			series: [{
					name: "Session Duration",
					data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
				},
				{
					name: "Page Views",
					data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
				},
				{
					name: 'Total Visits',
					data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
				}
			],
			chart: {
				height: 350,
				type: 'line',
				zoom: {
					enabled: false
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				curve: 'smooth',
			},
			title: {
				text: 'Page Statistics',
				align: 'left'
			},
			legend: {
				tooltipHoverFormatter: function(val, opts) {
					return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
				}
			},
			markers: {
				size: 0,
				hover: {
					sizeOffset: 6
				}
			},
			xaxis: {
				categories: ['Jan', 'Feb', 'Mar'],

			},
			yaxis: {
				labels: {
					show: true,
				},
			},
			tooltip: {
				y: [{
						title: {
							formatter: function(val) {
								return val + " (mins)"
							}
						}
					},
					{
						title: {
							formatter: function(val) {
								return val + " per session"
							}
						}
					},
					{
						title: {
							formatter: function(val) {
								return val;
							}
						}
					}
				]
			},
			grid: {
				borderColor: '#f1f1f1',
			}
		};

		var chart = new ApexCharts(document.querySelector("#chartLine"), options);
		chart.render();



		grafik('')

		function grafik(date) {
			$.ajax({
				url: "<?= base_url('dashboard/sales_performance?orderDate='); ?>" + date,
				method: 'GET',
				dataType: 'JSON',
			}).done(function(response) {
				// console.log(response.series);
				var dSeries = response.series;

				var dCategories = response.categories;
				chart.updateOptions({
					series: dSeries,
					xaxis: {
						categories: dCategories
					},
					yaxis: {
						labels: {
							show: true,
						},
					},
				})

			});
		}


		var Dtabel;
		$(document).ready(function() {

			$('#DTable tfoot th').each(function() {
				var title = $(this).text();
				// console.log(title);

				if (title == 'OrderAmount') {
					$(this).html('');
				} else if (title == 'OrderDate') {
					$(this).html(`<input type="date" class="form-control" placeholder="${title}">`);
				} else {

					$(this).html(`<div class="form-group has-search">
									<span class="fa fa-search form-control-feedback"></span>
									<input type="text" class="form-control" placeholder="${title}">
								</div>`);
				}
			});

			Dtabel = $("#DTable").DataTable({
				processing: true,
				serverSide: true,
				responsive: true,
				dom: 'lrtip',
				order: [],
				ajax: {
					url: "<?= base_url() . 'datatable'; ?>",
					type: "GET",
					data: function(d) {
						d.tanggal = $('#orderDate').val();
					},
				},
				initComplete: function() {
					this.api().columns().every(function() {
						var column = this;
						$('input', this.footer()).on('keyup change', function() {
							column.search(this.value).draw();
						});
					});
				},
				columnDefs: [{
					className: "text-center",
					targets: ['_all'],
				}, ],
				columns: [{
					data: "EmployeeName",
				}, {
					data: "OrderDate",
				}, {
					data: "OrderAmount",
				}, {
					data: "EmployeePhone",
				}, {
					data: "ClientName",
				}, {
					data: "Office",
				}],

			});

		});

		total_order('')

		function total_order(date) {
			$.ajax({
				url: "<?= base_url('dashboard/total_order?orderDate='); ?>" + date,
				method: 'GET',
				dataType: 'JSON',
			}).done(function(response) {
				// console.log(response);
				$('#tt_sales').html(response.totalSales);
				$('#tt_income').html(rupiah(response.totalIncome));
			});
		}

		function rupiah(number) {
			return new Intl.NumberFormat("id-ID", {
				style: "currency",
				currency: "IDR"
			}).format(number);
		}
	</script>
</body>

</html>
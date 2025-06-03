@extends('admin.layout.page')
@section('contect')

	<!-- End Navbar -->
	<div class="container-fluid py-2">

		<div class="row mt-2">
			<div class="ms-1">
				<h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
				<p class="mb-4">Check the sales, value and bounce rate by country.</p>
			</div>
			<h3 class="mb-0 h4 font-weight-bolder mt-2">Meesho </h3>
			<!-- <h3 class="mb-0 h4 font-weight-bolder mt-2">Meesho <label for="" class="text-success"><b>₹{{$meeshoBaseProfit}}</b></label><label for="" class="text-danger"><b>₹{{$meeshoBaseReturnsProfit}}</b></label></h3> -->
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Total Payments Received</p>
								<h4 class="mb-0 text-success">{{ '₹' . number_format($totalPayment, 2) }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">payments</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>
		</div>{{-- Today's Money --}}
		<div class="row">
			
		</div>
		<div class="row mt-2">

			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Today's Money</p>
								<h4 class="mb-0">₹{{ \App\Helpers\Helper::getMeeshoTodayOrderAmount() }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">payments</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

			{{-- Today's Orders --}}
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Today's Orders</p>
								<h4 class="mb-0">{{ \App\Helpers\Helper::getMeeshoTodayOrderCount() }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">shopping_cart</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

			{{-- Total Orders --}}
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Total Orders</p>
								<h4 class="mb-0">{{ $meeshoOrderCount }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">list_alt</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

			{{-- Sales (₹) --}}
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Sales</p>
								<h4 class="mb-0">₹{{ \App\Helpers\Helper::formatIndianCurrency($meeshoSales) }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-success shadow-success shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">trending_up</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>
		</div>

		{{-- Row 2 --}}
		<div class="row">
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Returns</p>
								<h4 class="mb-0">₹{{ \App\Helpers\Helper::formatIndianCurrency($meeshoReturns) }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-danger shadow-danger shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">undo</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

			{{-- Return Orders Count --}}
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Return Orders</p>
								<h4 class="mb-0">{{ $meeshoReturnCount }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-warning shadow-warning shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">assignment_return</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

			{{-- Base Sales (₹) --}}
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Base Sales</p>
								<h4 class="mb-0 text-success">
									₹{{ \App\Helpers\Helper::formatIndianCurrency($meeshoBaseProfit) }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-info shadow-info shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">savings</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

			{{-- Base Returns (₹) --}}
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Base Returns</p>
								<h4 class="mb-0 text-danger">
									₹{{ \App\Helpers\Helper::formatIndianCurrency($meeshoBaseReturnsProfit) }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-secondary shadow-secondary shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">unarchive</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>
			<div class="col-lg-4 col-md-6 mt-4 mb-4">
				<div class="card ">
					<div class="card-body">
						<h6 class="mb-0 "> Daily Sales </h6>
						<p class="text-sm "> (<span class="font-weight-bolder">+15%</span>) increase in today sales. </p>
						<div class="pe-2">
							<div class="chart">
								<canvas id="chart-line" class="chart-canvas" height="170" width="494"
									style="display: block; box-sizing: border-box; height: 170px; width: 494px;"></canvas>
							</div>
						</div>
						<!-- <hr class="dark horizontal">
				  <div class="d-flex ">
					<i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm"> updated 4 min ago </p>
				  </div> -->
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 mt-4 mb-4">
				<div class="card">
					<div class="card-body">
						<h6 class="mb-0 ">Website Views</h6>
						<p class="text-sm ">Last Campaign Performance</p>
						<div class="pe-2">
							<div class="chart">
								<canvas id="chart-bars" class="chart-canvas" height="170" width="494"
									style="display: block; box-sizing: border-box; height: 170px; width: 494px;"></canvas>
							</div>
						</div>
						<!-- <hr class="dark horizontal">
				  <div class="d-flex ">
					<i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm"> campaign sent 2 days ago </p>
				  </div> -->
					</div>
				</div>
			</div>

			<div class="col-lg-4 mt-4 mb-3">
				<div class="card">
					<div class="card-body">
						<h6 class="mb-0 ">Completed Tasks</h6>
						<p class="text-sm ">Last Campaign Performance</p>
						<div class="pe-2">
							<div class="chart">
								<canvas id="chart-line-tasks" class="chart-canvas" height="170" width="494"
									style="display: block; box-sizing: border-box; height: 170px; width: 494px;"></canvas>
							</div>
						</div>
						<!-- <hr class="dark horizontal">
				  <div class="d-flex ">
					<i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm">just updated</p>
				  </div> -->
					</div>
				</div>
			</div>
		</div>

		<div class="row">

			<h3 class="mb-0 h4 font-weight-bolder">Amazon</h3>
			<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Today's Money</p>
								<h4 class="mb-0">₹{{ \App\Helpers\Helper::getAmazonTodayOrderAmount() }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">weekend</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Today's Order</p>
								<h4 class="mb-0">{{ \App\Helpers\Helper::getAmazonTodayOrderCount() }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">person</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Orders</p>
								<h4 class="mb-0">{{ $amazonOrders }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">leaderboard</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>
			<div class="col-xl-3 col-sm-6">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Sales</p>
								<h4 class="mb-0">₹{{ \App\Helpers\Helper::getAmazonTotalSales() }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">weekend</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>
		</div>
		{{-- Row 2 --}}
		<div class="row mt-3">
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Returns</p>
								<h4 class="mb-0">₹{{ $amazonReturns }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-danger shadow-danger shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">undo</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

			{{-- Return Orders Count --}}
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Return Orders</p>
								<h4 class="mb-0">{{ $amazonReturnCount }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-warning shadow-warning shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">assignment_return</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

			{{-- Base Sales (₹) --}}
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Base Sales</p>
								<h4 class="mb-0">₹{{ $amazonBaseSales }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-info shadow-info shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">savings</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

			{{-- Base Returns (₹) --}}
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="card">
					<div class="card-header p-2 ps-3">
						<div class="d-flex justify-content-between">
							<div>
								<p class="text-sm mb-0 text-capitalize">Base Returns</p>
								<h4 class="mb-0">₹{{ $amazonBaseReturns }}</h4>
							</div>
							<div
								class="icon icon-md icon-shape bg-gradient-secondary shadow-secondary shadow text-center border-radius-lg">
								<i class="material-symbols-rounded opacity-10">unarchive</i>
							</div>
						</div>
					</div>
					<hr class="dark horizontal my-0">
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-lg-6 col-md-8 mt-4 mb-4">
				<div class="card mb-4 shadow-sm">
					<div class="card-header bg-gradient-secondary text-center">
						<h5 class="mb-0 text-white">Order Place</h5>
					</div>
					<div class="card-body">

						{{-- ✅ Success Message --}}
						@if (session('success'))
							<div class="alert alert-success">
								{{ session('success') }}
							</div>
						@endif

						{{-- ✅ Error Message --}}
						@if (session('error'))
							<div class="alert alert-danger">
								{{ session('error') }}
							</div>
						@endif

						{{-- ✅ Missing SKUs if passed --}}
						@if (session('missing_skus'))
							<div class="alert alert-warning">
								<strong>Missing SKUs:</strong> {{ implode(', ', session('missing_skus')) }}
							</div>
						@endif

						<form action="{{ route('meesho.label.upload') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<input type="file" name="label_pdf" accept=".pdf" required>
							<button type="submit" class="btn bg-gradient-secondary">Upload</button>
						</form>

					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-8 mt-4 mb-4">
				<div class="card mb-4 shadow-sm">
					<div class="card-header bg-gradient-primary text-center">
						<h5 class="mb-0 text-white">Profit Calculator</h5>
					</div>
					<div class="card-body">
						<form id="profitCalculator">
							<div class="row">
								<div class="col-md-6">
									<div class="input-group input-group-outline my-3">
										<label class="form-label">Product Price (USD)</label>
										<input type="number" step="0.01" class="form-control" id="product_price" required
											onfocus="focused(this)" onfocusout="defocused(this)">
									</div>
								</div>
								<div class="col-md-6">
									<div class="input-group input-group-outline my-3">
										<label class="form-label">1 USD to INR</label>
										<input type="number" step="0.01" class="form-control" id="usd_inr" required
											onfocus="focused(this)" value="83" onfocusout="defocused(this)">
									</div>
								</div>
								<div class="col-md-6">
									<div class="input-group input-group-outline my-3">
										<label class="form-label">Amazon Fees (USD)</label>
										<input type="number" step="0.01" class="form-control" id="amazon_fee" required
											onfocus="focused(this)" onfocusout="defocused(this)">
									</div>
								</div>
								<div class="col-md-6">
									<div class="input-group input-group-outline my-3">
										<label class="form-label">Stitching Charges (INR)</label>
										<input type="number" step="0.01" class="form-control" id="stitching" required
											onfocus="focused(this)" value="350" onfocusout="defocused(this)">
									</div>
								</div>
								<div class="col-md-6">
									<div class="input-group input-group-outline my-3">
										<label class="form-label">Shipment Charges (INR)</label>
										<input type="number" step="0.01" class="form-control" id="shipment" required
											onfocus="focused(this)" value="1850" onfocusout="defocused(this)">
									</div>
								</div>
								<div class="col-md-6 d-flex align-items-center mt-3">
									<button type="submit" class="btn btn-primary w-100">Calculate</button>
								</div>
							</div>
						</form>

						<div class="mt-4">
							<h5>Result (INR): <span id="finalAmount" class="text-success fw-bold">-</span></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</main>
@endsection
@push('scripts')
	<script>
		// Chart: Sales Line Chart
		const salesCtx = document.getElementById("chart-line").getContext("2d");
		new Chart(salesCtx, {
			type: "line",
			data: {
				labels: {!! $salesLabels !!},
				datasets: [{
					label: "Sales",
					tension: 0,
					borderWidth: 2,
					pointRadius: 3,
					pointBackgroundColor: "#43A047",
					pointBorderColor: "transparent",
					borderColor: "#43A047",
					backgroundColor: "transparent",
					fill: true,
					data: {!! $salesData !!},
					maxBarThickness: 6
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					},
					tooltip: {
						callbacks: {
							title: function (context) {
								const fullMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
								return fullMonths[context[0].dataIndex];
							}
						}
					}
				},
				interaction: {
					intersect: false,
					mode: 'index',
				},
				scales: {
					y: {
						grid: {
							drawBorder: false,
							display: true,
							drawOnChartArea: true,
							drawTicks: false,
							borderDash: [4, 4],
							color: '#e5e5e5'
						},
						ticks: {
							display: true,
							color: '#737373',
							padding: 10,
							font: {
								size: 12,
								lineHeight: 2
							},
						}
					},
					x: {
						grid: {
							drawBorder: false,
							display: false,
							drawOnChartArea: false,
							drawTicks: false,
							borderDash: [5, 5]
						},
						ticks: {
							display: true,
							color: '#737373',
							padding: 10,
							font: {
								size: 12,
								lineHeight: 2
							},
						}
					},
				},
			},
		});

		// Chart: Views Bar Chart
		const viewsCtx = document.getElementById("chart-bars").getContext("2d");
		new Chart(viewsCtx, {
			type: "bar",
			data: {
				labels: {!! $viewsLabels !!},
				datasets: [{
					label: "Views",
					tension: 0.4,
					borderWidth: 0,
					borderRadius: 4,
					borderSkipped: false,
					backgroundColor: "#43A047",
					data: {!! $viewsData !!},
					barThickness: 'flex'
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					}
				},
				interaction: {
					intersect: false,
					mode: 'index',
				},
				scales: {
					y: {
						grid: {
							drawBorder: false,
							display: true,
							drawOnChartArea: true,
							drawTicks: false,
							borderDash: [5, 5],
							color: '#e5e5e5'
						},
						ticks: {
							suggestedMin: 0,
							suggestedMax: 500,
							beginAtZero: true,
							padding: 10,
							font: {
								size: 14,
								lineHeight: 2
							},
							color: "#737373"
						},
					},
					x: {
						grid: {
							drawBorder: false,
							display: false,
							drawOnChartArea: false,
							drawTicks: false,
							borderDash: [5, 5]
						},
						ticks: {
							display: true,
							color: '#737373',
							padding: 10,
							font: {
								size: 14,
								lineHeight: 2
							},
						}
					},
				},
			},
		});

		// Chart: Tasks Line Chart
		const tasksCtx = document.getElementById("chart-line-tasks").getContext("2d");
		new Chart(tasksCtx, {
			type: "line",
			data: {
				labels: {!! $tasksLabels !!},
				datasets: [{
					label: "Tasks",
					tension: 0,
					borderWidth: 2,
					pointRadius: 3,
					pointBackgroundColor: "#43A047",
					pointBorderColor: "transparent",
					borderColor: "#43A047",
					backgroundColor: "transparent",
					fill: true,
					data: {!! $tasksData !!},
					maxBarThickness: 6
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					}
				},
				interaction: {
					intersect: false,
					mode: 'index',
				},
				scales: {
					y: {
						grid: {
							drawBorder: false,
							display: true,
							drawOnChartArea: true,
							drawTicks: false,
							borderDash: [4, 4],
							color: '#e5e5e5'
						},
						ticks: {
							display: true,
							padding: 10,
							color: '#737373',
							font: {
								size: 14,
								lineHeight: 2
							},
						}
					},
					x: {
						grid: {
							drawBorder: false,
							display: false,
							drawOnChartArea: false,
							drawTicks: false,
							borderDash: [4, 4]
						},
						ticks: {
							display: true,
							color: '#737373',
							padding: 10,
							font: {
								size: 14,
								lineHeight: 2
							},
						}
					},
				},
			},
		});
	</script>
	<script>
		function focused(el) {
			el.parentElement.classList.add('is-focused', 'is-filled');
		}

		function defocused(el) {
			if (!el.value) {
				el.parentElement.classList.remove('is-filled');
			}
			el.parentElement.classList.remove('is-focused');
		}

		// Auto-fill support on page load
		document.addEventListener('DOMContentLoaded', function () {
			document.querySelectorAll('.form-control').forEach(function (input) {
				if (input.value) {
					input.parentElement.classList.add('is-filled');
				}
			});
		});

		// Calculator logic
		$('#profitCalculator').on('submit', function (e) {
			e.preventDefault();
			let price = parseFloat($('#product_price').val());
			let usdToInr = parseFloat($('#usd_inr').val());
			let amazonFee = parseFloat($('#amazon_fee').val());
			let stitching = parseFloat($('#stitching').val());
			let shipment = parseFloat($('#shipment').val());

			let afterPromo = price - (price * 0.05);
			let afterAmazon = afterPromo - amazonFee;
			let inrAmount = afterAmazon * usdToInr;
			let finalAmount = inrAmount - shipment - stitching;

			$('#finalAmount').text('₹' + finalAmount.toFixed(2));
		});
	</script>
@endpush
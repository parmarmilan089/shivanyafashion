@extends('admin.layout.page')
@section('contect')

	<!-- End Navbar -->
	<div class="container-fluid py-2">
		<div class="row">
			<div class="ms-3">
				<h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
				<p class="mb-4">Check the sales, value and bounce rate by country.</p>
			</div>
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
		<div class="row mt-2">
			<h3 class="mb-0 h4 font-weight-bolder mt-2">Meesho</h3>

			{{-- Today's Money --}}
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
								<h4 class="mb-0">₹{{ $meeshoSales }}</h4>
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
								<h4 class="mb-0">₹{{ $meeshoReturns }}</h4>
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
								<h4 class="mb-0">₹{{ $meeshoBaseSales }}</h4>
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
								<h4 class="mb-0">₹{{ $meeshoBaseReturns }}</h4>
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
		var ctx = document.getElementById("chart-bars").getContext("2d");

		new Chart(ctx, {
			type: "bar",
			data: {
				labels: ["M", "T", "W", "T", "F", "S", "S"],
				datasets: [{
					label: "Views",
					tension: 0.4,
					borderWidth: 0,
					borderRadius: 4,
					borderSkipped: false,
					backgroundColor: "#43A047",
					data: [50, 45, 22, 28, 50, 60, 76],
					barThickness: 'flex'
				},],
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


		var ctx2 = document.getElementById("chart-line").getContext("2d");

		new Chart(ctx2, {
			type: "line",
			data: {
				labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
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
					data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
					maxBarThickness: 6

				}],
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

		var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

		new Chart(ctx3, {
			type: "line",
			data: {
				labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
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
					data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
					maxBarThickness: 6

				}],
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
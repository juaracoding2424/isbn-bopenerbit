@extends('layouts.index')
@section('content')
<div class="d-flex flex-column flex-column-fluid">
			<!--begin::Content-->
			<div id="kt_app_content" class="app-content">
				<!--begin::Content container-->
				<div id="kt_app_content_container" class="app-container container-fluid">
					<!--begin::Row-->
					<div class="row g-5 gx-xl-10">
						<!--begin::Col-->
						<div class="col-xxl-12 mb-md-0">
							<!--begin::Row-->
							<div class="row g-5 g-xl-10">
								<!--begin::Col-->
								<div class="col-md-3 col-xl-3 mb-md-5">
									<!--begin::Card widget 8-->
									<div class="card overflow-hidden mb-5 mb-xl-10">
										<!--begin::Card body-->
										<a class="card-body d-flex justify-content-between flex-column px-0 pb-0" href="{{ url('/penerbit/isbn/data') }}">
											<!--begin::Statistics-->
											<div class="mb-10 px-9">
												<!--begin::Info-->
												<div class="d-flex align-items-center mb-2">
													<!--begin::Value-->
													<span class="fs-3hx fw-bold text-gray-800 me-2 lh-1"  id='isbn_diterima'></span>
													<!--end::Value-->
												</div>
												<!--end::Info-->
												<!--begin::Description-->
												<span class="fs-6 fw-semibold text-gray-500">Total ISBN</span>
												<!--end::Description-->
											</div>
											<!--end::Statistics-->
										</a>
										<!--end::Card body-->
									</div>
								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="col-md-3 col-xl-3 mb-md-5">
									<!--begin::Card widget 5-->
									<div class="card bg-gray-100 overflow-hidden mb-5 mb-xl-10">
										<!--begin::Header-->
										<a class="card-body d-flex justify-content-between flex-column px-0 pb-0" href="{{ url('/penerbit/isbn/permohonan') }}">
											<!--begin::Title-->
											<div class="mb-10 px-9">
												<!--begin::Info-->
												<div class="d-flex align-items-center mb-2">
													<!--begin::Amount-->
													<span class="fs-3hx fw-bold text-gray-900 me-2 lh-1 ls-n2" id='isbn_permohonan'></span>
													<!--end::Amount-->
												</div>
												<!--end::Info-->
												<!--begin::Subtitle-->
												<span class="text-gray-500 pt-1 fw-semibold fs-6">Permohonan ISBN</span>
												<!--end::Subtitle-->
											</div>
											<!--end::Title-->
										</a>
										<!--end::Header-->
									</div>
								</div>
								<div class="col-md-3 col-xl-3 mb-md-5">
									<!--end::Card widget 5-->
									<!--begin::Card widget 9-->
									<div class="card bg-danger overflow-hidden mb-5 mb-xl-10">
										<!--begin::Card body-->
										<a class="card-body d-flex justify-content-between flex-column px-0 pb-0"
											href="{{ url('/penerbit/isbn/masalah') }}">
											<!--begin::Statistics-->
											<div class="mb-10 px-9">
												<!--begin::Statistics-->
												<div class="d-flex align-items-center mb-2">
													<!--begin::Value-->
													<span class="fs-3hx fw-bold text-white me-2 lh-1" id='isbn_pending'></span>
													<!--end::Value-->
												</div>
												<!--end::Statistics-->
												<!--begin::Description-->
												<span class="fs-6 fw-semibold text-white">Permohonan bermasalah</span>
												<!--end::Description-->
											</div>
											<!--end::Statistics-->
										</a>
										<!--end::Card body-->
									</div>
									<!--end::Card widget 9-->
								</div>
								<!--end::Col-->

							</div>
							<!--end::Row-->

						</div>
						<!--end::Col-->
						<!--begin::Col-->
						<div class="col-xxl-6 mb-5 mb-xl-10">
							<!--begin::Chart widget 15-->
							<div class="card card-flush h-xl-100">
								<!--begin::Header-->
								<div class="card-header pt-7">
									<!--begin::Title-->
									<h3 class="card-title align-items-start flex-column">
										<span class="card-label fw-bold text-gray-900" id="title_chart">Data ISBN 2024
											{{ $nama_penerbit }}</span>
										<span class="text-gray-500 pt-2 fw-semibold fs-6">Statistik bulanan</span>
									</h3>
									<!--end::Title-->
									<!--begin::Toolbar-->
									<div class="card-toolbar">
										<!--begin::Menu-->
										<button
											class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end"
											data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
											data-kt-menu-overflow="true">
											<i class="ki-outline ki-dots-square fs-1 text-gray-500 me-n1"></i>
										</button>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-100px py-4"
											data-kt-menu="true" id="isbn_year">
											
										</div>
										<!--end::Menu-->
										<!--end::Menu-->
									</div>
									<!--end::Toolbar-->
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body pt-5">
									<!--begin::Chart container-->
									<div id="chart_isbn_month" class="min-h-auto ps-4 pe-6 mb-3 h-350px col-md-6 col-xxl-12"></div>
									<!--end::Chart container-->
								</div>
								<!--end::Body-->
							</div>
						</div>
						<!--end::Col-->
						<div class="col-xxl-6 mb-5 mb-xl-10">
							<div class="card card-flush h-xl-100">
								<!--begin::Header-->
								<div class="card-header pt-7 mb-5">
									<!--begin::Title-->
									<h3 class="card-title align-items-start flex-column">
										<span class="card-label fw-bold text-gray-800">Berita dan Pengumuman</span>
										<span class="text-gray-500 mt-1 fw-semibold fs-6">temukan informasi terbaru di
											sini</span>
									</h3>
									<!--end::Title-->
									<!--begin::Toolbar>
														<div class="card-toolbar">
															<a href="apps/ecommerce/sales/listing.html" class="btn btn-sm btn-light">View All</a>
														</div>
														<end::Toolbar-->
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body pt-0">
									<!--begin::Items-->
									<div class="m-0 hover-scroll-overlay-y " style="height: 350px" id="divBerita">
									</div>
									<!--end::Items-->
								</div>
								<!--end::Body-->
							</div>
						</div>
					</div>
					<!--end::Row-->

				</div>
				<!--end::Content container-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Content wrapper-->

<!--begin::Javascript-->
@stop
@section('script')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js ') }}"></script>
<script src="//cdn.amcharts.com/lib/5/themes/Responsive.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ url('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ url('assets/js/custom/widgets.js') }}"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
<script>
//$(document).ready(function(){
	var dataChart = [];
	function chart_isbn_month() {
		var e = document.getElementById("chart_isbn_month");

		if (e) {
			var t, a = function () {
					//var dataChart = generateData('2024');
					(t = am5.Root.new(e)).setThemes([am5themes_Responsive.new(t)]); //am5themes_Animated.new(t)]);
					var a = t.container.children.push(am5xy.XYChart.new(t, {
						panX: !1,
						panY: !1,
						layout: t.verticalLayout
					})),
						l = (a.get("colors"), dataChart),
						r = a.xAxes.push(am5xy.CategoryAxis.new(t, {
							categoryField: "month",
							renderer: am5xy.AxisRendererX.new(t, {
								minGridDistance: 30
							}),
							bullet: function (e, t, a) {
								return am5xy.AxisBullet.new(e, {
									location: .5,
									sprite: am5.Picture.new(e, {
										width: 24,
										height: 24,
										centerY: am5.p50,
										centerX: am5.p50,
									})
								})
							}
						}));
					r.get("renderer").labels.template.setAll({
						paddingTop: 20,
						fontWeight: "400",
						fontSize: 10,
						fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500"))
					}), r.get("renderer").grid.template.setAll({
						disabled: !0,
						strokeOpacity: 0
					}), r.data.setAll(l);
					var o = a.yAxes.push(am5xy.ValueAxis.new(t, {
						renderer: am5xy.AxisRendererY.new(t, {})
					}));
					o.get("renderer").grid.template.setAll({
						stroke: am5.color(KTUtil.getCssVariableValue("--bs-gray-300")),
						strokeWidth: 1,
						strokeOpacity: 1,
						strokeDasharray: [3]
					}), o.get("renderer").labels.template.setAll({
						fontWeight: "400",
						fontSize: 10,
						fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500"))
					});
					var i = a.series.push(am5xy.ColumnSeries.new(t, {
						xAxis: r,
						yAxis: o,
						valueYField: "counts",
						categoryXField: "month"
					}));
					i.columns.template.setAll({
						tooltipText: "{categoryX}: {valueY}",
						tooltipY: 0,
						strokeOpacity: 0,
						templateField: "columnSettings"
					}), i.columns.template.setAll({
						strokeOpacity: 0,
						cornerRadiusBR: 0,
						cornerRadiusTR: 6,
						cornerRadiusBL: 0,
						cornerRadiusTL: 6
					}), i.data.setAll(l), i.appear(), a.appear(1e3, 100)
				};
				am5.ready((function () {
					a()
				})), KTThemeMode.on("kt.thememode.change", (function () {
					t.dispose(), a()
				}))
			}
	}
	getYear();
	chart_isbn_month();
	getBerita();
	function getRandom(min, max) {
		return Math.floor(Math.random() * (max - min) + min);
	};
	function changeChart(year) {
		$('#title_chart').html("Data ISBN " + year + ' {{$nama_penerbit}} ');
		dataChart = generateData(year);
		am5.array.each(am5.registry.rootElements,
			function (root) {
				if (root.dom.id == "chart_isbn_month") {
					root.dispose();
					chart_isbn_month()
				}
			}
		);

	};
	function generateData(year) {
		dataChart = [];
		$.ajax({
            url: '{{ url('penerbit/dashboard/statistik-isbn') }}' + '?year=' + year,
            type: 'GET',
            contentType: false,
            processData: false,
			async :false,
            success: function(response) {
                for (var d = 0; d < response.length; d++) {
					dataChart = dataChart.concat({
						month: Intl.DateTimeFormat('id', { month: 'short' }).format(new Date(response[d]['MONTH_NUMB'])),
						counts: parseInt(response[d]['JUMLAH']),
						columnSettings: {
							fill: am5.color(KTUtil.getCssVariableValue("--bs-primary"))
						}
					});
				}

            },
            error: function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Server Error!'
                });
            }
        });
		return dataChart;
	};
	function getYear(){
	$.ajax({
            url: '{{ url('penerbit/dashboard/year') }}',
            type: 'GET',
            contentType: false,
            processData: false,
            success: function(response) {
				for(var i=0; i< response.length; i++){
					$('#isbn_year').append('<div class="menu-item px-3"><a href="#chart_isbn_month" class="menu-link px-3"onclick="changeChart('+response[i]['YEAR']+')">'+response[i]['YEAR']+'</a></div>');
				}
				let lenRes = response.length - 1;
				changeChart(response[lenRes]['YEAR']);
            },
            error: function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Server Error!'
                });
            }
        });
	}
	$.ajax({
            url: "{{ url('penerbit/dashboard/total-isbn') }}" + '?status=diterima',
            type: 'GET',
            contentType: false,
            processData: false,
            success: function(response) {
                $('#isbn_diterima').text(response);
            },
            error: function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Server Error!'
                });
            }
        });
	$.ajax({
        url: "{{ url('penerbit/dashboard/total-isbn') }}" + '?status=permohonan',
        type: 'GET',
        contentType: false,
        processData: false,
        success: function(response) {
            $('#isbn_permohonan').text(response);
        },
        error: function() {
            Toast.fire({
                icon: 'error',
                title: 'Server Error!'
            });
        }
    });
	$.ajax({
        url: "{{ url('penerbit/dashboard/total-isbn') }}" + '?status=pending',
        type: 'GET',
        contentType: false,
        processData: false,
        success: function(response) {
            $('#isbn_pending').text(response);
        },
        error: function() {
            Toast.fire({
                icon: 'error',
                title: 'Server Error!'
            });
        }
    });
	function getBerita(){
		$.ajax({
            url: "{{ url('penerbit/dashboard/berita') }}",
            type: 'GET',
            contentType: false,
            processData: false,
            success: function(response) {
				for(var i = 0; i < response.length; i++) {
					var date = new Date(response[i]['TANGGAL']);
					var newDate =Intl.DateTimeFormat('id', { dateStyle: 'full' }).format(date);
					$('#divBerita').append('<div class="d-flex flex-stack"><div class="d-flex flex-stack flex-row-fluid d-grid gap-2"><div class="me-5"><span class="fs-8 fw-bolder text-success text-uppercase">'+ newDate+'</span>');
					$('#divBerita').append('<a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">'+ response[i]['JUDUL']+'</a>');
					$('#divBerita').append('<span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">'+ response[i]['BERITA']+'</span></div></div></div>');
					$('#divBerita').append('<div class="separator separator-dashed my-3"></div>');
				}
            },
            error: function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Server Error!'
                });
            }
        });
	}
//})
</script>
@stop

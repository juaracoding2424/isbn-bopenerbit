<div id="kt_activities" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
	data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '900px'}"
	data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_activities_toggle"
	data-kt-drawer-close="#kt_activities_close">
	<div class="card shadow-none border-0 rounded-0">
		<!--begin::Header-->
		<div class="card-header" id="kt_activities_header">
			<h3 class="card-title fw-bold text-gray-900">Activity Logs</h3>
			<div class="card-toolbar">
				<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
					id="kt_activities_close">
					<i class="ki-outline ki-cross fs-1"></i>
				</button>
			</div>
		</div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body position-relative" id="kt_activities_body">
			<!--begin::Content-->
			<div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true"
				data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
				data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer" data-kt-scroll-offset="5px">
				<!--begin::Timeline items-->
				<div class="timeline timeline-border-dashed" id="log_aktifitas">
				</div>

			</div>
			<!--end::Content-->
		</div>
		<!--end::Body-->
		<!--begin::Footer-->
		<div class="card-footer py-5 text-center" id="kt_activities_footer">
			<a href="/penerbit/history" class="btn btn-bg-body text-primary">View All Activities
				<i class="ki-outline ki-arrow-right fs-3 text-primary"></i></a>
		</div>
		<!--end::Footer-->
	</div>
</div>
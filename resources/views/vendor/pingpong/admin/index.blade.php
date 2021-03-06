@extends($layout)

@section('content-header')
	<h1>
		Dashboard
		<small>Control panel</small>
	</h1>
@stop

@section('content')

<!-- Small boxes (Stat box) -->
<div class="row">
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3>
					{!! user()->count() !!}
				</h3>

				<p>
					All Users
				</p>
			</div>
			<div class="icon">
				<i class="fa fa-users"></i>
			</div>
			<a href="{!! route('admin.users.index') !!}" class="small-box-footer">
				More info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-green">
			<div class="inner">
				<h3>
					{!! Pingpong\Admin\Entities\Article::onlyPost()->count() !!}
				</h3>

				<p>
					All Articles
				</p>
			</div>
			<div class="icon">
				<i class="fa fa-book"></i>
			</div>
			<a href="{!! route('admin.articles.index') !!}" class="small-box-footer">
				More info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
</div>

			@stop

@section('script')
	<script src="{!! admin_asset('components/raphael/raphael-min.js') !!}"></script>
	<script src="{!! admin_asset('adminlte/js/plugins/morris/morris.min.js') !!}"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="{!! admin_asset('adminlte/js/AdminLTE/dashboard.js') !!}" type="text/javascript"></script>

@stop

<?php
/*
 * Presentation of a single metric for the dashboard
 */
?>
<div class="col-lg-3 col-md-6">
	<div class="panel panel-{panel}">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-3">
					<i class="fa fa-{icon} fa-5x"></i>
				</div>
				<div class="col-xs-9 text-right">
					<div class="huge">{value}</div>
					<div>{text}</div>
				</div>
			</div>
		</div>
		<a href="{link}">
			<div class="panel-footer">
				<span class="pull-left">{subtitle}</span>
				<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
				<div class="clearfix"></div>
			</div>
		</a>
	</div>
</div>



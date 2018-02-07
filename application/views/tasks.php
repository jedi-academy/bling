<div class="col-lg-4">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Recent Activity</h3>
		</div>
		<div class="panel-body">
			<div class="list-group">
				{activities}
				<a href="#" class="list-group-item">
					<span class="badge">{delta}</span>
					<strong>{factory}</strong> {action}
				</a>
				{/activities}
			</div>
<!--			<div class="text-right">
				<a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
			</div>-->
		</div>
	</div>
</div>

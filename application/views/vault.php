<div class="row">
    <div class="col-md-4 col-md-offset-4">
	<div class="login-panel panel panel-default">
	    <div class="panel-heading">
		<h3 class="panel-title">Please Sign In</h3>
	    </div>
	    <div class="panel-body">
		<form role="form" action="/vault/login" method="post">
		    <fieldset>
			<div class="form-group">
			    <input class="form-control" placeholder="Group code" name="group" type="text" autofocus>
			</div>
			<div class="form-group">
			    <input class="form-control" placeholder="Super secret access token" name="password" type="password" value="">
			</div>
			<input type="submit" class="btn btn-lg btn-success btn-block" value="Login"/>
		    </fieldset>
		</form>
	    </div>
	</div>
    </div>
</div>

<div class="row">
	<h2>These are your webapp deployment testing settings</h2>
	<p>
		The fields below are only needed if you wish to test deploy your webapp.
		If specified, then any push or merge to the configured repository
		will trigger a pull and deployment on the test server.

		You need to configure a webhook in your repository settings, 
		pointing at the <code>https://deployer.jlparry.com/please</code>
		endpoint. This would be for both pushes and pulls, and you should specify JSON as the data 
		format.

		Your webapp will be accessible through https://xxx.jlparry.com, where 'xxx'
		is your group name.
	</p>

	<form role="form" action="/vault/update" method="post">
		{forg}
		{frepo}
		{fbranch}
		<hr/>
		{fwebsite}
		<input type="submit" class="btn btn-lg btn-success btn-block" value="Update my settings"/>
	</form>
</div>

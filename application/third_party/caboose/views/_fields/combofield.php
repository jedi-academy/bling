<div class="form-group">
	<label for="{name}">{label}</label>
	<select id="{name}" name="{name}" title="{explain}" {disabled}>
		{options}
			<option value="{val}" {selected}>{display}</option>
		{/options}
	</select>
	<p class="help-block">{explain}</p>
</div>

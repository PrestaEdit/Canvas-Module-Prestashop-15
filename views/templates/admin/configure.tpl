{if $errors|@count > 0}
	<div class="error">
		<ul>
			{foreach from=$errors item=error}
				<li>{$error}</li>
			{/foreach}
		</ul>
	</div>
{/if}

<form action="{$request_uri}" method="post">
	<fieldset>
		<legend><img src="{$path}logo.gif" alt="" title="" />{l s='Settings' mod='example'}</legend>
		<label>{l s='Your label' mod='example'}</label>
		<div class="margin-form">
			<input type="text" size="20" name="EXAMPLE_CONF" value="{$EXAMPLE_CONF}" /> 
			<p class="clear">{l s='e.g. something' mod='example'}</p>
		</div>
		<center><input type="submit" name="{$submitName}" value="{l s='Save' mod='example'}" class="button" /></center>
	</fieldset>
</form>
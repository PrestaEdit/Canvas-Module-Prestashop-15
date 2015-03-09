{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author     PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

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
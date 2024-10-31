<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar -- Can't change End of the line charcter.
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.cmsminds.com
 * @since      1.0.3
 *
 * @package    Wpcmscf7
 * @subpackage Wpcmscf7/admin/partials
 */
?>
<table width='100%' class="paypal_set_table">	
	<tr>
		<td width="76%" valign="top">
		<table>
		<form method='post'>			
			
			<?php
			// save and update options
			if (isset($_POST['update'])) {			
			
				$options['currency'] = sanitize_text_field($_POST['currency']);
				$options['language'] = sanitize_text_field($_POST['language']);
				$options['liveaccount'] = sanitize_text_field($_POST['liveaccount']);
				$options['sandboxaccount'] = sanitize_text_field($_POST['sandboxaccount']);
				$options['mode'] = sanitize_text_field($_POST['mode']);
				$options['cancel'] = sanitize_text_field($_POST['cancel']);
				$options['return'] = sanitize_text_field($_POST['return']);
				$options['tax'] = sanitize_text_field($_POST['tax']);
				$options['tax_rate'] = sanitize_text_field($_POST['tax_rate']);
				
				update_option("wpcms_cf7pp_options", $options);
				
				echo "<br /><div class='updated'><p><strong>"; _e("Settings Updated."); echo "</strong></p></div>";
				
			}			
			
			$options = get_option('wpcms_cf7pp_options');
			if(isset($options) && is_array($options)){
				foreach ($options as $k => $v ) { $value[$k] = $v; }
			}
			
			$siteurl = get_site_url();
			
			?>
			<div class='wrap'><h2>Contact Form 7 - PayPal Settings</h2></div>
					
				<tr><th colspan="2" class="cf-head"><h2> PayPal Account </h2></th></tr>

				<tr>	
					<td class="cf-left-col"><b>Payment Mode:</b></td>
					<td class="cf-right-col">
					<input id="sandbox_mode" <?php if (isset($value['mode']) && $value['mode'] == "1") { echo "checked='checked'"; } ?> type='radio' name='mode' value='1'>  
						<label for="sandbox_mode"> On (Sandbox mode) </label>  &nbsp; &nbsp;
					<input id="live_mode" <?php if (isset($value['mode']) && $value['mode'] == "2") { echo "checked='checked'"; } ?> type='radio' name='mode' value='2'><label for="live_mode"> Off (Live mode) </label>
						
					
					<input type='hidden' name='tax' value=''>
					<input type='hidden' name='tax_rate' value=''>
				</tr>
				<tr class="live_pay_details">				
					<td class="cf-left-col"><b>Live Account: </b></td>
					<td class="cf-right-col">
						<input type='text' name='liveaccount' checked="checked" value='<?php if(isset($value["liveaccount"])) echo $value["liveaccount"]; ?>'> (Required)</td>
				</tr>
				<tr class="live_pay_details">
					<td colspan="2">
						If you don't have a PayPal account, you can sign up for free at <a target='_blank' href='https://paypal.com'>PayPal</a>.
					</td>
				<tr>
				<tr class="sandbx_pay_details">
					<td class="cf-left-col"><b>Sandbox Account: </b></td>
					<td class="cf-right-col">
						<input type='text' size="30" name='sandboxaccount' value='<?php if(isset($value["sandboxaccount"])) echo $value['sandboxaccount']; ?>'> (Optional)
					</td>
				</tr>
				<tr class="sandbx_pay_details">
					<td colspan="2">
						To create a Sandbox account, you first need a Developer Account. You can sign up for free at the <a target='_blank' href='https://www.sandbox.paypal.com/us/webapps/mpp/account-selection'>PayPal Developer</a> site. 
					</td>
				</tr>

				<tr><th colspan="2" class="cf-head"><h2> Language & Currency </h2></th></tr>
				<tr>
					<td class="cf-left-col"><b>Language:</b></td>
					<td class="cf-right-col">
						<select name="language" style="width:250px;">
						<option <?php if (isset($value['language']) && $value['language'] == "1") { echo "SELECTED"; } ?> value="1">Danish</option>
						<option <?php if (isset($value['language']) && $value['language'] == "2") { echo "SELECTED"; } ?> value="2">Dutch</option>
						<option <?php if (isset($value['language']) && $value['language'] == "3") { echo "SELECTED"; } ?> value="3">English</option>
						<option <?php if (isset($value['language']) && $value['language'] == "20") { echo "SELECTED"; } ?> value="20">English - UK</option>
						<option <?php if (isset($value['language']) && $value['language'] == "4") { echo "SELECTED"; } ?> value="4">French</option>
						<option <?php if (isset($value['language']) && $value['language'] == "5") { echo "SELECTED"; } ?> value="5">German</option>
						<option <?php if (isset($value['language']) && $value['language'] == "6") { echo "SELECTED"; } ?> value="6">Hebrew</option>
						<option <?php if (isset($value['language']) && $value['language'] == "7") { echo "SELECTED"; } ?> value="7">Italian</option>
						<option <?php if (isset($value['language']) && $value['language'] == "8") { echo "SELECTED"; } ?> value="8">Japanese</option>
						<option <?php if (isset($value['language']) && $value['language'] == "9") { echo "SELECTED"; } ?> value="9">Norwgian</option>
						<option <?php if (isset($value['language']) && $value['language'] == "10") { echo "SELECTED"; } ?> value="10">Polish</option>
						<option <?php if (isset($value['language']) && $value['language'] == "11") { echo "SELECTED"; } ?> value="11">Portuguese</option>
						<option <?php if (isset($value['language']) && $value['language'] == "12") { echo "SELECTED"; } ?> value="12">Russian</option>
						<option <?php if (isset($value['language']) && $value['language'] == "13") { echo "SELECTED"; } ?> value="13">Spanish</option>
						<option <?php if (isset($value['language']) && $value['language'] == "14") { echo "SELECTED"; } ?> value="14">Swedish</option>
						<option <?php if (isset($value['language']) && $value['language'] == "15") { echo "SELECTED"; } ?> value="15">Simplified Chinese -China only</option>
						<option <?php if (isset($value['language']) && $value['language'] == "16") { echo "SELECTED"; } ?> value="16">Traditional Chinese - Hong Kong only</option>
						<option <?php if (isset($value['language']) && $value['language'] == "17") { echo "SELECTED"; } ?> value="17">Traditional Chinese - Taiwan only</option>
						<option <?php if (isset($value['language']) && $value['language'] == "18") { echo "SELECTED"; } ?> value="18">Turkish</option>
						<option <?php if (isset($value['language']) && $value['language'] == "19") { echo "SELECTED"; } ?> value="19">Thai</option>
						</select>
						
						PayPal currently supports 18 languages.</br>
					</td>
				</tr>

				<tr>				
					<td class="cf-left-col"><b>Currency:</b> </td>
					<td class="cf-right-col">
						<select name="currency" style="width:250px;">
						<option <?php if (isset($value['currency']) && $value['currency'] == "1") { echo "SELECTED"; } ?> value="1">Australian Dollar - AUD</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "2") { echo "SELECTED"; } ?> value="2">Brazilian Real - BRL</option> 
						<option <?php if (isset($value['currency']) && $value['currency'] == "3") { echo "SELECTED"; } ?> value="3">Canadian Dollar - CAD</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "4") { echo "SELECTED"; } ?> value="4">Czech Koruna - CZK</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "5") { echo "SELECTED"; } ?> value="5">Danish Krone - DKK</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "6") { echo "SELECTED"; } ?> value="6">Euro - EUR</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "7") { echo "SELECTED"; } ?> value="7">Hong Kong Dollar - HKD</option> 	 
						<option <?php if (isset($value['currency']) && $value['currency'] == "8") { echo "SELECTED"; } ?> value="8">Hungarian Forint - HUF</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "9") { echo "SELECTED"; } ?> value="9">Israeli New Sheqel - ILS</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "10") { echo "SELECTED"; } ?> value="10">Japanese Yen - JPY</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "11") { echo "SELECTED"; } ?> value="11">Malaysian Ringgit - MYR</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "12") { echo "SELECTED"; } ?> value="12">Mexican Peso - MXN</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "13") { echo "SELECTED"; } ?> value="13">Norwegian Krone - NOK</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "14") { echo "SELECTED"; } ?> value="14">New Zealand Dollar - NZD</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "15") { echo "SELECTED"; } ?> value="15">Philippine Peso - PHP</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "16") { echo "SELECTED"; } ?> value="16">Polish Zloty - PLN</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "17") { echo "SELECTED"; } ?> value="17">Pound Sterling - GBP</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "18") { echo "SELECTED"; } ?> value="18">Russian Ruble - RUB</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "19") { echo "SELECTED"; } ?> value="19">Singapore Dollar - SGD</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "20") { echo "SELECTED"; } ?> value="20">Swedish Krona - SEK</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "21") { echo "SELECTED"; } ?> value="21">Swiss Franc - CHF</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "22") { echo "SELECTED"; } ?> value="22">Taiwan New Dollar - TWD</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "23") { echo "SELECTED"; } ?> value="23">Thai Baht - THB</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "24") { echo "SELECTED"; } ?> value="24">Turkish Lira - TRY</option>
						<option <?php if (isset($value['currency']) && $value['currency'] == "25") { echo "SELECTED"; } ?> value="25">U.S. Dollar - USD</option>
						</select>
						PayPal currently supports 25 currencies.
					</td>
				</tr>
				
				

				<tr><th colspan="2" class="cf-head"><h2> Other Settings </h2></th></tr>
				<tr>
					<td class="cf-left-col"><b>Cancel URL: </b></td>
					<td class="cf-right-col">
					<input type='text' name='cancel' size="50" value='<?php if(isset($value["cancel"])) echo $value["cancel"]; ?>'> (Optional)
					</td>
				</tr>
				<tr>
					<td colspan="2">
						If the customer goes to PayPal and clicks the cancel button, where do they go. Example: <?php echo $siteurl; ?>/cancel. Max length: 1,024. 
					</td>
				</tr>			
		
				<tr>
					<td class="cf-left-col"><b>Return URL: </b></td>
					<td class="cf-right-col">
					<input type='text' name='return' size="50" value='<?php if(isset($value["return"])) echo $value["return"]; ?>'> (Optional)
					</td>
				</tr>
				<tr>
					<td colspan="2"> 
						If the customer goes to PayPal and successfully pays, where are they redirected to after. Example: <?php echo $siteurl; ?>/thankyou. Max length: 1,024. 
					</td>
				</tr>	

				<tr>				
					<td>
						<input type='submit' name='btn2' class='button-primary' style='font-size: 17px;line-height: 28px;height: 32px;margin: 20px 0; ' value='Save Settings'>
					</td>
				</tr>			
				<input type='hidden' name='update' value='1'>
			</form>
			</table>
			</td>
		</tr>
</table>
	
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
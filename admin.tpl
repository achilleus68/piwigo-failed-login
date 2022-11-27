
<!-- Show the title of the plugin -->
<div class="titlePage">
 <h2>{'Failed Logins'|@translate}</h2>
</div>

<!-- Show content in a nice box -->
<fieldset>
<legend>{'Failed Logins'|@translate}</legend>

<div align=left>
<p>This plugin writes all failed login attempts into a text file, one line for one failed attempt. The format of the log looks like this:</p>

<pre>
2022/11/01 09:43:44 ip=192.168.254.1 username=Admin
</pre>

<p>The intended purpose of the logfile is to be used with <em>fail2ban</em>. Make sure the user running your website (e.g. <em>www-data</em>) must have read/write access to the
logfile.</p>
<div id="configContent">
<form method="post" class="properties">
<fieldset id="mainConf">
<span class="property" style="text-align:left;">
  <label for="log_filename">{'Log filename (including absolute path)'|@translate}</label>
</span><br /><br />
<input type="text" name="log_filename" id="log_filename" value="{$FAILED_LOGINS_FILENAME}" size="100" maxlength="100">
<br /><br />
  <input class="submit" type="submit" name="submitButton" value="{'Submit'|@translate}">
  <input class="submit" type="reset" name="resetButton" value="{'Reset'|@translate}">
</form>
</div>
</fieldset>


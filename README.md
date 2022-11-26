# Piwigo Failed Login logger
Log failed logins in Piwigo

## Credits
This plugin is an adaption of the plugin [Log Failed Logins](https://piwigo.org/ext/extension_view.php?eid=801) by [Tomas Sobek](https://piwigo.org/forum/profile.php?id=21757). That version does not work with Piwigo 13, so I made some changes to make it compatible. While Piwigo Admin Plugin section stills states that "This plugin does not seem to be compatible with this version of Piwigo", it does work.

### Usage
This plugin writes all failed login attempts into a text file, one line for each failed attempt. The intended purpose of the logfile is to be used with `fail2ban`. The format of the log looks like this:

```
2022/11/01 09:43:44 ip=192.168.254.1 username=Admin
```

### Installation
Download the code and place it in a subfolder of the Piwigo plugin directory. The plugin should now be visible in the Piwigo Admin Plugin section.

### Configuration
On the settings page of the plugin, add the path to the config file in the form at the botton, and save. Make sure that Piwigo has write access to the file.

### Fail2ban
In your `/etc/fail2ban/jail.local`:

```
[piwigo]
enabled = true
port = http,https
filter = piwigo
logpath = <<path to your failed login file>>
```

Create new filter `/etc/fail2ban/filter.d/piwigo.conf` with following content:

```
[INCLUDES]
before = common.conf
[Definition]
failregex = ip=<HOST>
ignoreregex =
```

#### Buy me a coffee
If you like this plugin, you can [Buy me a coffee](https://www.buymeacoffee.com/achilleusr).


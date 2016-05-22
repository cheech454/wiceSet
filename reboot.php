<?php
$contents = file_get_contents('interface');
$contents=trim(str_replace('{{$essid}}',$_SESSION["essid"],$contents));
$contents=trim(str_replace('{{$password}}',$_SESSION["wifipassword"] ,$contents));
file_put_contents('/etc/network/interfaces',$contents);
shell_exec('update-rc.d hostapd disable');
shell_exec('update-rc.d dnsmasq disable');
shell_exec('update-rc.d phpserve disable');
shell_exec('service hostapd stop');
shell_exec('service dnsmasq stop');
shell_exec('service phpserve stop');
shell_exec('reboot');
die();
?>

<?php
$contents = file_get_contents('interface');
$contents=trim(str_replace('{{$essid}}',$_POST['essid'],$contents));
$contents=trim(str_replace('{{$password}}',$_POST['wifipassword'],$contents));
file_put_contents('/etc/network/interfaces',$contents);
shell_exec('ifdown wlan0');
shell_exec('ifup wlan0');
$wifi=shell_exec('iwgetid -r');
shell_exec('echo "auto lo" >/etc/network/interfaces');
shell_exec('echo "iface lo inet loopback" >>/etc/network/interfaces');
shell_exec('echo "auto eth0" >>/etc/network/interfaces');
shell_exec('echo "iface eth0 inet dhcp" >>/etc/network/interfaces');
shell_exec('echo "auto wlan0" >>/etc/network/interfaces');
shell_exec('echo "iface wlan0 inet static" >>/etc/network/interfaces');
shell_exec('echo "address 10.0.0.1" >>/etc/network/interfaces');
shell_exec('echo "netmask 255.255.255.0" >>/etc/network/interfaces');
shell_exec('echo "broadcast 255.0.0.0" >>/etc/network/interfaces');
shell_exec('ifdown wlan0');
shell_exec('ifup wlan0');
shell_exec('service hostapd restart');
shell_exec('service dnsmasq restart');
//shell_exec('service phpserve start');
if(!empty($wifi)){
    // shell_exec('update-rc.d hostapd disable');
    // shell_exec('update-rc.d dnsmasq disable');
    // shell_exec('update-rc.d phpserve disable');
    // shell_exec('service hostapd stop');
    // shell_exec('service dnsmasq stop');
    // shell_exec('service phpserve stop');
    header("Location: index.php?status=success");
    die();
}else{
    header("Location: index.php?status=failed");
    die();
}
?>

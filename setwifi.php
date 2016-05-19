<?php

$contents = file_get_contents('interface');
$contents=trim(str_replace('{{$essid}}',$_POST['essid'],$contents));
$contents=trim(str_replace('{{$password}}',$_POST['wifipassword'],$contents));
file_put_contents('/etc/network/interfaces',$contents);
shell_exec('ifconfig wlan0 up');
shell_exec('service networking restart');
//sleep(20);
$wifi=shell_exec('iwgetid -r');
if(!empty($wifi)){
    shell_exec('update-rc.d hostapd disable');
    shell_exec('update-rc.d dnsmasq disable');
    shell_exec('service hostapd stop');
    shell_exec('service dnsmasq stop');
    // shell_exec("rm /etc/cron.d/serve");
    return ['status'=>'<h4 class="bg-success">Connected to <strong>'.$_POST['essid'].'</strong>.<br>Please reboot.</h4>'];
}else{
    shell_exec('echo "auto lo" >/etc/network/interfaces');
    shell_exec('echo "iface lo inet loopback" >>/etc/network/interfaces');
    shell_exec('echo "iface eth0 inet dhcp" >>/etc/network/interfaces');
    shell_exec('echo "auto wlan0" >/etc/network/interfaces');
    shell_exec('echo "iface wlan0 inet static" >>/etc/network/interfaces');
    shell_exec('echo "address 10.0.0.1" >>/etc/network/interfaces');
    shell_exec('echo "netmask 255.255.255.0" >>/etc/network/interfaces');
    shell_exec('echo "broadcast 255.0.0.0" >>/etc/network/interfaces');
    return ['status'=>'<h4 class="bg-danger">Could not connect to <strong>'.$_POST['essid'].'</strong>.<br>Please try again</h4>'];
}
 ?>

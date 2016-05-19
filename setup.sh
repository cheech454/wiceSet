#!/usr/bin/env bash
dpkg --clear-avail
apt-get update
apt-get -y install php5-common php5-cgi php5 php5-cli hostapd dnsmasq git

service hostapd stop
service dnsmasq stop

rm -rf /var/www/html
git clone https://github.com/cheech454/wIceSet.git /var/www/html
cd /var/www/html || exit
chmod -R 777 /var/www/html

unzip hostapd.zip
mv /usr/sbin/hostapd /usr/sbin/hostapd.bak
mv hostapd /usr/sbin/hostapd.edimax
ln -sf /usr/sbin/hostapd.edimax /usr/sbin/hostapd
chown root.root /usr/sbin/hostapd
chmod 755 /usr/sbin/hostapd

touch /etc/hostapd/hostapd.conf
echo "interface=wlan0" >/etc/hostapd/hostapd.conf
echo "ssid=icetoaster" >>/etc/hostapd/hostapd.conf
echo "channel=1" >>/etc/hostapd/hostapd.conf

echo "log-facility=/var/log/dnsmasq.log" >>/etc/dnsmasq.conf
echo "address=/#/10.0.0.1" >>/etc/dnsmasq.conf
echo "interface=wlan0" >>/etc/dnsmasq.conf
echo "dhcp-range=10.0.0.10,10.0.0.250,12h" >>/etc/dnsmasq.conf
echo "no-resolv" >>/etc/dnsmasq.conf
echo "log-queries" >>/etc/dnsmasq.conf

echo "auto lo" >/etc/network/interfaces
echo "iface lo inet loopback" >>/etc/network/interfaces
echo "iface eth0 inet dhcp" >>/etc/network/interfaces
echo "auto wlan0" >/etc/network/interfaces
echo "iface wlan0 inet static" >>/etc/network/interfaces
echo "address 10.0.0.1" >>/etc/network/interfaces
echo "netmask 255.255.255.0" >>/etc/network/interfaces
echo "broadcast 255.0.0.0" >>/etc/network/interfaces

sed -i  's^DAEMON_CONF=^DAEMON_CONF=/etc/hostapd/hostapd.conf^g' /etc/init.d/hostapd

cp /var/www/html/phpserve /etc/init.d/phpserve

sudo update-rc.d hostapd defaults
sudo update-rc.d dnsmasq defaults
sudo update-rc.d phpserve defaults


service hostapd start
service dnsmasq start
service phpserve start

echo '*************'
echo 'Please Reboot'
echo '*************'

<?php header("Content-type: text/plain"); ?>
# Kickstart for CentOS 7

install
url --url http://mirror.rackspace.com/CentOS/7/os/x86_64/
lang en_US.UTF-8
keyboard us
network --onboot=yes --device=eth0 --bootproto=dhcp --noipv6 --hostname=<?php echo $_GET["hostname"]; ?>

rootpw K2r0L7x9
firewall --service=ssh
authconfig --enableshadow --passalgo=sha512
selinux --disabled
timezone --utc America/Chicago
bootloader --location=mbr --driveorder=sda
# The following is the partition information you requested
# Note that any partitions you deleted are not expressed
# here so unless you clear all partitions first, this is
# not guaranteed to work

clearpart --all
zerombr
part pv.01 --grow --size=1
part /boot --fstype=ext4 --asprimary --size=500
part swap --fstype=swap --recommended

volgroup VolGroup00 pv.01

logvol /opt --fstype=ext4 --name=opt --vgname=VolGroup00 --size=5000
logvol / --fstype=ext4 --name=root --vgname=VolGroup00 --size=15000
logvol /var/log --fstype=ext4 --name=log --vgname=VolGroup00 --size=5000
logvol /home --fstype=ext4 --name=home --vgname=VolGroup00 --size=5000

text
reboot

%packages --nobase
@core
-aic94xx-firmware
-atmel-firmware
-bfa-firmware
-ipw2100-firmware
-ipw2200-firmware
-ivtv-firmware
-iwl1000-firmware
-iwl3945-firmware
-iwl4965-firmware
-iwl5000-firmware
-iwl5150-firmware
-iwl6000-firmware
-iwl6050-firmware
-kernel-firmware
-libertas-usb8388-firmware
-ql2100-firmware
-ql2200-firmware
-ql23xx-firmware
-ql2400-firmware
-ql2500-firmware
-rt61pci-firmware
-rt73usb-firmware
-xorg-x11-drv-ati-firmware
-zd1211-firmware

vim-enhanced
openssh-server
openssh-clients
file
man
mlocate
open-vm-tools

%end

%post
rpm -ivh http://mirror.rackspace.com/epel/7/x86_64/e/epel-release-7-5.noarch.rpm
rpm -ivh http://mirror.rackspace.com/ius/stable/CentOS/7/x86_64/ius-release-1.0-14.ius.centos7.noarch.rpm
rpm -ivh http://yum.puppetlabs.com/el/7/products/x86_64/puppetlabs-release-7-11.noarch.rpm
yum -y install puppet

%end


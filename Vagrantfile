# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  # base box
  config.vm.box = "ubuntu/trusty64"

  # machine configuration
  config.vm.provider "virtualbox" do |v|
    v.customize ["modifyvm", :id, "--cpuexecutioncap", "50", "--memory", "512"]
    # v.gui = true
  end

  # ssh
  config.ssh.forward_agent = true

  # workaround for ssh agent forwarding issue during provisioning
  # https://github.com/mitchellh/vagrant/issues/1303
  config.vm.provision :shell do |shell|
      shell.inline = "touch $1 && chmod 0440 $1 && echo $2 > $1"
      shell.args = %q{/etc/sudoers.d/root_ssh_agent "Defaults env_keep += \"SSH_AUTH_SOCK\""}
  end

  # provision
  config.vm.provision :shell, path: "provision.sh"

  # networking
  config.vm.network "forwarded_port", guest: 81, host: 8081
  config.vm.network "forwarded_port", guest: 443, host: 8443

  # forward host port using vagrant trigger
  # http://salvatore.garbesi.com/vagrant-port-forwarding-on-mac/
  # $ vagrant plugin install vagrant-triggers
  config.trigger.after [:provision, :up, :reload] do
    system('echo "
rdr pass on lo0 inet proto tcp from any to 127.0.0.1 port 443 -> 127.0.0.1 port 8443
" | sudo pfctl -ef - > /dev/null 2>&1; echo "==> Fowarding Ports: 443 -> 8443"')
  end

  config.trigger.after [:halt, :destroy, :suspend] do
    system("sudo pfctl -f /etc/pf.conf > /dev/null 2>&1; echo '==> Removing Port Forwarding'")
  end

  # make application folder writable by web server
  config.vm.synced_folder "./", "/var/www/app",
    owner: "vagrant",
    group: "www-data",
    mount_options: ["dmode=775,fmode=664"]

end

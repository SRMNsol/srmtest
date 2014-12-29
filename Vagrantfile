# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  # base box
  config.vm.box = "chef/ubuntu-14.10"

  # machine configuration
  # config.vm.provider "virtualbox" do |v|
  #   v.memory = 1024
  #   v.gui = true
  # end

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
  config.vm.provision :shell, path: "development.sh"

  # networking
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 81, host: 8081

  # make application folder writable by web server
  config.vm.synced_folder "./", "/var/www/app",
    owner: "vagrant",
    group: "www-data",
    mount_options: ["dmode=775,fmode=664"]

end

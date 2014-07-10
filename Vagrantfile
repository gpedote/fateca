# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  
    # Host name of the guest 
    config.vm.hostname = "fateca"

    config.vm.box = "precise64-chef"
    config.vm.box_url = "https://opscode-vm.s3.amazonaws.com/vagrant/opscode_ubuntu-12.04_provisionerless.box"
    config.vm.network "private_network", ip: "192.168.13.37"
    config.vm.network :forwarded_port, guest: 80, host: 8080

    if Vagrant.has_plugin?("vagrant-cachier")
        config.cache.scope = :box
    end

    # Chef Install
    config.omnibus.chef_version = "11.8.2"

    # Warns to use vagrant-omnibus plugin
    unless Vagrant.has_plugin?("vagrant-omnibus")
        puts "--- WARNING ---"
        puts "Fateca requires the vagrant-omnibus plugin"
        puts "command  to install: vagrant plugin install vagrant-omnibus"
        puts "---------------"
    end

    # Enable provisioning with chef solo
    config.vm.provision :chef_solo do |chef|
        chef.cookbooks_path = "./chef/cookbooks"
        chef.roles_path = "./chef/roles"
        #chef.data_bags_path = "./chef/data_bags"
        chef.environments_path = "./chef/environments"
        #chef.environment = "production"
        chef.add_role "fateca"
    end

    # VBox config
    config.vm.provider "virtualbox" do |v|
        v.gui = false
        v.name = "fateca"
        v.memory = 1024
        v.customize ["modifyvm", :id, "--cpuexecutioncap", "80"]
        v.customize ["modifyvm", :id, "--ioapic", "on"]
        #v.customize ["modifyvm", :id, "--cpus", "2"] 
    end
end

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

    # Enable provisioning with chef solo
    config.vm.provision :chef_solo do |chef|
        chef.cookbooks_path = "./chef/cookbooks"
        chef.roles_path = "./chef/roles"
        chef.add_role "fateca"
        #chef.data_bags_path = "../my-recipes/data_bags"
        #chef.add_recipe "mysql"
    end
end

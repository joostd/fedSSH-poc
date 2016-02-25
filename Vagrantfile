# -*- mode: ruby -*-
# vi: set ft=ruby :

hosts = {
  "web" => "192.168.100.10",
  "ssh" => "192.168.100.11",
  "ldap" => "192.168.100.12",
}

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.ssh.insert_key = false 

  hosts.each do |name, ip|
    config.vm.define name do |machine|
      machine.vm.hostname = name
      machine.vm.network :private_network, ip: ip
      machine.vm.provider "virtualbox" do |v|
      machine.vm.synced_folder name, "/vagrant_data"
          v.name = name
      end
    end
  end

  config.vm.provision "ansible" do |ansible|
    ansible.playbook = "ansible/playbook.yml"
    #ansible.verbose = "vvvv"

    ansible.groups = {
      "webservers" => ["web"],
      "sshservers" => ["ssh"],
      "ldapservers" => ["ldap"],
      "all_groups:children" => ["webservers", "sshservers", "ldapservers"],
      "all_groups:vars" => { "domain" => "example.org"}
    }
  end

end


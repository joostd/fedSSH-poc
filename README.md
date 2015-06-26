# fedSSH-poc
PoC code for mitigating the Federated SSH problem using pubkey autoprovisioning

## Install

Install [vagrant](http://docs.vagrantup.com/v2/installation/) to launch two VMs using Ubuntu Server 14.04 LTS (Trusty Tahr). The VMs will have IP addresses 192.168.100.10 and 192.168.100.11, installed as web server and SSH server, respectively.

Install [ansible](http://docs.ansible.com/intro_installation.html#getting-ansible) for provisioning the VM with all necessary software.

To launch the VMs and install all software, simply type

  vagrant up
  
The web server authenticates users using SAML 2.0 against the Feide [OpenIdP](https://openidp.feide.no). Register an account there to be able to log in.

The SSH server authenticates users using public keys. The public key used for a particular user is retrieved from an API on the web server.

## Usage

The default names and IP addresses for the servers need to be either changed or you will need to edit your `/etc/hosts` file to include

  192.168.100.10  example.org
  192.168.100.11  ssh.example.org

Point your web browser to https://example.org/ and log in using your OpenIdP account. Upload an SSH public key to associate with your account.

After uploading your key, you can access the SSH server using

  ssh 192.168.100.11 -l ubuntu -i


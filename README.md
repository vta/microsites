[![Waffle.io - Columns and their card count](https://badge.waffle.io/vta/microsites.svg?columns=all)](https://waffle.io/vta/microsites)
[![BrowserStack](wp-content/themes/customizr-pro-newswheel/browserstack.png)](https://www.browserstack.com)

# VTA micro-sites
A collection of files need to support the VTA's usage of micro-sites for both internal and external consumption by employees, vendors and the general public.

## System Requirements
Our websites are hosted using AWS & Ubuntu with WordPress as the common framework to support individual theme development, customized plugins for internal applications, and consistency across development and deployment platforms.

To aid other organizations and individuals in creating a modern LAMP stack we included the following links:

 - [AWS - Amazon Web Services including EC2, S3, RDS & EB](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/create_deploy_PHP.rds.html)
 - [Ubuntu 16.04 LTS](https://insights.ubuntu.com/2017/04/05/ubuntu-on-aws-gets-serious-performance-boost-with-aws-tuned-kernel/)
 - [Apache 2.4](https://help.ubuntu.com/lts/serverguide/httpd.html)
 - [MySQL 5.7](https://aws.amazon.com/about-aws/whats-new/2016/02/amazon-rds-now-supports-mysql-5-7/)
 - [PHP 7.1](https://launchpad.net/~ondrej/+archive/ubuntu/php)
 - [PHP-FPM](http://php.net/manual/en/install.fpm.php)
 - [ImageMagick 6.8](https://www.imagemagick.org)
 - [Postfix & Office 365](https://www.onceuponanipsum.com/relay-mail-with-office-365-and-postfix/)
 - [WordPress 4.9](https://codex.wordpress.org/)

## Installation
In order to use a micro-site theme template you'll need a couple of things in place before using this repository.

First you'll need a working AWS EC2 cloud instance, with Ubuntu, Apache, PHP and MySQL configured as indicated above.

Best practices indicate you should confine the `/public_html` folder to a non-privileged user's home directory and use `apache2-suexec-pristine` to restrict the daemon processes.

Lastly you'll need to configure [WordPress Multi-Site](https://codex.wordpress.org/Create_A_Network) to make use of the RDS endpoint with an [Apache Virtual Host container](https://httpd.apache.org/docs/2.4/vhosts/examples.html) and enable [SuEXEC](https://httpd.apache.org/docs/2.4/suexec.html) with the `SuExecUserGroup` directive for security reasons.

You're now ready to begin using [WordPress Child Themes](https://codex.wordpress.org/Child_Themes) properly keeping the changes unique to the individual micro-site.
&nbsp;Additionally we gain the benefits globally by the usage of network plugins and shared common assets.


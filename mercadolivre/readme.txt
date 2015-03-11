Thanks for using this extension!

Current Version: 2.1

Installation: 
-------------
Simply upload the files in your opencart directory on the server. No file will be overwritten.
VQMOD is needed to work. Please install vqmod if it is not installed already on your server

Instruction:
==============
Please check Help button after installing. 


Upgrade instruction:
-----------------------

A upgrade button will be appeared if any database upgradation needed in the Mercadoliver Dashboard page. Please click on that icon.
Finally please re-import category by visiting this url http://YOUR_DOMAIN_NAME/index.php?route=mercadolivre/mercadolivre/syncat

Upgrade for Auto Feedback features:
------------------------
Please upload latest files on your server. Simply overwrite old files.

Now you will have to run following sql from phpmyadmin:

ALTER TABLE `YOUR_PREFIX_mercadolivre_order` ADD `feedback` TINYINT( 1 ) NOT NULL 
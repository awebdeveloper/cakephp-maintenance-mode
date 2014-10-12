Cakephp Maintenance Mode
========================

CakePHP Maintenance Mode is to put your website in maintenance mode while you do your upgrade. Most ppl would add a static file on the server and route all request to it during maintenance. The file is shown to everybody including you unless a rewrite rule or expressions is added to exclude yourself which would complicate the matter.  

This filter file would tell CakePHP to put all requests to maintenance mode i.e show a msg but would allow requests from your IPs to be processed normally.


## Installation

_[Using [Composer](http://getcomposer.org/)]_

[View on Packagist](https://packagist.org/packages/awebdeveloper/cakephp-maintenance-mode), and copy
the JSON snippet for the latest version into your project's `composer.json`. Eg, v. 1.2.0 would look like this:

	{
		"require": {
			"awebdeveloper/cakephp-maintenance-mode": "1.2.0"
		}
	}

Because this plugin has the type `cakephp-plugin` set in it's own `composer.json`, composer knows to install it inside your `/Plugin` directory, rather than in the usual vendor directory.
It is recommended that you add `/Plugin/MaintenanceMode` to your .gitignore file. (Why? [Read this](http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).)

_[Manual]_

* Download this: [http://github.com/awebdeveloper/cakephp-maintenance-mode/zipball/master](http://github.com/awebdeveloper/cakephp-maintenance-mode/zipball/master)
* Unzip that download.
* Copy the resulting folder to `app/Plugin`
* Rename the folder you just copied to `MaintenanceMode`

_[GIT Submodule]_

In your app directory type:

	git submodule add -b master git://github.com/awebdeveloper/cakephp-maintenance-mode.git Plugin/MaintenanceMode
	git submodule init
	git submodule update

_[GIT Clone]_

In your `Plugin` directory type:

	git clone -b master git://github.com/awebdeveloper/cakephp-maintenance-mode.git MaintenanceMode


### Usage ###

In your **Bootstrap.php** add 

```php
Configure::write('MaintenanceMode', array(
	'enabled' => true,
	'view' =>	array(
		'layout' => '',
		'template' => 'MaintenanceMode/index'
	),
	'ip_filters' => array('127.0.*.*')
));
```

Also in the same file find the below code and add this line

```php
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher',
    'MaintenanceMode.MaintenanceMode' ## this line 
));
```

### Parameters ###
It supports Following Parameters

1. **enabled**  set this to *true* to enable it
2. **view** this is a array that accepts the template and the layout. If layout key is absent it will use the default layout.
    ```
    	'view' =>	array(
    		'template' => 'Pages/index'
    	),
    ```
    or

    ```
    	'view' =>	array(
     		'layout' => 'main',
    		'template' => 'MaintenanceMode/index'
    	),
    ```
3. **ip_filters** this is either a string containing a single IP or an array containing multiple IPs for which maintainance mode will NOT  be applied.

    ```
    	'ip_filters' => array('127.0.*.*','201.201.201.1')
    ```
    or

    ```
    	'ip_filters' => '201.201.201.1'
    ```




For info read the docs on dispatch filter

http://book.cakephp.org/2.0/en/development/dispatch-filters.html



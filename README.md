Cakephp Maintenance Mode
========================

CakePHP Maintenance Mode is to put your website in maintenance mode while you do your upgrade. Most ppl would add a static file on the server and route all request to it during maintenance. The file is shown to everybody including you unless a rewrite rule or expressions is added to exclude yourself which would complicate the matter.  

This filter file would tell CakePHP to put all requests to maintenance mode i.e show a msg but would allow requests from your IPs to be processed normally.




### Setup ###
Copy the file **MaintenanceMode.php** into 
```
app\Lib\Routing\Filter
```


Now in your **Bootstrap.php** add 

```
Configure::write('MaintenanceMode', array(
	'enabled' => true,
	'view' =>	array(
		'layout' => '',
		'template' => 'MaintenanceMode/index'
	),
	'ip_filters' => array('127.0.*.*')
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


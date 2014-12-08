<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	echo getcwd() . "\n";
	return View::make('hello');
});

Route::get('test', function()
{
    echo 'Environment: '.App::environment().'<br>';
    $test = Feed::users();
    echo $test;
    $results = DB::select('SHOW DATABASES;');
    echo print_r($results);
    phpinfo();
}); 

Route::get('xen', function()
{
	$url = "https://10.12.49.115"; /* URL of the Citrix XenSerer Xapi */
	$login = "wbirkmaier"; /* login/user for the citrix box */
	$password = ""; /* password for the user */
	
	/* Establish session with Xenserver */
	$xenserver = new XenApi($url, $login, $password);
	
	/* Once sucessfully logged in - any method (valid or not) is passed to the XenServer.
	Replace the first period (.) of the method with a underscore (_) - because PHP doesnt like 
	periods in the function names.
	All the methods (other then logging in) require passing the session_id as the first parameter,
	however this is done automatically - so you do not need to pass it.
	For example, to do VM.get_all(session_id) and get all the vms as an array, then get/print the details of each
	using VM.get_record(session_id, self) (self = VM object):
	 */
	
	$vms_array = $xenserver->VM_get_all();

	foreach ($vms_array as $vm) {
	    $record = $xenserver->VM_get_record($vm);
	echo '<pre>';
	    print_r($record);
	echo '</pre>';
}
	/*For parameters/usage, check out:
	    http://docs.vmd.citrix.com/XenServer/5.5.0/1.0/en_gb/api/docs/html/browser.html
	To see how parametes are returned, print_r() is your friend :)
	*/
});


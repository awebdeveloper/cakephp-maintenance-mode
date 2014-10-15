<?php


App::uses('DispatcherFilter', 'Routing');
App::uses('View', 'View');

class MaintenanceMode extends DispatcherFilter {
	public function beforeDispatch(CakeEvent $event) {

		$MaintenanceMode = Configure::read('MaintenanceMode');
	
		/* Not in maintenance mode*/
		if (!$MaintenanceMode['enabled']) {
		  return;
		}

		/* Allow access from following IPS*/
		if(!empty($MaintenanceMode['ip_filters'])){
			if(!is_array($MaintenanceMode['ip_filters'])){
				$ips = array($MaintenanceMode['ip_filters']);
			}
			else{
				$ips = $MaintenanceMode['ip_filters'];
			}

			$userIP = $this->_getUserIpAddr();
			foreach($ips as $ip){
				if($this->_compareIp($userIP,$ip)){
					return ;
				}
			}
		}


		$statusCode 	= 503;
		$body           = 'Currently undergoing maintenance';

		if (!empty($MaintenanceMode['code'])) {
			$statusCode = $MaintenanceMode['code'];
		}


		if (!empty($MaintenanceMode['view']['template'])) {
			$View = $this->_getView();
			$body = $View->render($MaintenanceMode['view']['template'], $MaintenanceMode['view']['layout']);
		} 
		
		$event->data['response']->statusCode($statusCode);
		$event->data['response']->body($body);
		$event->stopPropagation();
		return $event->data['response'];
	}
	
	protected function _getView() {

		$MaintenanceMode = Configure::read('MaintenanceMode');

		$helpers = array('Html');
		if (!empty($MaintenanceMode['view']['helpers']) && is_array($helpers)) {
			$helpers = $MaintenanceMode['view']['helpers'];
		}

		$View 				= new View(null);
		$View->viewVars 	= $MaintenanceMode;
		$View->hasRendered 	= false;
		$View->helpers 		= $helpers;
		$View->loadHelpers();
		return $View;
	}

	protected function _getUserIpAddr()
	{
		$ip = '0.0.0.0';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){ //if from shared
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //if from a proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}


	protected function _compareIp($userIp, $compareIp)
	{
		$compareIpLowerBoundary = str_replace("*", "0", $compareIp);
 		$compareIpUpperBoundary = str_replace("*", "255", $compareIp);

 		if(ip2long($compareIpLowerBoundary) <= ip2long($userIp) &&
 		  ip2long($userIp) <= ip2long($compareIpUpperBoundary))
 		{
 			return true;
 		}
 		else{
 			return false;
 		}
	}
  
}


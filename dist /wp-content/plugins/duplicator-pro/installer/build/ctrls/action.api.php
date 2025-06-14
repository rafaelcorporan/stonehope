<?php
//-- START OF ACTION API
class DUPX_API_REQUEST 
{
	public $report	= array('operation' => '', 'process_time' => '');
	public $result;
}

class DUPX_API_ERROR 
{
	public $request;
	public $message;
	public $exception;
}


/**
 *  The DUPX_API_ROUTE object is a routable object that the DUPX_API_SERVER
 *  uses to help convert methods to routable service calls.
 * 
 *	In order for a classes method to become routeable the following route
 *  tag must be delcated in the comments section of the method in the format
 *  below with {} brackets around that name of the actual paramter.
 *  
 *  <route template="/api/category/example_method/{param1}/{param2}/{list*}/" type="request">
 *  
 *  TEMPLATE ATTRIBUTE:
 *	When called via an http request the paramter name should be substituted 
 *  with the actual value for the parameter such as
 * 
 *	/api/category/example_method/1/test/a,b,c/
 *  
 *	Supported parameter types:
 *  {param1} = string type 
 *		example: /test/  or  /1/
 * 
 *  {list*}  = array type  
 *		example: /1,2,3/  or  /a,b,c/
 *  
 *  TYPE ATTRIBUTE:
 *  The attribute type="request" is used to determine where the request values 
 *  are retrived from.  The default is "request" meaning it looks for:
 *  PATH, GET, POST in that order.  If you want the request to only look
 *  for GET requets then set the attribute to type="get"
 *
 */
class DUPX_API_ROUTE 
{
	public $template;
	public $type;
	public $operation;
	public $params = array();
	public $class_method;
	public $class_name;
	public $class_instance;
	
}


/**
 *  The DUPX_API_SERVER object is used to listen for and process
 *  routable template calls.  The root for this api stack starts with
 *  https://website.com/installer.php/api/
 * 
 *  This will display the GUI for the api and is the starting point
 *  for processing api requets.
 * 
 * <code>
 *  //Register API Engine
 *  $API_SERVER = new DUPX_API_SERVER();
 *  $API_SERVER->add_controller(new MyClass());
 *  $API_SERVER->listen();
 * </code>
 */
class DUPX_API_SERVER 
{
	public $controllers = array();
	public $uri_found;
	public $uri_match;
	public $args_in = array();
	public $args_map = array();
	public $exe_route;
	public $api_enabled = false;

	public function listen($debug = false)
	{
		$url_route = $this->get_active_url_route();
		$this->exe_route = $this->find_route($url_route);
		
		//API index browser: 
		//see /views/view.api.php
		if ($url_route == '/api/') {
			$GLOBALS["VIEW"] = 'api';
			return;
		}
		
		//API process
		if (! $this->exe_route) {
			//Invalid route requested
			if (strpos($url_route, '/api/') !== false) {
				die("Invlaid API Route Request '{$url_route}'");
			}
			return;
		}
		
		$this->uri_found = $url_route;
		$this->uri_match = $this->exe_route->operation;
		$this->args_map = $this->process_args($this->exe_route);
		
		if ($debug) {
			$this->debug_info();
		}
	
		$api_request = new DUPX_API_REQUEST();
		
		try {
			$time_start = microtime(true);
			$rfl_method = new ReflectionMethod($this->exe_route->class_name, $this->exe_route->class_method);
			$result = $rfl_method->invokeArgs($this->exe_route->class_instance, $this->args_map);	
			$result = (DUPX_Util::isJSON($result)) ? json_decode($result) : $result;
			
			//Return results as JSON
			$api_request->report['process_time']  = microtime(true) - $time_start;
			$api_request->report['operation'] = $this->exe_route->operation;
			$api_request->result = $result;
			echo json_encode($api_request);
			exit;
		} catch (Exception $ex) {
			$err = new DUPX_API_ERROR();
			$err->request = $this->exe_route->class_method;
			$err->message = $ex->getMessage();
			$err->exception = $ex->__toString();
			echo json_encode($err);
			exit;
		} 
	}
	
	public function debug_info() 
	{
		echo '<pre>';
		echo 'FOUND: '   . $this->uri_found . '<br/>';
		echo 'MATCHED: ' . $this->uri_match . '<br/>';
		echo 'INPUTS:';		DUPX_Util::dump($this->args_in);
		echo 'INPUT MAP:';  DUPX_Util::dump($this->args_map);
		DUPX_Util::dump($this->exe_route, 1);
		echo '<br/> RESULT: <br/>';
		echo '</pre>';
	}

	public function add_controller($class)
	{
		$rfl 		 = new ReflectionClass($class);
		$cls_name 	 = $rfl->getName();
		$cls_methods = $rfl->getMethods();
		
		if (in_array($cls_name, $this->controllers)) {
			return false;
		}
	
		foreach ($cls_methods as $m)
		{
			$comments  = $m->getDocComment();
			$route_elm = $this->get_tag_attributes('route', $comments);
			if ($route_elm != null) 
			{
				$route = new DUPX_API_ROUTE();
				$route->type 			= isset($route_elm['type']) ? $route_elm['type'] : 'request'  ;
				$route->template 		= isset($route_elm['template']) ? $route_elm['template'] : '';
				
				//Check for duplicate operation
				if ($this->find_route($route->operation)) 
				{
					throw new Exception("Duplicate route tag opration '{$route->operation}'! See tag <route tempalte='{$route->template}' > in class {$cls_name}");
				}
				
				$route->operation 		= $this->get_operation($route_elm['template']);
				$route->params			= $this->get_params($route->template, $route->operation);
				$route->class_method 	= $m->getName();
				$route->class_instance  = $class;
				$route->class_name  	= $cls_name;	
				$this->controllers[] = $route;
			}
		}
		return true;
	}
	
	/* Matches the uri defined template args
	 * with the inbound args, PATH, GET, POST
	 */
	private function process_args()
	{
		$args_map = array();
		$params = empty($this->exe_route->params) ? null : $this->exe_route->params;
		if ($params == null) {
			return $args_map;
		}
		$args_map   = $params;
		$args_map   = array_map(create_function('$n', 'return null;'), $args_map);
		
		// <route template="/cpnl/is_active/{cpnl-host}/{arg1}/{list*}" type="request">
		//REQUEST: 	Post, Get, Path
		//PATH:		Path
		//GET: 		Get
		//POST: 	Post
		$uri_params = substr($this->uri_found , strlen($this->uri_match));
		$this->args_in['PATH'] = array_filter(explode("/", preg_replace('/\?.*/', '', $uri_params)));	
		$this->args_in['GET']  = $_GET;
		$this->args_in['POST'] = $_POST;
		
		switch (strtoupper($this->exe_route->type))
		{
			case 'POST' :	$args_map = array_merge($args_map, $this->args_in['POST']); break;
			case 'GET'  :	$args_map = array_merge($args_map, $this->args_in['GET']);  break;
			case 'PATH' :	$args_map = $this->args_map_merge($args_map);	   			break;
			default :
				$args_map = array_merge($args_map, $this->args_in['POST']);
				$args_map = array_merge($args_map, $this->args_in['GET']);
				$args_map = $this->args_map_merge($args_map);
		}
		
		//Only returned the params defined
		$length = count($this->exe_route->params);
		$args_map = array_slice($args_map, 0, $length);
		$args_map = array_map('urldecode', $args_map);

		return $args_map;
	}
	
	private function args_map_merge($args_map) 
	{
		$keys = array_keys($args_map);
		foreach($this->args_in['PATH'] as $k => $v) 
		{
			$args_map[$keys[$k]] = $v;
		}
		return $args_map;
	}
	
	private function find_route($template) 
	{
		if (empty ($this->controllers)) {
			return;
		}
		foreach($this->controllers as $route)
		{		
			if (strstr($template, $route->operation)) {
				return $route;
			}
		}
	}
	
	/* Returns the parameters from a uri template
	 * example:  "/cpnl/is_active/{host}?s=1" 
	 * returns: array('host' => '', 's' => 1); 
	 */
	private function get_params($template, $operation) 
	{
		$paths = str_replace($operation, '', $template );
		$paths = array_filter(explode("/", $paths));
		$params = array();
		foreach ($paths as $p)
		{
			$type = strpos($p, '*') ? 'list' : 'string';
			$name = $type == 'list' ? trim($p, '{*}') : trim($p, '{}');
			$params[$name] = $type; 
		}
		return $params;
	}
	
	
	/* Returns the base operation portion of a template
	 * example: "http://site.com/instatller.php/cpnl/is_active/1/category/a,b,c" 
	 * returns: "/cpnl/is_active/host?s=1" */
	private function get_active_url_route()
	{
		$file = basename(__file__);

		$url_path = strstr(DUPX_HTTP::get_request_uri(), $file);
		return str_replace($file, '', $url_path);
	}
	
	
	/* Returns the base operation portion of a template
	 * example:  "/cpnl/is_active/host?s=1" 
	 * returns: "/cpnl/is_active/" */
	private function get_operation($template) 
	{
		$routes = explode("/", $template);
		if (! $routes) {
			return null;
		}
		//remove parameters
		foreach($routes as $r)
		{
			if (preg_match("/^[a-zA-Z0-9_\-]+$/", $r)) {
				$ops[] = $r;
			}
		}
		$operation = '/' . implode('/', $ops) . '/';
		return $operation;
	}

    
	/* Finds a tag element in a string and parses its attributes
	 * example: Finds <route> element and returns its attributes */
	private function get_tag_attributes($element_name, $string) 
	{
		if ($string == false) {
			return;
		}
		// Grab the string of attr inside an element tag.
		$found = preg_match('#<'.$element_name.'\s+([^>]+(?:"|\'))\s?/?>#',$string, $matches);
		if ($found == 1) 
		{
			// Match attr-name attribute-value pairs.
			$attr_array  = array();
			$attr_string = $matches[1];
			$found = preg_match_all('#([^\s=]+)\s*=\s*(\'[^<\']*\'|"[^<"]*")#', $attr_string, $matches, PREG_SET_ORDER);
			if ($found != 0) 
			{
				// Create an associative array that matches attr names to attr values.
				foreach ($matches as $att) {
					$attr_array[$att[1]] = substr($att[2], 1, -1);
				}
				return $attr_array;
			}
		}
		return;
	}
	
}
//-- END OF ACTION API
?>
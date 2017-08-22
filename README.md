Installation

- You can install this plugin into your CakePHP application using composer by running the following commands in the terminal.

- composer config repositories.integrateideas vcs https://github.com/integrateideas/taskMaster 

- composer require "integrateideas/inspiniaTheme" : "dev-InspiniaTheme"

- Then load the plugin by running
	
	bin/cake plugin load InspiniaTheme -b -r

	or by manually adding statement shown below to bootstrap.php:

	Plugin::load('InspiniaTheme', ['bootstrap' => true,'routes' => true]);

Usage

- Create app_form.php in config and add this :

	<!--
	/**<?php

	return [
	        'button' => '<div class="form-group"><div class="col-sm-4 col-sm-offset-2"><button class="btn btn-primary" {{attrs}}>{{text}}</button></div></div>',
	        'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
	        'checkboxFormGroup' => '{{label}}',
	        'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
	        'dateWidget' => '{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}',
	        'error' => '<div class="error-message">{{content}}</div>',
	        'errorList' => '<ul>{{content}}</ul>',
	        'errorItem' => '<li>{{text}}</li>',
	        'file' => '<input type="file" name="{{name}}"{{attrs}}>',
	        'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
	        'formStart' => '<div class="ibox-content"><form class="form-horizontal" {{attrs}}>',
	        'formEnd' => '</form></div>',
	        'formGroup' => '{{label}}{{input}}',
	        'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
	        'input' => '<div class="col-sm-10"><input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/></div>',
	        'inputSubmit' => '<input type="{{type}}"{{attrs}}/>',
	        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div><div class="hr-line-dashed"></div>',
	        'inputContainerError' => '<div class="input {{type}}{{required}} error">{{content}}{{error}}</div>',
	        'label' => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
	        'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
	        'legend' => '<legend>{{text}}</legend>',
	        'multicheckboxTitle' => '<legend>{{text}}</legend>',
	        'multicheckboxWrapper' => '<fieldset{{attrs}}>{{content}}</fieldset>',
	        'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
	        'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
	        'select' => '<div class="col-sm-10"><select name="{{name}}" class="form-control m-b" {{attrs}}>{{content}}</select></div>',
	        'selectMultiple' => '<div class="col-sm-10"><select class="form-control m-b" name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select></div>',
	        'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
	        'radioWrapper' => '{{label}}',
	        'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
	        'submitContainer' => '<div class="submit">{{content}}</div>',
	    ];

	?> -->

- Then load it  in src/View/AppView.php in initialize function :
	 
	 $this->loadHelper('Form', [
           'templates' => 'app_form',
       ]);

- Then load this theme in src/Controller/AppController.php in beforeRender function:
	
	$this->viewBuilder()->theme('InspiniaTheme');

- Create navigation.php file in config and create menu in it.
	<!--If a menu has children, then the link for the menu must always be #-->
	<!--All links must be in the form of ['controller' => 'ControllerName', 'action' =>'action name' ] -->
	Example:
		<?php
		use Cake\Core\Configure;
		return [ 'Menu' =>
                 [
                   'Users' => [
                       'link' => '#',
                       'class' => 'fa-list-alt',
                       'children' => [
                               'View All' => [
                                   'link' => [
                                         'controller' => 'Users',
                                         'action' => 'index'
                                       ],
                                     ],
                               'Add' => [
                                   'link' => ['controller' => 'Users', 'action' => 'add']
                                     ]
                             ],
                       ], 
                    'Roles' => [
                       'link' => ['controller' => 'Users', 'action' => 'index'],
                       'class' => 'fa-list-alt',
                       ]
                  ]
               ]
        ?>
- Load navigation.php file in bootsrap.php
	if (file_exists(CONFIG . 'navigation.php')) {
   		Configure::load('navigation');
	}

- Then in your AppController, add the below content in the related functions:
	
	public function beforRendor(Event $event){

		if($this->response->getStatusCode() == 200) {
            $user = $this->Auth->user();
            $this->viewBuilder()->theme('InspiniaTheme');
            $nav = $this->checkLink(Configure::read('NavigationMenu'), $user->role['name']);
            $this->set('sideNav',$nav['children']);
        }
	}	

	<!-- If there is no Roles table in your Application, then set 'role_name' blank-->
    public function beforeFilter(Event $event)
    {
        $user = $this->Auth->user();
        // pr($user);
        $sideNavData = ['id'=>$user['id'],'first_name' => $user['first_name'],'last_name' => $user['last_name'],'role_name' => $user['role']['name'],];
        $this->set('sideNavData', $sideNavData);
     }


    public function beforeFilter(Event $event)
    {
        $user = $this->Auth->user();
        // pr($user);
        $sideNavData = ['id'=>$user['id'],'first_name' => $user['first_name'],'last_name' => $user['last_name'],'role_name' => $user['role']['name'],];
        $this->set('sideNavData', $sideNavData);
     }


	public function checkLink($nav = [], $role = false){
        $currentLink = [
                'controller' => $this->request->params['controller'],
                'action' => $this->request->params['action']
          ];
        $check = 0;
        foreach($nav as $key => &$value){
            
            //Figure out active class
            if($value['link'] == '#'){
                $response = $this->checkLink($value['children'], $role);
                $value['children'] = $response['children'];
                $value['active'] = $response['active'];
            } else {
                $value['active'] = empty(array_diff($currentLink, $value['link'])) ? 1 : 0;
            }
            
            if(isset($value['active']) && $value['active']){
                $check = 1;
            }
            //Figure out whether to show or not
            if($role){
                $show = 0;
                //role is not in show_to_roles
                if(empty($value['show_to_roles'])) {
                  $show = 1;
                } elseif (in_array($role, $value['show_to_roles'])) {
                  $show = 1;
                } 
                if($show){
                  if(empty($value['hide_from_roles'])) {
                    $show = 1;
                  } elseif (in_array($role, $value['hide_from_roles'])) {
                    $show = 0;
                  }   
                }
                $value['show'] = $show;
            } else {
                $value['show'] = 1;
            }
        }
        return ['children' => $nav, 'active' => $check];
    } 


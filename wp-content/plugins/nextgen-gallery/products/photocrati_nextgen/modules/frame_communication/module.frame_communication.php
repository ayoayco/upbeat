<?php

/***
    {
        Module: photocrati-frame_communication,
		Depends: { photocrati-router }
    }
***/

class M_Frame_Communication extends C_Base_Module
{
	function define($context=FALSE)
	{
		parent::define(
			'photocrati-frame_communication',
			'Frame/iFrame Inter-Communication',
			'Provides a means for HTML frames to share server-side events with each other',
			'0.4',
			'http://www.nextgen-gallery.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);

        include_once('class.frame_communication_option_handler.php');
        C_NextGen_Settings::get_instance()->add_option_handler('C_Frame_Communication_Option_Handler', array(
           'frame_event_cookie_name',
        ));
        C_NextGen_Global_Settings::get_instance()->add_option_handler('C_Frame_Communication_Option_Handler', array(
            'frame_event_cookie_name',
        ));
	}

	function _register_utilities()
	{
		$this->get_registry()->add_utility(
			'I_Frame_Event_Publisher', 'C_Frame_Event_Publisher'
		);
	}

	function _register_hooks()
	{
		add_action('init', array($this, 'enqueue_admin_scripts'));

	}

	function enqueue_admin_scripts()
	{
		$router = $this->get_registry()->get_utility('I_Router');

		wp_register_script(
			'frame_event_publisher',
			$router->get_static_url('photocrati-frame_communication#frame_event_publisher.js'),
			array('jquery')
		);
		
		if (is_admin())
			wp_enqueue_script('frame_event_publisher');
	}

    function get_type_list()
    {
        return array(
            'C_Frame_Communication_Option_Handler'	=> 'class.frame_communication_option_handler.php',
            'C_Frame_Event_Publisher' 			    => 'class.frame_event_publisher.php',
            'I_Frame_Event_Publisher' 			    => 'interface.frame_event_publisher.php'
        );
    }
}

new M_Frame_Communication();

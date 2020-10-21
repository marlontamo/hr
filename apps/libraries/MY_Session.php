<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session {

    /**
     * sess_update()
     *
     * @access    public
     * @return    void
     */
    public function sess_update()
    {
        $CI =& get_instance();

        if ( !IS_AJAX )
        {
            log_message('error', "Session updated from my session. ".$CI->router->fetch_method());
            parent::sess_update();
        }
    }
}

/* End of file */
/* Location: application/core */
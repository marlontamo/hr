<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class mobile_dashboard_model extends Record{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	public function __construct(){
		
		$this->mod_id = 9;
		$this->mod_code = 'dashboard';
		$this->route = 'dashboard';
		$this->url = site_url('dashboard');
		$this->primary_key = '';
		$this->table = '';
		$this->icon = '';
		$this->short_name = 'Dashboards';
		$this->long_name  = 'Dashboard';
		$this->description = '';
		$this->path = APPPATH . 'modules/mobile/mobile_dashboard';

		parent::__construct();
	}

	function getDashboardFeeds($userID, $start, $limit){

		$data = array();

		$qry = "
		SELECT a.*, c.company, d.group
				FROM dashboard_feeds a
				LEFT JOIN {$this->db->dbprefix}users_profile b on b.user_id = a.user_id
				LEFT JOIN {$this->db->dbprefix}users_company c on c.company_id = b.company_id
				LEFT JOIN {$this->db->dbprefix}business_group d on d.group_id = c.business_group_id
				WHERE recipient_id = '$userID'
				LIMIT $limit OFFSET $start;";

		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
			return 	$result->result();			
		}
		
		return array();
	}

	function getBirthdayFeeds(){ 
		
		$data = array();

		$qry = "SELECT a.*, c.company, d.group
		FROM dashboard_birthday a
		LEFT JOIN {$this->db->dbprefix}users_profile b on b.user_id = a.celebrant_id
		LEFT JOIN {$this->db->dbprefix}users_company c on c.company_id = b.company_id
		LEFT JOIN {$this->db->dbprefix}business_group d on d.group_id = c.business_group_id"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	function getBirthdayGreetings($filter){

		$data = array();

		$qry = "SELECT * FROM dashboard_birthday_greetings
				WHERE recipient_id = '" . $filter['celebrant_id'] . "' AND birthday = '". $filter['birth_date'] . "'";

		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;
	}

	function getTodoFeeds($userID){

		$data = array();

		$qry = "SELECT a.*, c.company, d.group
		FROM dashboard_todos a
		LEFT JOIN {$this->db->dbprefix}users_profile b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_company c on c.company_id = b.company_id
		LEFT JOIN {$this->db->dbprefix}business_group d on d.group_id = c.business_group_id
		WHERE approver_id = '$userID' 
		AND approver_status_id = '2' AND form_status_id != 8
		ORDER BY created_on DESC";
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
		
		$result->free_result();
		return $data;	
	}

	function setDecission($decission){

		$data = array();

		$qry = "CALL sp_time_forms_approval(
					'".$decission['formid']."', 
					'".$decission['userid']."', 
					'".$decission['decission']."', 
					'". mysqli_real_escape_string($this->db->conn_id, $decission['comment']) ."')";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		mysqli_next_result($this->db->conn_id);
		return $data;	
	}

	function getUserNotification($userID, $itemID){

		$response = new stdClass();

		$qry = "SELECT * 
				FROM `dashboard_notification` 
				WHERE ( recipient_id = ". $userID .") 
					  AND (readon IS NULL OR readon = '0000-00-00 00:00:00') 
					  AND (reactedon IS NULL OR reactedon = '0000-00-00 00:00:00')";

		$notifications = $this->db->query($qry);
		$response->total_notification = $notifications->num_rows();
		$response->total_unread = $notifications->num_rows();
		$response->notification = array();

		$limit = 0;

		foreach( $notifications->result_array() as $notification ){

			$response->notification[] = $this->load->view('templates/notifications/'.$notification['status'], $notification, true);

			$limit++;
			
			if( $limit > 9 ){
				break;
			}	
		}


		$qry = "SELECT * 
				FROM `dashboard_notification` 
				WHERE (recipient_id = ". $userID .") 
				AND (readon IS NULL OR readon = '0000-00-00 00:00:00') 
				AND NOT (reactedon IS NULL OR reactedon = '0000-00-00 00:00:00')";

		$notifications = $this->db->query($qry);

		$response->total_unread += $notifications->num_rows();

		if( sizeof( $response->notification ) < 10 )
		{
			$limit = sizeof( $response->notification ) - 1;
			foreach( $notifications->result_array() as $notification )
			{
				$response->notification[] = $this->load->view('templates/notifications/'.$notification['status'], $notification, true);
				$limit++;
				if( $limit > 9 )
				{
					break;
				}	
			}	
		}

		return $response;
	}


	// START DASHBOARD TAGS AUTOCOMPLETE SOURCE
	function getUsersTagList(){

		$data = array();

		$qry = "SELECT user_id AS value, full_name AS label FROM users WHERE active = '1'";
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$row['label'] = trim($row['label']);
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;			
	}

	function getCompanyTagList(){

		$data = array();

		$qry = "SELECT company_id AS value, company AS label FROM {$this->db->dbprefix}users_company WHERE deleted = 0 order by company";
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$row['label'] = trim($row['label']);
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;			
	}


	//START FEED POSTING SECTION

	function saveRecipients($feedID, $to, $recipients){

		$values = '';

		// FIELDS
		// id, user_id, department_id

		// if($to === 'user'){
		//
		// 	$values .= "('$feedID', $recipients, '0')";
		// }
		// else{
		//
		// 	$values .= "('$feedID', '0', $recipients)"
		// }

		foreach($recipients as $recipient){

			if($to === 'user'){
				$values .= $values === '' ? "('$feedID', $recipient, '0')" : ",('$feedID', $recipient, '0')";
			}
			else{
				$values .= $values === '' ? "('$feedID', '0', $recipient)" : ",('$feedID', '0', $recipient)";
			}
		}

		// INSERT INTO table (a,b) VALUES (1,2), (2,3), (3,4);
		$qry = "INSERT INTO ww_system_feeds_recipient(id, user_id, department_id) VALUES " . $values;

		$result = $this->db->query($qry);
		return $result;
	}

	function newPostData($data , $mode=''){
		switch($mode){
			case 'bday':
				$recipient = 0;
				$this->load->model('birthdays_model', 'bday');
				$uri = str_replace(base_url(), '', $this->bday->url)."?bday=1&celebrant_id={$data['recipient_id']}&birth_date=".strtotime($data['birtday']);
			break;
			case 'appforms':
				$recipient = $data['recipient_id'];
				$this->load->model('form_application_model', 'formApp');
				$uri = str_replace(base_url(), '', $this->formApp->url).'/detail/'.$data['forms_id'];
			break;
			default:
				$uri = null;
				$recipient = $data['recipient_id'];
			break;
		}

		$qry = "INSERT INTO ww_system_feeds 
				(
					status
					, message_type
					, user_id
					, display_name
					, feed_content
					, recipient_id
					, uri
				) 
				VALUES
				(
					'" . $data['status'] . "',
					'" . $data['message_type'] . "',
					'" . $data['user_id'] . "',
					'" . $data['display_name'] . "',
					'" . $data['feed_content'] . "',
					'" . $recipient . "',
					\"" . $uri . "\"
				)";

		$this->db->query($qry);
		return $this->db->insert_id();
	}

	function getLatestPostData($feedID, $recipient_id){

		$data = array();

		$qry = "SELECT * FROM dashboard_feeds WHERE id = '$feedID' AND recipient_id = '{$recipient_id}'"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
			return $result->result();			
		}
			
		return array();
	}

	function getUpdatedPosts($userID, $limit){

		$data = array();

		$qry = "SELECT * 
				FROM dashboard_feeds 
				WHERE recipient_id IN ('$userID', 0)
				LIMIT $limit";

		
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;		
	}

	function getPostTime($userID){

		$data = array();

		$qry = "SELECT id, createdon 
				FROM dashboard_feeds 
				WHERE recipient_id IN ('$userID', 0)
				";
		
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;		
	}
	//END FEED POSTING SECTION



	//START BIRTHDAY SECTION
	function newGreetingsData($data){

		$qry = "INSERT INTO ww_system_birthday 
				(
					status
					, user_id
					, display_name
					, content
					, birthday
					, recipient_id
				) 
				VALUES
				(
					'" . $data['status'] . "',
					'" . $data['user_id'] . "',
					'" . $data['display_name'] . "',
					'" . $data['content'] . "',
					'" . $data['birtday'] . "',
					'" . $data['recipient_id'] . "'
				)";
		
		$this->db->query($qry);
		return $this->db->insert_id();
	}

	function getLatestGreetingsData($greetingsID){

		$data = array();

		$qry = "SELECT * FROM dashboard_birthday_greetings WHERE id = '$greetingsID'"; //echo $qry;
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;
	}
	//END BIRTHDAY SECTION

	function filterDashboard($userID=0, $start, $limit, $message_type=''){ 

		$data = array();

		$qry = "SELECT * 
				FROM dashboard_feeds 
				/*WHERE recipient_id IN ('$userID', 0)*/
				WHERE recipient_id = '$userID'";
				
		if($message_type != 'all'){
			$qry .= " AND message_type = '$message_type'";
		}
		
		$qry .= " LIMIT $limit OFFSET $start"; // WHERE user_id = '$userID';
		
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
			return 	$result->result();			
		}
		
		return array();
	}

	function feed_like( $feed_id, $status ){
		
		return $this->db->update('system_feeds_recipient', array('like' => $status), array('id' => $feed_id, 'user_id'=> $this->user->user_id));
	}

	function get_feed_likes( $feed_id )
	{
		$qry = "select a.user_id, b.full_name, c.company, d.position, b.email, c.photo
		FROM {$this->db->dbprefix}system_feeds_recipient a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
		where a.id = {$feed_id} and a.like = 1";
		$likers = $this->db->query($qry);
		$users = array();
		if( $likers->num_rows() > 0 )
		{
			foreach( $likers->result() as $like )
			{
				$users[$like->user_id] = $like;
			}
			return $users;
		}
		return false;


	}

	function feed_like_str( $feed_id, $mobile = false )
	{
		$image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
   		$image_dir_full  = FCPATH.'uploads/users/';
		
		$like_str = "";
		$likers = $this->get_feed_likes( $feed_id );
		if( $likers )
		{
			if( isset($likers[$this->user->user_id]) )
			{
				$like_str = "You";
				unset($likers[$this->user->user_id]);
			}

			switch( true )
            {
                case sizeof( $likers ) == 0:
                    if( $like_str == "You" ) $like_str = "You liked this.";
                    break;
                case sizeof( $likers ) == 1:
                    foreach( $likers as $like )
                    {
                        $user_avatar = basename(base_url( $like->photo ));
                        // determine image/photo
                        $file_name_thumbnail = $image_dir_thumb . $user_avatar;
                        $file_name_full = $image_dir_full . $user_avatar;


                        if(file_exists($file_name_thumbnail)){
                            $user_avatar = base_url() . "uploads/users/thumbnail/" . $user_avatar;
                        }
                        else if(file_exists($file_name_full)){
                            $user_avatar = base_url() . "uploads/users/" . $user_avatar;
                        }
                        else{
                            $user_avatar = base_url() . "uploads/users/avatar.png";
                        }
                        
                        if( $like_str == "You" ){
                            $like_str .= ' and ';
                        }
                        $like_str .= '<span class="user_popover">
                        <small>
                            <a 
                            class="user_preview popovers" 
                            data-trigger="hover" 
                            data-placement="top"
                            data-html="true" 
                            data-content=\'
                                <div class="clearfix">
                                    <div class="pull-left" style="padding:0; width: 120px;">
                                        <img class="img-responsive" alt="" src="'.$user_avatar.'" style="border-radius:2% !important; height:100px; width: 100px;" />
                                    </div>
                                    <div class="pull-right" style="padding:0; width: 200px;">
                                        <p style="margin-bottom:5px;"><strong>'.$like->position.'</strong></p>
                                        <p style="margin-bottom:10px;">'.$like->company.'</p>
                                        <p class="text-muted small" style="margin-bottom:2px !important;"><i class="fa fa-envelope"></i> '.$like->email.'<p>
                                    </div>
                                </div>\'
                            data-original-title = "'.$like->full_name.'" >
                            '.$like->full_name.'
                            </a>   
                        </small>                                 
                        </span> liked this.';    
                    }
                    break;
                case sizeof( $likers ) > 1 && $like_str == "":
                    $first = true;
                    $others = "";
                    foreach( $likers as $like )
                    {
                        if( $first )
                        {
                            $user_avatar = basename(base_url( $like->photo ));
                            // determine image/photo
                            $file_name_thumbnail = $image_dir_thumb . $user_avatar;
                            $file_name_full = $image_dir_full . $user_avatar;


                            if(file_exists($file_name_thumbnail)){
                                $user_avatar = base_url() . "uploads/users/thumbnail/" . $user_avatar;
                            }
                            else if(file_exists($file_name_full)){
                                $user_avatar = base_url() . "uploads/users/" . $user_avatar;
                            }
                            else{
                                $user_avatar = base_url() . "uploads/users/avatar.png";
                            }
                            
                            $like_str .= '<span class="user_popover">
                            <small>
                                <a 
                                class="user_preview popovers" 
                                data-trigger="hover" 
                                data-placement="top"
                                data-html="true" 
                                data-content=\'
                                    <div class="clearfix">
                                        <div class="pull-left" style="padding:0; width: 120px;">
                                            <img class="img-responsive" alt="" src="'.$user_avatar.'" style="border-radius:2% !important; height:100px; width: 100px;" />
                                        </div>
                                        <div class="pull-right" style="padding:0; width: 200px;">
                                            <p style="margin-bottom:5px;"><strong>'.$like->position.'</strong></p>
                                            <p style="margin-bottom:10px;">'.$like->company.'</p>
                                            <p class="text-muted small" style="margin-bottom:2px !important;"><i class="fa fa-envelope"></i> '.$like->email.'<p>
                                        </div>
                                    </div>\'
                                data-original-title = "'.$like->full_name.'" >
                                '.$like->full_name.'
                                </a>   
                            </small>                                 
                            </span>';    
                            $first = false;
                        }
                        else{
                            $others .= $like->full_name . '<br/>';
                        }   
                    }
                    $like_str .= ' and ';
                    $like_str .= '<span class="user_popover">
                    <small>
                        <a 
                        class="user_preview popovers" 
                        data-trigger="hover" 
                        data-placement="top"
                        data-html="true" 
                        data-content=\'
                            <div class="clearfix">
                                '.$others.'
                            </div>\'
                        >
                        '.(sizeof($likers)-1).' others
                        </a>   
                    </small>                                 
                    </span> liked this.'; 
                    break; 
                default:
                    $like_str .= ' and ';
                    $others = "";
                    foreach( $likers as $like )
                    {
                        $others .= $like->full_name . '<br/>';
                    }
                    $like_str .= '<span class="user_popover">
                        <small>
                            <a 
                            class="user_preview popovers" 
                            data-trigger="hover" 
                            data-placement="top"
                            data-html="true" 
                            data-content=\'
                                <div class="clearfix">
                                    '.$others.'
                                </div>\'
                            >
                            '.sizeof($likers).' others
                            </a>   
                        </small>                                 
                        </span> liked this.';  
            }

            if( !$mobile )
            {
	            $like_str = '<div class="alert alert-success padding-10 likes-'.$feed_id.'"> 
	                <i class="fa fa-check"></i> <span class="user_popover"></span>'.$like_str.'</a> 
	            </div>';
	        }
		}	
		return $like_str;
	}

	function get_feed_comments( $feed_id )
	{
		$qry = "select a.*, gettimeline(a.createdon) as timeline, b.full_name, c.photo, d.position
		FROM {$this->db->dbprefix}system_feeds_comments a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
		WHERE a.deleted = 0 and id = {$feed_id} order by feeds_comment_id asc";

		$comments = $this->db->query( $qry );

		if( $comments->num_rows() > 0 )
			return $comments->result();
		else
			return array();
	}

	function get_feed_comment( $comment_id ){

		$qry = "select a.*, gettimeline(a.createdon) as timeline, b.full_name, c.photo, d.position
		FROM {$this->db->dbprefix}system_feeds_comments a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
		WHERE a.deleted = 0 and feeds_comment_id = {$comment_id} order by feeds_comment_id asc limit 1";

		$comment = $this->db->query( $qry );
		if( $comment->num_rows() == 1 )
			return $comment->row();
		else
			return false;
		
	}
}

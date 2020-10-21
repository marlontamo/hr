<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class my_group_model extends Record
{
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

	public function __construct()
	{
		$this->mod_id = 209;
		$this->mod_code = 'my_group';
		$this->route = 'account/groups';
		$this->url = site_url('account/groups');
		$this->primary_key = 'group_id';
		$this->table = 'groups';
		$this->icon = '';
		$this->short_name = 'My Groups';
		$this->long_name  = 'My Groups';
		$this->description = '';
		$this->path = APPPATH . 'modules/my_group/';

		parent::__construct();
	}

	function _get_members( $record_id, $format = 'array' )
	{
		$where = array(
			$this->primary_key => $record_id,
			'active' => 1,
			'left_group' => 0
		);
		$members = $this->db->get_where('groups_members', $where);
		if( $members->num_rows() > 0 )
		{
			$user_id = array();
			foreach( $members->result() as $member )
				$user_id[] = $member->user_id;

			switch( $format )
			{
				case 'array':
					return $user_id;
					break;
				case 'csv':
					return implode(',', $user_id);
					break;
			}
			
		}
		else
			return '';
	}

	function _get_admins( $record_id, $format = 'array' )
	{
		$where = array(
			$this->primary_key => $record_id,
			'active' => 1,
			'left_group' => 0,
			'admin' => 1
		);

		$members = $this->db->get_where('groups_members', $where);
		if( $members->num_rows() > 0 )
		{
			$user_id = array();
			foreach( $members->result() as $member )
				$user_id[] = $member->user_id;

			switch( $format )
			{
				case 'array':
					return $user_id;
					break;
				case 'csv':
					return implode(',', $user_id);
					break;
			}
			
		}
		else
			return '';
	}

	function get_admins( $record_id )
	{
		$qry = "select a.*, b.full_name, c.photo, d.position
		FROM {$this->db->dbprefix}groups_members a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
		WHERE a.group_id = {$record_id} AND a.active = 1 AND a.admin = 1";
		$admins = $this->db->query( $qry );
		if( $admins->num_rows() > 0 )
			return $admins->result();
		else
			return false;
	}

	function get_members( $record_id )
	{
		$qry = "select a.*, b.full_name, c.photo, d.position
		FROM {$this->db->dbprefix}groups_members a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
		WHERE a.group_id = {$record_id} AND a.active = 1 AND a.admin = 0";
		$members = $this->db->query( $qry );
		if( $members->num_rows() > 0 )
			return $members->result();
		else
			return false;
	}

	function get_membership( $user_id )
	{
		$where = array(
			'user_id' => $user_id,
			'active' => 1,
			'left_group' => 0
		);
		$groups = $this->db->get_where('groups_members', $where);	
		if( $groups->num_rows() > 0 )
		{
			foreach($groups->result() as $group)
			{
				$grp[] = $group->group_id;
			}
			return $grp;
		}
		else{
			return false;
		}
	}

	function get_groups( $user_id )
	{
		$membership = $this->get_membership( $user_id );
		if( $membership )
		{	
			$membership = implode(',', $membership);
			$this->db->where('group_id in ('.$membership.')');
			$this->db->where('deleted = 0');
			$groups = $this->db->get($this->table);
			if( $groups->num_rows() > 0 )
				return $groups->result();
			else
				return false;
		}
		return false;
	}

	function get_avail_groups( $user_id )
	{
		$membership = $this->get_membership( $user_id );
		if( $membership )
		{	
			$membership = implode(',', $membership);
			$this->db->where('group_id not in ('.$membership.')');
		}
		$this->db->where('deleted = 0');
		$groups = $this->db->get($this->table);
		if( $groups->num_rows() > 0 )
			return $groups->result();
		else
			return false;
	}

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}
		
		$qry .= ' '. $filter;
		$qry .= ' AND T1.user_id='.$this->user->user_id;
		$qry .= ' AND T1.active=1 AND T1.left_group=0';
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function check_pending_request( $group_id, $user_id )
	{
		$where = array(
			'group_id' => $group_id,
			'user_id' => $user_id,
			'left_group' => 0,
			'active' => 0
		);
		$this->db->limit(1);
		$check = $this->db->get_where('groups_members', $where);
		if( $check->num_rows() == 1 )
			return true;
		else
			return false;
	}

	function is_admin( $group_id, $user_id )
	{
		$where = array(
			'group_id' => $group_id,
			'user_id' => $user_id,
			'left_group' => 0,
			'active' => 1,
			'admin' => 1
		);
		$this->db->limit(1);
		$check = $this->db->get_where('groups_members', $where);
		if( $check->num_rows() == 1 )
			return true;
		else
			return false;
	}

	function is_member( $group_id, $user_id )
	{
		$where = array(
			'group_id' => $group_id,
			'user_id' => $user_id,
			'left_group' => 0,
			'active' => 1
		);
		$this->db->limit(1);
		$check = $this->db->get_where('groups_members', $where);
		if( $check->num_rows() == 1 )
			return true;
		else
			return false;
	}

	function _get_members_list($start, $limit, $search, $filter, $group_id)
	{
		$data = array();				
		
		$this->load->config('members_list_query');
		$qry = $this->config->item('members_list_query');
		
		$qry .= ' '. $filter;
		$qry .= ' AND a.group_id='. $group_id;
		$qry .= " ORDER BY a.admin DESC, a.active DESC";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function _get_files_list($start, $limit, $search, $filter, $group_id)
	{
		$data = array();				
		
		$this->load->config('files_list_query');
		$qry = $this->config->item('files_list_query');
		
		$qry .= ' '. $filter;
		$qry .= ' AND T1.group_id='. $group_id;
		$qry .= " ORDER BY T1.modified_on DESC";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function _get_photos_list($start, $limit, $search, $filter, $group_id)
	{
		$data = array();				
		
		$this->load->config('photos_list_query');
		$qry = $this->config->item('photos_list_query');
		
		$qry .= ' '. $filter;
		$qry .= ' AND T1.group_id='. $group_id;
		$qry .= " ORDER BY T1.modified_on DESC";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function _get_post_list($start, $limit, $search, $filter, $group_id)
	{
		$data = array();				
		
		$this->load->config('post_list_query');
		$qry = $this->config->item('post_list_query');
		$qry .= " AND a.deleted = 0";
		$qry .= ' '. $filter;
		$qry .= ' AND a.group_id='. $group_id;
		$qry .= " ORDER BY a.modified_on DESC";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function get_post( $post_id )
	{
		$qry = "Select a.*, gettimeline(a.created_on) as timeline, b.full_name, c.photo, d.position
		FROM {$this->db->dbprefix}groups_post a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
		WHERE a.post_id={$post_id}
		LIMIT 1 OFFSET 0";
	
		$post = $this->db->query( $qry );
		if( $post->num_rows() == 1 )
			return $post->row();
		else
			return false;
	}

	function liked( $post_id, $user_id )
	{
		$this->db->limit(1);
		$where = array(
			'post_id' => $post_id,
			'user_id' => $user_id
		);
		$check = $this->db->get_where('groups_post_likes', $where);
		if( $check->num_rows() == 1 )
			return true;
		else
			return false;
	}

	function post_like_str( $post_id )
	{
		$like_str = "";
		$likers = $this->get_post_likes( $post_id );
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
                        $photo = get_photo( $like->photo );
                        
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
                                        <img class="img-responsive" alt="" src="'.$photo['avatar'].'" style="border-radius:2% !important; height:100px; width: 100px;" />
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
                            $photo = get_photo( $like->photo );
                            
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
                                            <img class="img-responsive" alt="" src="'.$photo['avatar'].'" style="border-radius:2% !important; height:100px; width: 100px;" />
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

            $like_str = '<div class="alert alert-success padding-10 likes-'.$post_id.'"> 
                <i class="fa fa-check"></i> <span class="user_popover"></span>'.$like_str.'</a> 
            </div>';
		}	
		return $like_str;
	}

	function get_post_likes( $post_id )
	{
		$qry = "select a.user_id, b.full_name, c.company, d.position, b.email, c.photo
		FROM {$this->db->dbprefix}groups_post_likes a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
		where a.post_id = {$post_id}";
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

	function like_post( $post_id, $insert )
	{
		if( $insert )
			$this->db->insert('groups_post_likes', array('post_id' => $post_id, 'user_id' => $this->user->user_id));
		else
			$this->db->delete('groups_post_likes', array('post_id' => $post_id, 'user_id' => $this->user->user_id));
	}

	function add_comment( $post_id, $comment, $comment_id )
	{
		if( !empty( $comment_id ) )
		{
			$where = array(
				'comment_id' => $comment_id
			);
			$update = array(
				'comment' => $comment
			);
			$this->db->update( 'groups_post_comments', $update, $where );
			return $comment_id;
		}
		else{
			$insert = array(
				'post_id' => $post_id,
				'user_id' => $this->user->user_id,
				'comment' => $comment
			);
			$this->db->insert( 'groups_post_comments', $insert );
			return $this->db->insert_id();
		}
	}

	function get_comment( $comment_id )
	{
		$qry = "select a.*, gettimeline(a.created_on) as timeline, b.full_name, b.email, c.photo, d.position, e.company, f.created_by
		FROM {$this->db->dbprefix}groups_post_comments a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
		LEFT JOIN {$this->db->dbprefix}users_company e on e.company_id = c.company_id
		LEFT JOIN {$this->db->dbprefix}groups_post f on f.post_id = a.post_id
		where a.comment_id = {$comment_id}
		LIMIT 1";
		$comment = $this->db->query( $qry );
		if( $comment->num_rows() == 1 )
			return $comment->row();
		else
			return false;
	}

	function get_comments( $post_id )
	{
		$qry = "select a.*, gettimeline(a.created_on) as timeline, b.full_name, b.email, c.photo, d.position, e.company, f.created_by
		FROM {$this->db->dbprefix}groups_post_comments a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
		LEFT JOIN {$this->db->dbprefix}users_company e on e.company_id = c.company_id
		LEFT JOIN {$this->db->dbprefix}groups_post f on f.post_id = a.post_id
		where a.post_id = {$post_id} AND a.deleted = 0
		ORDER BY a.created_on asc";
		$comments = $this->db->query( $qry );
		if( $comments->num_rows() > 0 )
			return $comments->result();
		else
			return false;
	}

	function _get_other_commenters( $post_id, $created_by, $user_id, $format = array() )
	{
		$this->db->where("user_id != {$created_by} and user_id != {$user_id}");
		$this->db->where("post_id = {$post_id}");
		$this->db->group_by('user_id');
		$this->db->select('user_id');
		$users = $this->db->get('groups_post_comments');
		if( $users->num_rows() > 0 )
		{
			$user_id = array();
			foreach( $users->result() as $user )
				$user_id[] = $user->user_id;

			switch( $format )
			{
				case 'array':
					return $user_id;
					break;
				case 'csv':
					return implode(',', $user_id);
					break;
			}
		}
		else
			return false;
	}

	function update_timeline_post( $post_id )
	{
		$update = array(
			'modified_by' => $this->user->user_id,
			'modified_on' => date('Y-m-d H:i:s')
		);
		$this->db->update('groups_post', $update, array('post_id' => $post_id));
	}
}
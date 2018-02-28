<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @brief     User Model
 * @details
 * The model works using one table: it contains the users.
 * The model provides functions to get info on the users.
 *
 * Copyright (c) 2015
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * @author    Balint Morvai
 * @version   0.9
 * @copyright MIT License
 */
class User_model extends CI_Model {

    /**
     * @var object: table_model object that manages table1 (users)
     */
    public $table1;

    /**
     * @brief User model constructor
     *
     * @param dateformat string: format to display dates in
     * @param enforce_field_types bool: setting whether to enforce field types in PHP by cast
     * @return void
     */
    function __construct($dateformat = "d.m.Y - H:i", $enforce_field_types = TRUE) {
        parent::__construct();
        $this->load->library('Table_model');
        $this->table1 = new table_model(TABLE_USERS, $dateformat, $enforce_field_types);
    }

    /**
     * @brief initialize
     *
     * Initializes values for this class.
     *
     * @param dateformat string: format to display dates in
     * @param enforce_field_types bool: setting whether to enforce field types in PHP by cast
     * @return void
     */
    public function initialize($dateformat = "d.m.Y - H:i", $enforce_field_types = TRUE) {
        // Define the date format & whether db field types are enforced in PHP by type cast
        $this->table1->initialize($dateformat, $enforce_field_types);
    }

    /**
     * @brief Get user id from a username
     *
     * Get user id from a username - gets any users id.
     * Per default performs an exact match search and returns
     * 1 or 0 ids in enumerated array! (not CI result array)
     * If you want a fuzzy search pass 2nd parameter FALSE. This will
     * search for any name containing given string and return ids - the
     * max number of returned ids (in the case of fuzzy search) is
     * limited by the 3rd optional parameter.
     * Returns an enumerated array in any case, containing 1 or more user
     * ids or empty if no matches found.
     *
     * @param username string: username to get user id(s) for
     * @param exact bool: if TRUE, exact search, returns 1 or 0 user ids in array;
     * 				if FALSE, fuzzy search, return 1 or more user ids in array
     * @param max_id_count int: max number of ids returned if fuzzy search done
     * @return array
     */
    public function get_userids($username, $exact = TRUE, $max_id_count = 10) {
        $this->db->select(TF_USER_ID);
        $this->db->from($this->table1->get_name());
        if ($exact) {
            $this->db->where(TF_USER_EMAIL, $username);
            $this->db->limit(1, 0);
        }
        else {
            $this->db->like(TF_USER_EMAIL, $username);
            $this->db->limit($max_id_count, 0);
        }

        $retval = array();
        if ($res = $this->table1->get_data())
            foreach ($res as $row)
                array_push($retval, $row[TF_USER_ID]);

        return $retval;
    }

    /**
     * @brief Get user name from an id.
     *
     * Get user name from an id - gets any users name, not just logged
     * in users.
     * Returns a string with the username.
     *
     * @param id int: user id to get user name for
     * @return string
     */
    public function get_username($id) {
        $this->db->select(TF_USER_NAME);
        $this->db->from($this->table1->get_name());
        $this->db->where(TF_USER_ID, $id);
        $this->db->limit(1, 0);

        $retval = '';
        if ($res = $this->table1->get_data())
            $retval = $res[0][TF_USER_NAME];

        return $retval;
    }

    public function get_thread($reciever, $sender) {

        $this->db->select('pm.*, pmt.pmto_recipient,pmt.pmto_deleted,p.profile_image');
        $this->db->from('privmsgs pm');
        $this->db->join('privmsgs_to pmt', 'pmto_message = pm.privmsg_id', 'INNER');
        $this->db->join('profile p', 'p.user_id = pm.privmsg_author', 'INNER');
        $this->db->where_in('pm.privmsg_author', $reciever.','.$sender, FALSE);
        $this->db->where_in('pmt.pmto_recipient', $reciever.','.$sender, FALSE);
        $this->db->where('pm.privmsg_deleted IS NULL', null, false);
        $this->db->order_by('pm.privmsg_id', 'ASC');

        $result = array();
        $result = $this->db->get()->result_array();
//      echo $this->db->last_query();exit;
        return $result;
    }

    public function get_last_message($reciever, $sender) {

        $this->db->select('pm.*, pmt.pmto_recipient,p.profile_image');
        $this->db->from('privmsgs pm');
        $this->db->join('privmsgs_to pmt', 'pmto_message = pm.privmsg_id', 'INNER');
        $this->db->join('profile p', 'p.user_id = pm.privmsg_author', 'INNER');
        $this->db->where_in('pm.privmsg_author', $reciever.','.$sender, FALSE);
        $this->db->where_in('pmt.pmto_recipient', $reciever.','.$sender, FALSE);
        $this->db->where('pm.privmsg_deleted IS NULL', null, false);
        $this->db->order_by('pm.privmsg_id', 'DESC');
        $this->db->limit(1);

        $result = array();
        $result = $this->db->get()->result_array();

//        echo $this->db->last_query();exit;
        return $result[0];
    }

    /**
     * @brief dummy method returning first user id found
     *
     * !!! DUMMY METHOD - IMPLEMENT THIS AS NEEDED !!!
     * Get user id of current user.
     * !!! DUMMY METHOD - IMPLEMENT THIS AS NEEDED !!!
     *
     * @return int
     */
    public function current_id() {
        $this->db->select(TF_USER_ID);
        $this->db->from($this->table1->get_name());
        $this->db->limit(1, 0);

        $retval = -1;
        if ($res = $this->table1->get_data())
            $retval = $res[0][TF_USER_ID];

        return $retval;
    }

    public function get_tag_notifications() {
        $curUser = currentuser_session();
        $this->db->select("p.title,p.post_id");
        $this->db->from("tag t");
        $this->db->join("posts p", 't.post_id = p.post_id');
        $this->db->where("t.user_id", $curUser['user_id']);
        $this->db->where("t.seen", '0');
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function get_comments_tag_notifications() {
        $curUser = currentuser_session();
        $this->db->select("c.message,c.cid,t.user_id, p.post_id");
        $this->db->from("tag_comments t");
        $this->db->join("comment c", 'c.cid = t.cid');
        $this->db->join("posts p", 'c.post_id = p.post_id');
        $this->db->where("t.user_id", $curUser['user_id']);
        $this->db->where("t.seen", '0');
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function getMarkers() {
        $curUser = currentuser_session();
        $this->db->select("u.first_name,u.last_name,u.user_email,p.*,c.name as cityName");
        $this->db->from("users u");
        $this->db->join("profile p", 'p.user_id = u.user_id');
        $this->db->join("cities c", 'c.id = p.city');
        //$this->db->where("u.user_status", '1');
        $this->db->where("u.assesment", '1');
        $result = $this->db->get()->result_array();
//echo $this->db->last_query();exit;
        return $result;
    }

    public function get_notifications($id = NULL) {
        if ($id == NULL) {
            return false;
        }
        $this->db->select("u.user_id as ID, u.first_name, u.last_name, p.*, r.confirm as relation");
        $this->db->from("relations r");
        $this->db->join("users u", 'u.user_id = r.user_id');
        $this->db->join("profile p", 'p.user_id = u.user_id', 'LEFT');
        $this->db->where("r.friend_id", $id);
        $this->db->where("r.confirm", '0');
        $result = $this->db->get()->result_array();
		
        return $result;
    }

    public function search_users($value = NULL) {
        if ($value == NULL) {
            return false;
        }
        $this->db->select("user_id");
        $this->db->from("users");
        $this->db->like("first_name", $value);
        $this->db->or_like("last_name", $value);
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function search_user($value = NULL) {
        $curUser = currentuser_session();
        if ($value == NULL) {
            return false;
        }
        $this->db->select("u.first_name, u.last_name, u.user_email,u.user_id,p.profile_image");
        $this->db->from("users u");
        $this->db->join("profile p", 'p.user_id = u.user_id');

        $this->db->where_not_in("u.user_id", $curUser['user_id']);
        $this->db->group_start();
        $this->db->like("u.first_name", $value);
        $this->db->or_like("u.last_name", $value);
        $this->db->or_like("u.user_email", $value);
        $this->db->group_end();
        $result = $this->db->get()->result_array();
//        echo $this->db->last_query();
        return $result;
    }

    public function get_user_profile($id = NULL) {
        if ($id == NULL) {
            return false;
        }

        $this->db->select("u.first_name,p.*");
        $this->db->from("users u");
        $this->db->join("profile p", 'p.user_id = u.user_id', 'LEFT');
        $this->db->where("u.user_id", $id);
        $result = $this->db->get()->result_array();

//        print_r($result);exit;
        return $result[0];
    }

    public function get_user_info($value = NULL) {
        if ($value == NULL) {
            return false;
        }

        $this->db->select("user_id");
        $this->db->from("users u");
        $this->db->where("user_email", $value);
        $targetUser = $this->db->get()->result_array();

        $curUser = currentuser_session();
        $userId = $curUser['user_id'];

        $this->db->select("u.user_id as ID, u.first_name, u.last_name, u.user_email, p.*, r.confirm as relation");
        $this->db->from("users u");
        $this->db->join("profile p", 'p.user_id = u.user_id', 'LEFT');
        $this->db->join("relations r", 'r.user_id = '.$userId.'  AND r.friend_id = '.$targetUser[0]["user_id"], 'LEFT');
        $this->db->where("user_email", $value);
        $result = $this->db->get()->result_array();

//        print_r($result);exit;
        return $result;
    }

    public function recent_activity($userId) {
        if (empty($userId)) {
            return false;
        }

        $this->db->select("r.friend_id");
        $this->db->from("users u");
        $this->db->join("relations r", 'r.user_id = u.user_id');
        $this->db->where("u.user_id", $userId, FALSE);
        $friends = $this->db->get()->result_array();
        $ids = '';


        foreach ($friends as $friend) {

            $ids .= $friend['friend_id'].',';
        }
        //$ids .= $userId;
        $ids = trim($ids, ',');


        $this->db->select("p.post_id,p.title,u.`first_name`,pr.profile_image");
        $this->db->from("posts p");
        $this->db->join("users u", 'u.user_id = p.user_id', 'LEFT');
        $this->db->join("profile pr", 'pr.user_id = u.user_id', 'LEFT');
        $this->db->where_in("p.user_id", $ids, FALSE);
        $this->db->order_by("p.created", 'DESC');
        $this->db->limit(4);
        $posts = $this->db->get()->result_array();
//        print_r($posts);
//        exit;

        return $posts;
    }

    public function check_relation($loggedInUser, $userId) {

        $this->db->select("confirm");
        $this->db->from("relations r");
        $this->db->where_in("r.user_id", $loggedInUser.",".$userId, FALSE);
        $this->db->where_in("r.friend_id", $loggedInUser.",".$userId, FALSE);
        $result = $this->db->get()->result_array();
        if (empty($result)) {
            $result['confirm'] = 2;
            return $result;
        }
        else {
            return $result[0];
        }
    }

    public function get_users($userId) {

        if (empty($userId)) {
            return false;
        }
		$curUser = currentuser_session();
        $curUserId = $curUser['user_id'];
        $this->db->select("u.user_id as ID, u.first_name, u.last_name, u.user_email, p.*,r.confirm as relation");
        $this->db->from("relations r");
        $this->db->join("users u", 'u.user_id = r.friend_id');
        $this->db->join("profile p", 'p.user_id = r.friend_id', 'LEFT');
        $this->db->where("r.friend_id", $userId, FALSE);
		$this->db->or_where("r.user_id", $curUserId, FALSE);
        $result = $this->db->get()->result_array();
//        if (empty($result)) {
//            return false;
//        }
        return $result;
    }
	
	public function get_friends($userId) {

        if (empty($userId)) {
            return false;
        }

        $this->db->select("u.user_id as ID, u.first_name, u.last_name, u.user_email, p.*,r.confirm as relation");
        $this->db->from("relations r");
        $this->db->join("users u", 'u.user_id = r.friend_id');
        $this->db->join("profile p", 'p.user_id = r.friend_id', 'LEFT');
        $this->db->where("r.user_id", $userId, FALSE);
        $result = $this->db->get()->result_array();
//        if (empty($result)) {
//            return false;
//        }
        return $result;
    }
	
	

    public function get_users_info($ids = NULL, $userId) {
        if (empty($ids) || $userId == '') {
            return false;
        }

        $this->db->select("u.user_id as ID, u.first_name, u.last_name, u.user_email, p.*,r.confirm as relation");
        $this->db->from("users u");
        $this->db->join("profile p", 'p.user_id = u.user_id', 'LEFT');
        $this->db->join("relations r", 'r.friend_id = u.user_id AND r.user_id ='.$userId, 'LEFT');
        $this->db->where_in("u.user_id", $ids, FALSE);
        $result = $this->db->get()->result_array();
//        echo $this->db->last_query();
//        exit;
//        print_r($result);exit;
        return $result;
    }

    public function getUserAssesment() {
        $userData = currentuser_session();
        $this->db->select('assesment');
        $this->db->from('users u');
        $this->db->where('u.user_id', $userData['user_id']);
        $result = $this->db->get()->result_array();
//        echo $this->db->last_query();exit;
        return $result[0];
    }

}

/* End of file User_model.php */

<?php

class Basic_model extends CI_Model {
    /*
     * Properties
     */

    public $tablename = "";

    function get($where = array(), $limit = 0, $orderby = null) {
        if ($orderby != null) {
            $this->db->order_by($orderby);
        }
        if ($limit != 0) {
            $this->db->limit($limit);
        }
        $q = $this->db->get_where($this->tablename, $where);
//        echo '<pre>';
//        print_r($this->db->last_query());exit;  
        $result = $q->result_array();
        if (count($result) > 0 && $limit == 1) {
            return $result[0];
        } else {
            return $result;
        }
    }

    function insert($data) {
        $this->db->insert($this->tablename, $data);
        return $this->db->affected_rows();
    }

    function insert_batch($data) {
        $this->db->insert_batch($this->tablename, $data);
        return $this->db->affected_rows();
    }

    function update($data, $where = array()) {
        $this->db->update($this->tablename, $data, $where);
        return $this->db->affected_rows();
    }

    function delete($where = array()) {
        $this->db->delete($this->tablename, $where);
        return $this->db->affected_rows();
    }

    function explicit($query) {
        $q = $this->db->query($query);
        if (is_object($q)) {
            return $q->result_array();
        } else {
            return $q;
        }
    }

}
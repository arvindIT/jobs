<?php

class General_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($table, $data, $where) {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function delete($table, $where) {
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function select($table_name, $getfields = '', $match_values = '', $condition = '', $compare_type = '', $count = '', $num = '', $offset = '', $orderby = '', $sort = '', $where_clause = '', $totalrows = '', $group_by = '') {

        $fields = $getfields ? implode(',', $getfields) : '';
        $sql = 'SELECT ';

        $sql .= $fields ? $fields : '*';
        $sql .= ' FROM ' . $table_name;
        $where = '';

        if ($match_values) {
            $keys = array_keys($match_values);
            $compare_type = $compare_type ? $compare_type : 'like';
            if ($condition != '')
                $and_or = $condition;
            else
                $and_or = ($compare_type == 'like') ? ' OR ' : ' AND ';

            $where = 'WHERE ';
            switch ($compare_type) {
                case 'like':
                    $where .= $keys[0] . ' ' . $compare_type . '"%' . $match_values[$keys[0]] . '%" ';
                    break;

                case '=':
                default:
                    $where .= $keys[0] . ' ' . $compare_type . '"' . $match_values[$keys[0]] . '" ';
                    break;
            }
            $match_values = array_slice($match_values, 1);

            foreach ($match_values as $key => $value) {
                $where .= $and_or . ' ' . $key . ' ';
                switch ($compare_type) {
                    case 'like':
                        $where .= $compare_type . '"%' . $value . '%"';
                        break;

                    case '=':
                    default:
                        $where .= $compare_type . '"' . $value . '"';
                        break;
                }
            }
        }
        if (!empty($where_clause)) {
            $where .= ' AND (';

            foreach ($where_clause as $key => $val) {
                $where .= $key . " LIKE '%" . $val . "%' OR ";
            }
            $where = rtrim($where, 'OR ');
            $where .= ')';
        }
        if (!empty($group_by)) {
            $sql .=' group by ' . $group_by;
        }
        $orderby = ($orderby != '') ? ' order by ' . $orderby . ' ' . $sort . ' ' : '';
        if ($offset == "0") {
            $offset = "";
        }
        if ($num == "0") {
            $num = "";
        }
        // echo 'o'.$offset;
        if ($offset == "" && $num == "")
            $sql .= ' ' . $where . $orderby;
        elseif ($offset == "" && $offset == 0)
            $sql .= ' ' . $where . $orderby . ' ' . 'limit ' . $num;
        else
            $sql .= ' ' . $where . $orderby . ' ' . 'limit ' . $offset . ',' . $num;

        $query = ($count) ? 'SELECT count(*) FROM ' . $table_name . ' ' . $where . $orderby : $sql;
        $query = $this->db->query($query);
        //echo $this->db->last_query();
        if (!empty($totalrows))
            return $query->num_rows();
        else
            return $query->result_array();
    }

    public function select_single($table_name, $getfields = '', $match_values = '', $condition = '', $compare_type = '', $count = '', $num = '', $offset = '', $orderby = '', $sort = '') {
        $fields = $getfields ? implode(',', $getfields) : '';
        $sql = 'SELECT ';

        $sql .= $fields ? $fields : '*';
        $sql .= ' FROM ' . $table_name;
        $where = '';

        if ($match_values) {
            $keys = array_keys($match_values);
            $compare_type = $compare_type ? $compare_type : 'like';
            if ($condition != '')
                $and_or = $condition;
            else
                $and_or = ($compare_type == 'like') ? ' OR ' : ' AND ';

            $where = 'WHERE ';
            switch ($compare_type) {
                case 'like':
                    $where .= $keys[0] . ' ' . $compare_type . '"%' . $match_values[$keys[0]] . '%" ';
                    break;

                case '=':
                default:
                    $where .= $keys[0] . ' ' . $compare_type . '"' . $match_values[$keys[0]] . '" ';
                    break;
            }
            $match_values = array_slice($match_values, 1);

            foreach ($match_values as $key => $value) {
                $where .= $and_or . ' ' . $key . ' ';
                switch ($compare_type) {
                    case 'like':
                        $where .= $compare_type . '"%' . $value . '%"';
                        break;

                    case '=':
                    default:
                        $where .= $compare_type . '"' . $value . '"';
                        break;
                }
            }
        }
        $orderby = ($orderby != '') ? ' order by ' . $orderby . ' ' . $sort . ' ' : '';
        if ($offset == "" && $num == "")
            $sql .= ' ' . $where . $orderby;
        elseif ($offset == "")
            $sql .= ' ' . $where . $orderby . ' ' . 'limit ' . $num;
        else
            $sql .= ' ' . $where . $orderby . ' ' . 'limit ' . $offset . ',' . $num;

        $query = ($count) ? 'SELECT count(*) FROM ' . $table_name . ' ' . $where . $orderby : $sql;
        $query = $this->db->query($query);
        return $query->row_array();
    }

    public function get_joins($table, $columns, $joins) {
        $this->db->select($columns)->from($table);
        if (is_array($joins) && count($joins) > 0) {
            foreach ($joins as $k => $v) {
                $this->db->join($v['table'], $v['condition'], $v['jointype']);
            }
        }
        return $this->db->get()->result_array();
    }

    /*
      @Description: Function for get Module Lists
      @Author: Mohit Trivedi
      @Input: Fieldl list(id,name..), match value(id=id,..), condition(and,or),compare type(=,like),count,limit per page, starting row number
      @Output: Payments list
      @Date: 25-02-2015
     */

    function getmultiple_tables_records($table = '', $fields = '', $join_tables = '', $join_type = '', $match_values = '', $condition = '', $compare_type = '', $num = '', $offset = '', $orderby = '', $sort = '', $group_by = '', $wherestring = '', $having = '', $where_in = '', $totalrow = '', $or_where = '') {
        if (!empty($fields)) {
            foreach ($fields as $coll => $value) {
                $this->db->select($value, false);
            }
        }

        $this->db->from($table);

        if (!empty($join_tables)) {
            foreach ($join_tables as $coll => $value) {
                //$this->db->join($coll, $value,$join_type);
                $colldata = explode('jointype', $coll);
                $coll = trim($colldata[0]);

                if (!empty($colldata[1])) {
                    $join_type1 = trim($colldata[1]);
                    if ($join_type1 == 'direct')
                        $join_type1 = '';
                }

                if (isset($join_type1))
                    $this->db->join($coll, $value, $join_type1);
                else
                    $this->db->join($coll, $value, $join_type);

                unset($join_type1);
            }
        }

        if ($condition != null)
            $this->db->where($condition);

        if ($wherestring != '')
            $this->db->where($wherestring, NULL, FALSE);
        if (!empty($where_in)) {
            foreach ($where_in as $key => $value) {
                $this->db->where_in($key, $value);
            }
        }

        if (!empty($or_where)) {
            foreach ($or_where as $key => $value) {
                $this->db->or_where($key, $value);
            }
        }

        if ($group_by != null)
            $this->db->group_by($group_by);
        if ($having != null)
            $this->db->having($having);
        if ($orderby != null && $sort != null)
            $this->db->order_by($orderby, $sort);
        elseif ($orderby != null) {
            if ($orderby == 'special_case')
                $this->db->order_by('is_done asc,task_date asc');
            elseif ($orderby == 'special_case_task')
                $this->db->order_by('id desc');
            else
                $this->db->order_by($orderby);
        }


        if ($match_values != null && $compare_type != null)
            $this->db->or_like($match_values);

        if ($offset != null && $num != null)
            $this->db->limit($num, $offset);
        elseif ($num != null)
            $this->db->limit($num);

        $query_FC = $this->db->get();
        //echo $this->db->last_query();exit;
        if (!empty($totalrow))
            return $query_FC->num_rows();
        else
            return $query_FC->result_array();
    }
    
    public function getuserpagingid($table = '', $user_id='')
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id','desc');
        $result = $this->db->get()->result_array();
        $op = 0;
        if(count($result) > 0)
        {
            foreach($result as $key=>$row)
            {
                if($row['id'] == $user_id)
                {
                    $op = $key;
                    $op1 = strlen($op);
                    $op = substr($op,0,$op1-1)*10;
                }
            }
        }
        return $op;
    }

}

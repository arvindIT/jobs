<?php

/*
  @Description: common function Model
  @Author: Jayesh Rojasara
  @Input:
  @Output:
  @Date: 06-05-14 */

class common_function_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table_name = '';
    }

    /*
      @Description: generate string
      @Author: Jayesh Rojasara
      @Input: length of string
      @Output: generate string in uppercase
      @Date: 06-05-14 */

    public function randr($j = 8) {
        $string = "";
        for ($i = 0; $i < $j; $i++) {
            srand((double) microtime() * 1234567);
            $x = mt_rand(0, 2);
            switch ($x) {
                case 0:$string.= chr(mt_rand(97, 122));
                    break;
                case 1:$string.= chr(mt_rand(65, 90));
                    break;
                case 2:$string.= chr(mt_rand(48, 57));
                    break;
            }
        }
        return strtoupper($string);
    }

    /*
      @Description: common function Model for encrypt Script
      @Author: Jayesh Rojasara
      @Input:
      @Output:
      @Date: 06-05-14 */

    public static function encrypt_script($string)
    {
        $CI = & get_instance();
        $key = $CI->config->item('encryption_key');
        $encrypt_method = "AES-256-CBC";
        $iv = substr(hash('sha256',$key), 0, 16);
        return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }

    /*
      @Description: Function to decrypt string
      @Author: Nishant Rathod
      @Date: 04-08-2016
    */

    public static function decrypt_script($string)
    {
        $CI = & get_instance();
        $key = $CI->config->item('encryption_key');
        $encrypt_method = "AES-256-CBC";
        $iv = substr(hash('sha256',$key), 0, 16);
        return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    /*
      @Description: function to send email
      @Author: Jayesh Rojasara
      @Input:
      @Output:
      @Date: 22-01-2014
     */

    function send_email($to = '', $subject = '', $message = '', $from = '', $cc = '', $bcc = '', $data = '') {

        $this->load->library('email');
        $config = Array(
            'protocol' => 'sendmail',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'arvind.prajapati@tops-int.com',
            'smtp_timeout' => '30',
            'smtp_pass' => 'arvind123`',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_priority(1);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->from($from, $this->config->item('sitename'));
        $this->email->to($to);
        $this->email->cc($cc);
        $this->email->bcc('arvind.naukarihub@gmail.com');
        if (!empty($data['attachment_email'])) {
            foreach ($data['attachment_email'] as $row_attachment)
                $this->email->attach("uploads/attachment_file/" . $row_attachment['attachment']);
        }
        $this->email->send();
        $this->email->clear(TRUE);
    }

    function send_email1($to = '', $subject = '', $message = '', $from = '', $cc = '') {
        unset($config);

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['protocol'] = 'smtp';
        $config['smtp_port'] = '26';
        $config['smtp_host'] = 'mail.tops-tech.com';
        $config['smtp_user'] = 'test@tops-tech.com';
        $config['smtp_pass'] = 'tops123';
        $config['mailtype'] = 'html';
        $config['newline'] = "\r\n";
        $this->load->library('email', $config);

        $this->email->initialize($config);
        $this->email->from($from, $this->config->item('sitename') . " Administrator");

        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
    }

    /*
      @Description: Function for get Records Lists Multiple tables
      @Author: Jatin Jajal
      @Input: Fieldl list(id,name..), match value(id=id,..), condition(and,or),compare type(=,like),count,limit per page, starting row number
      @Output: Records list
      @Date: 01-05-2015
     */

    function getmultiple_tables_records($table = '', $fields = '', $join_tables = '', $join_type = '', $match_values = '', $condition = '', $compare_type = '', $num = '', $offset = '', $orderby = '', $sort = '', $group_by = '', $wherestring = '', $where_in = '', $totalrow = '', $having = '') {

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
            //$this->db->where_in('bm.id',$where_in['bm.id']);
            //pr($where_in);
            foreach ($where_in as $key => $value) {
                $this->db->where_in($key, $value);
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
        //echo $num."<br>".$offset."<br>";
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

}

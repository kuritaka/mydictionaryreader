<?php
class Dictionary extends CI_Model {

    var $table = 'dic';


    public function __construct() {
                parent::__construct();
                //$this->load->database('default');
                //$this->load->database('eijiro');
                //$this->load->database("$database");
                //echo "_construct database = $database";
        } 


    //fetch dictionary
    function get_dictionary($limit, $start, $st = NULL, $database, $check01, $radiovalue)
    {
        //echo "funcation database=$database<br>";
        if ($st == "NIL") $st = "";
        //$sql = "select * from dic where entry like '$st%' limit " . $start . ", " . $limit;
        //$sql = "select * from dic where entry like '%$st%' limit " . $start . ", " . $limit;

        //if ($radiovalue == "") $radiovalue = "entry";
        
        //echo "keyword =" . $st ."<br>";

        if ($check01 == "on"){
            $array = explode(" ", $st);
            $keywordCondition = [];
            foreach ($array as $keyword) {
                //$keywordCondition[] = '$radiovalue LIKE "%' . $keyword . '%"';
                $keywordCondition[] = $radiovalue . ' LIKE "%' . $keyword . '%"';
            }
            //var_dump($keywordCondition); 
            $keywordCondition = implode(' AND ', $keywordCondition);


            //$sql1 = " select entry,desc from dic where $radiovalue like '%$st%' ";
            $sql1 = " select entry,desc from dic where $keywordCondition ";
        }else{
            $sql1 = " select entry,desc from dic where $radiovalue like '$st%' ";
        }
        
        //$sql2 = " or cidr like '%$st%' or broadcast_address like '%$st%' or vlan_id like '%$st%' ";
        //$sql3 = " or note1 like '%$st%' or note2 like '%$st%' ";
        //$sql_order = " order by networks ";
        $sql_limit = " limit " . $start . ", " . $limit;

        $sql = "$sql1 $sql_order $sql_limit";

        //SQL Debug
        //echo "sql = $sql <br>";
        $this->sql  = "$sql";


        //echo "get_dictionary database=$database<br>";
        $this->load->database("$database");

        $query = $this->db->query($sql);

        return $query->result_array();
    }


    function get_dictionary_count($st = NULL, $check01, $database, $radiovalue, $maxrow)
    {
        if ($st == "NIL") $st = "";
        //$sql = "select entry,desc from dic where entry like '%$st%'";
        if ($check01 == "on"){
            $array = explode(" ", $st);
            $keywordCondition = [];
            foreach ($array as $keyword) {
                //$keywordCondition[] = '$radiovalue LIKE "%' . $keyword . '%"';
                $keywordCondition[] = $radiovalue . ' LIKE "%' . $keyword . '%"';
            }
            //var_dump($keywordCondition); 
            $keywordCondition = implode(' AND ', $keywordCondition);


            //$sql1 = " select entry,desc from dic where $radiovalue like '%$st%' ";
            $sql1 = " select entry,desc from dic where $keywordCondition ";
        }else{
            $sql1 = " select entry,desc from dic where $radiovalue like '$st%' ";
        }

        //$sql1 = "select * from networks where networks like '%$st%' ";
        //$sql2 = "or cidr like '%$st%' or broadcast_address like '%$st%' or vlan_id like '%$st%' ";
        //$sql3 = "or note1 like '%$st%' or note2 like '%$st%' ";
        //$sql = "$sql1 $sql2 $sql3";

        // Result Max is xxxxx.
        $sql_limit = " limit $maxrow";

        $sql = "$sql1 $sql_order $sql_limit";

        //echo "get_dictionary_count database=$database<br>";
        $this->load->database("$database");
        //$other->load->database("$database", TRUE);

        $query = $this->db->query($sql);
        //$query = $other->db->query($sql);

        return $query->num_rows();
    }


}

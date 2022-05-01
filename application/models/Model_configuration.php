<?php
    Class Model_configuration extends CI_Model
    {
    protected $table ='config';

    public function __construct()
        {
            parent::__construct();

        }
    public function GetValue($value)
		{
              	 $query = $this->db->query("select *  from config where id='".$value."'");

              		if ($query->num_rows() > 0)
              		{
              		   $row = $query->row();
              		   return $row->value;
              		}
              		else
              				{
              				return false;
              				}
        }
 
 }
    ?>
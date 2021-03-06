<?php

/*
 * @author jotiLalli, Richard Gosse
 */

class Result extends CI_Model {

	// Constructor
	public function __construct() {
		parent::__construct();
	}
        
        //returns a count of all results
        public function countResults($parameters)
        {
            $this->db->from('result');
            if(!empty($parameters['school_name']))
            {
                $this->db->like('LOWER(school_name)',strtolower($parameters['school_name']),'after');
                unset($parameters['school_name']);
            }            
            $this->db->where($parameters);
            return $this->db->count_all_results();
        }
        
        //returns a count of all results from past day
        public function countDailyResults($parameters)
        {
            $this->db->from('result');
            if(!empty($parameters['school_name']))
            {
                $this->db->like('LOWER(school_name)',strtolower($parameters['school_name']),'after');
                unset($parameters['school_name']);
            }            
            $this->db->where($parameters);
            $this->db->where('date',Date('Y-m-d'));
            return $this->db->count_all_results();
        }
        
        //returns a count of all results from past week
        public function countWeeklyResults($parameters)
        {
            $this->db->from('result');
            if(!empty($parameters['school_name']))
            {
                $this->db->like('LOWER(school_name)',strtolower($parameters['school_name']),'after');
                unset($parameters['school_name']);
            }            
            $this->db->where($parameters);
            $this->db->where('date <=',Date('Y-m-d'));
            $this->db->where('date >=',Date('Y-m-d', strtotime('-7 days')));
            return $this->db->count_all_results();
        }
        
        //returns a count of all results from past month
        public function countMonthlyResults($parameters)
        {
            $this->db->from('result');
            if(!empty($parameters['school_name']))
            {
                $this->db->like('LOWER(school_name)',strtolower($parameters['school_name']),'after');
                unset($parameters['school_name']);
            }            
            $this->db->where($parameters);
            $this->db->where('date <=',Date('Y-m-d'));
            $this->db->where('date >=',Date('Y-m-d', strtotime('first day of this month'))); 
            return $this->db->count_all_results();
        }
        
	//returns all results by the gender and grade
	public function getResults($parameters)
                {
            
            $this->db->select('*');
            $this->db->from('result');
            if(!empty($parameters['school_name']))
            {
                $this->db->like('LOWER(school_name)',strtolower($parameters['school_name']),'after');
                unset($parameters['school_name']);
            }            
            $this->db->where($parameters);
            $this->db->order_by('time', "asc");
            //$this->db->limit(20);
            $result = $this->db->get();
            return $result->result_array();
		
	}
        
        public function getAlltimeResults($parameters)
                {
            
            $this->db->select('*');
            $this->db->from('result');
            if(!empty($parameters['school_name']))
            {
                $this->db->like('LOWER(school_name)',strtolower($parameters['school_name']),'after');
                unset($parameters['school_name']);
            } 
            $this->db->where($parameters);
            $this->db->order_by('time', "asc");
            $this->db->limit(20);
            $result = $this->db->get();
            return $result->result_array();
		
	}
        
        public function getDailyResults($parameters) 
                {
            $this->db->select('*');
            $this->db->from('result');
            if(!empty($parameters['school_name']))
            {
                $this->db->like('LOWER(school_name)',strtolower($parameters['school_name']),'after');
                unset($parameters['school_name']);
            } 
            $this->db->where($parameters);
            $this->db->where('date',Date('Y-m-d'));
            $this->db->order_by('time', "asc");
            $this->db->limit(20);
            $result = $this->db->get();
            return $result->result_array();;
            
        }
        
        public function getWeeklyResults($parameters) 
                {
            
            $this->db->select('*');
            $this->db->from('result');
            if(!empty($parameters['school_name']))
            {
                $this->db->like('LOWER(school_name)',strtolower($parameters['school_name']),'after');
                unset($parameters['school_name']);
            } 
            $this->db->where($parameters);
            $this->db->where('date <=',Date('Y-m-d'));
            $this->db->where('date >=',Date('Y-m-d', strtotime('-7 days')));
            $this->db->order_by('time', "asc");
            $this->db->limit(20);
            $result = $this->db->get();
            return $result->result_array();;
            
  
        }
        
        public function getMonthlyResults($parameters) 
                {
            $this->db->select('*');
            $this->db->from('result');
            if(!empty($parameters['school_name']))
            {
                $this->db->like('LOWER(school_name)',strtolower($parameters['school_name']),'after');
                unset($parameters['school_name']);
            } 
            $this->db->where($parameters);
            $this->db->where('date <=',Date('Y-m-d'));
            $this->db->where('date >=',Date('Y-m-d', strtotime('first day of this month'))); 
            $this->db->order_by('time', "asc");
            $this->db->limit(20);
            $result = $this->db->get();
            return $result->result_array();;
        }


	//creates a new database entry in the result table
	public function addResult($parameters) {

		$date = $parameters['date'];
		$time = $parameters['time'];
		$ranked = $parameters['ranked'];
		$flagged = $parameters['flagged'];
		$student_name = $parameters['student_name'];
                $student_gender = $parameters['student_gender'];
                $student_grade = $parameters['student_grade'];
                $school_name = $parameters['school_name'];

                if ($student_gender == 'M' | $student_gender == 'F'
                        )
                {
                
		$data = array(
			'date' => $date,
			'time' => $time,
			'ranked' => $ranked,
			'flagged' => $flagged,
			'student_name' => $student_name,
                        'student_gender' => $student_gender,
                        'student_grade' => $student_grade,
                        'school_name' => $school_name
		);

		return $this->db->insert('result', $data);
                }
                else {
                    return FALSE;
                }
	}

	public function deleteResult($result_id) {
		if ($result_id > 0) {
			$this->db->where('result_id', $result_id);
			$this->db->delete('result');
			return array('affected_rows' => $this->db->affected_rows());
		}
	}

}
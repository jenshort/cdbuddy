<?php

namespace SierraSql\Model;
use SierraSql\DbConnection;


class Model
{
	protected $fpdo;

	public function __construct()
	{
		$db = DbConnection::connect();
		$this->fpdo = $db->fpdo;		
	}


	/* 	Sierra generates check digits for its client-visible record numbers, 
		but these aren't stored in the database, so we need to generate them ourselves.  
		See http://csdirect.iii.com/sierrahelp/Content/sril/sril_records_numbers.html
		(Modulus 11 check digit)
	*/
	private function getRecordWithCheckDigit($record_num)
	{
		// reverse the number so it's easier to work with
		$reversed_number = strrev($record_num);
		for($i = 0, $sum = 0; $i < strlen($reversed_number); $i++) {
			// get the $i'th digit
			$current = substr($reversed_number, $i, 1);
			$product = $current * ($i+2);
			$sum += $product;
		}

		$remainder = $sum % 11;
		if($remainder == 10) {
			$new = $record_num . 'x';
		} else {
			$new = $record_num . $remainder;
		}

		return $new;
	}

	// Takes an array of query results and an array of field names that correspond to 
	// record numbers and types.  Alters record numbers of the given fields to include
	// the record type code and the calculated check digit.  The Field name should match
	// the key used by the $data array.  
	// $fieldsWithCheckDigits format:
	// [
	//		"field_name" => "record_type_code",
	// ]
	protected function updateRecordsWithCheckDigits($data, $fieldsWithCheckDigits)
	{
		foreach($data as $key=>$item) {
			foreach($fieldsWithCheckDigits as $field=>$code) {
				$record_num = $item[$field];
				$item[$field] = $code . $this->getRecordWithCheckDigit($record_num);
			}
			$data[$key] = $item;
		}
		return $data;		
	}
}
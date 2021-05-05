<?php 

class rest {
	
	function responce (string $status, array $data = []) {
		$status = ["status" => $status];
		$responce = (!empty($data)) array_merge($status, $data) : $status;
		echo json_encode($responce);
	}
	
	function error (string $message = []) {
		$this->responce("error", []);
	}
	
	function success (array $data = []) {
		$this->responce("ok", $data);
	}
	
}

$rest = new rest;
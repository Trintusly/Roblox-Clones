<?php
header("Content-type: application/json");
class rest {

	function response (string $status, array $data = []) {
		$status = ["status" => $status];
		$response = (!empty($data)) ? array_merge($status, $data) : $status;
		echo json_encode($response);
	}

	function error (string $message = "") {
		$message = (!empty($message)) ? ["error" => $message] : [];
		$this->response("error", $message);
	}

	function success (array $data = []) {
		$this->response("ok", $data);
	}

}

$rest = new rest;

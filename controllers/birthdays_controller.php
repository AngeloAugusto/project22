<?php

require_once '../models/birthdays_model.php';

class BirthdayController
{
	private $model;

	public function __construct($dbConnection)
	{
		$this->model = new BirthdayModel($dbConnection);
	}

	public function getAll()
	{
		$result = $this->model->getAll();
		$birthdays = [];

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				array_push($birthdays, $row);
			}
			return ['status' => 'success', 'data' => $birthdays];
		} else {
			return ['status' => 'error', 'message' => 'No birthdays found'];
		}
	}

	public function get($id)
	{
		$result = $this->model->get($id);

		if ($result->num_rows > 0) {
			$example = $result->fetch_assoc();
			return ['status' => 'success', 'data' => $example];
		} else {
			return ['status' => 'error', 'message' => 'Example not found'];
		}
	}

	public function create()
	{
		$data = json_decode(file_get_contents('php://input'), true);

		if (!empty($data['name']) && !empty($data['birthday'])) {
			$result = $this->model->create($data);

			return $result;
		} else {
			return ['status' => 'error', 'message' => 'Name and birthday fields are required'];
		}
	}

	public function update($id)
	{
		$data = json_decode(file_get_contents('php://input'), true);

		if (!empty($data['name']) && !empty($data['birthday'])) {
			$result = $this->model->update($id, $data);

			return $result;
		} else {
			return ['status' => 'error', 'message' => 'Name and birthday fields are required'];
		}
	}

	public function delete($id)
	{
		if (!empty($id)) {
			$result = $this->model->delete($id);

			return $result;
		} else {
			return ['status' => 'error', 'message' => 'Invalid example ID'];
		}
	}
}

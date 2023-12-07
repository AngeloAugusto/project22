<?php

class BirthdayModel
{
	private $conn;

	public function __construct($dbConnection)
	{
		$this->conn = $dbConnection;
	}

	public function getAll()
	{
		$query = "SELECT * FROM birthdays";
		$result = $this->conn->query($query);
		return $result;
	}

	public function get($id)
	{
		$query = "SELECT * FROM birthdays WHERE id = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	public function create($data)
	{

		$query = "INSERT INTO birthdays (name, birthday, description) VALUES (?, STR_TO_DATE(?, '%d/%m/%Y'), ?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('sss', $data['name'], $data['birthday'], $data['description']);

		if ($stmt->execute()) {
			return ['status' => 'success', 'message' => 'Foi criado com sucesso'];
		} else {
			return ['status' => 'error', 'message' => 'Erro ao criar'];
		}
	}

	public function update($id, $data)
	{
		$query = "UPDATE birthdays SET name = ?, birthday = STR_TO_DATE(?, '%d/%m/%Y'), description = ? WHERE id = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('sssi', $data['name'], $data['birthday'], $data['description'], $id);

		if ($stmt->execute()) {
			return ['status' => 'success', 'message' => 'Foi atualizado com sucesso'];
		} else {
			return ['status' => 'error', 'message' => 'Erro ao atualizar'];
		}
	}

	public function delete($id)
	{
		$query = "DELETE FROM birthdays WHERE id = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('i', $id);

		if ($stmt->execute()) {
			return ['status' => 'success', 'message' => 'Foi deletado com sucesso'];
		} else {
			return ['status' => 'error', 'message' => 'Erro ao deletar'];
		}
	}
}

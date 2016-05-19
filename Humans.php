<?php

require_once("REST.php");

class Humans extends REST {



	/**
     * Display all entries.
     *
     * @param  $connection
     */
	function get_humans($connection)
	{

		$query = "SELECT * FROM humans";
		$response = array();
		$result = mysqli_query($connection, $query);


		while($row = mysqli_fetch_array($result)) {

			$rowPart = [
				'id' => $row['id'],
				'first_name' => $row['first_name'],
				'last_name' => $row['last_name']
				];

			array_push($response, $rowPart);

		}

		$this->setHttpHeaders(200);
		echo json_encode($response);

	}



	/**
     * Display a specified entry.
     *
     * @param  $connection
     * @param  $human_id
     */
	function get_human($connection, $human_id)
	{

		$query = "SELECT * FROM humans WHERE id=".$human_id;
		$response = array();
		$result = mysqli_query($connection, $query);
		$row = mysqli_fetch_array($result);
		$response = [
			'id' => $row['id'],
			'first_name' => $row['first_name'],
			'last_name' => $row['last_name']
			];

		if ($result->num_rows != 0) {

			$this->setHttpHeaders(200);
			echo json_encode($response);

		} else {

			$this->setHttpHeaders(404);

		}

	}



	/**
     * Store a newly created entry on database.
     *
     * @param  $connection
     */
	function insert_human($connection)
	{

		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];

		$query = "INSERT INTO humans SET first_name='{$first_name}', last_name='{$last_name}'";

		if(mysqli_query($connection, $query)) {

			$response = array(
				'status' => 1,
				'status_message' => 'Added Successfully.'
			);

		} else {

			$response = array(
				'status' => 0,
				'status_message' => 'Addition Failed.'
			);

		}

		$this->setHttpHeaders(200);
		echo json_encode($response);

	}



	/**
     * Delete a specified entry.
     *
     * @param  $connection
     * @param  $human_id
     */
	function delete_human($connection, $human_id)
	{

		$query = "SELECT * FROM humans WHERE id=".$human_id;
		$result = mysqli_query($connection, $query);

		if ($result->num_rows != 0) {

			$query="DELETE FROM humans WHERE id=".$human_id;

			if(mysqli_query($connection, $query)) {

				$response = array(
					'status' => 1,
					'status_message' =>'Deleted Successfully.'
				);

			} else {

				$response = array(
					'status' => 0,
					'status_message' =>'Deletion Failed.'
				);

			}

			$this->setHttpHeaders(200);
			echo json_encode($response);

		} else {

			$this->setHttpHeaders(404);

		}

	}



	/**
     * Update a specified entry.
     *
     * @param  $connection
     * @param  $human_id
     */
	function update_human($connection, $human_id)
	{

		$query = "SELECT * FROM humans WHERE id=".$human_id;
		$result = mysqli_query($connection, $query);

		if ($result->num_rows != 0) {

			parse_str(file_get_contents("php://input"),$post_vars);

			$first_name = $post_vars["first_name"];
			$last_name = $post_vars["last_name"];

			$query = "UPDATE humans SET first_name='{$first_name}', last_name='{$last_name}' WHERE id=".$human_id;

			if(mysqli_query($connection, $query)) {
				$response = array(
					'status' => 1,
					'status_message' =>'Updated Successfully.'
				);
			} else {
				$response = array(
					'status' => 0,
					'status_message' =>'Updation Failed.'
				);
			}

			$this->setHttpHeaders(200);
			echo json_encode($response);

		} else {

			$this->setHttpHeaders(404);

		}

	}



}

?>
<?php

require_once("Humans.php");

class API extends Humans {



	/**
     * Initialize API.
     *
	 *
     */
	public function init($host, $username, $password, $database)
	{

		$connection = mysqli_connect($host, $username, $password, $database);
		$request_method = $_SERVER["REQUEST_METHOD"];

		switch($request_method)
		{

			case 'GET':

				if(!empty($_GET["human_id"])) {

					$human_id = intval($_GET["human_id"]);
					$this->get_human($connection, $human_id);

				} else {

					$this->get_humans($connection);

				}
				break;

			case 'POST':

				$this->insert_human($connection);
				break;

			case 'PUT':

				$human_id = intval($_GET["human_id"]);
				$this->update_human($connection, $human_id);
				break;

			case 'DELETE':

				$human_id = intval($_GET["human_id"]);
				$this->delete_human($connection, $human_id);
				break;

			default:

				$this->setHttpHeaders(405);
				break;
				
		}

		// Close database connection
		mysqli_close($connection);
	}



}
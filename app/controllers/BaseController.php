<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */


	protected function setupLayout()
	{


		

		if ( ! is_null($this->layout))
		{


			$this->layout = View::make($this->layout);
		}
	}

	public function json_validate($string){
  
    $result = json_decode($string);

			
			switch (json_last_error()) {
				case JSON_ERROR_NONE:
					$error = ''; 
					break;
				case JSON_ERROR_DEPTH:
					$error = 'The maximum stack depth has been exceeded.';
					break;
				case JSON_ERROR_STATE_MISMATCH:
					$error = 'Invalid or malformed JSON.';
					break;
				case JSON_ERROR_CTRL_CHAR:
					$error = 'Control character error, possibly incorrectly encoded.';
					break;
				case JSON_ERROR_SYNTAX:
					$error = 'Syntax error, malformed JSON.';
					break;
				// PHP >= 5.3.3
				case JSON_ERROR_UTF8:
					$error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
					break;
				// PHP >= 5.5.0
				case JSON_ERROR_RECURSION:
					$error = 'One or more recursive references in the value to be encoded.';
					break;
				// PHP >= 5.5.0
				case JSON_ERROR_INF_OR_NAN:
					$error = 'One or more NAN or INF values in the value to be encoded.';
					break;
				case JSON_ERROR_UNSUPPORTED_TYPE:
					$error = 'A value of a type that cannot be encoded was given.';
					break;
				default:
					$error = 'Unknown JSON error occured.';
					break;
			}

			if ($error !== '') {
			
				exit($error);
			}

			
			return 1;
	}

	public function Cefis()
    {


			$result = file_get_contents('https://cefis.com.br/api/v1/event');
			$json_check = $this->json_validate($result);

			if($json_check != 1){

				$result = '{"data":[{"id":1,"title":"JSON iNVÁLIDO"}]}';
			}
			 


       return View::make('index4', array('json' => $result));
    }

}

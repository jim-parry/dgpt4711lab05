<?php
namespace App\Controllers;

class Travel extends BaseController
{

	public function index()
	{
		// connect to the model
		$places = new \App\Models\Places();
		// retrieve all the records
		$records = $places->findAll();

		// Let's generate a table to show the destinations
		$table = new \CodeIgniter\View\Table();
		$table->setHeading('ID', 'Destination');
		// add a  row for each spot
		foreach ($records as $key => $record)
			$table->addRow(anchor('/travel/showme/' . $record->id, $key), $record->name);

		// get a template parser
		$parser = \Config\Services::parser();
		// tell it about the substitions
		return $parser->setData(['table' => $table->generate()], 'raw') // "raw" prevents escaping the generated HTML
						// and have it render the template with those
						->render('placeslist');
	}

	public function showme($id)
	{
		// connect to the model
		$places = new \App\Models\Places();
		// retrieve all the records
		$record = $places->find($id);

		// build a form to present this destination
		// nothing is editable (nor will the ID be), but it should look familar
		helper('form');
		$form = form_open('#');
		$form .= form_fieldset('ID') .
				$record['id'] . form_fieldset_close();
		$form .= form_fieldset('Name') .
				'Destination name: ' .
				form_input('name', $record['name']) . form_fieldset_close();
		$form .= form_fieldset('Description') .
				'Destination description: ' .
				form_textarea('description', $record['description']) . form_fieldset_close();
		$form .= form_fieldset('Link') .
				'Official tourism site: ' .
				form_input('link', $record['link']) . form_fieldset_close();
		// don't include any buttons yet
		$form .= form_close();

		//get a template parser
		$parser = \Config\Services::parser();
		// tell it about the substitions
		return $parser->setData(['form' => $form], 'raw')
						// and have it render the template with those
						->render('oneplace');
	}

}

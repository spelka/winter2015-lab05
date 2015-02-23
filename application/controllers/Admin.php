<?php

/**
 * Admin Controller
 * 
 * controllers/Admin.php
 *
 * ------------------------------------------------------------------------
 */
class Admin extends Application
{

    function __construct()
    {
		parent::__construct();
		$this->load->helper('formfields');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index()
    {
		$this->data['title'] = 'Quotations Maintenance';
		$this->data['quotes'] = $this->quotes->all();
		$this->data['pagebody'] = 'admin_list';
		$this->render();
    }
	
	// Add a new quotation
	function add()
	{
		$quote = $this->quotes->create();
		$this->present($quote);
	} 
	
	// Present a quotation for adding/editing
	function present($quote)
	{
		$this->data['fid'] = makeTextField('ID#', 'id', $quote->id, "Unique quote identifier, system-assigned",10,10,true);
		$this->data['fwho'] = makeTextField('Author', 'who', $quote->who);
		$this->data['fmug'] = makeTextField('Picture', 'mug', $quote->mug);
		$this->data['fwhat'] = makeTextArea('The Quote', 'what', $quote->what);
		$this->data['pagebody'] = 'quote_edit';
		
		$this->data['fsubmit'] = makeSubmitButton('Process Quote', "Click here to validate the quotation data", 'btn-success');
		
		$this->render();
	}
	
	// process a quotation edit
	function confirm()
	{
		$record = $this->quotes->create();
		
		// Extract submitted fields
		$record->id = $this->input->post('id');
		$record->who = $this->input->post('who');
		$record->mug = $this->input->post('mug');
		$record->what = $this->input->post('what');
		
		// Save stuff
	    if (empty($record->id))
		{
			$this->quotes->add($record);
	    }
		else 
		{
			$this->quotes->update($record);
	    }
		redirect('/admin');
	} 

}

/* End of file Admin.php */
/* Location: application/controllers/Admin.php */
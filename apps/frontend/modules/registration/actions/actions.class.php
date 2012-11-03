<?php

/**
 * registration actions.
 *
 * @package    charitycoding
 * @subpackage registration
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registrationActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
        // get the form
        $this->form = new UserRegistrationForm();
        
    	// has the form been submitted?
	if ($request->isMethod('post')) {

            // bind submitted data
            $form->bind($request->getParameter($form->getName()),
                        $request->getFiles($form->getName()));

            // validate the form
            if ($form->isValid()) {

                // get the cleansed values
                $submittedInfo = $form->getValues();
            }            
            
        }    
    }
    
}

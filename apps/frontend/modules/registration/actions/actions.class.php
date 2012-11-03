<?php
require_once(dirname(__FILE__).'/../../../../../lib/vendor/php-github-api/vendor/autoload.php');

/**
 * registration actions.
 *
 * @package    charitycoding
 * @subpackage registration
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registrationActions extends sfActions {

    
    public function preExecute() {
        parent::preExecute();       
        $this->gitClient = new Github\Client();        
        if($this->getUser()->isAuthenticated()) {
 

        }
    }
    
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
        $this->form = new UserRegistrationForm(array(), array('gitClient' => $this->gitClient));
        
    	// has the form been submitted?
	if ($request->isMethod('post')) {

            // bind submitted data
            $this->form->bind($request->getParameter($this->form->getName()),
                              $request->getFiles($this->form->getName()));

            // validate the form
            if ($this->form->isValid()) {

                // grab the submitted user data of birth
                $submittedData = $request->getParameter('user_details');
                
                // create a new sfGuard user and populate with submitted data
                $sfGuardUser = new sfGuardUser();
                $sfGuardUser->fromArray($submittedData);
                                
                // create a new user detail object, set the submitted data and 
                // add the sfGuard user object
                $userDetails = new UserDetails();
                $userDetails->fromArray($submittedData);
                $userDetails->setSfGuardUser($sfGuardUser);

                // now, save the sfGuard and UserDetails
                if (!$userDetails->register()) {
                    throw new Exception("Could not register user.");
                }

                // sign the user in.. 
                $this->getUser()->signin($sfGuardUser, false);
                            
                // redirect the user to the next step
                $this->redirect("@list_user_repo");
            }                        
        }    
    }
    
    /**
     * Executes list user repos
     *
     * @param sfRequest $request A request object
     */
    public function executeListUserRepo(sfWebRequest $request) {
        
        $this->userRepos = 
        
        die('-2');
    }
    
    
}

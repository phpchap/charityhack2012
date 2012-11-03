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
        
        // get the twitter client
        $this->gitClient = new Github\Client();
        
        // grab a few bits for use down thar
        if($this->getUser()->isAuthenticated()) {
            $this->githubUsername = $this->getUser()->getAttribute('github_username');
            $this->userId = $this->getUser()->getGuardUser()->getId();            
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
                
                // add a few bits into the session
                $this->getUser()->setAttribute('github_username', $submittedData['github_username']);
                                
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
        
        // fetch a list of user repos
        $this->userRepos = $this->getUserRepos();

    	// has the form been submitted?
	if ($request->isMethod('post')) {
            
            // loop over each repo and get the name
            foreach($_POST['repo_name'] as $repoName) {
                
                // add if not exists
                if(GitHubRepoTable::checkRepoNameExists($repoName) != true) {
                    // create github repo acc
                    $g = new GitHubRepo;
                    $g->setRepoName($repoName);
                    $g->setUserId($this->userId);
                    $g->save();                    
                }                
            }
            
            // redirect to the list page
            $this->redirect("@list_user_issues");
         }
    }
    
    /**
     * Executes list repo issues
     *
     * @param sfRequest $request A request object
     */
    public function executeListIssues(sfWebRequest $request) {
        
        
        $this->issues = $client->api('issue')->all($this0, 'php-github-api', array('state' => 'open'));
        
        /*
        // fetch a list of user repos
        $this->userRepos = $this->getUserRepos();

    	// has the form been submitted?
	if ($request->isMethod('post')) {
            
            // loop over each repo and get the name
            foreach($_POST['repo_name'] as $repoName) {

                // create github repo acc
                $g = new GitHubRepo;
                $g->namegithub_repo = $repoName;
                $g->user_id = $this->userId;
                $g->save();
            }

         }
         * 
         */
    }
    
    // PRIVATE FUNCTIONS
    
    /**
     * fetch a list of a users github repositories
     * @param string $user
     * @return array
     */
    private function getUserRepos($user="") 
    {
        if($user == "") {
            $user = $this->githubUsername;
        }
        return $this->gitClient->api('user')->repositories($user);
        
    }
    

}

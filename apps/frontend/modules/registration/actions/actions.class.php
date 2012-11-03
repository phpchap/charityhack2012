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

    	// has the form been submitted?
	if ($request->isMethod('post')) {
            
            // we only want to process the items the user has entered a value for            
            foreach($_POST['issue_value'] as $issueIndex => $issueValue) {
                    
                $repoId = $_POST['repo_id'][$issueIndex];
                $issueId = $_POST['issue_id'][$issueIndex];
                $issueNumber = $_POST['issue_number'][$issueIndex];
                $issueValue = $_POST['issue_value'][$issueIndex];                
                
                // build the issue
                $i = new GitHubIssue;
                $i->repo_id = $repoId;
                $i->user_id = $this->userId;
                $i->issue_number = $issueNumber;
                $i->donation_amount = $issueValue;
                
                // save the issue
                $i->save();                
                
            }

            // now do the redirect
            $this->redirect("@create_just_giving_page");
                        
        }        
        
        // fetch the newly saved repos
        $this->userRepos = GitHubRepoTable::getUserRepos($this->userId);
 
        $counter = 0;

        // now we fetch the issues for each repo 
        foreach($this->userRepos as $repo) {

            // fetch the issues
            $userIssues = $this->getOpenUserIssues($repo['repo_name']);
            
            $userRepoIssues[$counter]['repo_id'] = $repo['id'];
            $userRepoIssues[$counter]['repo'] = $repo['repo_name'];
            $userRepoIssues[$counter]['issue'] = $userIssues;                    
            
            $counter++;
        }
        
        $this->userRepoIssues = $userRepoIssues;
    }
        
    /**
     * Executes create a just giving page
     *
     * @param sfRequest $request A request object
     */
    public function executeCreateJustGivingPage(sfWebRequest $request) 
            
        die('--1');
    
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
    
    /**
     * fetch a list of a users github repositories
     * @param string $repoName 
     * @param string $user (optional)
     * @param string $state (optional, default: open)
     * @return array
     */
    private function getOpenUserIssues($repoName, $user="", $state="") 
    {
        if($user == "") {
            $user = $this->githubUsername;
        }

        if($state == "") {
            $state = "open";
        }
        
        return $this->gitClient->api('issue')->all($user, $repoName, array('state' => $state));
    }
    

}

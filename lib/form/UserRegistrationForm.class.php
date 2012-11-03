<?php

/**
 * UserDetails form.
 *
 * @package    charitycoding
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserRegistrationForm extends BaseUserDetailsForm {

    public function configure() {

	// grab the sfGuard user registration form
	$sfGuardForm = new sfGuardRegisterForm();
	
	// By default, BasesfGuardUserForm sets email's validator to a mere string validator.
	// Add in actual email validation
	$sfGuardForm->setValidator('email_address', new sfValidatorEmail(array('required' => true)));
	
	// remove the unnecessary fields
	unset($sfGuardForm['id']);        
        unset($this['user_id']);
        unset($sfGuardForm['first_name']);
        unset($sfGuardForm['last_name']);
        unset($sfGuardForm['username']);
        
        $helps = array('email_address' => 'Will also be used for creating/checking JustGiving Account',
                       'password' => 'Will also be used to create JustGiving account');
        
        $this->getWidgetSchema()->setHelps($helps);
        
	// embed the sfGuardUserForm within this form
	$this->mergeForm($sfGuardForm);        
        // call the custom validator
	$this->validatorSchema->setPostValidator(
	    new sfValidatorCallback(array('callback' => array($this, 'validateExtra')))
	);

    }

    /**
     * validate the id with the hash of the id
     * 
     * @param type $validator
     * @param type $values
     * @param type $arguments
     */
    public function validateExtra($validator, $values, $arguments)
    {               
        // verify the email
        if(sfGuardUserTable::checkEmailExists($values['email_address']) == true){
	    // assign the error to the title field
	    $error = new sfValidatorError($validator, 'Email already exists');
	    throw new sfValidatorErrorSchema($validator, array('email_address' => $error));            
        }
        // check github user isnt already registered
        if(UserDetailsTable::checkGithubUsernameExists($values['github_username']) == true){
	    // assign the error to the title field
	    $error = new sfValidatorError($validator, 'Github user already registered');
	    throw new sfValidatorErrorSchema($validator, array('github_username' => $error));            
        }
        
	// return values
	return $values;
    }
}

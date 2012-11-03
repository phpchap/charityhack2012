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
	
	// remove the id field
	unset($this->widgetSchema['id']);

	// embed the sfGuardUserForm within this form
	$this->mergeForm($sfGuardForm);        
    }

}

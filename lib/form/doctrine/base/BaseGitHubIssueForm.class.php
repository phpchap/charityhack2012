<?php

/**
 * GitHubIssue form base class.
 *
 * @method GitHubIssue getObject() Returns the current form's model object
 *
 * @package    charitycoding
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGitHubIssueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'repo_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GitIssue'), 'add_empty' => true)),
      'user_id'         => new sfWidgetFormInputText(),
      'issue_number'    => new sfWidgetFormInputText(),
      'donation_amount' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'repo_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GitIssue'), 'required' => false)),
      'user_id'         => new sfValidatorInteger(array('required' => false)),
      'issue_number'    => new sfValidatorInteger(array('required' => false)),
      'donation_amount' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('git_hub_issue[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GitHubIssue';
  }

}

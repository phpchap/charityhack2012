<?php

/**
 * GitHubIssue filter form base class.
 *
 * @package    charitycoding
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGitHubIssueFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'repo_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GitIssue'), 'add_empty' => true)),
      'user_id'         => new sfWidgetFormFilterInput(),
      'issue_number'    => new sfWidgetFormFilterInput(),
      'donation_amount' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'repo_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('GitIssue'), 'column' => 'id')),
      'user_id'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'issue_number'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'donation_amount' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('git_hub_issue_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GitHubIssue';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'repo_id'         => 'ForeignKey',
      'user_id'         => 'Number',
      'issue_number'    => 'Number',
      'donation_amount' => 'Number',
    );
  }
}

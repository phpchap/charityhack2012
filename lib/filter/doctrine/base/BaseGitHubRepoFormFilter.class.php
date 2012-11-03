<?php

/**
 * GitHubRepo filter form base class.
 *
 * @package    charitycoding
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGitHubRepoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'   => new sfWidgetFormFilterInput(),
      'repo_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'repo_name' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('git_hub_repo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GitHubRepo';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'user_id'   => 'Number',
      'repo_name' => 'Text',
    );
  }
}

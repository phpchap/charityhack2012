<?php

/**
 * GitHubAccount filter form base class.
 *
 * @package    charitycoding
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGitHubAccountFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'github_repo' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'github_repo' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('git_hub_account_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GitHubAccount';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'github_repo' => 'Text',
    );
  }
}

<?php

/**
 * BaseGitHubIssue
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $repo_id
 * @property integer $user_id
 * @property integer $issue_number
 * @property integer $donation_amount
 * @property Doctrine_Collection $GitIssue
 * 
 * @method integer             getRepoId()          Returns the current record's "repo_id" value
 * @method integer             getUserId()          Returns the current record's "user_id" value
 * @method integer             getIssueNumber()     Returns the current record's "issue_number" value
 * @method integer             getDonationAmount()  Returns the current record's "donation_amount" value
 * @method Doctrine_Collection getGitIssue()        Returns the current record's "GitIssue" collection
 * @method GitHubIssue         setRepoId()          Sets the current record's "repo_id" value
 * @method GitHubIssue         setUserId()          Sets the current record's "user_id" value
 * @method GitHubIssue         setIssueNumber()     Sets the current record's "issue_number" value
 * @method GitHubIssue         setDonationAmount()  Sets the current record's "donation_amount" value
 * @method GitHubIssue         setGitIssue()        Sets the current record's "GitIssue" collection
 * 
 * @package    charitycoding
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGitHubIssue extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_issue');
        $this->hasColumn('repo_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('issue_number', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('donation_amount', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('type', 'InnoDB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('GitHubRepo as GitIssue', array(
             'local' => 'repo_id',
             'foreign' => 'id'));
    }
}
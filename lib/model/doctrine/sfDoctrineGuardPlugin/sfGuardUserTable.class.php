<?php

/**
 * sfGuardUserTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class sfGuardUserTable extends PluginsfGuardUserTable {

    /**
     * Returns an instance of this class.
     *
     * @return object sfGuardUserTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('sfGuardUser');
    }


    /**
     * fetch a list of user emails by their group name, used for forum admin 
     * alerts
     * @param string $groupName (Forum Admin|Article Editor|Article Admin)
     * @return array
     */
    public static function checkEmailExists($email)
    {
	// create the query
	$q = Doctrine_Query::create();
	$q->select("u.email_address");
	$q->from("sfGuardUser u");        
	$q->addWhere("u.email_address = ?", $email);        
	// execute the query and return the resultset
        $res = $q->fetchArray();
        // check the result
        if(count($res) > 0) {
            // email exists
            return true;
        } else {
            // email doesnt exist
            return false;
        }
    }    
}
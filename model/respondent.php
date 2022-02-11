<?php

/*
 *
 *       Date              User               Description
 * ------------------------------------------------------------------------------
 *      2/11/22           Aaron Potter        Refactoring initial functionality
 * 
 *  
 */

class Respondent {

    private $first_name, $last_name;

    public function __construct($first_name, $last_name) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

}

class RespondentDB {

    public static function getRespondents() {
        $db = Database::getDB();
        $query = 'SELECT first_name, last_name FROM respondent ORDER BY last_name';

        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        $respondent = array();
        foreach ($rows as $row) {
            $respondentObject = new Respondent($row['first_name'],
                    $row['last_name']);
            $respondent[] = $respondentObject;
        }
        return $respondent;
    }
    
    public static function getResp() {
        $db = Database::getDB();
        $queryRespondent = 'SELECT * FROM respondent';
        $statement1 = $db->prepare($queryRespondent);
        $statement1->execute();
        $respondents = $statement1;
        return $respondents;
    }
}


?>
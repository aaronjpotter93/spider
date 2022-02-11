<?php

/*
 *
 *       Date              User               Description
 * ------------------------------------------------------------------------------
 *      2/11/22           Aaron Potter        Refactoring initial functionality
 *                                            Created a visit function
 *  
 */

function addVisit($email_address, $phone, $contact_by_mobile,
        $contact_by_email, $comments) {
    $db = Database::getDB();
    $query = 'INSERT INTO visit
	(email_address, mobile_phone, visit_msg, visit_date, 
        respondent_id, contact_by_mobile, contact_by_email)
        VALUES (:email_address, :phone, :comments, NOW(), 1, :contact_by_mobile, 
        :contact_by_email)';

    $statement = $db->prepare($query);
    $statement->bindValue(':email_address', $email_address);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':contact_by_mobile', $contact_by_mobile);
    $statement->bindValue(':contact_by_email', $contact_by_email);
    $statement->bindValue(':comments', $comments);
    $statement->execute();
    $statement->closeCursor();
}

function getVisitbyResp($respondent_id) {
    $db = Database::getDB();
    $queryVisit = 'SELECT visit.email_address, visit.mobile_phone, 
                        visit.visit_msg, visit.visit_date, visit.contact_by_mobile, 
                        visit.contact_by_email
                        FROM visit
                        JOIN respondent
                        ON visit.respondent_id = respondent.respondent_id
                        WHERE respondent.respondent_id = :respondent_id
                        ORDER BY visit_date';
        $statement2 = $db->prepare($queryVisit);
        $statement2->bindValue(":respondent_id", $respondent_id);
        $statement2->execute();
        $visits = $statement2;
        return $visits;
}

function delVisit($visit_id) {
    $db= Database::getDB();
     $visit_id = filter_input(INPUT_POST, 'visit_id', FILTER_VALIDATE_INT);
    $respondent_id = filter_input(INPUT_POST, 'respondent_id', FILTER_VALIDATE_INT);
    $queryDelete = 'DELETE FROM visit WHERE visit_id = :visit_id';
    $statement3 = $db->prepare($queryDelete);
    $statement3->bindValue(":visit_id", $visit_id);
    $statement3->execute();
    $statement3->closeCursor();
}
?>
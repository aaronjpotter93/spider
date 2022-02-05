<?php
##########################################################################################
# Creating an admin manager page.
#Name			Date			Description
#Aaron			2/4/2022		Admin Manager Page
#
#
##########################################################################################


try {
    $dsn = 'mysql:host=localhost;dbname=spiderBeGoneCo';
    $username = 'root';
    $password = 'hillo';
    $db = new PDO($dsn, $username, $password);
} catch (Exception $ex) {
    $error_message = $e->getMessage();
    echo 'DB Error: ' . $error_message;
}
//check action
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = 'list_visits';
    }
}

if ($action == 'list_visits') {
    $respondent_id = filter_input(INPUT_GET, 'respondent_id', FILTER_VALIDATE_INT);
    if ($respondent_id == NULL || $respondent_id == FALSE) {
        $respondent_id = filter_input(INPUT_POST, 'respondent_id',FILTER_VALIDATE_INT);
        if ($respondent_id == NULL || $respondent_id == FALSE) {
            $respondent_id = 1;
        }
        
    }
    try { //set query, prepare, bind if needed, execute
        $queryRespondent = 'SELECT * FROM respondent';
        $statement1 = $db->prepare($queryRespondent);
        $statement1->execute();
        $respondents = $statement1;

        $queryVisit = 'SELECT *
                        FROM visit
                        JOIN respondent
                        ON visit.respondent_id = respondent.respondent_id
                        WHERE respondent.respondent_id = :respondent_id
                        ORDER BY visit_date';
        $statement2 = $db->prepare($queryVisit);
        $statement2->bindValue(":respondent_id", $respondent_id);
        $statement2->execute();
        $visits = $statement2;
    } catch (PDOException $ex) {
        $error_message = $e->getMessage();
        echo 'DB Error: ' . $error_message;
    }
} else if ($action == 'delete_visit') {
    $visit_id = filter_input(INPUT_POST, 'visit_id', FILTER_VALIDATE_INT);
    $respondent_id = filter_input(INPUT_POST, 'respondent_id', FILTER_VALIDATE_INT);
    $queryDelete = 'DELETE FROM visit WHERE visit_id = :visit_id';
    $statement3 = $db->prepare($queryDelete);
    $statement3->bindValue(":visit_id", $visit_id);
    $statement3->execute();
    $statement3->closeCursor();
    header("Location: admin.php?respondent_id=$respondent_id");
}
?>


<html>
    <head>
        <title>Admin Page</title>
        <link href="../css/contact.css" rel="stylesheet">
    </head>
    <body>
        <div id="formContainer" style="color:White">
            <h1>Administrator Manager</h1>
            <h3>Select a respondent to view the assigned visit information.</h3>
            <aside>
                <ul style="list-style-type: none;">
                    <?php foreach ($respondents as $respondent) : ?>
                        <li>
                            <a href="?respondent_id=<?php echo $respondent['respondent_id']; ?>">
                                <?php echo $respondent['first_name'] . ' ' . $respondent['last_name']; ?>
                            </a>
                        </li>

                    <?php endforeach; ?>
                </ul>
            </aside>

            <table style="color:White">
                <tr>
                    <th>Email Address</th>
                    <th>Mobile Phone</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Contact By Mobile</th>
                    <th>Contact By Email</th>
                    <th></th>
                    
                </tr>
                <?php foreach($visits as $visit) : ?>
                <tr>
                    <td><?php echo $visit['email_address'] ?></td>
                    <td><?php echo $visit['mobile_phone'] ?></td>
                    <td><?php echo $visit['visit_msg'] ?></td>
                    <td><?php echo $visit['visit_date'] ?></td>
                    <td><?php echo $visit['contact_by_mobile'] ?></td>
                    <td><?php echo $visit['contact_by_email'] ?></td>
                    <td>
                        <form action="admin.php" method="post">
                            <input type="hidden" name="respondent_id"
                                   value="<?php echo $visit['respondent_id'] ?>">
                            <input type="hidden" name="action" value="delete_visit">
                            <input type="hidden" name="visit_id"
                                   value="<?php echo $visit['visit_id']; ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>




            <p>Plan for Project 3: 
                1. Read employee data. 
                2. Read visit data. 
                3. Add for loop in body to create employee anchor links. 
                4. Add for loop in body to display visit info by employee. 
            </p>
        </div>

    </body>
</html>



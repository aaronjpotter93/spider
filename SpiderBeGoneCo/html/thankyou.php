<?php 
    $email_address = filter_input(INPUT_POST, 'email_address');
    $phone = filter_input(INPUT_POST, 'phone');
    $contact = filter_input(INPUT_POST, 'contact');
    $comments = filter_input(INPUT_POST, 'comments');
    
    if ($contact == 'text') {
        $contact_by_mobile = 1;
    }
    else {
        $contact_by_mobile = 0;
    }
    if ($contact == 'email'){
        $contact_by_email = 1;
    }
    else {
        $contact_by_email = 0;
    }
    
    if ($email_address == null || $phone == null 
            || $comments == null) {
        $error = "Invalid input data. Check all fields and try again.";
        echo "From Data Error: " , $error;
        exit();
    } else {
        //data is valid. define pdo & insert data.
        try {
            $dsn = 'mysql:host=localhost;dbname=spiderBeGoneCo';
            $username = 'spuser';
            $password = 'hillo';
            $db = new PDO($dsn, $username, $password);
        } catch (PDOException $ex) {
            $error_message = $ex->getMessage();
            echo 'DB Error: ' . $error_message;
        }
        
        //add to database - query | prepare | bind | execute | close
        $query = 'INSERT INTO visit
	(email_address, mobile_phone, visit_msg, visit_date, 
        respondent_id, contact_by_mobile, contact_by_email)
        VALUES (:email_address, :phone, :comments, NOW(), 1, :contact_by_mobile, 
        :contact_by_email)';
        
        $statement = $db->prepare($query);
        $statement ->bindValue(':email_address', $email_address);
        $statement ->bindValue(':phone', $phone);
        $statement ->bindValue(':contact_by_mobile', $contact_by_mobile);
        $statement ->bindValue(':contact_by_email', $contact_by_email);
        $statement ->bindValue(':comments', $comments);
        $statement ->execute();
        $statement ->closeCursor();
    }

?>

<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/contact.css" rel="stylesheet" type="text/css"/>
</head>
    <body>
        <h1 id="thankYouScreen">Thank You!</h1>
    </body>
</html>


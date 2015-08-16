<?php
    $recipient = 'management@sierraplaceapartments.com';
    $type = stripslashes($_POST['type']);
    $name = stripslashes($_POST['firstName']." ".stripslashes($_POST['lastName']);
    $email = stripcslashes($_POST['email']);
    $phone = stripcslashes($_POST['phone']);
    $bedrooms = stripcslashes($_POST['bedrooms']);
    $pets = stripcslashes($_POST['pets']);
    $moveInDate = stripcslashes($_POST['moveInDate']);
    $tourDate = stripcslashes($_POST['tourDate']);
    $tourTime = stripcslashes($_POST['tourTime']);
    $source = stripcslashes($_POST['source']);
    $comments = stripcslashes($_POST['comments']);
    $subject = "Sierra Place Apartments: $type, $from";
    $msg = "Message from: $from\nEmail: $email\nPhone: $phone\nBedrooms: $bedrooms\nPets: $pets\nTour Date and time: $tourDate $tourTime\nMove-in Date: $moveInDate\nSource: $source\nComments:\n$comments";
   mail($recipient, $subject, $msg);
?>
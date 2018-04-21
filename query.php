<?php

function create_email_entry($username, $contact, $userquery) {
  $pdo = new PDO('mysql:dbname=club:host=localhost', $user, $password);
  if(!$pdo) {
    http_response_code(500);
    error_log('Cannot connect to db');
    exit();
  }
  $query = 'insert into query values(null, :username, :query, :contact, null)';
  $statement = $pdo->prepare($query);

  if(!$statement) {
    http_response_code(500);
    error_log('Cannot prepare statement');
    exit();
  }

  $result =  $query->execute(array(
    ':username' => $username,
    ':query' => $userquery,
    ':contact' => $contact,
  ));

  if(!$result) {
    http_response_code(500);
    error_log('Cannot insert record in database');
    exit();
  }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'] ?? null;
  $query = $_POST['query'] ?? null;
  $contact = $_POST['contact'] ?? null;
  if(!($username && $query && $contact)) {
    http_response_code(400);
    error_log('Malformed request');
    exit();
  }
  create_email_entry($username, $contact, $query);
}


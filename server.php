<?php

   require_once('dbconn.php');
   require_once('lib/nusoap.php'); 
   $server = new nusoap_server();


  function insertBook($title, $author_name, $price, $isbn, $category){
    global $dbconn;
    $sql_insert = "insert into books (title, author_name, price, isbn, category) values ( :title, :author_name, :price, :isbn, :category)";
    $stmt = $dbconn->prepare($sql_insert);
    $result = $stmt->execute(array(':title'=>$title, ':author_name'=>$author_name, ':price'=>$price, ':isbn'=>$isbn, ':category'=>$category));
    if($result) {
      return json_encode(array('status'=> 200, 'msg'=> 'success'));
    }
    else {
      return json_encode(array('status'=> 400, 'msg'=> 'fail'));
    }
    
    $dbconn = null;
    }

  function fetchBookData($isbn){
  	global $dbconn;
  	$sql = "SELECT id, title, author_name, price, isbn, category FROM books 
  	        where isbn = :isbn";
      $stmt = $dbconn->prepare($sql);
      $stmt->bindParam(':isbn', $isbn);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      return json_encode($data);
      $dbconn = null;
  }
  $server->configureWSDL('booksServer', 'urn:book');
  $server->register('fetchBookData',
  			array('isbn' => 'xsd:string'),  
  			array('data' => 'xsd:string'),  
  			'urn:book',   
  			'urn:book#fetchBookData' 
        );  
        $server->register('insertBook',
  			array('title' => 'xsd:string', 'author_name' => 'xsd:string', 'price' => 'xsd:string', 'isbn' => 'xsd:string', 'category' => 'xsd:string'),  
  			array('data' => 'xsd:string'),  
  			'urn:book',   
  			'urn:book#fetchBookData' 
  			);  
  $server->service(file_get_contents("php://input"));

?>

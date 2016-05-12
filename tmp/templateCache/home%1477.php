<!-- Example of a home view, you can use php in here-->
<html>
	<head>

		<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
		<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Kanit' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href=<?php Route::secure_assest("css/style.css");?> type="text/css">
	</head>
<body>
	<div class="framework-container">
		<h1 class="framework-title"> Wellcome to SmallFramework</h1>
		<!-- Example for use variables from the controller if not set the model
						<?php // print_r($all);?>
				If set the model are used in the controller, use the table name of the array
				for example
				<?php //print_r($table_name) ?>
	 -->
	 <form role="search" method="GET" >
	 <div class="form-group" >
		 <input type="text" placeholder="Search" name="search"/>
	 </div>
	 <input type="submit" velue="submit" name="submit">
 </form>
 <?php
 /*if(isset($_GET['search'])){
	 echo $_GET['search'];
 }*/
 //echo $users[7]['email'];
 debug($users);
 //debug($get);
 //debug($_SERVER);
 //debug($_SESSION);
 //debug($_ENV);
 //debug($_COOKIE);
 //debug(get_defined_vars());


 ?>
 <?php $a=10213;  ?>
 <?php $b= true; ?>
 <?= $a ?> <br />
 <?php for($i=0; $i<10; $i++) : ?>
 <?= $i ?>
 <?php endfor ?> <br />
 <?php if($b) : ?><br />
 succede qualcosa;<br />
 <?php endif ?>


	 <h1> CIAO!!!<h1>
	</div>
</body>
</html>
<?php
  function fetchTimes() {
    $url = 'http://api.timezonedb.com/v2.1/list-time-zone?key=H3S57JBR3HZ1&format=json';
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    $json = json_decode($response, true);

    return $json['zones'];
  }

  $zones = fetchTimes();
?>
<html>
<head>
  <title>TimezoneDB API Test</title>
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
      text-align: center;
    }

		.form {
		  padding: 50px;
		  text-align: center;
		}

		label {
		  display: block;
		  font-size: 18px;
		  margin-bottom: 10px;
		}

		input[type="text"] {
		  border: 3px solid #333;
		  font-size: 24px;
		  padding: 10px 15px;
		  text-align: center;
		}

		input[type="submit"] {
		  background: #06c;
		  border: 0;
		  border-radius: 30px;
		  color: #fff;
		  cursor: pointer;
		  font-size: 18px;
		  margin-top: 15px;
		  padding: 15px 50px;
		}

		.welcome, .align-center {
		  text-align: center;
		}
  </style>
</head>
<body>
  <h3>Hello. What is your name?</h3>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="name" /><br />
    <input type="submit" name="submit" value="Submit" />
  </form>
<?php
  if ($_POST && $_POST['name']) {
  	echo "<p>Welcome {$_POST['name']}</p>";

	  foreach ($zones as $k=>$v) {
	    if ($v['zoneName'] === 'Australia/Melbourne') {
	      $dt = new DateTime('@'.$v['timestamp']);
	      $dt->setTimeZone(new DateTimeZone('UTC'));

	      echo "<p>The time in Melbourne now is {$dt->format('h:i:s a')}</p>";
	    }
	    if ($v['zoneName'] === 'Asia/Manila') {
	      $dt = new DateTime('@'.$v['timestamp']);
	      $dt->setTimeZone(new DateTimeZone('UTC'));

	      echo "<p>The time in Manila now is {$dt->format('h:i:s a')}</p>";
	    }
	  }
  }
?>

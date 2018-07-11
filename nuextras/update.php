<?php include('head.php'); ?>
		<p><strong>Update nuBuilder</strong></p>

		<p>This script will download the latest build of nuBuilder4, then install these files without overwriting your configuration file and then run the database updater.</p>
		<p>It is recommended that you have a backup of your database before proceeding.</p>
		<p>Enter your globeadmin username and password, then click run to update your nuBuilder installation to the latest build.</p>

		<form action="run.php" method="post">
		<table>
			<tr>
                                <td>Globeadmin Username</td>
                                <td><input type="username" name="username"></td>
                        </tr>
                 	<tr>
                        	<td>Globeadmin Password</td>
                             	<td><input type="password" name="password"></td>
                        </tr>
			<tr>	<td></td>
                                <td>
					<input id="task" name="task" type="hidden" value="update">
                                        <input id="submit" type="submit" class="nuButton" value="Run">
				</td>
                        </tr>
		</table>
		</form>
	
		<br>
		<hr>
		<a href='index.php'>menu</a> | <a href='../'>login</a>	
<?php include('bottom.php'); ?>

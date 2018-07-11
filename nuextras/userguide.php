<?php include('head.php'); ?>
		<p><strong>Install User Guide Table</strong></p>

		<p>The nuBuilderForte user guide can be downloaded from this <a href='https://www.nubuilder.com/storage/pdf/nuBuilderForte_UserGuide.pdf'>link</a>.</p>

		<p>To follow the steps in the user guide you need to have the following three tables:</p>

<br>course_auto_number
<br>course_contact
<br>course_organization

		<p>Enter your globeadmin username and password, then click run to install these tables.</p>

		<p>Please note that if these tables already exist, then they will be removed and re-created.</p>

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
					<input id="task" name="task" type="hidden" value="userguide">
                                        <input id="submit" type="submit" class="nuButton" value="Run">
				</td>
                        </tr>
		</table>
		</form>
	
		<br>
		<hr>
		<a href='index.php'>menu</a> | <a href='../'>login</a>	
<?php include('bottom.php'); ?>

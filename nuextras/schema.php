<?php include('head.php'); ?>	
		<p><strong>Update Schema</strong></p>
	
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
                        <tr>
                        	<td>Engine</td>
                        	<td>MyISM</td>
			</tr>
                        <tr>
                        	<td>Character Set</td>
                               	<td>utf8</td>
                        </tr>
                        <tr>
                             	<td>Collation</td>
                                <td>utf8_general_ci</td>
                      	</tr>
			<tr>	<td></td>
                                <td>
					<input id="task" name="task" type="hidden" value="schema">
					<input id="submit" type="submit" class="nuButton" value="Run">
				</td>
                        </tr>
		</table>
		</form>
	
		<br>
		<hr>
		<a href='index.php'>menu</a> | <a href='../'>login</a>	
		</p>
<?php include('bottom.php'); ?>

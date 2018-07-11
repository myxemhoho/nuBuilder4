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
                        	<td>
					<select name="engine">
						<option value="s_innodb" selected>InnoDB</option>
                                      		<option value="s_myisam">MyISAM</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>If you are using InnoDB you can please select a ROW_FORMAT</td>
				<td>	
					<select name="row_format">
						<option value="s_blank"></option>
                                                <option value="s_dynamic">dynamic</option>
                                                <option value="s_compressed">compressed</option>
                                        </select>
				</td>	 
                        </tr>
                        <tr>
                        	<td>Character Set</td>
                               	<td>
					<select name="char_set">
						<option value="s_utf8mb4" selected>utf8mb4</option>
                                                <option value="s_utf8">utf8</option>
                                        </select>
				</td>
                        </tr>
                        <tr>
                             	<td>Collation</td>
                                <td>
					<select name="collation">
                                                <option value="s_utf8mb4_general_ci" selected>utf8mb4_general_ci</option>
                                                <option value="s_utf8_general_ci">utf8_general_ci</option>
                                        </select>
				</td>
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

<table>
	<tr><td style="font-family: 'hind-bold';font-size:11;" colspan="5">User BUMN pada aplikasi JDIH</td></tr>
	<tr>
		<td style="" >No</td>
		<td style="" >BUMN</td>
		<td style="" >Username</td>
		<td style="" >Email</td>
	</tr>
	<?php
		$i=1;
	?>
	<?php foreach($users['data'] as $data) {?>
		<tr>
			<td style="">{{ $i }}</td>
			<td style="">{{ $data['name'] }}</td>
			<td style="">{{ $data['username'] }}</td>
			<td style="">{{ $data['email'] }}</td>
			<td style="">{{ $data['asal_instansi'] }}</td>
			<td style="">{{ $data['activated'] < 1 ? 'No' : 'Yes' }}</td>
		</tr>
		<?php 
			$i++; 
		} ?>
</table>
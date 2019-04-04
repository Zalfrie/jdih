<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
            @page { margin: 25px 25px; }
			header { position: fixed; top: 0px; left: 0px; right: 0px; height: 50px; }
			footer { position: fixed; bottom: -40px; left: 0px; right: 0px; height: 100px; }
        </style>
    </head>
	<?php
		$i=1;
	?>
    <body style="font-family: 'hind';line-height:12px;">
        <div class='container' style="width: 100%; height: auto; display: block;">
            <header>
            </header>
            <div class='list_user_jdih' style="margin-top: 40px;">
				<table>
					<tr><td style="padding-top:15px;font-family: 'hind-bold';font-size:16;" colspan="8">User pada aplikasi JDIH Kementrian BUMN</td></tr>
					<tr>
						<td style="padding-top:15px;padding-right:5px;" >No</td>
						<td style="padding-top:15px;padding-right:5px;" >Nama</td>
						<td style="padding-top:15px;padding-right:5px;" >Username</td>
						<td style="padding-top:15px;padding-right:5px;" >Email</td>
						<td style="padding-top:15px;padding-right:5px;" >Instansi</td>
						<td style="padding-top:15px;padding-right:5px;" >Activated</td>
					</tr>
					<?php foreach($users['data'] as $data){?>
						<tr>
							<td style="padding-top:15px;padding-right:5px;">{{ $i }}</td>
							<td style="padding-top:15px;padding-right:5px;">{{ $data['name'] }}</td>
							<td style="padding-top:15px;padding-right:5px;">{{ $data['username'] }}</td>
							<td style="padding-top:15px;padding-right:5px;">{{ $data['email'] }}</td>
							<td style="padding-top:15px;padding-right:5px;">{{ $data['asal_instansi'] }}</td>
							<td style="padding-top:15px;padding-right:5px;">{{ $data['activated'] < 1 ? 'No' : 'Yes' }}</td>
						</tr>
						<?php 
							$i++; 
						} ?>
				</table>
			</div>
			<footer>
				
			</footer>
        </div>
    </body>
</html>

<!doctype html>
<html>
	<head>
			<meta charset="utf-8">
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			<title><?= $subject; ?></title>
			<style type="text/css">
				body{border:5px solid #1b6633; text-align: center; font-size: 18px; line-height:1.5em; }
				h3{ font-size:24px;}
			</style>
	</head>
	<body>
		<table cellpadding="5px" style="background-color:#FFFFFF;width:60%;margin:0 auto;">
			<tr>
				<td align="center"><h3><?= $subject; ?></h3></td>
			</tr>
			<tr><td align="left">&nbsp;</td></tr>
			<tr>
				<td align="left">
					User: <strong><?= strtoupper($user->username); ?></strong> has opened the Payroll portion of the 20<?= $this->globals_m->current_year(); ?> Budget for <strong><?= $budget[0]['name']; ?></strong> on <?= date('l, F d, Y'); ?>.
				</td>
			</tr>
			<tr>
				<td align="left">
					All existing employees and their existing benefits have been loaded into P.A.M. IV. <strong>NOTE:</strong> Hourly and monthly employees do not have work hours attributed to them by default.<br><br>Employees may be modified/deleted or new employees can be added to fit the budgetary plan.
				</td>
			</tr>
		</table>
	</body>
</html>
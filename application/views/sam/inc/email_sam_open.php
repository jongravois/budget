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
					User: <strong><?= strtoupper($user->username); ?></strong> has opened the Fixed Assets Management portion of the 20<?= $this->globals_m->current_year(); ?> Budget for <strong><?= $budget[0]['name']; ?></strong> on <?= date('l, F d, Y'); ?>.
				</td>
			</tr>
			<tr>
				<td align="left">
					All available prior year fixed assets projections have been loaded into S.A.M. IV. Existing projects may be modified/deleted or new projects can be added to fit the budgetary or projection plan.<br><br>
					<strong>NOTE:</strong> The Assets Timeline must be submitted and approved before the Fixed Assets Budget can be submitted for approval.
				</td>
			</tr>
		</table>
	</body>
</html>
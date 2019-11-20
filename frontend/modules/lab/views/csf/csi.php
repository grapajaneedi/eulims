<!DOCTYPE html>
<html>



<h3 style="color:#1a4c8f;font-family:verdana;font-size:150%, 
      7px 7px 0px rgba(0, 0, 0, 0.2);text-align:center";><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Department of Science and Technology</b></h3>
<h3 style="color:#142142;font-family:verdana;font-size:150%;, 
      7px 7px 0px rgba(0, 0, 0, 0.2);text-align:center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REGIONAL STANDARDS AND TESTING LABORATORY</b></h3>

<h1 style="color:#1a4c8f;font-family:Century Gothic;font-size:250%;, 
      7px 7px 0px rgba(0, 0, 0, 0.2);text-align:center;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Customer Satisfaction Index</b></h1><br>



<head>
	<title>Parcel Sandbox</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- COPY STYLES FROM HERE -->
	<style>
		.top.table td:nth-child(1) {
			width: 1%;
			white-space: nowrap;
		}

		.score-card-container {
			background-color: #f8f8f8;
			border: 1px solid #eee;
			padding: 8px;
			border-radius: 4px;
		}
		.score-card, .score-card > div > div, .score-card-label {
			display: flex;
		}
		.score-card  h5 {
			text-align: center;
			font-weight: bold;
		}
		.score-card > .detractors {
			flex: 7;
			color: #f85e5e;
		}
		.score-card > .passives {
			flex: 2;
			color: #716f6f;
		}
		.score-card > .promoters {
			flex: 2;
			color: #22bf22;
		}
		.score-card > div > div > div {
			flex: 1;
			border: 1px solid #eee;
			text-align: center;
		}
		.score-card-label > div {
			flex: 1;
			text-align: center;
			margin-top: 9px;
			font-size: 8px;
		}
		.score-card-label > div:first-child { text-align: left; }
		.score-card-label > div:last-child { text-align: right; }
	</style>
	<!-- TO HERE -->
</head>

<body>
	<!-- COPY CONTENTS FROM HERE -->
	<div class="container">	
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						Technical Services: Regional Standards and Testing Laboratories
					</div>
					<div class="panel-body">
						<table class="table top">
							<tbody>
								<tr>
									<td>For the period of</td>
									<td>: <strong>Jan 2019</strong></td>
								</tr>
								<tr>
									<td>Total no. of Respondents</td>
									<td>: <strong id="respondents">32</strong></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading">Part I: Customer Rating of Service Quality</div>
					<div class="panel-body">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Service Quality Items</th>
									<th>Very Satisfied</th>
									<th class="active">5</th>
									<th>Quite Satisfied</th>
									<th class="active">4</th>
									<th>N Sat nor D Sat</th>
									<th class="active">3</th>
									<th>Quite Dissatisfied</th>
									<th class="active">2</th>
									<th>Very Dissatisfied</th>
									<th class="active">1</th>
									<th>Total Score</th>
									<th>SS</th>
									<th>GAP</th>
								</tr>
							</thead>
							<tbody id="part-1"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading">Part II: Importance of these attributes to the customers</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Importance of Service Quality Attributes to Customers</th>
									<th>Very Important</th>
									<th class="active">5</th>
									<th>Quite Important</th>
									<th class="active">4</th>
									<th>Neither Imp nor Unimp</th>
									<th class="active">3</th>
									<th>Quite Unimportant</th>
									<th class="active">2</th>
									<th>Not important at all</th>
									<th class="active">1</th>
									<th>Total Score</th>
									<th>IS</th>
									<th>WF</th>
									<th>SS</th>
									<th>WS</th>
								</tr>
							</thead>
							<tbody id="part-2"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-info">
					<div class="panel-heading">Customer Satisfaction Measurement</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Detractors (0-6)</th>
									<th>Passives (7-8)</th>
									<th>Promoters (9-10)</th>
									<th>Net Promoter Score</th>
								</tr>
							</thead>
							<tbody id="satisfaction-measurement"></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-info">
					<div class="panel-heading">Legend</div>
					<div class="panel-body">
						<div class="score-card-container">
							<div class="score-card">
								<div class="detractors">
									<h5>Detractors</h5>
									<div>
										<div>0</div>
										<div>1</div>
										<div>2</div>
										<div>3</div>
										<div>4</div>
										<div>5</div>
										<div>6</div>
									</div>
								</div>
								<div class="passives">
									<h5>Passives</h5>
									<div>
										<div>7</div>
										<div>8</div>
									</div>
								</div>
								<div class="promoters">
									<h5>Promoters</h5>
									<div>
										<div>9</div>
										<div>10</div>
									</div>
								</div>
							</div>
							<div class="score-card-label text-muted">
								<div>Not at all likely</div>
								<div>Neutral</div>
								<div>Extremely likely</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- TO HERE -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<!-- COPY SCRIPT FROM HERE -->
	<script>
		$(document).ready(function () {
			// ECHO DATA AS respondents VALUE
			let respondents = [
				{
					"id": 1,
					"name": "Coca-Cola Beverages Philippines, Inc.",
					"ref_num": "R9-102019-MIC-0821",
					"nob": "Beverage and Juices",
					"tom": 1,
					"service": 2,
					"d_deliverytime": 5,
					"d_accuracy": 5,
					"d_speed": 5,
					"d_cost": 5,
					"d_attitude": 5,
					"d_overall": 5,
					"i_deliverytime": 5,
					"i_accuracy": 5,
					"i_speed": 5,
					"i_cost": 5,
					"i_attitude": 5,
					"i_overall": 5,
					"recommend": 10,
					"essay": "",
					"r_date": "10/22/2019 14:29"
				},
				{
					"id": 2,
					"name": "Suzette daniel",
					"ref_num": "R9-102019-MET-0342",
					"nob": "Petroleum Products / Haulers",
					"tom": 1,
					"service": 3,
					"d_deliverytime": 3,
					"d_accuracy": 4,
					"d_speed": 3,
					"d_cost": 5,
					"d_attitude": 5,
					"d_overall": 5,
					"i_deliverytime": 3,
					"i_accuracy": 4,
					"i_speed": 5,
					"i_cost": 5,
					"i_attitude": 5,
					"i_overall": 5,
					"recommend": 10,
					"essay": "",
					"r_date": "10/23/2019 13:47"
				},
				{
					"id": 3,
					"name": "Noel",
					"ref_num": "",
					"nob": "",
					"tom": "",
					"service": "",
					"d_deliverytime": 5,
					"d_accuracy": 5,
					"d_speed": 5,
					"d_cost": 5,
					"d_attitude": 5,
					"d_overall": 5,
					"i_deliverytime": 5,
					"i_accuracy": 5,
					"i_speed": 5,
					"i_cost": 5,
					"i_attitude": 5,
					"i_overall": 5,
					"recommend": 10,
					"essay": "",
					"r_date": "11/11/2019 12:42"
				},
				{
					"id": 4,
					"name": "Green Grass Food Service",
					"ref_num": "R9-112019-MIC-0878",
					"nob": "Others",
					"tom": 1,
					"service": 2,
					"d_deliverytime": 4,
					"d_accuracy": 4,
					"d_speed": 2,
					"d_cost": 3,
					"d_attitude": 5,
					"d_overall": 4,
					"i_deliverytime": 5,
					"i_accuracy": 5,
					"i_speed": 4,
					"i_cost": 4,
					"i_attitude": 5,
					"i_overall": 4,
					"recommend": 8,
					"essay": "",
					"r_date": "11/12/2019 14:58"
				},
				{
					"id": 5,
					"name": "Permex Producer and exporter Corporations",
					"ref_num": "",
					"nob": "",
					"tom": 1,
					"service": 1,
					"d_deliverytime": 4,
					"d_accuracy": 5,
					"d_speed": 4,
					"d_cost": 4,
					"d_attitude": 5,
					"d_overall": 5,
					"i_deliverytime": 5,
					"i_accuracy": 5,
					"i_speed": 4,
					"i_cost": 4,
					"i_attitude": 5,
					"i_overall": 5,
					"recommend": 10,
					"essay": "",
					"r_date": "11/13/2019 10:31"
				},
				{
					"id": 6,
					"name": "Bueno Pizza House Corporation",
					"ref_num": "R9-112019-CHE-0815",
					"nob": "Raw and Processed Food",
					"tom": 1,
					"service": 1,
					"d_deliverytime": 5,
					"d_accuracy": 5,
					"d_speed": 5,
					"d_cost": 5,
					"d_attitude": 5,
					"d_overall": 5,
					"i_deliverytime": 5,
					"i_accuracy": 5,
					"i_speed": 5,
					"i_cost": 5,
					"i_attitude": 5,
					"i_overall": 5,
					"recommend": 10,
					"essay": "",
					"r_date": "11/14/2019 15:44"
				},
				{
					"id": 7,
					"name": "PHILGEN CITY MALL",
					"ref_num": "R9-102019-CHE-0806",
					"nob": "Others",
					"tom": "",
					"service": "",
					"d_deliverytime": 5,
					"d_accuracy": 5,
					"d_speed": 5,
					"d_cost": 5,
					"d_attitude": 5,
					"d_overall": 5,
					"i_deliverytime": 5,
					"i_accuracy": 5,
					"i_speed": 5,
					"i_cost": 5,
					"i_attitude": 5,
					"i_overall": 5,
					"recommend": 10,
					"essay": "",
					"r_date": "11/14/2019 15:46"
				},
				{
					"id": 11,
					"name": "Tandem cedar cypress Corp.",
					"ref_num": "R9-112019-0769",
					"nob": "Others",
					"tom": 1,
					"service": 1,
					"d_deliverytime": 5,
					"d_accuracy": 5,
					"d_speed": 5,
					"d_cost": 5,
					"d_attitude": 5,
					"d_overall": 5,
					"i_deliverytime": 5,
					"i_accuracy": 5,
					"i_speed": 5,
					"i_cost": 5,
					"i_attitude": 5,
					"i_overall": 5,
					"recommend": 10,
					"essay": "",
					"r_date": "11/15/2019 14:32"
				}
			]

			let part1 = {}
			let part2 = {}
			let items = {
				"deliverytime": 'Delivery Time',
				"accuracy": 'Correctness and Accuracy of Results',
				"speed": 'Speed of Service',
				"cost": 'Cost',
				"attitude": 'Attitude of Staff',
				"overall": 'Over-all Customer Experience',
			}
			let satMeasurement = {
				detractors: 0,
				passives: 0,
				promoters: 0
			}

			respondents.forEach(respondent => {
				Object.keys(respondent).forEach(key => {
					if (key.startsWith('d_')) {
						if (!part1[key]) part1[key] = { 5: 0, 4: 0, 3: 0, 2: 0, 1: 0 }
						part1[key][respondent[key]] += 1
					}

					if (key.startsWith('i_')) {
						if (!part2[key]) part2[key] = { 5: 0, 4: 0, 3: 0, 2: 0, 1: 0 }
						part2[key][respondent[key]] += 1
					}

					if (key === 'recommend') {
						if (respondent[key] <= 6) satMeasurement.detractors += 1
						if (respondent[key] >= 7 && respondent[key] <= 8) satMeasurement.passives += 1
						if (respondent[key] >= 9) satMeasurement.promoters += 1
					}
				})
			})

			Object.keys(items).forEach(key => {
				let part1_totalScore = (part1['d_' + key][5] * 5) +
					(part1['d_' + key][4] * 4) +
					(part1['d_' + key][3] * 3) +
					(part1['d_' + key][2] * 2) +
					(part1['d_' + key][1] * 1)
				let part1_ss = parseFloat(Math.round((part1_totalScore / respondents.length) * 100) / 100).toFixed(2)

				let part2_totalScore = (part2['i_' + key][5] * 5) +
					(part2['i_' + key][4] * 4) +
					(part2['i_' + key][3] * 3) +
					(part2['i_' + key][2] * 2) +
					(part2['i_' + key][1] * 1)
				let part2_is = parseFloat(Math.round((part2_totalScore / respondents.length) * 100) / 100).toFixed(2)
				let part2_wf = parseFloat(Math.round(((part2_is / part2_totalScore) * 100) * 100) / 100).toFixed(2)
				let part2_ws = parseFloat(Math.round(((part1_ss * part2_wf) / 100) * 100) / 100).toFixed(2)

				let part1_gap = parseFloat(Math.round((part2_is - part1_ss) * 100) / 100).toFixed(2)

				$(`
					<tr>
						<td>${items[key]}</td>
						<td>${part1['d_' + key][5]}</td>
						<td class="active">${part1['d_' + key][5] * 5}</td>
						<td>${part1['d_' + key][4]}</td>
						<td class="active">${part1['d_' + key][4] * 4}</td>
						<td>${part1['d_' + key][3]}</td>
						<td class="active">${part1['d_' + key][3] * 3}</td>
						<td>${part1['d_' + key][2]}</td>
						<td class="active">${part1['d_' + key][2] * 2}</td>
						<td>${part1['d_' + key][1]}</td>
						<td class="active">${part1['d_' + key][1] * 1}</td>
						<td>${part1_totalScore}</td>
						<td>${part1_ss}</td>
						<td>${part1_gap}</td>
					</tr>
				`).appendTo('#part-1')

				if (key !== 'overall') {
					$(`
						<tr>
							<td>${items[key]}</td>
							<td>${part2['i_' + key][5]}</td>
							<td class="active">${part2['i_' + key][5] * 5}</td>
							<td>${part2['i_' + key][4]}</td>
							<td class="active">${part2['i_' + key][4] * 4}</td>
							<td>${part2['i_' + key][3]}</td>
							<td class="active">${part2['i_' + key][3] * 3}</td>
							<td>${part2['i_' + key][2]}</td>
							<td class="active">${part2['i_' + key][2] * 2}</td>
							<td>${part2['i_' + key][1]}</td>
							<td class="active">${part2['i_' + key][1] * 1}</td>
							<td>${part2_totalScore}</td>
							<td>${part2_is}</td>
							<td>${part2_wf}</td>
							<td>${part1_ss}</td>
							<td>${part2_ws}</td>
						</tr>
					`).appendTo('#part-2')
				}
			})

			$(`
				<tr>
					<td>${satMeasurement.detractors}</td>
					<td>${satMeasurement.passives}</td>
					<td>${satMeasurement.promoters}</td>
					<td>${(satMeasurement.promoters * 100 / respondents.length) - (satMeasurement.detractors * 100 / respondents.length)}</td>
				</tr>
			`).appendTo('#satisfaction-measurement')
		})
	</script>
	<!-- TO HERE -->
</body>

</html>
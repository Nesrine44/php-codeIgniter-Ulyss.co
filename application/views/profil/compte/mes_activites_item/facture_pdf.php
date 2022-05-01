<html>
<head>
	<title>Facture</title>
</head>

<body>
<?php if (!empty($facture)) { ?>
	<!-- facture -->
	<!-- header facture -->

	<!-- end header facture -->


	<table style="border:1px solid #ddd;width:100%;">
		<tr style="border:1px solid #ddd;height:40px;    background: #f2f2f2;">
			<th style="padding-left:20px"><b>Designation</b></th>
			<th style=""></th>
			<th style=""><b>Prix</b></th>
		</tr>
		<tr style="border:1px solid #ddd">
			<td colspan="2" style="padding:10px 20px">
                <?php echo $facture->titre; ?>
			</td>
			<td style="">
                <?php echo $facture->montant - ($facture->montant * ($facture->montant / 100)); ?>€
			</td>
		</tr>

		<tr style="border:1px solid #ddd;height:40px">
			<td></td>
			<td style="background: #f2f2f2;padding-left: 20px;">
				<b>TVA</b>
			</td>
			<td style="background: #f2f2f2">
				<b><?php echo $facture->montant * ($facture->montant / 100); ?>€ </b>
			</td>
		</tr>

		<tr style="border:1px solid #ddd;height:40px">
			<td></td>
			<td style="background: #f2f2f2;padding-left: 20px;">
				<b>Total TTC</b>
			</td>
			<td style="background: #f2f2f2">
				<b><?php echo $facture->montant; ?>€ </b>
			</td>
		</tr>
	</table>


<?php } ?>


</body>

</html>


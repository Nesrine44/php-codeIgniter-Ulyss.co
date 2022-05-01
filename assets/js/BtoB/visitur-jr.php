<?php
/* Open connection to "ulyss" MySQL database. */
$mysqli = new mysqli("localhost", "root", "", "ulyss");

/* Check the connection. */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$ent = $BusinessEntreprise->getId();
/* Fetch result set from t_test table */
$nbrRequete = mysqli_query($mysqli,
    "SELECT COUNT(*)as nbrReq, cast(date_creation as date) as date FROM `entreprise_vues` WHERE entreprise_id='$ent' GROUP BY DAY(date_creation)");
$dmyRequete = mysqli_query($mysqli,
    "SELECT COUNT(*)as nbrReq, cast(date_creation as date) as date FROM `entreprise_vues` WHERE entreprise_id='$ent' GROUP BY DAY(date_creation)");
?>
var nbrReqVisit = [ <?php
while ($info = mysqli_fetch_array($nbrRequete)) {
    echo
        $info['nbrReq'] . ',';
    /* We use the concatenation operator '.' to add comma delimiters after each data value. */
}
?>];
var dmyReqVisit = [ <?php
while ($info = mysqli_fetch_array($dmyRequete)) {
    ;
    echo
        '"' . $info['date'] .
        '",';
    /* We use the concatenation operator '.' to add comma delimiters after each data value. */
}
?>]
;
var VisiConf = {
"globals": {
"font-family": "Lato"
},

"graphset": [
{
"type": "area",
"background-color": "#fff",
"utc": true,
"plotarea": {
"margin-top": "10%",
"margin-right": "dynamic",
"margin-bottom": "dynamic",
"margin-left": "dynamic",
"adjust-layout": true
},
"title": {
"text": 'NOMBRE DE VISITEURS PAR JOUR',
"fontSize": 15,
"align": "center",
},
"labels": [
{
"text": "Visiteurs: %plot-0-value",
"default-value": "",
"color": "#000000",
"x": "20%",
"y": 50,
"width": 120,
"text-align": "left",
"bold": 0,
"font-size": "14px",
"font-weight": "bold"
},
],
"scale-x": {
"label": {
"text": "",
"font-size": "14px",
"font-weight": "normal",
"offset-x": "10%",
},
"item": {
"text-align": "center",
"font-color": "#9a9b9c"
},
"zooming": 1,
"max-labels": 12,
"labels": dmyReqVisit,
"max-items": 12,
"items-overlap": true,
"guide": {
"line-width": "0px"
},
"tick": {
"line-width": "2px"
},
},
"crosshair-x": {
"line-color": "#898989",
"line-style": "dashed",
"line-width": 1,
"plot-label": {
"visible": false
},
"marker": {
visible: true,
size: 4
}
},
"scale-y": {
"values": "0:50:1",
"item": {
"font-color": "#05636c",
"font-weight": "normal"
},
"label": {
"text": "Nombre de visiteurs",
"font-size": "14px"
},
"guide": {
"line-width": "0px",
"alpha": 0.2,
"line-style": "dashed"
}
},
"plot": {
"line-width": 2,
"marker": {
"size": 1,
"visible": false
},
"tooltip": {
"font-family": "Lato",
"font-size": "15px",
"text": "Il y a eu %v visiteurs le %data-days",
"text-align": "left",
"border-radius": 5,
"padding": 10
},
"animation": {
"delay": 500,
"speed": "9000",
"effect": "ANIMATION_EXPAND_LEFT"
},
},
"series": [

{
"values": nbrReqVisit,
"data-days": dmyReqVisit,
"line-color": "#3cd572",
"background-color": "#6de06e",
"aspect": "spline",
"alpha-area": "0.2",
"text": "visitors",
"font-family": "Roboto",
"font-size": "14px"
}
]
}
]
};


$('.usersMol').click(function () {
zingchart.render({
id: 'visiUniq',
data: VisiConf,
height: 430,
width: 500
});
});
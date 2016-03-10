<?php
include("config/config.php");
include("function.criatagclouds.php");

include('lib/dwoo/dwooAutoload.php'); 
$dwoo = new Dwoo(); 
$tpl  = new Dwoo_Template_File('templates/patent.tpl'); 
$data = new Dwoo_Data();

function limpaVariavel($variavel)
{
    return (htmlspecialchars(strip_tags($variavel)));
}
$id = limpaVariavel(@$_GET["id"]);
$patent = new Patents();

$patent->retrieve($id);

$link_patente = "http://patft.uspto.gov/netacgi/nph-Parser?Sect1=PTO2&Sect2=HITOFF&p=1&u=%2Fnetahtml%2FPTO%2Fsearch-adv.htm&r=1&f=G&l=50&d=PALL&S1=" . $patent->id . "&OS=" . $patent->id . "&RS=" . $patent->id;


$data->assign('link', $link_patente);

$date = $patent->date;
$date = substr($date,4,2)."/".substr($date,6,2)."/".substr($date,0,4);

$appl_date = $patent->appl_date;
$appl_date = substr($appl_date,4,2)."/".substr($appl_date,6,2)."/".substr($appl_date,0,4);

$data->assign('id',$patent->id);
$data->assign('title',$patent->title);
$data->assign('date',$date);
$data->assign('appl_type',$patent->appl_type);
$data->assign('appl_number',$patent->appl_number);
$data->assign('appl_date',$appl_date);
$data->assign('abstract', nl2br($patent->abstract));
$data->assign('description', nl2br($patent->description));
$data->assign('claims', nl2br($patent->claims));



$dwoo->output($tpl, $data);

?>
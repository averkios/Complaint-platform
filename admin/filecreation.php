<?php

	if (basename($_SERVER['PHP_SELF']) == 'filecreation.php') {
		die('You cannot load this page directly.');
	};
  
//txt               
$file = fopen($_SERVER['DOCUMENT_ROOT']."/output/statistics.txt", "w") or die("can't open file");
$txt = "\xEF\xBB\xBF===============================================\r\nΣυνολικά στοιχεία\r\n===============================================\r\nΠαράπονα ανα Κατηγορία\r\n-----------------------------------------------\r\nΚατηγορία\t\tΠλήθος\r\n";
fwrite($file, $txt);

foreach ($pososta as $p) 
{
	if(isset($p["Kat"]))
	{
		$txt = $p['Kat'] . "\t" .  $p['Plithos'] . "\r\n";
		fwrite($file, $txt);
	}
}
$txt = "-----------------------------------------------\r\nΠαράπονα ανα Έτος\r\n-----------------------------------------------\r\nΈτος\tΠλήθος\r\n";
fwrite($file, $txt);

foreach ($xronosPososta as $y) 
	{
	if(isset($y["xronia"]))
		{
			$txt = $y['xronia'] . "\t" . $y['Plithos'] . "\r\n";
			fwrite($file, $txt);
		}
	}

$txt = "===============================================\r\nΣτατιστικά στοιχεία\r\n===============================================\r\nΚατανομή χρηστών\r\n-----------------------------------------------\r\nΧρήστες\t\tΠοσοστό\r\nΧρήστες\t\t" . $users . "%\r\nΦιλοξενούμενοι\t" . $guests . "%\r\nΔιαχειριστές\t" . $admins . "%\r\n-----------------------------------------------\r\nΚατανομή παραπόνων ανα κατηγορία\r\n-----------------------------------------------\r\nΚατηγορία\t\tΠοσοστό\r\n";
fwrite($file, $txt);

foreach ($pososta as $p) 
{
	if(isset($p["Kat"]))
	{
		$txt = $p['Kat'] . "\t" . $p['Percent'] . "%\r\n";
		fwrite($file, $txt);
	}
}

$txt = "-----------------------------------------------\r\nΚατανομή παραπόνων ανα έτος\r\n-----------------------------------------------\r\nΈτος\tΠοσοστό\r\n";
fwrite($file, $txt);

foreach ($xronosPososta as $y) 
{
	if(isset($y["xronia"]))
	{
	$txt = $y['xronia'] . "\t" . $y['Percent'] . "%\r\n";
	fwrite($file, $txt);
	}
}

$txt = "===============================================";
fwrite($file, $txt);

//xml
$file = fopen($_SERVER['DOCUMENT_ROOT']."/output/statistics.xml", "w") or die("can't open file");
$txt = "<?xml version='1.0' encoding='UTF-8'?>\r\n<statistics>\r\n\t<Συνολικά-στοιχεία>\r\n\t\t<Παράπονα-ανα-Κατηγορία>\r\n";
fwrite($file, $txt);
foreach ($pososta as $p) 
{
	if(isset($p["Kat"]))
	{
		$txt = "\t\t\t<Κατηγορία>" . $p['Kat'] . "</Κατηγορία>\r\n" . "\t\t\t<Πλήθος>" . $p['Plithos'] . "</Πλήθος>\r\n";
		fwrite($file, $txt);
	}
}

$txt = "\t\t</Παράπονα-ανα-Κατηγορία>\r\n\t\t<Παράπονα-ανα-Έτος>\r\n";
fwrite($file, $txt);

foreach ($xronosPososta as $y) 
	{
	if(isset($y["xronia"]))
		{
		$txt = "\t\t\t<Έτος>" . $y['xronia'] . "</Έτος>\r\n" . "\t\t\t<Πλήθος>" . $y['Plithos'] . "</Πλήθος>\r\n";
		fwrite($file, $txt);
		}
	}

$txt = "\t\t</Παράπονα-ανα-Έτος>\r\n\t</Συνολικά-στοιχεία>\r\n\t<Στατιστικά-στοιχεία>\r\n\t\t<Κατανομή-χρηστών>\r\n\t\t\t<Χρήστες>" . $users . "%</Χρήστες>\r\n\t\t\t<Φιλοξενούμενοι>" . $guests . "%</Φιλοξενούμενοι>\r\n\t\t\t<Διαχειριστές>" . $admins ."%</Διαχειριστές>\r\n\t\t</Κατανομή-χρηστών>\r\n\t\t<Κατανομή-παραπόνων-ανα-κατηγορία>\r\n";
fwrite($file, $txt);
											
foreach ($pososta as $p) 
{
	if(isset($p["Kat"]))
	{
		$txt = "\t\t\t<Κατηγορία>" . $p['Kat'] . "</Κατηγορία>\r\n" . "\t\t\t<Ποσοστό>" . $p['Percent'] . "%</Ποσοστό>\r\n";
		fwrite($file, $txt);
	}
}
$txt = "\t\t</Κατανομή-παραπόνων-ανα-κατηγορία>\r\n\t\t<Κατανομή-παραπόνων-ανα-έτος>\r\n";
fwrite($file, $txt);

foreach ($xronosPososta as $y) 
	{
	if(isset($y["xronia"]))
		{
		$txt = "\t\t\t<Έτος>" . $y['xronia'] . "</Έτος>\r\n" . "\t\t\t<Ποσοστό>" . $y['Percent'] . "%</Ποσοστό>\r\n";
		fwrite($file, $txt);
		}
	}
$txt = "\t\t</Κατανομή-παραπόνων-ανα-έτος>\r\n\t</Στατιστικά-στοιχεία>\r\n</statistics>";
fwrite($file, $txt);

fclose($file);
 
?>
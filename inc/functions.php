<?php

function getData()
{
	global $tsAdminSocket;
	$data = fgets($tsAdminSocket, 4096);
	if (!empty($data)) {
		$datasets = explode(' ', $data);
		$output = array();
		foreach($datasets as $dataset) {
			$dataset = explode('=', $dataset);
			if (count($dataset) > 2) {
				for ($i = 2; $i < count($dataset); $i++) {
					$dataset[1].= '=' . $dataset[$i];
				}

				$output[unEscapeText($dataset[0]) ] = unEscapeText($dataset[1]);
			}
			else {
				if (count($dataset) == 1) {
					$output[unEscapeText($dataset[0]) ] = '';
				}
				else {
					$output[unEscapeText($dataset[0]) ] = unEscapeText($dataset[1]);
				}
			}
		}

		return $output;
	}
}

function unEscapeText($text)
{
	$escapedChars = array(
		"\t",
		"\v",
		"\r",
		"\n",
		"\f",
		"\s",
		"\p",
		"\/"
	);
	$unEscapedChars = array(
		'',
		'',
		'',
		'',
		'',
		' ',
		'|',
		'/'
	);
	$text = str_replace($escapedChars, $unEscapedChars, $text);
	return $text;
}

function isInGroup($usergroups, $group)
{
	$diff = count(array_diff($usergroups, $group));
	if ($diff < count($usergroups)) {
		return true;
	}
	else {
		return false;
	}
}

?>
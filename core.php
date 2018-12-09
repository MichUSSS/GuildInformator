<?php

require 'config/config.php';
require 'inc/ts3admin.class.php';
require 'inc/functions.php';

system('clear');

$query = new ts3admin($config['connection']['host'], $config['connection']['queryPort']);

echo ':: Startowanie aplikacji @GuildInformator ...' . PHP_EOL;

if($query->connect()['success'])
{
	echo ':: Pomyslnie polaczono z serwerem' . PHP_EOL;
	if($query->login($config['connection']['queryLogin'], $config['connection']['queryPassword'])['success'])
	{
		echo ':: Pomyslnie zalogowano do serwera' . PHP_EOL;
		$query->selectServer($config['connection']['serverPort']);
		$query->setName($config['general']['name']);
		
		$tsAdminSocket = $query->runtime['socket'];
		
		while(1)
		{
			$core = $query->getElement('data',$query->whoAmI());
			$query->clientMove($core['client_id'], $config['general']['defaultChannel']);
			
			$query->execOwnCommand(0, 'servernotifyregister event=server');
			$query->execOwnCommand(0, 'servernotifyregister event=textprivate');
			$socketData = getData();
			
			if(array_key_exists('notifycliententerview', $socketData))
			{
				$query->sendMessage(1, $socketData['clid'], '● Witaj [b][URL=client://'.$socketData['cldbid'].'/'.$socketData['client_unique_identifier'].']'.$socketData['client_nickname'].'[/url][/b]\n ');
				$query->sendMessage(1, $socketData['clid'], ' Chciałbyś się wybrać do swojej gildii w której jesteś?');
				$query->sendMessage(1, $socketData['clid'], ' ');				
				$query->sendMessage(1, $socketData['clid'], ' Aby przejść na kanał klanowy, wystarczy ze wpiszesz [b]!tp <TAG Klanu>[/b]');
				$query->sendMessage(1, $socketData['clid'], ' [b]Lista klanów:[/b]');
				$query->sendMessage(1, $socketData['clid'], '' .$config ['tags']['list'].'');
				$query->sendMessage(1, $socketData['clid'], ' Posiadasz u nas kanał, a nie ma Cię na liście? Za [b]24h[/b] lista się zauktalizuje!');
				$query->sendMessage(1, $socketData['clid'], ' [color=red]Pamiętaj, wielkość liter ma znaczenie![/color]');				
			}
			
			if(array_key_exists('notifytextmessage', $socketData))
			{
				$command = explode(' ', $socketData['msg']);
				
				$clInfo = $query->clientInfo($socketData['invokerid'])['data'];
				$clGroups = explode(',', $clInfo['client_servergroups']);
				
				if($command[0]=='!tp')
				{
					if(isset($command[1]))
					{
						if(array_key_exists($command[1], $config['clans']))
						{
							if(isInGroup($clGroups, array($config['clans'][$command[1]][1])))
							{
								$query->clientMove($socketData['invokerid'], $config['clans'][$command[1]][0]);
								$query->sendMessage(1, $socketData['invokerid'], '[color=green][u][b]Zostałeś przeniesiony pomyślnie.[/b][/u][/color]');	
							}
							else
							{
								$query->sendMessage(1, $socketData['invokerid'], '[color=red][u][b]Nie posiadasz wymaganej grupy, aby przejsc na ten kanal![/b][/u][/color]');
							}
						}
					}
				}
				else
				{
					$query->sendMessage(1, $socketData['invokerid'], '[color=red][u][b]Nie znaleziono takiej komendy![/b][/u][/color]');
					$query->sendMessage(1, $socketData['invokerid'], '[color=blue]Aby przejść na kanał klanowy, wystarczy ze wpiszesz [b]!tp <TAG Klanu>[/b]');
					$query->sendMessage(1, $socketData['invokerid'], '[color=red]Pamiętaj, wielkość liter ma znaczenie![/color]');						
				}
			}
		}
	}
	else
	{
		echo ':: Nie udalo zalogowac sie do serwera';
        echo ':: Sprawdź config/config.php';
		exit();
	}
}
else
{
	echo ':: Nie udalo polaczyc sie z serwerem';
	echo ':: Sprawdź config/config.php';
	exit();
}
?>  
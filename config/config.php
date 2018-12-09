<?php

// Autor: MichUŚŚŚ 🔥
// Aplikacja: @GuildInformator
// Wersja: v0.5
// Pakiet: Free Standard

$config = [

	'connection' => [
		'host' => '127.0.0.1', // IP Serwera
		'serverPort' => '9987', // PORT Serwera (domyslnie 9987)
		'queryPort' => '10011', // QUERY PORT Serwera (domyslnie 10011)
		'queryLogin' => 'serveradmin', // Domyslnie serveradmin
		'queryPassword' => 'password' // Hasło do query
	],
	
	'general' => [
		'name' => '@GuildInformator', // Nazwa Bota
		'defaultChannel' => 1 // Kanał Bota
	],
	
	'clans' => [
		'TAG1' => [18, 9], //ID kanalu, na ktory ma przenosic, wymagane id grupy
		'TAG2' => [19, 10],
	],
	
	'tags' => [
		'list' => 'TAG1, TAG2', //Nazwy wszystkich kalnów (można formatować BBCODE np. [b]TAG1, TAG2[/b])
	],
	
];

?> 

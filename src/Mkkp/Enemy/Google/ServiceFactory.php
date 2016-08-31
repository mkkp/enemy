<?php

namespace Mkkp\Enemy\Google;

class ServiceFactory
{
	public static function createClient($secretPath)
	{
		$client = new \Google_Client();
		$client->setScopes(\Google_Service_Sheets::SPREADSHEETS_READONLY);
		$client->setAuthConfig($secretPath);
		$client->setAccessType('offline');
		$client->setApprovalPrompt('force');

		return $client;
	}

	private static function createClientWithToken($secretPath, $tokenPath)
	{
		$client = self::createClient($secretPath);

		if (file_exists($tokenPath)) {
			$token = json_decode(file_get_contents($tokenPath), true);
			$client->setAccessToken($token);
			if ($client->isAccessTokenExpired()) {
				$client->refreshToken($client->getRefreshToken());
				$newToken                  = $client->getAccessToken();
				$newToken['refresh_token'] = $token['refresh_token'];
				self::saveToken($tokenPath, $newToken);
			}
		} else {
			throw new \InvalidArgumentException('Can not open token file');
		}

		return $client;
	}

	public static function createSheetService($secretPath, $tokenPath)
	{
		return new \Google_Service_Sheets(
			self::createClientWithToken($secretPath, $tokenPath)
		);
	}

	public static function saveToken($tokenPath, $token)
	{
		file_put_contents($tokenPath, json_encode($token));
	}
}

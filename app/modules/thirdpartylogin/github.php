<?php
if (!defined('srkVersion')) {
	exit(403);
}

class GithubLogin {
	public function fetchInfo() {
		global $srkEnv;
		$code = $_GET['code'];
		$data = (Object)Array(
			'client_id'=>$srkEnv->thirdPartyLogin['github']->clientId,
			'client_secret'=>$srkEnv->thirdPartyLogin['github']->clientSecret,
			'code'=>$code,
			'accept'=>'json'
		);
		$postOut = webPostData('https://github.com/login/oauth/access_token', $data);
		$postRes = decipherGetStr($postOut);
		if (isset($postRes['access_token'])) {
			$accessToken = $postRes['access_token'];
			$dataStr = webGetData('https://api.github.com/user', $accessToken);
			$userInfo = json_decode($dataStr);
			if (!$userInfo) {
				return 'Data fetching error';
			}
			if (!isset($userInfo->login)) {
				srkLog('Github information: '.$dataStr);
				return 'Github information fetching error';
			}
			if (!isset($userInfo->name)) {
				$userInfo->name = $userInfo->login;
			}
			if (!isset($userInfo->email)) {
				$userInfo->email = 'secret';
			}
			if (!isset($userInfo->avatar_url)) {
				$userInfo->avatar_url = 'https://github.com/github.png?size=460';
			}
			$userData = (Object)Array(
				'userId'=>'github_'.$userInfo->login,
				'email'=>$userInfo->email,
				'nickname'=>$userInfo->name,
				'accessToken'=>$accessToken,
				'avatarURL'=>$userInfo->avatar_url,
				'source'=>'github'
			);
			$user = new UserData;
			$user->registerThirdParty($userData);
			$writeRes = $user->writeUser();
			if (!$writeRes) {
				$_SESSION['userId'] = $userData->userId;
			} else {
				srkLog('Wrong write result '.$writeRes);
			}
			srkLog('User login '.$userData->userId);
			return $writeRes;
		}
		else {
			srkLog('Github access token error: '.$postOut);
			return 'Access code error';
		}
	}
};


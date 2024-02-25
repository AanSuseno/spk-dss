<?php

namespace App\Controllers;
use Google_Client;
use Google_Service_Oauth2;

class Home extends BaseController
{
    public function index()
	{
		// jika user login tidak bisa kehalaman landing page
		if (session()->get('user_login')) {
			return redirect()->to(base_url('/dashboard'));
		}

        $setting = model('Settings')->first();

		$clientID = $setting['google_client_id'];
		$clientSecret = $setting['google_client_secret'];
		$clientUrl = $setting['google_client_url'];

		$client = new Google_Client();
		$client->setClientId($clientID);
		$client->setClientSecret($clientSecret);
		$client->setRedirectUri($clientUrl);
		$client->addScope('profile');
		$client->addScope('email');

		if (isset($_GET['code'])) {
			$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

			try {
				$client->setAccessToken($token);

				$gauth = new Google_Service_Oauth2($client);
				$google_info = $gauth->userinfo->get();

				$muser = model('Users');
				$gi_email = $google_info['email'];
				$gi_name = $google_info['name'];
				$gi_picture = $google_info['picture'];
				$hasil = $muser->login($gi_email, $gi_name, $gi_picture);

				if ($hasil == 'oke') {
					session()->set('email', $gi_email);
					session()->set('name', $gi_name);
					session()->set('picture', $gi_picture);
					session()->set('user_login', true);

					return redirect()->to(base_url('/dashboard'));
				} else if ($hasil == 'freeze') {
					session()->setFlashdata('tipe', 'warning');
					session()->setFlashdata('pesan', 'Oops akun Anda sedang dibekukan.');

					return redirect()->to(base_url('/'));
				}
				
			} catch (Exception $e) {
				session()->setFlashdata('tipe', 'warning');
				session()->setFlashdata('pesan', 'Oops ada masalah saat masuk, coba lagi.');

				return redirect()->to(base_url('/'));
			}

		} else {
			$jml_user = model('Users')->countAllResults();
			return view('welcome_message', [
				'authUri' => $client->createAuthUrl(),
				'jml_user' => $jml_user,
			]);
		}
	}

	function dashboard_user() {
		$arr_total_sub_criteria = [];
		foreach(model('Projects')->dss() as $v) {
			if (in_array($v['dss'], ['smart'])) {
				continue;
			}
			$arr_total_sub_criteria[$v['dss']] = model('UsersLimit')->total_sub_criteria_1_dss($v['dss']);
		}

		$data_view = [
            'title' => 'Dashboard User',
            'page_master' => 'dashboard',
            'page_sub' => 'dashboard',
            'total_projects' => model('UsersLimit')->arr_total_projects(),
            'arr_total_criteria' => model('UsersLimit')->arr_total_criteria(),
            'arr_total_sub_criteria' => $arr_total_sub_criteria,
            'arr_total_alternatives' => model('UsersLimit')->arr_total_alternatives(),
			'max_project' => model('UsersLimit')->max_project(),
			'max_criteria' => model('UsersLimit')->max_criteria(),
			'max_sub_criteria' => model('UsersLimit')->max_sub_criteria(),
			'max_alternatives' => model('UsersLimit')->max_alternatives(),
			'total_project' => model('UsersLimit')->total_project(),
			'total_criteria' => model('UsersLimit')->total_criteria(),
			'total_sub_criteria' => model('UsersLimit')->total_sub_criteria(),
			'total_alternatives' => model('UsersLimit')->total_alternatives(),
        ];
        return view('user_dashboard', $data_view);
	}

	function logout() {
		session()->destroy();
		return redirect()->to(base_url('/'));
	}
}

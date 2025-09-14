<?php

namespace App\Livewire\App\SiteSettings;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class LandingPageFooterSettings extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Landing Page Footer Settings')]
    public $alamat, $email, $phone;
    public $selectedIcon=null, $url, $platform;
    public $socMedData;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->dispatch('initIconPicker');

        $this->fetchSocMed();

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/site/site-infos', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $siteInfoData = json_decode($res1->getBody()->getContents(), true);
            $this->alamat = $siteInfoData['SITE_INFO_ADDRESS'];
            $this->email = $siteInfoData['SITE_INFO_EMAIL'];
            $this->phone = $siteInfoData['SITE_INFO_PHONE'];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', 'Gagal menyimpan');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function saveChanges()
    {

        $this->validate([
            'alamat' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $data = [
            'SITE_INFO_ADDRESS' => $this->alamat,
            'SITE_INFO_EMAIL' => $this->email,
            'SITE_INFO_PHONE' => $this->phone,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $client->put('/api/super-admin/manage/site/site-infos', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            session()->flash('success_message', 'Informasi Footer berhasil diperbarui');
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function addSosMed()
    {
        $this->validate([
            'platform' => 'required',
            'selectedIcon' => 'required',
            'url' => 'required'
        ]);

        $data = [
            'platform' => $this->platform,
            'icon' => $this->selectedIcon,
            'url' => $this->url,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/site/site-socmed', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['message']);

            $this->fetchSocMed();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function fetchSocMed()
    {

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res2 = $client->get('/api/super-admin/manage/site/site-socmed', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->socMedData = json_decode($res2->getBody()->getContents(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', 'Gagal menyimpan');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function deleteSocMed($socMedId)
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res2 = $client->delete('/api/super-admin/manage/site/site-socmed/' . $socMedId . '/delete', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $responseData = json_decode($res2->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['message']);

            $this->fetchSocMed();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', 'Gagal hapus social media');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.app.site-settings.landing-page-footer-settings');
    }
}

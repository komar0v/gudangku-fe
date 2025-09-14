<?php

namespace App\Livewire\App\Supplier;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use App\Helpers\IndoDateFormat;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Edit extends Component
{
    use RequireLogin, WithFileUploads;

    #[Layout('components.layouts.applayout')]
    #[Title('Edit Data Supplier')]

    public $supplierData;
    public $logo_img, $created_at;
    public $logo_file;
    public $nama_pengrajin, $alamat, $tentang, $nomer_wa;

    public function mount($supplierId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/pengrajin/details/' . $supplierId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->supplierData = json_decode($res1->getBody()->getContents(), true);


            $this->logo_img = env('API_URL') . '/' . $this->supplierData['logo_file_path'];
            $this->created_at = IndoDateFormat::formatIndo($this->supplierData['created_at']);

            $this->nama_pengrajin = $this->supplierData['nama_pengrajin'];
            $this->nomer_wa = $this->supplierData['nomer_wa'];
            $this->tentang = $this->supplierData['tentang'];
            $this->alamat = $this->supplierData['alamat'];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 404) {
                    //Forbidden
                    session()->flash('error_message', $body->message);
                    $this->redirectRoute('appSupplierIndexPage', navigate: true);
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
        return view('livewire.app.supplier.edit');
    }

    public function saveSupplierData1()
    {
        $this->validate([
            'nomer_wa' => 'required|regex:/^\+?[0-9\s\-]{7,20}$/',
            'alamat' => 'required',
            'tentang' => 'required',
        ]);

        $data = [
            'nomer_wa' => $this->nomer_wa,
            'alamat' => $this->alamat,
            'tentang' => $this->tentang,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/pengrajin/update/' . $this->supplierData['id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', 'Perubahan data pengrajin ' . $responseData['data']['nama_pengrajin'] . ' berhasil disimpan');
            $this->redirectRoute('appSupplierDetailPage', ['supplierId' => $this->supplierData['id']], navigate: true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    // $this->redirectRoute('accountInfoPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function saveSupplierData2(){
        $this->validate([
            'nama_pengrajin'=>'required',
        ]);

        $data=[
            'nama_pengrajin'=>$this->nama_pengrajin,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/pengrajin/update/' . $this->supplierData['id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', 'Perubahan data pengrajin ' . $responseData['data']['nama_pengrajin'] . ' berhasil disimpan');
            $this->redirectRoute('appSupplierDetailPage', ['supplierId' => $this->supplierData['id']], navigate: true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    // $this->redirectRoute('accountInfoPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function changeLogo()
    {
        $file = $this->logo_file;

        $this->validate([
            'logo_file' => 'required|image|max:1024',
        ]);


        $filePath = $file->getRealPath();
        $fileName = $file->getClientOriginalName();

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/pengrajin/update/' . $this->supplierData['id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'multipart' => [
                    [
                        'name'     => 'logo_file',
                        'filename' => $fileName,
                        'Mime-Type' => $file->getMimeType(),
                        'contents' => fopen($filePath, 'r'),
                    ]
                ]
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);
            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appSupplierDetailPage', ['supplierId' => $this->supplierData['id']]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    // $this->redirectRoute('accountInfoPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }
}

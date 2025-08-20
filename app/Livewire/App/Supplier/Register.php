<?php

namespace App\Livewire\App\Supplier;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Register extends Component
{
    use RequireLogin, WithFileUploads;

    #[Layout('components.layouts.applayout')]
    #[Title('Register New Pengrajin')]

    public $nama_pengrajin, $nomer_wa, $alamat, $tentang;
    public $excel_file;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function render()
    {
        return view('livewire.app.supplier.register');
    }

    public function rules()
    {
        return [
            'nama_pengrajin' => 'required',
            'nomer_wa' => 'required|regex:/^\+?[0-9\s\-]{7,20}$/',
            'alamat' => 'required',
            'tentang' => 'required',
        ];
    }

    public function saveSupplierData()
    {
        $this->validate();

        $data = [
            'nama_pengrajin' => $this->nama_pengrajin,
            'nomer_wa' => $this->nomer_wa,
            'alamat' => $this->alamat,
            'tentang' => $this->tentang,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/pengrajin/add', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['data']['nama_pengrajin'] . ' berhasil ditambahkan');

            $this->redirectRoute('appSupplierIndexPage', navigate: true);
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

    public function downloadTemplate()
    {
        $path = public_path('assets/template_files/templateImportPengrajin.xlsx');

        return response()->streamDownload(function () use ($path) {
            readfile($path);
        }, 'templateImportPengrajin.xlsx');
    }

    public function uploadFile()
    {

        $file = $this->excel_file;

        $this->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);


        $filePath = $file->getRealPath();
        $fileName = $file->getClientOriginalName();

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/pengrajin/bulk-add-new', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'multipart' => [
                    [
                        'name'     => 'excel_file',
                        'filename' => $fileName,
                        'Mime-Type' => $file->getMimeType(),
                        'contents' => fopen($filePath, 'r'),
                    ]
                ]
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);
            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appSupplierIndexPage', navigate: true);
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

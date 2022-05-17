<?php

namespace App\Http\Livewire\Pages;

use App\Models\ShotURL;
use Illuminate\Support\Facades\Http;
use LaravelQRCode\Facades\QRCode;
use Livewire\Component;
use QR_Code\QR_Code;

class Generator extends Component
{
    public string|null $longLink = null;
    public string|null $shortLink = null;

    public $svgImg = null;

    public ShotURL $item;

    public function mount()
    {
        $this->item = new ShotURL();
    }

    public function rules()
    {
        return [
            'longLink' => 'required|string|min:6',
        ];
    }

    public function messages ()
    {
        return [
            'linkLink.required' => 'Введите пожалуйста ссылку',
            'linkLink.string' => 'Неверный формат данных, проверьте ввод',
        ];
    }

    public function copy()
    {
        $this->dispatchBrowserEvent('copy');
    }

    public function clear()
    {
        $this->item = new ShotURL();
        $this->shortLink = null;
        $this->longLink = null;
    }


    public function Generate()
    {
        $this->validate();

        if (filter_var( str($this->longLink), FILTER_VALIDATE_URL) == false){
            $this->dispatchBrowserEvent('failLink');
            return 0;
        }

        if(ShotURL::checkUrlInDB(str($this->longLink))){
            $this->item = ShotURL::getShortLinkItem(str($this->longLink));
        }else{
            $this->item->long_url = str($this->longLink);
            $this->item->short_url = uniqid();
            $this->item->save();
        }



        $this->shortLink = env('DOMAIN_CODE') . '/s/'. $this->item->short_url;
        $this->item = new ShotURL();

    }

    public function render()
    {
        return view('livewire.pages.generator');
    }
}

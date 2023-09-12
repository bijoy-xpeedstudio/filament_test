<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\View\View;

class ManageCustomers extends ManageRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooter(): View
    {
        return view('hello')->with([
            'bijoy' => 'bijoy'
        ]);
    }
}

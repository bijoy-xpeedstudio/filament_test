<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\Roles;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Fieldset;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Fieldset::make('Customer Information')->schema([
                Forms\Components\TextInput::make('name')->required(),

                Forms\Components\Select::make('role_id')
                    ->options(Roles::pluck('name', 'id'))
                    ->relationship('roles', 'name')
                    ->required(),

                Forms\Components\FileUpload::make('image')->image()
                    //->rules('required|image|max:2048')
                    ->required(),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('roles.name'),
                Tables\Columns\ImageColumn::make('image')->circular(),
                // Tables\Columns\IconColumn::make('image')->options([
                //     //'heroicon-o-x-circle',
                //     'heroicon-o-pencil',
                //     'heroicon-o-clock' => 'reviewing',
                //     'heroicon-o-check-circle' => 'published',
                // ])->colors([
                //     'danger',
                //     'danger' => 1,
                //     'warning' => 'reviewing',
                //     'success' => 'published',
                // ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomers::route('/'),
        ];
    }

    public function validationRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'exists:roles,id'],
            'image' => ['required', 'image', 'max:2048'],
        ];
    }
}

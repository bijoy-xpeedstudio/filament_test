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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\BijoyTest;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    public Customer $customer;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Fieldset::make('Customer Information')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->hint('Your full name here, including any middle names.')
                    ->hintColor('success')
                    ->hintIcon('heroicon-s-translate')
                    ->extraInputAttributes(['title' => 'Text input'])
                    ->autofocus()
                    ->placeholder('Johddn Doe'),

                Forms\Components\TextInput::make('domain')
                    ->url()
                    ->prefix('https://')
                    ->suffix('.com'),

                Forms\Components\Select::make('role_id')
                    ->options(Roles::pluck('name', 'id'))
                    ->relationship('roles', 'name')
                    ->required(),

                TextInput::make('code')->mask(fn (TextInput\Mask $mask) => $mask->enum(['F1', 'G2', 'H3'])),

                Forms\Components\FileUpload::make('image')->image()->required(),
                Forms\Components\TextInput::make('manufacturer')->datalist([
                    'BWM',
                    'Ford',
                    'Mercedes-Benz',
                    'Porsche',
                    'Toyota',
                    'Tesla',
                    'Volkswagen',
                ]),
                Repeater::make('members')->schema([
                    TextInput::make('name')->required(),
                    Select::make('role')
                        ->options([
                            'member' => 'Member',
                            'administrator' => 'Administrator',
                            'owner' => 'Owner',
                        ])
                        ->required(),
                ])->columnSpan(2)
            ]),
            Tabs::make('Heading')->tabs([
                Tabs\Tab::make('Label 1')
                    ->schema([
                        // ...
                    ]),
                Tabs\Tab::make('Label 2')
                    ->schema([
                        // ...
                    ]),
                Tabs\Tab::make('Label 3')
                    ->schema([
                        // ...
                    ]),
            ])->columnSpan(2),

            BijoyTest::make('a;dkfasdlfkj')->getActiveTabx()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('roles.name'),
                Tables\Columns\ImageColumn::make('image')->circular(),
            ])
            ->filters([
                SelectFilter::make('Role')->options([
                    '1' => 'admin',
                    '2' => 'users',
                ])->attribute('role_id'),
                Filter::make('created_at')->form([
                    Forms\Components\TextInput::make('name'),
                ])->query(function (Builder $query, array $data): Builder {
                    return $query->when(
                        $data['name'],
                        fn (Builder $query, $date): Builder => $query->where('name', 'LIKE', '%' . $date . '%'),
                    );
                })
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

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->columnSpan([])->schema([
                    // Define the form fields and elements here
                    \Filament\Forms\Components\Select::make('customer_id')
                        ->relationship('customer', 'id',) // Assumes you have a 'customer' relationship in the Order model
                        ->label('Customer')
                        ->preload()
                        //->getOptionLabelFromRecordUsing(fn (Customer $record) => "{$record->first_name} {$record->last_name}")
                        ->required(),
                    \Filament\Forms\Components\TextInput::make('order_number')
                        ->label('Order Number')
                        ->required(),
                    \Filament\Forms\Components\TextInput::make('total_amount')
                        ->numeric()
                        ->label('Total Amount')
                        ->required(),
                    \Filament\Forms\Components\DateTimePicker::make('order_date')->label('Order Date')->required(),
                    $aa = \Filament\Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'completed' => 'Completed',
                            'canceled' => 'Canceled',
                        ])
                        ->label('Status')
                        ->required()
                        ->reactive(),
                    \Filament\Forms\Components\Select::make('payment_status')->options(function (callable $get) use ($aa) {
                        if ($get('status') == 'processing') {
                            $aa->disabled();
                            return [
                                'pending' => 'Pending',
                                'completed' => 'Completed',
                                'failed' => 'Failed',
                            ];
                        }
                    })
                        ->label('Payment Status')
                        ->required()
                        ->reactive(),
                    \Filament\Forms\Components\TextInput::make('payment_method')->label('Payment Method')->nullable(),
                    \Filament\Forms\Components\TextArea::make('shipping_address')->label('Shipping Address')->nullable(),
                    \Filament\Forms\Components\TextInput::make('shipping_method')->label('Shipping Method')->nullable(),
                    \Filament\Forms\Components\TextInput::make('discount_amount')
                        ->numeric()
                        ->label('Discount Amount')
                        ->required(),
                    \Filament\Forms\Components\TextInput::make('tax_amount')
                        ->numeric()
                        ->label('Tax Amount')
                        ->required()
                    // Add more fields as needed for your specific use case
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

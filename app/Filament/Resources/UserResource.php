<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique('users', 'email', fn($record) => $record),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Nomor Handphone')
                    ->nullable()
                    ->maxLength(15)
                    ->tel()
                    ->placeholder('Masukkan nomor handphone'),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->required(fn($record) => $record === null),
                Forms\Components\Select::make('role')
                    ->label('Peran')
                    ->options([
                        'user' => 'user',
                        'admin' => 'admin',
                    ])
                    ->default('user')
                    ->required(),
                // Menambahkan kolom untuk avatar, background, dan page_image
                Forms\Components\FileUpload::make('avatar')
                    ->label('Gambar Profil')
                    ->image()
                    ->disk('public')
                    ->directory('users-avatar')
                    ->nullable()
                    ->maxSize(2048)
                    ->rules('image', 'max:2048')
                    ->previewable(true),
                Forms\Components\FileUpload::make('background')
                    ->label('Background User')
                    ->image()
                    ->disk('public')
                    ->directory('users-background')
                    ->nullable()
                    ->maxSize(2048)
                    ->rules('image', 'max:2048')
                    ->previewable(true),
                Forms\Components\FileUpload::make('page_image')
                    ->label('Foto Profil pada Page')
                    ->image()
                    ->disk('public')
                    ->directory('users-page-images')
                    ->nullable()
                    ->maxSize(2048)
                    ->rules('image', 'max:2048')
                    ->previewable(true),
                // Checkbox untuk private dan selebritis
                Forms\Components\Checkbox::make('private')
                    ->label('Private')
                    ->default(false),
                Forms\Components\Checkbox::make('selebritis')
                    ->label('Selebritis')
                    ->default(false),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('username')->label('Username')->searchable(),
                TextColumn::make('gender')->label('Gender')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('no_hp')->label('Nomor Handphone')->searchable()->sortable(),
                TextColumn::make('gender')->label('Jenis Kelamin'),
                TextColumn::make('private')
                    ->label('Private')
                    ->getStateUsing(function ($record) {
                        return $record->private == 1 ? 'Private' : 'Tidak Private';  // Menampilkan "Iya" jika private = 1, "Tidak" jika private = 0
                    }),

                TextColumn::make('selebritis')
                    ->label('Selebritis')
                    ->getStateUsing(function ($record) {
                        return $record->private == 1 ? 'Selebritis' : 'Tidak Selebritis';  // Menampilkan "Iya" jika private = 1, "Tidak" jika private = 0
                    }),

                BadgeColumn::make('role')
                    ->label('Peran')
                    ->color(function ($state) {
                        return match ($state) {
                            'admin' => 'success',
                            'user' => 'warning',
                            default => 'gray',
                        };
                    }),


                \Filament\Tables\Columns\ImageColumn::make('avatar')->square()
                    ->label('Gambar Profil')
                    ->disk('public')
                    ->height(80)
                    ->width(80)
                    ->getStateUsing(function ($record) {
                        return $record->avatar ? asset("storage/{$record->avatar}") : asset("storage/users-avatar/avatar.png");
                    }),

                \Filament\Tables\Columns\ImageColumn::make('background')->square()
                    ->label('Background User')
                    ->disk('public')
                    ->height(80)
                    ->width(120)
                    ->getStateUsing(function ($record) {
                        return $record->background ? asset("storage/{$record->background}") : asset("storage/users-avatar/avatar.png");
                    }),

                \Filament\Tables\Columns\ImageColumn::make('page_image')->square()
                    ->label('Foto Profil pada Page')
                    ->disk('public')
                    ->height(80)
                    ->width(80)
                    ->getStateUsing(function ($record) {
                        return $record->page_image ? asset("storage/{$record->page_image}") : asset("storage/users-avatar/avatar.png");
                    })

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Peran')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                    ])
                    ->default('user'),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

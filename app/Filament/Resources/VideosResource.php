<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideosResource\Pages;
use App\Filament\Resources\VideosResource\RelationManagers;
use App\Models\Video;
use App\Models\User; // Tambahkan untuk relasi dengan User
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VideosResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Postingan';
    protected static ?string $navigationLabel = 'Postingan Video';
    protected static ?string $pluralLabel = 'Postingan Video';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Kolom untuk memilih user
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id')) // Menampilkan daftar nama user
                    ->required(),

                // Kolom untuk konten video
                Forms\Components\Textarea::make('content')
                    ->label('Content')
                    ->nullable()
                    ->maxLength(1000),

                // Kolom untuk video
                Forms\Components\FileUpload::make('video')
                    ->label('Video')
                    ->disk('public')
                    ->directory('videos')
                    ->nullable()
                    ->acceptedFileTypes(['video/mp4', 'video/mkv', 'video/avi'])
                    ->maxSize(10240) // Maksimal ukuran 10MB
                    ->rules('file', 'max:10240'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('user.name')->label('User')->sortable(), // Menampilkan nama user
                TextColumn::make('content')->label('Content')->limit(50), // Menampilkan konten dengan limit 50 karakter
                TextColumn::make('video')->label('Video')->getStateUsing(function ($record) {
                    return $record->video ? asset("storage/{$record->video}") : null;
                }), // Menampilkan video jika ada
                TextColumn::make('created_at')->label('Created At')->dateTime('Y-m-d H:i:s'),
                TextColumn::make('updated_at')->label('Updated At')->dateTime('Y-m-d H:i:s'),
            ])
            ->filters([
                // Filter berdasarkan user jika diperlukan
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Relasi dengan model lain bisa ditambahkan di sini
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            // 'create' => Pages\CreateVideos::route('/create'),
            // 'edit' => Pages\EditVideos::route('/{record}/edit'),
        ];
    }
}

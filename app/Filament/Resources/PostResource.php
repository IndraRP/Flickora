<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\User; // Tambahkan untuk relasi dengan User
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Postingan';
    protected static ?string $navigationLabel = 'Postingan Foto';
    protected static ?string $pluralLabel = 'Postingan Foto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Kolom untuk memilih user
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id')) // Menampilkan daftar nama user
                    ->required(),

                // Kolom untuk konten post
                Forms\Components\Textarea::make('content')
                    ->label('Content')
                    ->required()
                    ->maxLength(1000),

                // Kolom untuk gambar post
                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('posts-images')
                    ->nullable()
                    ->maxSize(2048)
                    ->rules('image', 'max:2048')
                    ->previewable(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('user.name')->label('User')->sortable(),
                TextColumn::make('content')->label('Content')->limit(50), // Menampilkan konten dengan limit 50 karakter
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->height(80)
                    ->width(80)
                    ->getStateUsing(function ($record) {
                        return $record->image ? asset("storage/{$record->image}") : null;
                    }),

                TextColumn::make('created_at')->label('Created At')->dateTime('Y-m-d H:i:s'),
                TextColumn::make('updated_at')->label('Updated At')->dateTime('Y-m-d H:i:s'),
            ])
            ->filters([ // Bisa ditambahkan filter jika diperlukan
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
            'index' => Pages\ListPosts::route('/'),
            // 'create' => Pages\CreatePost::route('/create'),
            // 'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}

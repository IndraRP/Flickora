<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Postingan';
    protected static ?string $navigationLabel = 'Tag ';
    protected static ?string $pluralLabel = 'Tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('user.name')->label('User')->sortable(),
                TextColumn::make('post_id')->label('Id Post'),
                \Filament\Tables\Columns\ImageColumn::make('post.image')
                    ->label('Image')
                    ->disk('public')
                    ->height(80)
                    ->width(80)
                    ->getStateUsing(function ($record) {
                        return $record->post && $record->post->image
                            ? asset("storage/{$record->post->image}")
                            : null;
                    }),


                TextColumn::make('created_at')->label('Created At')->dateTime('Y-m-d H:i:s'),
                TextColumn::make('updated_at')->label('Updated At')->dateTime('Y-m-d H:i:s'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTags::route('/'),
            // 'create' => Pages\CreateTag::route('/create'),
            // 'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}

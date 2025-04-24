<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BandingVideoResource\Pages;
use App\Filament\Resources\BandingVideoResource\RelationManagers;
use App\Models\Banding_Video;
use App\Models\BandingVideo;
use App\Models\Report_Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;

class BandingVideoResource extends Resource
{
    protected static ?string $model = Banding_Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Banding';
    protected static ?string $navigationLabel = 'Banding Video';
    protected static ?string $pluralLabel = 'Banding Video';

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
                Tables\Columns\TextColumn::make('id')->label('ID'),
                TextColumn::make('user.name')->label('User'),
                Tables\Columns\TextColumn::make('video_id')->label('Video ID'),
                Tables\Columns\TextColumn::make('report_reason')->label('Alasan Laporan'),
                Tables\Columns\TextColumn::make('alasan')->label('Alasan Tambahan'),
                ImageColumn::make('bukti')
                    ->label('Bukti')
                    ->square() // Gambar berbentuk persegi
                    ->height(120) // Ukuran tinggi gambar
                    ->width(120) // Ukuran lebar gambar
                    ->getStateUsing(function ($record) {
                        return $record->bukti ? asset("storage/{$record->bukti}") : asset("storage/users-avatar/avatar.png");
                    }),

                Tables\Columns\BadgeColumn::make('approved')
                    ->label('Approved')
                    ->colors(['danger' => 0, 'success' => 1])
                    ->getStateUsing(function ($record) {
                        return $record->approved ? 'Approved' : 'Not Approved';
                    }),
            ])
            ->filters([ /* Filter jika diperlukan */])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                // Menambahkan aksi "Approve"
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($record) {
                        // Set approved ke 1 untuk banding ini
                        $record->update(['approved' => 1]);

                        // Kirimkan notifikasi sukses
                        Notification::make()
                            ->title('Laporan disetujui')
                            ->success()
                            ->send();

                        // Update semua banding dengan post_id yang sama
                        Banding_Video::where('video_id', $record->video_id)
                            ->update(['approved' => 1]);

                        Report_Video::where('video_id', $record->video_id)
                            ->update(['approved' => 0]);
                    })
                    ->requiresConfirmation() // Konfirmasi sebelum disetujui
                    ->modalHeading('Approve Report')
                    ->modalSubheading('Apakah Anda yakin ingin menyetujui laporan ini?')
                    ->modalButton('Setujui')
                    ->visible(fn(Banding_Video $record): bool => $record->approved == 0), // Menampilkan hanya jika belum disetujui
            ])
            ->bulkActions([
                // Bulk actions jika diperlukan
                Tables\Actions\BulkActionGroup::make([ /* Bulk actions */])
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
            'index' => Pages\ListBandingVideos::route('/'),
            // 'create' => Pages\CreateBandingVideo::route('/create'),
            // 'edit' => Pages\EditBandingVideo::route('/{record}/edit'),
        ];
    }
}

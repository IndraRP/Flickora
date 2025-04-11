<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Notifications\Notification;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Report';
    protected static ?string $navigationLabel = 'Report Foto';
    protected static ?string $pluralLabel = 'Report Foto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('alasan')
                    ->label('Alasan')
                    ->nullable()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('post_id')->label('Post ID')->sortable(),
                TextColumn::make('user_id')->label('User ID')->sortable(),
                TextColumn::make('alasan')->label('Alasan')->sortable(),
                TextColumn::make('approved')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                    })
                    ->formatStateUsing(fn($state) => $state ? 'Approved' : 'Not Approved'),

            ])
            ->filters([
                // Anda bisa menambahkan filter di sini jika diperlukan
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                // Menambahkan aksi untuk "Approve"
                Action::make('approved')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Report $record) {
                        // Update kolom approved menjadi 1 ketika di-approve
                        $record->update(['approved' => 1]);

                        // Periksa apakah data berhasil diperbarui
                        if ($record->approved === 1) {
                            // Kirimkan notifikasi sukses setelah laporan disetujui
                            Notification::make()
                                ->title('Laporan berhasil disetujui.')
                                ->success()
                                ->send();
                        } else {
                            // Notifikasi error jika update gagal
                            Notification::make()
                                ->title('Gagal memperbarui status laporan.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->requiresConfirmation() // Konfirmasi sebelum disetujui
                    ->modalHeading('Approve Report')
                    ->modalSubheading('Apakah Anda yakin ingin menyetujui laporan ini?')
                    ->modalButton('Setujui')
                    ->visible(fn(Report $record): bool => $record->approved == 0)

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
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            // 'create' => Pages\CreateReport::route('/create'),
            // 'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}

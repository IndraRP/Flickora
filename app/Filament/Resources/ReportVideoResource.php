<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportVideoResource\Pages;
use App\Models\Post;
use App\Models\Report_Video;
use App\Models\User;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class ReportVideoResource extends Resource
{
    protected static ?string $model = Report_Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Report';
    protected static ?string $navigationLabel = 'Report Video';
    protected static ?string $pluralLabel = 'Report Video';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // Select::make('video_id')
                //     ->label('Pilih Post')
                //     ->options(Video::all()->pluck('title', 'id')) // Ambil data post dan pluck hanya id dan title
                //     ->required() // Menandakan bahwa field ini diperlukan
                //     ->searchable(), // Agar bisa mencari post

                // // Menambahkan input untuk memilih User (user_id)
                // Select::make('user_id')
                //     ->label('Pilih User')
                //     ->options(User::all()->pluck('name', 'id')) // Ambil data user dan pluck hanya id dan name
                //     ->required() // Menandakan bahwa field ini diperlukan
                //     ->searchable(), // Agar bisa mencari user

                // // You can define form fields here if needed, for example:
                // Forms\Components\Textarea::make('alasan')
                //     ->label('Alasan')
                //     ->nullable()
                //     ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('post_id')->label('Post ID')->sortable(),
                Tables\Columns\TextColumn::make('user_id')->label('User ID')->sortable(),
                Tables\Columns\TextColumn::make('alasan')->label('Alasan')->sortable(),
                Tables\Columns\BadgeColumn::make('approved')
                    ->label('Approved')
                    ->colors(['danger' => 0, 'success' => 1])
                    ->getStateUsing(function ($record) {
                        return $record->approved ? 'Approved' : 'Not Approved';
                    }),
            ])
            ->filters([
                // Add any necessary filters here
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                // Adding the "Approve" action
                Action::make('approved')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Report_Video $record) {
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
                    ->visible(fn(Report_Video $record): bool => $record->approved == 0)

            ])
            ->bulkActions([
                // Add any bulk actions if necessary
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportVideos::route('/'),
            // 'create' => Pages\CreateReportVideo::route('/create'),
            // 'edit' => Pages\EditReportVideo::route('/{record}/edit'),
        ];
    }
}

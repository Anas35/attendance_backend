<?php

namespace App\Filament\Resources\ClassResource\RelationManagers;

use App\Models\Record;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use DB;

class RecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'records';

    protected static ?string $recordTitleAttribute = 'record_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    protected function getTableQuery(): Builder
    {
        $class_id = $this->ownerRecord->class_id;
        return Record::select(
            DB::raw('reg_no'),
            DB::raw('record_id'),
            DB::raw('SUM(is_present = 1) as present'),
            DB::raw('SUM(is_present = 0) as absent'),
            DB::raw('round(AVG(is_present = 1) * 100, 0) as percentage'),
        )->groupBy('reg_no')->where('class_id', '=', $class_id);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reg_no'),
                Tables\Columns\TextColumn::make('present')->label('Class Present'),
                Tables\Columns\TextColumn::make('absent')->label('Class Absent'),
                Tables\Columns\TextColumn::make('percentage')->suffix('%'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject_name')->relationship('subject', 'subject_name'),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until')->default(Carbon::now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),
                ],
                layout: Tables\Filters\Layout::AboveContent,
            )
            ->headerActions([

            ])
            ->actions([
                
            ])
            ->bulkActions([

            ]);
    }    
}

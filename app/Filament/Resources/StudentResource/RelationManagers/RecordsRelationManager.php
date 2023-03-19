<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Models\Record;
use DB;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class RecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'records';

    protected static ?string $recordTitleAttribute = 'reg_no';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reg_no')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        $reg_no = $this->ownerRecord->reg_no;
        return Record::select(
            DB::raw('subject_id'),
            DB::raw('record_id'),
            DB::raw('SUM(is_present = 1) as present'),
            DB::raw('SUM(is_present = 0) as absent'),
            DB::raw('round(AVG(is_present = 1) * 100, 0) as percentage'),
        )->groupBy('subject_id')->where('reg_no', '=', $reg_no);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject.subject_name'),
                Tables\Columns\TextColumn::make('present')->label('Class Present'),
                Tables\Columns\TextColumn::make('absent')->label('Class Absent'),
                Tables\Columns\TextColumn::make('percentage')->suffix('%'),
            ])
            ->filters([
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
            );
    }    
}

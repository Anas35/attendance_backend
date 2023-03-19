<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\Subject;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject_id')->required(),
                Forms\Components\TextInput::make('subject_name')->required(),
                Forms\Components\TextInput::make('semester')
                ->minValue(1)
                ->maxValue(6)
                ->required(),
                Forms\Components\Select::make('department_id')->relationship('department', 'department_name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject_id'),
                Tables\Columns\TextColumn::make('subject_name')->searchable(),
                Tables\Columns\TextColumn::make('semester')->sortable(),
                Tables\Columns\TextColumn::make('department.department_name')->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_name')->relationship('department', 'department_name'),
                Tables\Filters\SelectFilter::make('semester')
                ->options([
                    '1' => 'Semester 1',
                    '2' => 'Semester 2',
                    '3' => 'Semester 3',
                    '4' => 'Semester 4',
                    '5' => 'Semester 5',
                    '6' => 'Semester 6',
                ]),
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }    
}

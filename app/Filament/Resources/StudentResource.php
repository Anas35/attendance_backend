<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reg_no'),
                Forms\Components\TextInput::make('student_name'),
                Forms\Components\Select::make('department_id')->relationship('class', 'class_name'),
                Forms\Components\Select::make('department_id')->relationship('department', 'department_name'),
                Forms\Components\TextInput::make('email'),
                Forms\Components\TextInput::make('roll_no'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reg_no')->label('Register No.')->sortable(),
                Tables\Columns\TextColumn::make('student_name')->searchable(),
                Tables\Columns\TextColumn::make('department.department_name')->searchable(),
                Tables\Columns\TextColumn::make('class.class_name')->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_name')->relationship('department', 'department_name'),
                Tables\Filters\SelectFilter::make('class_name')->relationship('class', 'class_name'),
                ],
                layout: Tables\Filters\Layout::AboveContent,
            )
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
           RelationManagers\RecordsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'view' => Pages\ViewStudent::route('/{record}'),
        ];
    }    
}
